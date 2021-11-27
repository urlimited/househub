<?php

namespace App\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class UserStatusHistory extends Model
{
    public $timestamps = false;

    protected $table = 'user_status_histories';

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'saved_at'
    ];
}
