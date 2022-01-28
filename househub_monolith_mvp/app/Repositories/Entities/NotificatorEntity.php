<?php

namespace App\Repositories\Entities;

/**
 * @property int $id
 * @property int $typeId
 * @property string $value
 */
final class NotificatorEntity extends BaseEntity
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
