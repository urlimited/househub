<?php

namespace App\Repositories\Entities;

use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int userId
 * @property int typeId
 * @property int value
 * @property Carbon savedAt
 */
final class TokenEntity extends BaseEntity
{
    protected $table = 'tokens';

    protected $fillable = [
        'id',
        'user_id',
        'type_id',
        'value',
        'saved_at'
    ];
}
