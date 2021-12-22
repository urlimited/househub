<?php

namespace App\Repositories\Entities;

use Carbon\Carbon;

/**
 * @property int id
 * @property int userId
 * @property int typeId
 * @property int notificatorId
 * @property string code
 * @property Carbon sentAt
 */
final class AuthCodeEntity extends BaseModel
{
    protected $table = 'auth_codes';

    protected $fillable = [
        'id',
        'user_id',
        'type_id',
        'notificator_id',
        'code',
        'sent_at'
    ];
}
