<?php

namespace App\UseCases;

use App\Contracts\Repositories\UserRepositoryContract;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;

final class ResidentUseCase
{
    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepository = $userRepositoryContract;
    }

    /**
     * Creates a new user
     * @param array $userData
     * @return array
     * @throws Exception
     */
    public function assignRealEstate(array $userData): array
    {
        return [];
    }

    public function withdrawRealEstate()
    {

    }
}
