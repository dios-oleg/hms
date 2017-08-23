<?php

namespace App\Services;

class PasswordToken
{
    protected $user;

    public function __construct(App\Models\User $user)
    {
        $this->user = $user;
    }

    public function create($size = 60)
    {
        $this->user->password_reset()->save(['token' => \Str::random($size)]);
    }

    public function compare($token)
    {
        return $user->password_reset->token === $token; // FIXME а если нет записи?
    }

    public function isValid()
    {
        $user->password_reset->created_at;
        // проверка актуальности токена
        // TODO scope с параметрами для получения экземпляра пользователя или ее отсутствие при истекшем токене
    }

    // TODO функция для проверки актуальности токена и полученного токена
}
