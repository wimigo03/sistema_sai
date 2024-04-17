<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateHoraEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update_horario_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return [
            //
            'Nombre' => 'string|max:100|unique:horarios,Nombre,'.$this->horario->id,
            'hora_inicio' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaFinal = request()->input('hora_final');
                    if ($horaFinal && strtotime($value) > strtotime($horaFinal)) {
                        $fail('La hora de Entrada no puede ser mayor que la hora final.');
                    }
                },
            ],
            'hora_salida' => [
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaInicio = request()->input('hora_inicio');
                    if ($horaInicio && strtotime($value) < strtotime($horaInicio)) {
                        $fail('La hora de Salida no puede ser menor que la hora de entrada.');
                    }
                },
            ],

            'hora_final' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaInicio = request()->input('hora_inicio');
                    $horaEntrada = request()->input('hora_entrada');
                    if ($horaInicio && strtotime($value) < strtotime($horaInicio)) {
                        $fail('La hora de Salida no puede ser menor que la hora de entrada.');
                    }
                    if ($horaEntrada && strtotime($value) < strtotime($horaEntrada)) {
                        $fail('La hora de Salida no puede ser menor que la hora de entrada del Turno Tarde.');
                    }

                },
            ],
            'excepcion' => 'required',
            'inicio_jornada' => 'required',
        ];
      
    }
    public function messages()
    {
        return [
            'Nombre.required' => 'El Nombre es obligatorio.', // Mensaje personalizado para la regla "required"
            'nombre.string' => 'El Nombre debe ser una cadena de texto.', // Mensaje personalizado para la regla "string"
            'nombre.regex' => 'El Nombre solo puede contener letras y espacios.',
            'nombre.max' => 'El Nombre no puede tener más de 20 caracteres.', // Mensaje personalizado para la regla "max"
            'Nombre.unique' => 'El Nombre de horario ya existe.', // Mensaje personalizado para la regla "unique"

        ];
    }
}
