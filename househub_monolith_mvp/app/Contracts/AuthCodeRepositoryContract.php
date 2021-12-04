<?php

namespace App\Contracts;

use App\Models\AuthCode;

interface AuthCodeRepositoryContract
{
    public function create(array $data): AuthCode;
    public function update(): AuthCode;
    public function softDelete(): AuthCode;
    public function delete(): AuthCode;
    public function find(): AuthCode;
}
