<?php

namespace App\Repositories\Entities;

/**
 * @property int id
 * @property int userId
 * @property int typeId
 * @property int value
 * @property string savedAt
 */
final class TokenEntity extends BaseModel
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
