<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\This;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Creates user into the users table, also inserts contacts if exist and status
     * into status history table
     */
    public static function create(): User
    {
        // Step 1: create user into the users table


        // Step 2: add contacts if exist

        // Step 3: add status into status history table
        return new static();
    }
}
