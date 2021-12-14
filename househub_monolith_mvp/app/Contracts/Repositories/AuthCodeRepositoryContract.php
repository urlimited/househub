<?php

namespace App\Contracts\Repositories;

use App\Models\AuthCode;

interface AuthCodeRepositoryContract
{
    public function create(array $data): AuthCode;
    public function update(): AuthCode;
    public function softDelete(): AuthCode;
    public function delete(): AuthCode;
    public function find(): AuthCode;
    public function getAllAttemptsForUser(): array;
    public function findLastAuthCodeForUser(int $userId): AuthCode;
}
