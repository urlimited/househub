<?php

namespace App\Repositories\Entities;

use DateTime;

/**
 * @method static create(array $data)
 * @method static where()
 */
final class NotificatorEntity extends BaseModel
{
    protected $table = 'notificators';

    protected $fillable = [
        'id',
        'type_id',
        'value'
    ];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];
}
