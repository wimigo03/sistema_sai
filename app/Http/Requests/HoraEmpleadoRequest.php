<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HoraEmpleadoRequest extends FormRequest
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
            //
            'Nombre' => [
                'required',
                'unique:horarios,Nombre',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
                'max:25'
            ],
            'hora_inicio' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaFinal = request()->input('hora_final');
                    $horaJornada = request()->input('inicio_jornada');
                    if ($horaFinal && strtotime($value) > strtotime($horaFinal)) {
                        $fail('La hora de Entrada no puede ser mayor que la hora final.');
                    }
                    if ($horaJornada && strtotime($value) <= strtotime($horaJornada)) {
                        $fail('La hora de Entrada no puede ser menor o igual que la hora del inicio de Jornada.');
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
            'hora_entrada' => [
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaInicio = request()->input('hora_inicio');

                    $horaJornada = request()->input('inicio_jornada');
                    if ($horaInicio && strtotime($value) < strtotime($horaInicio)) {
                        $fail('La hora de Entrada no puede ser menor que la hora de entrada del Turno Mañana.');
                    }
                    $horaSalida = request()->input('hora_salida');

                    if ($horaSalida && strtotime($value) <= strtotime($horaSalida)) {
                        $fail('La hora de Entrada no puede ser menor o igual que la hora de salida del Turno Mañana.');
                    }

                    if ($horaJornada && strtotime($value) <= strtotime($horaJornada)) {
                        $fail('La hora de Entrada no puede ser menor o igual que la hora del inicio de Jornada.');
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
                        $fail('La hora de Salida no puede ser menor que la hora de entrada.');
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
            'nombre.max' => 'El Nombre no puede tener más de 25 caracteres.', // Mensaje personalizado para la regla "max"
            'Nombre.unique' => 'El Nombre de horario ya existe.', // Mensaje personalizado para la regla "unique"

        ];
    }
}
