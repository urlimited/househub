<?php

namespace App\Http\Requests\RealEstate;

use App\Enums\RealEstateType;
use App\Http\Requests\FormRequestJSON;
use Illuminate\Validation\Rule;

class CreateApartment extends FormRequestJSON
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
    public function rules(): array
    {
        $rules = [
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'apartment_number' => 'required|string',
            'floor_number' => 'integer',
            'entrance' => 'string',
        ];

        if ($this->has('house_id')) {
            $rules['house_id'] = ['required', 'integer',
                Rule::exists('real_estates', 'id')
                    ->where('type_id', RealEstateType::house)
            ];
        } else {
            $rules['house_number'] = 'required|string';
            $rules['house_floors_total_number'] = 'integer';
        }

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
