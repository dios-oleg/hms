<?php

namespace App\Http\Requests;

class PasswordValidator extends \Illuminate\Validation\Validator
{
    // TODO можем заменить на Equal и сверять с переданным значением, или же тут проверять на пароль из БД. Или же сравнивать со значением ИЗ БД с конкретной записи
    // например передали назв таблицы, столбца и id записи и должно быть равным тому значению, но тогда должно быть шифрование
    public function validatePassword($attribute, $value, $parameters)
    {
        // проще тут сравнить с записью из БД и ниче не делать, другие методы не понадобятся
        return $value == $parameters[0];
    }

}
