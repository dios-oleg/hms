<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;

class SendResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user, $token, $view = 'emails.reset_password', $subject = 'Восстановление пароля';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $token, $view = null, $subject = null)
    {
        $this->user = $user;
        $this->token = $token;
        $this->view = $view != null ? $view : $this->view;
        $this->subject = $subject != null ? $subject : $this->subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $user = $this->user;
        $subject = $this->subject;

        $mailer->send($this->view, ['user' => $user, 'token' => $this->token], function ($m) use ($user, $subject){
           $m->from('fff@ff.by', 'HMS');
           $m->to($user->email, $user->name)->subject($subject);
        });
    }
}
