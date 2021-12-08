<?php

namespace App\Models;

class Notificator
{
    public function __construct(
        public int $id,
        public string $value,
        public int $typeId
    ){

    }

    public function publish(): array{
        return [];
    }
}
