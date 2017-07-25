<?php

namespace App\Http\Requests;

use App\Models\User;

class PasswordValidator extends \Illuminate\Validation\Validator
{
    public function validatePassword($attribute, $value)
    {
        return \Hash::check($value, \Auth::user()->password);
    }

}
