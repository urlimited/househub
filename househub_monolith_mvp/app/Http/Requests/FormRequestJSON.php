<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

abstract class FormRequestJSON extends FormRequest
{
    public function all($keys = null): array
    {
        if(empty($keys)){
            return json_decode($this->getContent(), true);
        }

        return parent::all();
    }
}
