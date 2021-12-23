<?php

namespace App\Repositories\Entities;

class UserEntity extends BaseModel
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
