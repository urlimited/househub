<?php

namespace App\Repositories\Entities;

/**
 * @method static create(array $data)
 */
class UserStatusHistoryEntity extends BaseModel
{
    public $timestamps = false;

    protected $table = 'user_status_histories';

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'saved_at'
    ];
}
