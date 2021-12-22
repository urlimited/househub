<?php

namespace App\Repositories;

use App\Contracts\Repositories\TokenRepositoryContract;
use App\Models\CallAuthCode;
use App\Models\Token;
use App\Repositories\Entities\TokenEntity;
use Illuminate\Support\Str;

class TokenRepository implements TokenRepositoryContract
{

    public function create(array $data): Token
    {
        $dataProcessed = collect($data)->reduce(function ($accum, $nextValue, $nextKey) {
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $token = TokenEntity::create($dataProcessed);

        return new Token(
            value: $token->value,
            typeId: $token->typeId,
            userId: $token->userId,
            id: $token->id
        );
    }

    public function delete(): Token
    {
        // TODO: Implement delete() method.

        return new Token();
    }

    public function find(): Token
    {
        return new CallAuthCode();
        // TODO: Implement find() method.
    }
}
