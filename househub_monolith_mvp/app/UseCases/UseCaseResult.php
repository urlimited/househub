<?php

namespace App\UseCases;

final class UseCaseResult
{
    const StatusSuccess = 1;
    const StatusFail = 2;

    public function __construct(
        public int $status,
        public ?string $message = null
    ){

    }
}
