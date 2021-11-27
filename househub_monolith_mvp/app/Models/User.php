<?php

namespace App\Models;

class User
{
    private ?int $id;

    public function __construct($data){
        $this->id = $data['id'] ?: null;
    }
}
