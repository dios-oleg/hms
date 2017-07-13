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
    
    public function messages() {
        return [
            'first_name.required' => 'Необходимо указать имя',
            'last_name.required' => 'Необходимо указать фамилию',
            'last_name_print.required' => 'Необходимо указать фамилию в родительном падеже',
            'patronymic.required' => 'Необходимо указать отчество',
            'address.required' => 'Необходимо указать адрес проживания',
        ];
    }
}
