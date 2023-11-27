<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualStoreRequest extends FormRequest
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
            'fotografia' => 'nullable|image|required_without:imagenes',
            'imagenes' => 'nullable|array|required_without:fotografia',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'descrip' => 'required',
            'codcont' => 'required|exists:codcont,codcont',
            'codaux' => 'required|exists:auxiliar,codaux',
            'codestado' => 'required|in:1,2,3',
            'observaciones' => 'nullable|min:2',
            'codarea' => 'required|exists:areas,idarea',
            'codemp' => 'required|exists:empleados,idemp',
            'idcargo' => 'required|exists:file,idfile',
            'org_fin' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'costo' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'fotografia.required_without' => 'Debe subir al menos una fotografía si no hay imágenes.',
            'fotografia.image' => 'El campo fotografia debe ser una imagen.',
            'imagenes.required_without' => 'Debe subir al menos una imagen si no hay fotografía.',
            'imagenes.array' => 'El campo imagenes debe ser un array de imágenes.',
            'imagenes.*.image' => 'Cada elemento en imagenes debe ser una imagen.',
            'imagenes.*.mimes' => 'Las imágenes deben ser de tipo jpeg, png o jpg.',
            'imagenes.*.max' => 'Cada imagen no debe exceder 2048 kilobytes (2MB).',
            'descrip.required' => 'El campo descripción es obligatorio',
            'idcodcont.required' => 'Debe seleccionar un grupo contable',
            'idaux.required' => 'Debe seleccionar un auxiliar',
            'codestado.required' => 'Debe seleccionar un estado del activo',
            'idarea.required' => 'Debe seleccionar una oficina',
            'idemp.required' => 'Debe seleccionar un empleado',
            'idcargo.required' => 'Debe seleccionar el cargo del empleado',
        ];
    }
}
