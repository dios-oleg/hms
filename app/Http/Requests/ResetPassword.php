<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|alpha_dash|max:255|min:8|confirmed',
            'token' => 'required|token'
        ];
    }

    public function messages() {
        return [
            'token.required' => 'Токен был утерян. Попробуйте повторно восстановить пароль.',
            'token.token' => 'Срок действия токена истек. Попробуйте повторно восстановить пароль.',
        ];
    }

    // TODO переводы сообщений в отдельный файл, а проверку эту мб ваще убрать? или как-то добавить сравнение со значение из БД
}
