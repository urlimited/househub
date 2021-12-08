<?php

namespace App\Models;

use App\Enums\AuthCodeType;

final class CallAuthCode extends AuthCode
{
    /**
     * @param int $userId
     * @param array<string> $sourceList
     * @return static
     */
    public static function generate(int $userId, array $sourceList = []): self
    {
        $phoneLastChars = substr(collect($sourceList)->shuffle()->first(), -4);

        return new CallAuthCode(
            code: $phoneLastChars,
            userId: $userId,
            typeId: AuthCodeType::phone
        );
    }
}
