<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test applicant registration.
     */
    public function test_applicant_can_register()
    {
        $response = $this->postJson('/register', [
            'nama' => 'Test Pelamar',
            'email' => 'pelamar@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Register berhasil'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'pelamar@test.com',
            'role' => 'applicant'
        ]);
    }

    /**
     * Test applicant registration validation failure.
     */
    public function test_applicant_registration_validation()
    {
        $response = $this->postJson('/register', [
            'nama' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     * Test applicant login success.
     */
    public function test_applicant_can_login()
    {
        $user = User::create([
            'name' => 'John Applicant',
            'email' => 'john@applicant.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        $response = $this->postJson('/login', [
            'email' => 'john@applicant.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'role' => 'applicant'
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test applicant login fails with wrong password.
     */
    public function test_applicant_cannot_login_with_wrong_password()
    {
        User::create([
            'name' => 'John Applicant',
            'email' => 'john@applicant.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        $response = $this->postJson('/login', [
            'email' => 'john@applicant.com',
            'password' => 'wrongpass'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Password salah'
            ]);

        $this->assertGuest();
    }

    /**
     * Test HR login success.
     */
    public function test_hr_can_login()
    {
        $user = User::create([
            'name' => 'HR Staff',
            'email' => 'hr@ecogreen.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'hr',
            'is_active' => true,
        ]);

        $response = $this->postJson('/hr/login', [
            'email' => 'hr@ecogreen.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'role' => 'hr'
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test HR login fails if deactivated.
     */
    public function test_deactivated_hr_cannot_login()
    {
        User::create([
            'name' => 'HR Staff Inactive',
            'email' => 'hr_inactive@ecogreen.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'hr',
            'is_active' => false,
        ]);

        $response = $this->postJson('/hr/login', [
            'email' => 'hr_inactive@ecogreen.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan oleh HR Master.'
            ]);

        $this->assertGuest();
    }

    /**
     * Test forgot password.
     */
    public function test_forgot_password_sends_email()
    {
        Mail::fake();

        $user = User::create([
            'name' => 'John Applicant',
            'email' => 'john@applicant.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        $response = $this->postJson('/forgot-password', [
            'email' => 'john@applicant.com'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('password_reset_tokens', [
            'user_id' => $user->id,
            'is_used' => false
        ]);

        Mail::assertSent(PasswordResetMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * Test reset password.
     */
    public function test_reset_password_updates_user_password()
    {
        $user = User::create([
            'name' => 'John Applicant',
            'email' => 'john@applicant.com',
            'password_hash' => Hash::make('oldpassword'),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        $token = 'test-reset-token-123456';
        DB::table('password_reset_tokens')->insert([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addMinutes(60),
            'is_used' => false,
            'created_at' => now()
        ]);

        $response = $this->postJson('/reset-password', [
            'token' => $token,
            'email' => 'john@applicant.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'role' => 'applicant'
            ]);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->getAuthPassword()));
    }

    /**
     * Test logout redirects and appends loggedout=1.
     */
    public function test_logout_redirects_with_loggedout_parameter()
    {
        $user = User::create([
            'name' => 'John Applicant',
            'email' => 'john@applicant.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login?loggedout=1');
        $this->assertGuest();
    }
}
