<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiculoRequest extends FormRequest
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
            'codigo' => 'required|string|max:255',
            'codigo_interno' => 'required|string|max:255',
            'da' => 'required|string|max:255',
            'costo_historico' => 'required|integer',
            'documento' => 'required|mimes:pdf',
            'documentos' => 'required',
            'documentos.*' => 'required|mimes:pdf',
            'estado' => 'required|in:BUENO,REGULAR,MALO',
            'nombre_propietario' => 'required|string|max:255',
            'municipio_radicatoria' => 'required|string|max:255',
            'clase_vehiculo' => 'required|string|max:255',
            'tipo_combustible' => 'required|string|max:255',
            'gnv' => 'required|boolean',
            'nro_placa' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'pais_procedencia' => 'required|string|max:255',
            'uso_bien' => 'required|string|max:255',
            'nro_motor' => 'required|string|max:255',
            'nro_chasis' => 'required|string|max:255',
            'cilindrada' => 'required|integer',
            'traccion' => 'required|string|max:255',
            'nro_plazas' => 'required|integer',
            'nro_puertas' => 'required|integer',
            'capacidad_carga' => 'required|integer',
            'nro_poliza_procedencia' => 'required|string|max:255',
            'fecha_poliza' => 'required|date',
            'ultimo_soat' => 'required|integer',
            'ultima_itv' => 'required|integer',
            'b_sisa' => 'required|string|max:255',
            'nro_ruat' => 'required|string|max:255',
            'documento_ruat' =>  'required|mimes:pdf',
            'nro_crpva' => 'required|string|max:255',
            'nro_poliza_seguro' => 'required|string|max:255',
            'vencimiento_poliza_seguro' => 'required|date',
            'departamento' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'distrito' => 'required|integer',
            'canton' => 'required|string|max:255',
            'comunidad' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'kardex_aclaracion' => 'required|string|max:255',
            'ubicacion_satelital' => 'required|string|max:255',
            'imagen' =>  'required|mimes:jpg,jpeg,bmp,png',
            'actual_id' => 'required|exists:actual,id',
        ];
    }
}
