<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveFormularioActivoRequest extends FormRequest
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
            'formulario_id' => [
                'required',
                'integer',
                'exists:formularios,id'
            ],
            'activo_id' => [
                'required',
                'integer',
                'exists:actual,id',
                Rule::unique('formulario_activos')->where(function ($query) {
                    return $query->where('formulario_id', $this->formulario_id);
                }),
            ]
        ];
    }
    public function messages()
    {
        return [
            'activo_id.unique' => 'Ya ha sido registrado el codigo'
        ];
    }
}
