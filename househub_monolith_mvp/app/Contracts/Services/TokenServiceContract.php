<?php

namespace App\Contracts\Services;

use App\Models\User;

interface TokenServiceContract
{
    static public function generateAccessTokenForUser(User $user): string;
}
