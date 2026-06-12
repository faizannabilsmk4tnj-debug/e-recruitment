<?php

namespace Tests\Feature;

use App\Models\CvTemplate;
use App\Models\User;
use Tests\TestCase;

class HrCvTemplateTest extends TestCase
{
    public function test_hr_can_manage_cv_templates(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is not installed.');
        }

        $this->artisan('migrate:fresh');

        $hr = User::create([
            'name' => 'HR Tester',
            'email' => 'hr.tester@example.com',
            'password' => 'password123',
            'role' => 'hr',
            'is_active' => true,
        ]);

        $this->actingAs($hr)
            ->get(route('hr.template-cv.index'))
            ->assertOk()
            ->assertSee('CV Template Management');

        $templateResponse = $this->actingAs($hr)->post(route('hr.template-cv.store'), [
            'name' => 'Technical CV',
            'description' => 'Template for technical applicants.',
            'status' => 'draft',
        ]);

        $template = CvTemplate::where('name', 'Technical CV')->firstOrFail();
        $templateResponse->assertRedirect(route('hr.template-cv.editor', $template));

        $this->actingAs($hr)
            ->patch(route('hr.template-cv.update', $template), [
                'name' => 'Technical CV Updated',
                'description' => 'Updated description.',
                'status' => 'draft',
                'content_html' => '<div class="page"><div class="blk">Content</div></div>',
            ])
            ->assertRedirect(route('hr.template-cv.editor', $template));

        $this->assertDatabaseHas('cv_templates', [
            'id' => $template->id,
            'name' => 'Technical CV Updated',
            'status' => 'draft',
        ]);

        $this->actingAs($hr)
            ->patch(route('hr.template-cv.publish', $template))
            ->assertRedirect();

        $this->actingAs($hr)
            ->patch(route('hr.template-cv.default', $template))
            ->assertRedirect();

        $this->assertDatabaseHas('cv_templates', [
            'id' => $template->id,
            'status' => 'published',
            'is_active' => true,
            'is_default' => true,
        ]);

        $draft = CvTemplate::create([
            'name' => 'Disposable Draft',
            'status' => 'draft',
            'is_active' => false,
            'is_default' => false,
        ]);

        $this->actingAs($hr)
            ->delete(route('hr.template-cv.destroy', $draft))
            ->assertRedirect(route('hr.template-cv.index'));

        $this->assertDatabaseMissing('cv_templates', [
            'id' => $draft->id,
        ]);
    }
}
