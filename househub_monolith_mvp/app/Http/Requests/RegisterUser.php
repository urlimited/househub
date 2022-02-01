<?php

namespace App\Http\Requests;

use App\Enums\Role;
use JetBrains\PhpStorm\ArrayShape;

class RegisterUser extends FormRequestJSON
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
        'first_name' => "string",
        'last_name' => "string",
        'phone' => "string",
        'password' => "string",
        'email' => "string"])]
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,login|max:14',
            'role_id' => 'required|integer|exists:roles',
            'password' => 'string|min:8|max:255',
            'email' => 'email:rfc|max:255'
        ];

        if ($this->input('role_id') === Role::serviceCompanyWorker
            && $this->has('company_id')) {
            $rules['company_id'] = 'required|integer|exists:companies';
        } elseif ($this->input('role_id') === Role::serviceCompanyWorker
            && !$this->has('company_id')) {
            $rules['company_name'] = 'required|string|max:255';
            $rules['company_type'] = 'required|integer|exists:company_types';
            $rules['company_bin'] = 'required|string|max:255';
            $rules['company_address'] = 'required|string|max:255';
            $rules['company_email'] = 'email:rfc|max:255';
            $rules['company_website'] = 'string|max:255';
            $rules['company_registration_comment'] = 'string|max:255';
        }

        return $rules;
    }
}
