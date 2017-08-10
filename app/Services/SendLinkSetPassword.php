<?php

namespace App\Services;

use SendMailToken;

class SendLinkSetPassword implements ISendMessage
{
  static public function sendMessage(App\Models\User $user)
  {
    $mail = new SendMailToken($user, $view = 'emails.specify_password', $subject = 'Добро пожаловать в систему!');
    $mail->send();
  }
}
