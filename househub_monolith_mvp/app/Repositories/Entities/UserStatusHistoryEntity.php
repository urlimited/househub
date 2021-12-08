<?php

namespace App\Repositories\Entities;

use Carbon\Carbon;

/**
 * @method static create(array $data)
 * @method static where(array $data)
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property Carbon $saved_at
 */
final class UserStatusHistoryEntity extends BaseModel
{
    public $timestamps = false;

    protected $table = 'user_status_histories';

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'saved_at'
    ];

    protected $casts = [
        'saved_at' => 'datetime',
    ];

    public static function findByUserId(int $userId): self{
        return self::where(['user_id' => $userId])
            ->orderBy('saved_at', 'desc')
            ->first();
    }
}
