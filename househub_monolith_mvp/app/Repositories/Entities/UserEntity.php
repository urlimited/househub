<?php

namespace App\Repositories\Entities;

/**
 * @property int $id
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $login
 * @property int $roleId
 */
final class UserEntity extends BaseEntity
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
