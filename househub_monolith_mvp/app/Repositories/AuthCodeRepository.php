<?php

namespace App\Repositories;

use App\Contracts\Repositories\AuthCodeRepositoryContract;
use App\Enums\AuthCodeType;
use App\Models\AuthCode;
use App\Models\CallAuthCode;
use App\Repositories\Entities\AuthCodeEntity;
use Illuminate\Support\Str;

class AuthCodeRepository implements AuthCodeRepositoryContract
{

    public function create(array $data): AuthCode
    {
        $dataProcessed = collect($data)->reduce(function ($accum, $nextValue, $nextKey) {
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $authCode = AuthCodeEntity::create($dataProcessed);

        return match ($authCode->typeId) {
            AuthCodeType::phone => new CallAuthCode(
                code: $authCode->code,
                userId: $authCode->userId,
                typeId: $authCode->typeId,
                notificator_id: $authCode->notificatorId,
                id: $authCode->id
            ),
            default => null,
        };
    }

    public function update(): AuthCode
    {
        // TODO: Implement update() method.

        return new CallAuthCode();
    }

    public function softDelete(): AuthCode
    {
        // TODO: Implement softDelete() method.

        return new CallAuthCode();
    }

    public function delete(): AuthCode
    {
        // TODO: Implement delete() method.

        return new CallAuthCode();
    }

    public function find(): AuthCode
    {
        return new CallAuthCode();
        // TODO: Implement find() method.
    }

    public function getAllAttemptsForUser(): array
    {
        return array();
        // TODO: Implement getAllAttemptsForUser() method.
    }

    public function findLastAuthCodeForUser(int $userId): AuthCode
    {
        $authCode = AuthCodeEntity::where('user_id', $userId)
            ->orderByDesc('sent_at')
            ->firstOrFail();

        return match ($authCode->typeId) {
            AuthCodeType::phone => new CallAuthCode(
                code: $authCode->code,
                userId: $authCode->userId,
                typeId: $authCode->typeId,
                notificator_id: $authCode->notificatorId,
                id: $authCode->id
            ),
            default => null,
        };
    }
}
