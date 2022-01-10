<?php

namespace App\Repositories\Entities;

use Carbon\Carbon;

/**
 * @property int $id
 * @property int $userId
 * @property int $statusId
 * @property Carbon $savedAt
 */
final class UserStatusHistoryEntity extends BaseEntity
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
            ->orderByDesc('saved_at')
            ->first();
    }
}
