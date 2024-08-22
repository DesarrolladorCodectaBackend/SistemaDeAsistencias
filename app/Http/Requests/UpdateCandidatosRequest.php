<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCandidatosRequest extends FormRequest
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
                'direccion' => ['sometimes','max:100'],
                'fecha_nacimiento' => ['sometimes'],
                'ciclo_de_estudiante' => ['sometimes'],
                'sede_id' => ['required'],
                'carrera_id' => ['required'],

                'dni' => [
                    'sometimes',
                    // 'min:8',
                    'max:8',
                    'nullable',
                    Rule::unique('candidatos')->ignore($this->route('candidato_id'))
                ],

                'correo' => ['sometimes',
                // 'min:1',
                'max:250',
                'nullable',
                Rule::unique('candidatos')->ignore($this->route('candidato_id'))
                ],

                'celular' => ['sometimes',
                // 'min:9',
                'max:9',
                'nullable',
                Rule::unique('candidatos')->ignore($this->route('candidato_id'))
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
            'dni.min' => 'El DNI debe contener 8 números',
            'dni.max' => 'El DNI debe contener 8 números',
            'min' => 'Debe contener más de 1 letra.',
            'max' => 'Debe contener menos de 100 letras.'
        ];
    }
}
