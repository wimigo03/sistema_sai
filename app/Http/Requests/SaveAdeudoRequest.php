<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAdeudoRequest extends FormRequest
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
            'ci' => 'required|string|max:20',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'nro_contrato' => 'required|numeric',
            'cantidad_activos' => [
            'required',
            'integer',
            function ($attribute, $value, $fail) {
                if ($value != 0) {
                    $fail('La cantidad de activos debe ser 0.');
                }
            }
        ],
            'motivo_retiro' => 'required|string|in:CONCLUSION DE CONTRATO,MEMORANDUM DE AGRADECIMIENTO,SOLICITUD PARTICULAR',
            'respaldo' => [
                'nullable',
                'mimes:pdf'
            ],
            'empleado_id' => 'required|exists:empleados,idemp',
        ];
    }
}
