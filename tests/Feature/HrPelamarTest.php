<?php

namespace Tests\Feature;

use App\Models\ApplicantCv;
use App\Models\Application;
use App\Models\CvTemplate;
use App\Models\JobCategory;
use App\Models\JobPosting;
use App\Models\User;
use Tests\TestCase;

class HrPelamarTest extends TestCase
{
    public function test_hr_can_open_applicant_list_detail_and_cv_preview(): void
    {
        [$hr, $application] = $this->seedApplicantFlow();

        $this->actingAs($hr)
            ->get('/hr/pelamar')
            ->assertOk()
            ->assertSee('Applicant List')
            ->assertSee('Chemical Process Engineer')
            ->assertSee('Budi Santoso');

        $this->actingAs($hr)
            ->get('/hr/pelamar/' . $application->id)
            ->assertOk()
            ->assertSee('Applicant Detail');

        $this->actingAs($hr)
            ->get('/hr/pelamar/' . $application->id . '/cv-preview')
            ->assertOk()
            ->assertSee('CV')
            ->assertSee('Budi Santoso');
    }

    public function test_hr_can_update_status_and_add_note(): void
    {
        [$hr, $application] = $this->seedApplicantFlow();

        $this->actingAs($hr)
            ->postJson('/hr/pelamar/' . $application->id . '/status', [
                'status' => 'shortlisted',
                'reason' => 'Qualified for next step.',
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'shortlisted',
            'hr_notes' => 'Qualified for next step.',
        ]);

        $this->actingAs($hr)
            ->postJson('/hr/pelamar/' . $application->id . '/note', [
                'note' => 'Strong portfolio.',
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('application_status_logs', [
            'application_id' => $application->id,
            'reason' => 'Strong portfolio.',
        ]);
    }

    public function test_hr_can_schedule_interview(): void
    {
        [$hr, $application] = $this->seedApplicantFlow();

        $this->actingAs($hr)
            ->postJson('/hr/pelamar/' . $application->id . '/interview', [
                'scheduled_at' => now()->addDay()->format('Y-m-d H:i:s'),
                'duration_minutes' => 60,
                'interview_type' => 'online',
                'location_or_link' => 'https://meet.example.test/hr',
                'notes' => 'Technical discussion.',
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'interview',
        ]);

        $this->assertDatabaseHas('interviews', [
            'application_id' => $application->id,
            'scheduled_by' => $hr->id,
            'interview_type' => 'online',
            'status' => 'scheduled',
        ]);
    }

    private function seedApplicantFlow(): array
    {
        $this->prepareDatabase();

        $hr = User::create([
            'name' => 'Demo HR',
            'email' => 'hr@example.test',
            'password_hash' => bcrypt('password123'),
            'role' => 'hr',
            'is_active' => true,
        ]);

        $applicant = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.test',
            'password_hash' => bcrypt('password123'),
            'role' => 'applicant',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $category = JobCategory::create([
            'name' => 'Production',
            'slug' => 'production',
            'is_active' => true,
        ]);

        $job = JobPosting::create([
            'hr_user_id' => $hr->id,
            'category_id' => $category->id,
            'title' => 'Chemical Process Engineer',
            'description' => 'Process engineering role.',
            'requirements' => 'Engineering background.',
            'employment_type' => 'full-time',
            'location_type' => 'onsite',
            'location' => 'Batam',
            'quota' => 1,
            'status' => 'open',
            'deadline' => now()->addDays(7)->toDateString(),
        ]);

        $template = CvTemplate::create([
            'name' => 'Default Template',
            'content_html' => '<div data-type="header"></div><div data-type="contact"></div><div data-type="skills"></div>',
            'status' => 'published',
            'is_active' => true,
            'is_default' => true,
        ]);

        $cv = ApplicantCv::create([
            'user_id' => $applicant->id,
            'template_id' => $template->id,
            'title' => 'Main CV',
            'is_primary' => true,
        ]);

        $application = Application::create([
            'user_id' => $applicant->id,
            'job_id' => $job->id,
            'cv_id' => $cv->id,
            'status' => 'applied',
        ]);

        return [$hr, $application];
    }

    public function test_job_posting_range_validation(): void
    {
        $this->prepareDatabase();

        $hr = User::create([
            'name' => 'Demo HR',
            'email' => 'hr@example.test',
            'password_hash' => bcrypt('password123'),
            'role' => 'hr',
            'is_active' => true,
        ]);

        $category = JobCategory::create([
            'name' => 'Production',
            'slug' => 'production',
            'is_active' => true,
        ]);

        // 1. age_max < age_min must fail
        $this->actingAs($hr)
            ->postJson('/hr/lowongan', [
                'title' => 'Invalid Age Vacancy',
                'category_id' => $category->id,
                'location' => 'Batam',
                'quota' => 5,
                'age_min' => 30,
                'age_max' => 25, // invalid
                'description' => 'Test',
                'requirements' => 'Test',
                'status' => 'open',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['age_max']);

        // 2. salary_max < salary_min must fail
        $this->actingAs($hr)
            ->postJson('/hr/lowongan', [
                'title' => 'Invalid Salary Vacancy',
                'category_id' => $category->id,
                'location' => 'Batam',
                'quota' => 5,
                'salary_min' => '10.000.000',
                'salary_max' => '5.000.000', // invalid
                'description' => 'Test',
                'requirements' => 'Test',
                'status' => 'open',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['salary_max']);

        // 3. valid range must succeed
        $response = $this->actingAs($hr)
            ->postJson('/hr/lowongan', [
                'title' => 'Valid Vacancy',
                'category_id' => $category->id,
                'location' => 'Batam',
                'quota' => 5,
                'age_min' => 20,
                'age_max' => 30,
                'salary_min' => '5.000.000',
                'salary_max' => '10.000.000',
                'description' => 'Test',
                'requirements' => 'Test',
                'status' => 'open',
            ]);
        
        $response->assertOk()
            ->assertJsonPath('success', true);

        $jobId = JobPosting::where('title', 'Valid Vacancy')->first()->id;

        // 4. Update with invalid age range must fail
        $this->actingAs($hr)
            ->putJson('/hr/lowongan/' . $jobId, [
                'title' => 'Valid Vacancy',
                'category_id' => $category->id,
                'location' => 'Batam',
                'quota' => 5,
                'age_min' => 30,
                'age_max' => 25, // invalid
                'requirements' => 'Test',
                'status' => 'open',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['age_max']);

        // 5. Update with invalid salary range must fail
        $this->actingAs($hr)
            ->putJson('/hr/lowongan/' . $jobId, [
                'title' => 'Valid Vacancy',
                'category_id' => $category->id,
                'location' => 'Batam',
                'quota' => 5,
                'salary_min' => '10.000.000',
                'salary_max' => '5.000.000', // invalid
                'requirements' => 'Test',
                'status' => 'open',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['salary_max']);
    }

    public function test_hr_can_toggle_applicant_privilege_and_prevents_applying(): void
    {
        [$hr, $application] = $this->seedApplicantFlow();
        $applicant = $application->user;

        // Verify initial state
        $this->assertTrue($applicant->has_privilege);

        // HR revokes privilege
        $this->actingAs($hr)
            ->postJson('/hr/pelamar/' . $application->id . '/toggle-privilege')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('has_privilege', false);

        $applicant->refresh();
        $this->assertFalse($applicant->has_privilege);

        // Verify applicant receives notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $applicant->id,
            'type' => 'privilege_change',
            'title' => 'Hak Akses Dicabut',
        ]);

        // Verify applicant cannot submit application when privilege is revoked
        $job2 = JobPosting::create([
            'hr_user_id' => $hr->id,
            'category_id' => $application->jobPosting->category_id,
            'title' => 'Process Engineer II',
            'description' => 'Role details.',
            'requirements' => 'Qualifications.',
            'employment_type' => 'full-time',
            'location_type' => 'onsite',
            'location' => 'Batam',
            'quota' => 5,
            'status' => 'open',
            'deadline' => now()->addDays(7)->toDateString(),
        ]);

        $this->actingAs($applicant)
            ->postJson('/pelamar/review-lamaran/' . $job2->id, [
                'cv_source' => 'builder',
                'cover_letter' => 'My cover letter',
            ])
            ->assertStatus(403)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Anda tidak memiliki hak akses (privilege) untuk melamar pekerjaan.');

        // HR grants privilege back
        $this->actingAs($hr)
            ->postJson('/hr/pelamar/' . $application->id . '/toggle-privilege')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('has_privilege', true);

        $applicant->refresh();
        $this->assertTrue($applicant->has_privilege);

        // Verify applicant receives grant notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $applicant->id,
            'type' => 'privilege_change',
            'title' => 'Hak Akses Diberikan',
        ]);
    }

    private function prepareDatabase(): void
    {
        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('pdo_sqlite is not installed in this PHP runtime.');
        }

        $this->artisan('migrate:fresh')->run();
    }
}
