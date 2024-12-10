<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $this->info('Testing email configuration...');
        
        try {
            $config = config('mail');
            $this->info('Current mail configuration:');
            $this->info('Host: ' . config('mail.mailers.smtp.host'));
            $this->info('Port: ' . config('mail.mailers.smtp.port'));
            $this->info('Username: ' . config('mail.mailers.smtp.username'));
            
            // Using Mailtrap test email
            Mail::raw('Test email from Music Library', function($message) {
                $message->to('test@example.com')
                        ->subject('Music Library Test Email');
            });
            
            $this->info('Test email sent successfully! Check your Mailtrap inbox.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Please verify your Mailtrap credentials in .env file.');
        }
    }
}
