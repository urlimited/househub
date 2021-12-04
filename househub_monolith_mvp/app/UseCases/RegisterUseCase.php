<?php

namespace App\UseCases;

use App\Contracts\AuthCodeRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Enums\ContactInformationType;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\AuthCode;
use Illuminate\Contracts\Container\BindingResolutionException;

final class RegisterUseCase
{
    private UserRepositoryContract $userRepository;
    private AuthCodeRepositoryContract $authCodeRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepositoryContract::class);
        $this->authCodeRepository = app()->make(AuthCodeRepositoryContract::class);
    }

    /**
     * Creates a new user, after that generates and sends the authentication code to him
     * @param array $userData
     */
    public function registerResidentUser(array $userData): array
    {
        // Create a new user
        $processedUserData = $this->prepareDataForRegisterResidentUser($userData);

        $user = $this->userRepository->create($processedUserData);

        // Generate and send code to the user
        $this->authCodeRepository->create(AuthCode::generate($user->id)->toDB());

        return $user->publish();
    }

    // TODO: [SRP] remove this into different class
    private function prepareDataForRegisterResidentUser(array $data): array {
        $processedUserData = $data;

        $processedUserData['role_id'] = Role::resident;
        $processedUserData['status_id'] = UserStatus::registered;
        $processedUserData['login'] = $data['phone'];

        $processedUserData['contact_information'] = [
            [
                'type_id' => ContactInformationType::phone,
                'value' => $data['phone'],
                'is_preferable' => true
            ]
        ];

        if(array_key_exists('email', $data))
            $processedUserData['contact_information'][] = [
                'type_id' => ContactInformationType::email,
                'value' => $data['email']
            ];

        return $processedUserData;
    }
}
