<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;
//use Mail;

class SendResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user, $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $user = $this->user;
        
        $mailer->send('emails.reset_password', ['user' => $user, 'token' => $this->token], function ($m) use ($user){
           $m->from('fff@ff.by', 'YA');
            //$m->to($user->email, $user->name)->subject('Восстановление пароля!');
           $m->to('dmitrochenkooleg@gmail.com', $user->name)->subject('Восстановление пароля!');
        });
    }
}
