<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmailSend extends Mailable
{
    use Queueable, SerializesModels;
    protected $emailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build(){

        return $this->from('hi@demomailtrap.com','Shahzaib Happy Coding')
           ->replyTo('hi@demomailtrap.com','Reply To Email')
           ->subject($this->emailData['subject'])
           ->view('mail_template.index',['name'=>$this->emailData['name']])
           ->with([
                 'tagline'=> $this->emailData['tagline']
           ]);
    }




}
