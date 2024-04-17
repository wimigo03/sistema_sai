<?php

namespace App\Http\Requests;

use App\Models\LicenciasRipModel;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateLicenciasPersonalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('licencias_access');

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
            'empleado_id' => 'required',
            'licencia_id' => 'required',
            'asunto' => 'required',
            'fecha_solicitud' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {

                    $licenciaId = request()->input('licencia_id');

                    $fechaCarbon = Carbon::createFromFormat('Y-m-d', $value);
                    $fechaAnual = $fechaCarbon->format('Y');

                    $licencia = LicenciasRipModel::find($licenciaId);
                    $fechaCarbon2 = Carbon::createFromFormat('Y', $licencia->licencia);
                    $anio = $fechaCarbon2->format('Y');
                    if ($fechaAnual !== $anio) {
                        $fail('La fecha de solicitud no corresponde al año seleccionado.');

                    }
                },
            ],
            'duracion' => 'required|numeric'
        ];
    }
}
