<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function create(User|array $userData): User;
    public function update(User|array $userData): User;
    public function softDelete(): user;
    public function delete(): User;
    public function find(int $id): User;
    public function findByLogin(string $login): User;
}
