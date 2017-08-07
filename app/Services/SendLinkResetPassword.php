<?php

namespace App\Services;

use SendMailToken;

class SendLinkResetPassword implements SendLink
{
    static public function sendMessage(App\Models\User $user) 
    {
        $mail = new SendMailToken($user, $view = 'emails.reset_password', $subject = 'Восстановление пароля!');
        $mail->send();
    }
}
