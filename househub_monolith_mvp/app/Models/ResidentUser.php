<?php

namespace App\Models;

use App\Enums\Role;
use JetBrains\PhpStorm\Pure;

final class ResidentUser extends User
{
    public int $typeId = Role::resident;

    #[Pure]
    public function __construct(
        public int          $id,
        public string       $firstName,
        public string       $lastName,
        public string       $phone,
        public int          $statusId,
        public ?string      $email = null,
        protected ?AuthCode $authCode = null
    )
    {
        parent::__construct(
            id: $id,
            firstName: $firstName,
            lastName: $lastName,
            phone: $phone,
            roleId: Role::resident,
            statusId: $statusId,
            email: $email,
            authCode: $authCode
        );
    }
}
