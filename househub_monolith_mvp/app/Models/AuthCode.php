<?php

namespace App\Models;

use App\Contracts\Repositories\NotificatorRepositoryContract;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;

abstract class AuthCode
{
    #[NoReturn]
    public function __construct(
        public string $code,
        protected int $userId,
        protected int $typeId,
        protected int $notificator_id,
        protected ?int $id = null
    ){

    }

    public abstract static function generate(int $userId, array $sourceList = []): AuthCode;

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
            'type_id' => $this->typeId,
            'notificator_id' => $this->notificator_id
        ];

        $this->id !== null && $result['id'] = $this->id;

        return $result;
    }

    public function getNotificator(): Notificator
    {
        return app()->make(NotificatorRepositoryContract::class)->find($this->notificator_id);
    }
}
