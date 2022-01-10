<?php

namespace App\Contracts\Services;

use App\Models\ResidentUser;

interface TokenServiceContract
{
    static public function generateAccessTokenForUser(int $userId): string;
}
