<?php

namespace App\UseCases;

use App\Contracts\Repositories\UserRepositoryContract;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;

final class RealEstateUseCase
{
    private UserRepositoryContract $userRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepositoryContract::class);
    }

    /**
     * Creates a new user
     * @param array $userData
     * @return array
     * @throws Exception
     */
    public function createRealEstate(array $realEstateData): array
    {
        return [];
    }
}
