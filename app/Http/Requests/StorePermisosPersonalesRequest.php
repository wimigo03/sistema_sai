<?php

namespace App\Http\Requests;

use App\Models\PermisoModel;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StorePermisosPersonalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('permisos_access_store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empleado_id' => 'required',
            'permiso_id' => 'required',
            'asunto' => 'required',
            'hora_salida_input' => 'required',
            'hora_retorno' => 'required',
            'fecha_solicitud' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {

                    $permisoId = request()->input('permiso_id');

                    $fechaCarbon = Carbon::createFromFormat('Y-m-d', $value);
                    $fechaMes = $fechaCarbon->format('Y-m');

                    $permisoMes = PermisoModel::find($permisoId);
                    $fechaCarbon2 = Carbon::createFromFormat('Y-m', $permisoMes->mes);
                    $mes = $fechaCarbon2->format('Y-m');
                    if ($fechaMes !== $mes) {
                        $fail('La fecha de solicitud no corresponde al mes seleccionado.');

                    }
                },
            ],
            'duracion' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'fecha_solicitud.required' => 'La fecha de solicitud es obligatoria.', // Mensaje personalizado para la regla "required"
            'fecha_solicitud.date' => 'El fecha de solicitud debe ser formato de fecha.', // Mensaje personalizado para la regla "string"
 
        ];
    }
}
