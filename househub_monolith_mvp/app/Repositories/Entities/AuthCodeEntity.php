<?php

namespace App\Repositories\Entities;

use DateTime;

/**
 * @method static create(array $data)
 */
final class AuthCodeEntity extends BaseModel
{
    protected $table = 'auth_codes';

    protected $fillable = [
        'id',
        'user_id',
        'type_id',
        'code',
        'sentAt'
    ];
}
