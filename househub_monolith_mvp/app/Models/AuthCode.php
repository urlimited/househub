<?php

namespace App\Models;

use App\Enums\AuthCodeType;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;

final class AuthCode
{
    #[NoReturn]
    public function __construct(
        public string $code,
        private int $userId,
        private int $typeId,
        private ?int $id = null
    ){

    }

    public static function generate($userId): AuthCode{
        return new AuthCode(
            code: rand(1111, 9999),
            userId: $userId,
            typeId: AuthCodeType::phone
        );
    }

    public function publish(){

    }

    #[ArrayShape([
        'code' => "string",
        'user_id' => "int",
        'type_id' => "int",
        'id' => "int|null"
    ])]
    public function toDB(): array{
        $result = [
            'code' => $this->code,
            'user_id' => $this->userId,
            'type_id' => $this->typeId
        ];

        $this->id !== null && $result['id'] = $this->id;

        return $result;
    }
}
