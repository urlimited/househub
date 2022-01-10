<?php

namespace App\Repositories\Entities;

/**
 * @property int $id
 * @property int $realEstateId
 * @property string $key
 * @property string $value
 */
final class RealEstateAttributeEntity extends BaseEntity
{
    protected $table = 'real_estate_attributes';

    protected $fillable = [
        'id',
        'real_estate_id',
        'key',
        'value'
    ];
}
