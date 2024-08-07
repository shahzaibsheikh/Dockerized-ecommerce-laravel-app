<?php

namespace App\Listeners;

use App\Events\WelcomeEmail;
use App\Mail\WelcomeEmailSend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailListener implements ShouldQueue
{
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
          'subject'=> 'welcome to learn vern',
          'body'=>'welcome to my watch store',
          'tagline'=> 'learn any course for free'
        ];
        Mail::to((string) $user->email)
        ->send(new WelcomeEmailSend($emailData));
    }
}
