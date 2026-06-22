<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActiveDeactiveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($content)
    {
        $this->data = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromName = 'Tuition Terminal';
        $fromAddress = 'noreply@tuitionterminal.com.bd';

        return $this->from($fromAddress, $fromName)
                    ->subject('Tuition Terminal')
                    ->view('email.active_deactive_email');
    }
}
