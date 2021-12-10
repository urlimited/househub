<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

abstract class FormRequestJSON extends FormRequest
{
    /**
     * Get the validator instance for the request.
     *
     * @return Validator
     * @throws BindingResolutionException
     */
    protected function getValidatorInstance(): Validator
    {
        $factory = $this->container->make('Illuminate\Validation\Factory');

        if (method_exists($this, 'validator'))
        {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }
        return $factory->make(
            $this->json()->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }
}
