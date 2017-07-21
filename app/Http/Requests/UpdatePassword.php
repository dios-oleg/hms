<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO должен быть авторизован
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|max:255|password', // TODO можем передать значение пароля и с ним сверять
            'password' => 'required|alpha_dash|max:255|min:6|confirmed|different:old_password',
        ];
    }
    
    public function checkPassword($attribute, $value, $parameters, $validator) {
        dd($parameters);
            return $value == 'foo';
    }
    
    // TODO переводы сообщений в отдельный файл, а проверку эту мб ваще убрать? или как-то добавить сравнение со значение из БД
}
