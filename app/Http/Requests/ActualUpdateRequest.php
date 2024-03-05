<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualUpdateRequest extends FormRequest
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
            'fotografia' => 'nullable|image',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'descrip' => 'required',
            'observaciones' => 'nullable|min:2',
            'latitude' => 'required',
            'longitude' => 'required',
            'costo' => 'required|integer',
            'codestado' => 'required|in:1,2,3',
            'ambiente_id' => 'required|exists:ambientes,id'
        ];
    }

    public function messages()
    {
        return [
            'fotografia.image' => 'El campo fotografia debe ser una imagen.',
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
