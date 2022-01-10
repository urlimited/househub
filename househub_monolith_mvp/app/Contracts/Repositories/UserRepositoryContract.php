<?php

namespace App\Contracts\Repositories;

use App\DTO\UserModelDTO;
use App\Models\ResidentUser;

interface UserRepositoryContract
{
    public function create(UserModelDTO $userData): ResidentUser;
    public function update(UserModelDTO $userData): ResidentUser;
    public function softDelete(int $id): ResidentUser;
    public function delete(int $id): ResidentUser;
    public function find(int $id): ResidentUser;
    public function findByLogin(string $login): ResidentUser;
}
