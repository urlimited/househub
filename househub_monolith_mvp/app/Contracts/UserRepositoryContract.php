<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function create(array $data): User;
    public function update(): User;
    public function softDelete(): user;
    public function delete(): User;
    public function find(): User;
}
