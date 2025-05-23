<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveArchivoActivoRequest extends FormRequest
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
            'descripcion' => ['required'],
            'ruta' => [
                ($this->route('id') ? 'nullable' : 'required'),
                'mimes:pdf'
            ],
            'activo_id' => [
                'required',
                'integer',
                'exists:actual,id'
            ]
        ];
    }
}
