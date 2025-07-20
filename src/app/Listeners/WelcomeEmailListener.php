<?php

namespace App\Listeners;

use App\Events\WelcomeEmail;
use App\Mail\WelcomeEmailSend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailListener
{
    // implements ShouldQueue
    public $queue = 'listener';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WelcomeEmail  $event
     * @return void
     */
    public function handle(WelcomeEmail $event)
    {
        //
        $user = $event->user;
        $emailData = [
            'subject' => 'Thank you for joining our community!',
            'tagline' => 'Coding with Shahzaib',
            'name'    => $user->first_name
        ];
        Mail::to((string) $user->email)
        ->locale('fr-FR')
        ->send(new WelcomeEmailSend($emailData));
        
    }
}
