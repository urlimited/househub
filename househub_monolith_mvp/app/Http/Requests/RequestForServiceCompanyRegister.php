<?php

namespace App\Http\Requests;

use JetBrains\PhpStorm\ArrayShape;

class RequestForServiceCompanyRegister extends FormRequestJSON
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'bin' => "string",
        'email' => "string",
        'website' => "string",
        'comments' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'bin' => 'required|string|max:255',
            'email' => 'required|string|unique:company,email',
            'website' => 'string|max:255',
            'comments' => 'string|max:255'
        ];
    }
}
