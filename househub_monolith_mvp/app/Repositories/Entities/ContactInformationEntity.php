<?php

namespace App\Repositories\Entities;

final class ContactInformationEntity extends BaseEntity
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
