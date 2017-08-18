<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
    public $timestamps = false;

    protected $fillable = ['token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function getValidTokenAttribute()
    {
        // TODO проверить, действителен токен во времени или нет
        return $this->created_at /*сверить с текущим временем и настройками восстановления пароля*/ ? true : false;
    }

    public function compareToken($token)
    {
        // сравнение токена с токеном пользователя из БД
        // TODO использование scope для получения актуального токена или использование глобального scope
    }

    public function checkToken()
    {
        // проверка актуальности токена
        // TODO scope с параметрами для получения экземпляра пользователя или ее отсутствие при истекшем токене
    }
}
