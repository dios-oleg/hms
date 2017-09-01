<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\PasswordToken;

class ApplicationValidator extends \Illuminate\Validation\Validator
{
    /**
     * Проверяет, равны ли пароли.
     *
     * @param  String  $attribute
     * @param  String  $password
     * @return bool
     */
    public function validatePassword($attribute, $password)
    {
        return \Hash::check($password, \Auth::user()->password);
    }

    /**
     * Проверяет, действительный ли токен.
     *
     * @param  String  $attribute
     * @param  String  ;token
     * @return bool
     */
    public function validateToken($attribute, $token)
    {
        return PasswordToken::isValid($token) == true;
    }

}
