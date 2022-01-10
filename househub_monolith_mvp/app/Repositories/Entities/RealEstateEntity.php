<?php

namespace App\Repositories\Entities;

/**
 * @property int $id
 * @property string $address
 * @property int $cityId
 * @property int $parentId
 * @property int $typeId
 */
final class RealEstateEntity extends BaseEntity
{
    protected $table = 'real_estates';

    protected $fillable = [
        'id',
        'address',
        'city_id',
        'parent_id',
        'type_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];
}
