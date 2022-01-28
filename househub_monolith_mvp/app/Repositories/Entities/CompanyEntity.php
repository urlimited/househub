<?php

namespace App\Repositories\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $bin
 * @property string $email
 * @property string $website
 * @property int $typeId
 * @property string $comments
 */
final class CompanyEntity extends BaseEntity
{
    protected $table = 'companies';

    protected $fillable = [
        'id',
        'name',
        'bin',
        'email',
        'website',
        'type_id',
        'comments'
    ];
}
