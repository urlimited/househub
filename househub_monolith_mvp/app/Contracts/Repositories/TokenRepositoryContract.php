<?php

namespace App\Contracts\Repositories;

use App\Models\Token;

interface TokenRepositoryContract
{
    public function create(array $data): Token;
    public function delete(): Token;
    public function find(): Token;
}
