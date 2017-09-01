<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordToken
{
    /**
     * Создает токен у указанного пользователя для восстановления пароля.
     * @param  App\Models\User  $user
     * @param  integer $tokenSize
     * @return void
     */
    public static function create($user, $tokenSize = 60)
    {
        $user->password_reset()->updateOrCreate(
            ['id' => $user->id],
            ['token' => Str::random($tokenSize)]
        );
    }

    /**
     * Возвращает экземпляр пользователя в случае существования модели.
     * @param  String $token Токен
     * @return App\Models\User
     */
    public static function getUserByToken($token)
    {
        return self::isValid($token, true);
    }

    /**
     * Проверят существование токена и его актуальность
     * @param  string  $token
     * @param  boolean  $returnUserModel Возвратить модель пользователя, если она существует
     * @return boolean | App\Models\User  Возвращает true, если токен актуальный. Возвращает модель, при ее существовании
     */
    public static function isValid($token, $returnUserModel = false) {
        $record = \App\Models\Password_reset::where('token', $token)->first();

        if ($record && strcmp($record->token, $token) == 0) {
          $date = Carbon::parse($record->created_at);
          $now = Carbon::now();
          $result = $date->diffInSeconds(Carbon::now()) < (config('auth.passwords.users.expire') * 60);

          return  $returnUserModel && $result ? $record->user : $result;
        }

        return null;
    }
}
