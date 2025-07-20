<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WelcomeEmailSend;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->email=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info('Processing EmailJob for user: ' . $this->email['first_name']);

            $data = [
                'subject' => ' Happy Coding',
                'tagline' => 'Coding with Shahzaib',
                'name' => $this->email['first_name']
            ];

            Mail::to("khurshid.shahzaib@gmail.com")
                ->locale('en')
                ->send(new WelcomeEmailSend($data));

            Log::info('Email sent successfully to ' . $this->email['first_name']);
        } catch (\Exception $e) {
            Log::error('Error sending welcome email: ' . $e->getMessage());
            throw $e;
        }
    }

}
