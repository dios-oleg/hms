<?php

namespace App\Services;

interface ISendMessage
{
    static public function sendMessage(App\Models\User $user);
}
