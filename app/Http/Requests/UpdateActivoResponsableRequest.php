<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivoResponsableRequest extends FormRequest
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
            'emp_id' => ['required', 'exists:empleados,idemp'],
            'activos' => ['required', 'array'],
            'activos.*.codemp' => ['required', 'exists:empleados,idemp'],
        ];
    }
}
