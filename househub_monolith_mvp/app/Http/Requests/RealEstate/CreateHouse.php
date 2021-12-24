<?php

namespace App\Http\Requests\RealEstate;

use App\Enums\RealEstateType;
use App\Http\Requests\FormRequestJSON;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class CreateHouse extends FormRequestJSON
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
        'number' => "string",
        'floors_total_number' => "string",
        'residential_complex_id' => "array",
        'residential_complex_name' => "string"
    ])]
    public function rules(): array
    {
        $rules = [
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'house_number' => 'required|string',
            'floors_total_number' => 'integer'
        ];

        if ($this->has('residential_complex_id')) {
            $rules['residential_complex_id'] = ['required', 'integer',
                Rule::exists('real_estates', 'id')
                    ->where('type_id', RealEstateType::residentialComplex)
            ];
        } elseif ($this->has('residential_complex_name')) {
            $rules['residential_complex_name'] = 'required|string';
        }

        return $rules;
    }
}
