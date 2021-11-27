<?php

namespace App\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    protected $table = 'permissions';
}
