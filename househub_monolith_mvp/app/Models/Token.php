<?php

namespace App\Models;

use App\Contracts\Services\TokenServiceContract;
use App\Enums\TokenType;
use JetBrains\PhpStorm\ArrayShape;

class Token
{
    public function __construct(
        public string $value,
        public int    $typeId,
        public int    $userId,
        public ?int   $id = null
    )
    {

    }

    public static function generate(int $userId): self
    {
        $tokenService = app()->make(TokenServiceContract::class);

        return new Token(
            value: $tokenService->generateAccessTokenForUser($userId),
            typeId: TokenType::access,
            userId: $userId
        );
    }

    public function publish(): array
    {
        return [
            'value' => $this->value
        ];
    }

    #[ArrayShape([
        'value' => "string",
        'type_id' => "int",
        'user_id' => "int",
        'id' => "int|null"
    ])]
    public function toDB(): array
    {
        $data = [
            'value' => $this->value,
            'type_id' => $this->typeId,
            'user_id' => $this->userId
        ];

        $this->id && $data['id'] = $this->id;

        return $data;
    }
}
