<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use App\Enums\CompanyType;
use JetBrains\PhpStorm\ArrayShape;

abstract class Company extends BaseModel
{
    protected array $publishable = [
        'id', 'name', 'bin', 'type_id', 'status_id', 'email'
    ];

    public function __construct(
        public int          $id,
        public string       $name,
        public string       $bin,
        public int          $typeId,
        public int          $statusId,
        public ?string      $email = null
    )
    {

    }

    #[ArrayShape([
        'id' => 'int',
        'name' => 'string',
        'bin' => 'string',
        'type_id' => 'int',
        'status_id' => 'int',
        'email' => 'string',
        'status' => 'string',
        'type' => 'string',
    ])]
    public function publish(array $additionalData = []): array
    {
        return parent::publish([
            'status' => CompanyType::getKey($this->typeId),
            'type' => CompanyStatus::getKey($this->statusId),
            ...$additionalData
        ]);
    }
}
