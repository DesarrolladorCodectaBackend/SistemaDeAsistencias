<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformesSemanalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'year' => 'required|integer',
                'mes' => 'required|string',
                'area_id' => 'required|integer',
        ];
    }
}
