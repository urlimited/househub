<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use JetBrains\PhpStorm\ArrayShape;

class User
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $phone;
    public ?string $email;
    public int $role_id;
    public int $status_id;

    public function __construct(array $data = []){
        $this->id = $data['id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone = $data['phone'];
        $this->role_id = $data['role_id'];
        $this->status_id = $data['status_id'];
        array_key_exists('email', $data) && $this->email = $data['email'];
    }

    #[ArrayShape([
        0 => "array",
        'role' => "string",
        'status' => "mixed"
    ])]
    public function publish(): array{
        return [
            ... (array)$this,
            'role' => Role::getKey($this->role_id),
            'status' => UserStatus::getKey($this->status_id),
        ];
    }
}
