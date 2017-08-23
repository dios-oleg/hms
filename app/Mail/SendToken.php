<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $token;
    protected $view;
    protected $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $view, $subject)
    {
        $this->token = $token;
        $this->view = $view;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)
                    ->subject($this->subject)
                    ->with(['token' => $this->token]);
    }
}
