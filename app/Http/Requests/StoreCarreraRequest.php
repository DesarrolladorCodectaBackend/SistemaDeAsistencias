<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreraRequest extends FormRequest
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
            'nombre' => 'required|string|min:1|max:100',
        ];
    }

    public function messages(){
        return [
            'nombre' => "Este campo es obligatorio",
            'nombre.max' => "Exceden los 100 caracteres"
        ];
    }
}
