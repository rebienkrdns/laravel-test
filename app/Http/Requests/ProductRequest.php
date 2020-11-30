<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    public $validator = null;

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
            'name'          => 'required|string',
            'description'   => 'required|string',
            'quantity'      => 'required|numeric|min:1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'El campo :attribute es requerido',
            'name.string'           => 'El campo :attribute no es un string o texto',

            'description.required'  => 'El campo :attribute es requerido',
            'description.string'    => 'El campo :attribute no es un string o texto',

            'quantity.required'     => 'El campo :attribute es requerido',
            'quantity.numeric'      => 'El campo :attribute no numérico',
            'quantity.min'          => 'El valor del campo :attribute mínimo permitido es 1'
        ];
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
