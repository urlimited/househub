<?php

namespace App\Contracts\Repositories;

use App\DTO\UserModelDTO;
use App\Models\User;

interface UserRepositoryContract
{
    public function create(UserModelDTO $userData): User;
    public function update(UserModelDTO $userData): User;
    public function softDelete(int $id): User;
    public function delete(int $id): User;
    public function find(int $id): User;
    public function findByLogin(string $login): User;
}
