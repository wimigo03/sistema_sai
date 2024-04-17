<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class PlantaEmpleadoRequest extends FormRequest
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
            'ci' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:50',
                Rule::unique('empleados')->ignore($this->idemp)->where(function ($query) {
                    return $query->where('tipo', 1);
                }),
            ],
            'nombres' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:50',
            'ap_pat' => 'string|regex:/^[a-zA-Z\s]+$/|max:50',

            'ap_mat' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:50',
            'natalicio' => 'required|date|before:' . Date::today()->subYears(18)->format('Y-m-d'),
            'fecha_ingreso' => 'required|date',
            'idioma' => 'required|string|max:50'
        ];
    }
    public function messages()
    {
        return [
            'ci.required' => 'El N° de Carnet es obligatorio.', // Mensaje personalizado para la regla "required"
            'ci.regex' => 'El formato de N° de Carnet es numérico ',
            

            'ap_mat.required' => 'El Apellido Materno es obligatorio.', // Mensaje personalizado para la regla "required"
            'ap_mat.string' => 'El Apellido Materno debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"
            'ap_mat.regex' => 'El Apellido Materno solo puede contener letras y espacios.',
            'ap_mat.max' => 'El Apellido Materno no puede tener más de 50 caracteres.', // Mensaje personalizado para la regla "max"

            'nombres.required' => 'El Nombre es obligatorio.', // Mensaje personalizado para la regla "required"
            'nombres.string' => 'El Nombre debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"
            'nombres.regex' => 'El Nombre solo puede contener letras y espacios.',
            'nombres.max' => 'El Nombre no puede tener más de 50 caracteres.', // Mensaje personalizado para la regla "max"
            
            'natalicio.before' => 'Debes ser mayor de 18 años.',
            'natalicio.required' => 'La Fecha de Nacimiento es obligatoria.',
            'idioma.required' => 'El idioma originario es obligatorio.'


        ];
    }
}
