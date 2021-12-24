<?php

namespace App\Http\Requests\RealEstate;

use App\Enums\RealEstateType;
use App\Http\Requests\FormRequestJSON;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class CreateResidentialComplex extends FormRequestJSON
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
        'address' => "string",
        'city_id' => "string",
        'residential_complex_name' => "string",
    ])]
    public function rules(): array
    {
        $rules = [
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'residential_complex_name' => 'required|string'
        ];

        return $rules;
    }
}
