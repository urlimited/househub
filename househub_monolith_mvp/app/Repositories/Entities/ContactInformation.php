<?php

namespace App\Repositories\Entities;

use App\Enums\ContactInformationType;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class ContactInformation extends Model
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
