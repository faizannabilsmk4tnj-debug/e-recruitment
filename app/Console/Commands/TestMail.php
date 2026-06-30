<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test password reset email to the specified address to verify SMTP/mail config';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Current Mail Default Driver: " . config('mail.default'));
        $this->info("Host: " . config('mail.mailers.smtp.host'));
        $this->info("Port: " . config('mail.mailers.smtp.port'));
        $this->info("Username: " . config('mail.mailers.smtp.username'));
        
        $this->info("Sending test mail to {$email}...");

        try {
            Mail::to($email)->send(new PasswordResetMail('http://localhost/reset-password/test-token-123456', 'User Test SMTP'));
            $this->info('Success: Mail sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error: Failed to send mail: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}
