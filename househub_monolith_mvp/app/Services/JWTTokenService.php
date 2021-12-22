<?php

namespace App\Services;

use App\Contracts\Services\TokenServiceContract;
use App\Models\User;
use Exception;
use Twilio\Jwt\JWT;

class JWTTokenService implements TokenServiceContract
{

    /**
     * @throws Exception
     */
    static public function generateAccessTokenForUser(int $userId): string
    {
        $payload = [
            'sub' => $userId,
            'iss' => 'https://househub.digital',
            'exp' => now()->addMonth()->timestamp,
            'aud' => ['mobile']
        ];

        return "Bearer " . JWT::encode($payload, config('auth.jwt_client_private_key'), 'HS512');
    }
}
