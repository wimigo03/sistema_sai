<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigDescuentoRequest extends FormRequest
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
            'minima' => 'required|numeric|min:4|max:8',
            'maxima' => 'required|numeric|min:8|max:12',
            'inicio' => 'required|date_format:H:i|after_or_equal:00:00|before_or_equal:05:00',
            'marcado' => 'required|numeric|min:30|max:45',
        ];
    }

    public function messages()
    {
        return [
            'minima.required' => 'El campo horas de jornada mínima es obligatorio.',
            'minima.numeric' => 'El campo horas de jornada mínima debe ser numérico.',
            'minima.min' => 'El campo horas de jornada mínima debe tener un valor mínimo de :min.',
            'minima.max' => 'El campo horas de jornada mínima debe tener un valor máximo de :max.',

            'maxima.required' => 'El campo horas de jornada máxima es obligatorio.',
            'maxima.numeric' => 'El campo horas de jornada máxima debe ser numérico.',
            'maxima.min' => 'El campo horas de jornada máxima debe tener un valor mínimo de :min.',
            'maxima.max' => 'El campo horas de jornada máxima debe tener un valor máximo de :max.',

            'inicio.required' => 'El campo hora inicio de jornada laboral es obligatorio.',
            'inicio.date_format' => 'El campo hora inicio de jornada laboral debe tener un formato válido (HH:MM).',
            'inicio.after_or_equal' => 'El campo hora inicio de jornada laboral debe ser posterior o igual a las 00:00.',
            'inicio.before_or_equal' => 'El campo hora inicio de jornada laboral debe ser anterior o igual a las 05:00.',

            'marcado.required' => 'El campo tiempo de marcado máxima es obligatorio.',
            'marcado.numeric' => 'El campo tiempo de marcado máxima debe ser numérico.',
            'marcado.min' => 'El campo tiempo de marcado máxima debe tener un valor mínimo de :min.',
            'marcado.max' => 'El campo tiempo de marcado máxima debe tener un valor máximo de :max.',
        ];
    }
}
