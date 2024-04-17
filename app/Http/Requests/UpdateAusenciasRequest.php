<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateAusenciasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('regularizar_access_crear');

        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reg_checks' => 'required|array|min:1',
            'hora_checks' => 'required|array|min:1',
            'observ' =>  'required|string', // Añade la regla 'required' para asegurarte de que el campo no esté vacío


            
            // Otros campos y reglas de validación si los tienes
        ];
    }
    public function messages()
    {
        return [
            'reg_checks.required' => 'Seleccione un tipo de regualrizado. Es obligatorio.', // Mensaje personalizado para la regla "required"
            'reg_checks.string' => 'El tipo de regualrizado debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"
            'reg_checks.regex' => 'El tipo de regualrizado solo puede contener letras y espacios.',
            'reg_checks.max' => 'El tipo de regualrizado no puede tener más de 100 caracteres.', // Mensaje personalizado para la regla "max"
            'hora_checks.required' => 'Seleccione un Horario de regualrizado. Es obligatorio.', // Mensaje personalizado para la regla "required"
            'hora_checks.string' => 'El tipo de entrada debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"
            'hora_checks.regex' => 'El tipo de regualrizado solo puede contener letras y espacios.',
            'hora_checks.max' => 'El tipo de regualrizado no puede tener más de 100 caracteres.', // Mensaje personalizado para la regla "max"
             'observ.required' => 'Seleccione un tipo de regualrizado. Es obligatorio.', // Mensaje personalizado para la regla "required"
             'observ.string' => 'El tipo de regualrizado debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"

        ];
    }
}
