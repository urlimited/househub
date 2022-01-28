<?php

namespace App\Models;

use App\Enums\Role;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class ServiceCompanyUser extends User
{
    public int $roleId = Role::serviceCompanyWorker;

    protected array $publishable = [
        'id', 'first_name', 'last_name', 'phone', 'role_id', 'status_id', 'email'
    ];

    #[Pure]
    public function __construct(
        public int          $id,
        public string       $firstName,
        public string       $lastName,
        public string       $phone,
        public int          $statusId,
        public ?string      $email = null,
        protected ?AuthCode $authCode = null,
        protected ?ServiceCompany $serviceCompany = null
    )
    {
        parent::__construct(
            id: $id,
            firstName: $firstName,
            lastName: $lastName,
            phone: $phone,
            roleId: Role::serviceCompanyWorker,
            statusId: $statusId,
            email: $email,
            authCode: $authCode
        );
    }

    #[ArrayShape([
        'id' => "int",
        'first_name' => "string",
        'last_name' => "string",
        'phone' => "string",
        'role_id' => "int",
        'status_id' => "int",
        'email' => "string",
        'role' => "string",
        'status' => "string"
    ])]
    public function publish(array $additionalData = []): array
    {
        return parent::publish([
            'company' => $this->serviceCompany->name,
            'company_id' => $this->serviceCompany->id,
        ]);
    }

    public function setServiceCompany(ServiceCompany $company){
        $this->serviceCompany = $company;
    }
}
