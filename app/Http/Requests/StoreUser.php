<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\Roles;

class StoreUser extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Получение правил валидации для сохранения пользователя.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'position' => 'required|exists:positions,id',
            'role' => 'required|in:' . implode(',', Roles::getConstants()),
        ];
    }

}
