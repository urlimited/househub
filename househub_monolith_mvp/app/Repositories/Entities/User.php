<?php

namespace App\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @method static create(array $data)
 */
class User extends Model
{
    public $timestamps = false;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'password',
        'first_name',
        'last_name',
        'login',
        'role_id'
    ];

    public function setPasswordAttribute(string $value){
        $this->attributes['password'] = app('hash')->make($value);
    }
}
