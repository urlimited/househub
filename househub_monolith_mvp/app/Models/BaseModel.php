<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property array $publishable must be in snake case
 */
abstract class BaseModel
{
    protected array $publishable = [];

    public function publish(array $additionalData = []): array
    {
        return [
            ...collect(get_object_vars($this))->filter(function ($val, $key) {
                return collect($this->publishable)->contains(Str::snake($key));
            })->reduce(function ($accum, $nextValue, $nextKey) {
                return [...$accum, Str::snake($nextKey) => $nextValue];
            }, []),
            ...$additionalData
        ];
    }
}
