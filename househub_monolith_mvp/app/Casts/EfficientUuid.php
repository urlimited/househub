<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EfficientUuid implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return null|string
     */
    public function get($model, string $key, $value, array $attributes): null|string
    {
        if (trim($value) === '') {
            return null;
        }

        return Uuid::fromBytes($value)->toString();
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return null|array
     */
    public function set($model, string $key, $value, array $attributes): null|array
    {
        if (trim($value) === '') {
            return null;
        }

        return [
            $key => Uuid::fromString(strtolower($value))->getBytes(),
        ];
    }
}
