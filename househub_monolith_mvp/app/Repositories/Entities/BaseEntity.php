<?php

namespace App\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
abstract class BaseEntity extends Model
{
    public $timestamps = false;

    public static $snakeAttributes = true;

    public function __get($key)
    {
        return parent::__get($key) ?? parent::__get(Str::snake($key));
    }
}
