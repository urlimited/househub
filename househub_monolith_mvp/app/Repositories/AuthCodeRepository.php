<?php

namespace App\Repositories;

use App\Contracts\AuthCodeRepositoryContract;
use App\Models\AuthCode;
use App\Models\User;
use App\Repositories\Entities\AuthCodeEntity;
use Illuminate\Support\Str;

class AuthCodeRepository implements AuthCodeRepositoryContract
{

    public function create(array $data): AuthCode
    {
        $dataProcessed = collect($data)->reduce(function($accum, $nextValue, $nextKey){
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $authCode = AuthCodeEntity::create($dataProcessed);

        return new AuthCode(
            code: $authCode->code,
            userId: $authCode->userId,
            typeId: $authCode->typeId,
            id: $authCode->id
        );
    }

    public function update(): AuthCode
    {
        // TODO: Implement update() method.

        return new AuthCode();
    }

    public function softDelete(): AuthCode
    {
        // TODO: Implement softDelete() method.

        return new AuthCode();
    }

    public function delete(): AuthCode
    {
        // TODO: Implement delete() method.

        return new AuthCode();
    }

    public function find(): AuthCode
    {
        return new AuthCode();
        // TODO: Implement find() method.
    }
}
