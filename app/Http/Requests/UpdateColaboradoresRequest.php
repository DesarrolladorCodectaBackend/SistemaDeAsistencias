<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateColaboradoresRequest extends FormRequest
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
    //Rule::unique('candidatos')->ignore($this->route('candidato')),
    public function rules()
    {
        return [
            'nombre' => ['sometimes', 'min:1','max:100'],
            'apellido' => ['sometimes','min:1','max:100'],
            'direccion' => ['sometimes', 'min:1','max:100'],
            'fecha_nacimiento' => ['sometimes'],
            'ciclo_de_estudiante' => ['sometimes'],
            'sede_id' => ['sometimes'],
            'carrera_id' => ['sometimes'],
            'dni' => ['sometimes',
            'min:8',
            'max:8',
            Rule::unique('candidatos')->ignore($this->route('candidato')),
        ],
            'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'areas_id.*' => 'sometimes|integer',
            'actividades_id.*' => 'sometimes|integer',
            'currentURL' => 'sometimes|string',
            'correo' => ['sometimes',
            'min:1',
            'max:250',
            Rule::unique('candidatos')->ignore($this->route('candidato')),
            ] ,

            'celular' => ['sometimes',
            'min:9',
            'max:9',
            Rule::unique('candidatos')->ignore($this->route('candidato'))
            ]
        ];
    }
}
