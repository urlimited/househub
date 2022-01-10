<?php

namespace App\Repositories\Entities;

/**
 * @method static create(array $data)
 */
class ContactInformationEntity extends BaseEntity
{
    public $timestamps = false;

    protected $table = 'contact_information';

    protected $fillable = [
        'id',
        'user_id',
        'type_id',
        'value',
        'is_preferable'
    ];
}
