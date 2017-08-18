<?php

namespace App\Services;

class Token
{
    protected $user;

    public function __construct(App\Models\User $user)
    {
        $this->user = $user;
    }

    public function createToken()
    {
        $token = \Str::random($size);
        $this->user->password_reset()->save(['token' => \Str::random(60)]);
    }

    public function compareToken($token)
    {
        return $user->password_reset->token === $token;
    }

    public function isValidToken()
    {
        $user->password_reset->created_at;
        // проверка актуальности токена
        // TODO scope с параметрами для получения экземпляра пользователя или ее отсутствие при истекшем токене
    }
}
