<?php

namespace App\Services;

use App\Models\{User, Password_reset};
use App\Mail\ResetPassword;
use Illuminate\Support\Str;

class SendMailToken 
{
    protected $user;
    protected $view;
    protected $subject;
    protected $token;
    
    public function __construct(User $user, $view, $subject, $sizeToken = 60) 
    {
        $this->user = $user;
        $this->user = $view;
        $this->user = $subject;
        $this->token = Str::random($sizeToken);
    }
    
    public function send() 
    {
        $password_reset = new Password_reset(['token' => $this->token]);
        $user->password_reset()->save($password_reset);
        \Mail::to($user->email)->queue(new ResetPassword($token, $view, $subject)); 
    }
}
