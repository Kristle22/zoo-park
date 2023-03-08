<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Request::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'manager_name' => ['required', 'min:3', 'max:64'],
            'manager_surname' => ['required', 'min:3', 'max:64'],
            'specie_id' => ['required', 'integer', 'min:1'],

        ];
    }
}
