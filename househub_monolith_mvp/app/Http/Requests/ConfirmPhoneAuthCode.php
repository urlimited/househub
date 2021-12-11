<?php

namespace App\Http\Requests;

use JetBrains\PhpStorm\ArrayShape;

class ConfirmPhoneAuthCode extends FormRequestJSON
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
    #[ArrayShape(['phone' => "string", 'code' => "string"])]
    public function rules(): array
    {
        return [
            'phone' => 'required|string|exists:users,login',
            'code' => 'required|string'
        ];
    }
}
