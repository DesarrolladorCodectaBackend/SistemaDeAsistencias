<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCandidatosRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'nombre' => ['required', 'min:1','max:100'],
                'apellido' => ['required','min:1','max:100'],
                'direccion' => ['required', 'min:1','max:100'],
                'fecha_nacimiento' => ['required'],
                'ciclo_de_estudiante' => ['required'],
                'sede_id' => ['required'],
                'carrera_id' => ['required'],

                'dni' => [
                    'required',
                    'min:8',
                    'max:8',
                    Rule::unique('candidatos')->ignore($this->route('candidatos'))
                ],

                'correo' => ['required',
                'min:1',
                'max:250',
                Rule::unique('candidatos')->ignore($this->route('candidatos'))
                ],

                'celular' => ['required',
                'min:9',
                'max:9',
                Rule::unique('candidatos')->ignore($this->route('candidatos'))
                ]
        ];
    }

    public function messages()
    {
        return[
            'required' => 'Campo obligatorio',
            'dni.unique' => 'Error. DNI en uso.',
            'correo.unique' => 'Error. Correo en uso',
            'celular.unique' => 'Error. Nro.celular en uso',
            'dni.min' => 'El DNI debe contener 8 caracteres',
            'dni.max' => 'El DNI debe contener 8 caracteres'
        ];
    }
}
