<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'nombre' => 'required',
            'hora_inicio' => 'required',
            'hora_final' => 'required',
            'excepcion' => 'required',
            'inicio_jornada' => 'required',
        ];
    }
}
