<?php

namespace App\Http\Requests\RealEstate;

use App\Enums\RealEstateType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApartment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $rules = [
            'address' => 'string|max:255',
            'city_id' => 'integer|exists:cities,id',
            'apartment_number' => 'string',
            'floor_number' => 'integer',
            'entrance' => 'string',
        ];

        if ($this->has('house_id')) {
            $rules['house_id'] = ['required', 'integer',
                Rule::exists('real_estates', 'id')
                    ->where('type_id', RealEstateType::house)
            ];
        } elseif ($this->has('house_number')){
            $rules['house_number'] = 'required|string';
            $rules['house_floors_total_number'] = 'required|integer';
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
