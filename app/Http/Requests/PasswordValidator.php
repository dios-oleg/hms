<?php

namespace App\Http\Requests;

use App\Models\User;

class PasswordValidator extends \Illuminate\Validation\Validator
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

}
