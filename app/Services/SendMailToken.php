<?php

namespace App\Services;

use App\Models\{User, Password_reset};
use App\Mail\ResetPassword;

class SendMailToken
{
    protected $user;
    protected $view;
    protected $subject;

    /**
    * Отправка сообщения пользователю системы с токеном
    *
    * @param App\Models\User
    * @param String $view
    * @param String $subject
    * @param Integer $sizeToken
    */
    public function __construct(User $user, $view, $subject)
    {
        $this->user = $user;
        $this->user = $view;
        $this->user = $subject;
    }

    /**
    * Отправка сообщения пользователю системы с токеном
    */
    public function send()
    {
        //$password_reset = new Password_reset();
        $this->$user->password_reset()->save(['token' => \Str::random(60)]);
        \Mail::to($user->email)->queue(new ResetPassword($this->user->password_reset->token, $view, $subject));
    }
}
