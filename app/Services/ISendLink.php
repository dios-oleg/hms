<?php

namespace App\Services;

interface ISendMessage
{
  /**
  * Отправка сообщения (E-Mail или другого типа сообщения) конкретному пользователю системы
  *
  * @param App\Models\User $user
  * @return void
  */
  static public function sendMessage(App\Models\User $user);
}
