<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function update(): User;
    public function softDelete(): user;
    public function delete(): User;
    public function find(): User;
}
