<?php

namespace App\UseCases;

use App\Contracts\UserRepositoryContract;
use App\Enums\ContactInformationType;
use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Contracts\Container\BindingResolutionException;

final class RegisterUseCase
{
    private UserRepositoryContract $userRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepositoryContract::class);
    }

    public function registerResidentUser(array $userData)
    {
        $processedUserData = $userData;

        $processedUserData['role_id'] = Role::resident;
        $processedUserData['status_id'] = UserStatus::registered;
        $processedUserData['login'] = $userData['phone'];

        $processedUserData['contact_information'] = [
            [
                'type_id' => ContactInformationType::phone,
                'value' => $userData['phone'],
                'is_preferable' => true
            ]
        ];

        if(array_key_exists('email', $userData))
            $processedUserData['contact_information'][] = [
                'type_id' => ContactInformationType::email,
                'value' => $userData['email']
            ];

        return $this->userRepository->create($processedUserData);
    }
}
