<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveFormularioRequest extends FormRequest
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
            'fecha' => 'required|date',
            'empleado_id' => [
                ($this->route('id') ? 'nullable' : 'required'),
                'integer',
                'exists:empleados,idemp'
            ],
            'user_id' => [
                ($this->route('id') ? 'nullable' : 'required'),
                'integer',
                'exists:users,id'
            ],
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'Debe llenar el campo fecha.',
            'empleado_id.required' => 'Debe llenar el campo ci.',
        ];
    }
}
