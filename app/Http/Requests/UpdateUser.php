<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'last_name_print' => 'required|max:255',
            'patronymic' => 'required|max:255',
            'address' => 'required|max:255',
        ];
    }

    // TODO сообщения перенести в переводы, если одни и те же сообщения буду использоваться для нескольких реквестов
    public function messages() {
        return [
            'first_name.required' => 'Необходимо указать Имя',
            'first_name.max' => 'Необходимо указать корректное Имя',
            'last_name.required' => 'Необходимо указать Фамилию',
            'last_name.max' => 'Необходимо указать корректную Фамилию',
            'last_name_print.required' => 'Необходимо указать Фамилию в родительном падеже',
            'last_name_print.max' => 'Необходимо указать корректную Фамилию',
            'patronymic.required' => 'Необходимо указать Отчество',
            'patronymic.max' => 'Необходимо указать корректное Отчество',
            'address.required' => 'Необходимо указать Адрес',
            'address.max' => 'Необходимо указать корректный Адрес',
        ];
    }
}
