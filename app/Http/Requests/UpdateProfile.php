<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'last_name_print' => 'required|min:2|max:255',
            'patronymic' => 'required|max:255',
            'address' => 'required|min:2|max:255',
        ];
    }

    // TODO Добавить переводы или сообщения, в т.ч. на Password
}
