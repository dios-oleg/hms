<?php

namespace App\Http\Requests;

use App\Models\User;

class PasswordValidator extends \Illuminate\Validation\Validator
{
    public function validatePassword($attribute, $password)
    {
        return \Hash::check($password, \Auth::user()->password);
    }

}
