<?php

namespace App\UseCases;

use App\Contracts\Repositories\AuthCodeRepositoryContract;
use App\Contracts\Repositories\NotificatorRepositoryContract;
use App\Contracts\Repositories\TokenRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\DTO\UserModelDTO;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Exceptions\AllNotificatorsUsedException;
use App\Models\CallAuthCode;
use App\Models\Token;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\MaxAttemptsExceededException;
use JetBrains\PhpStorm\ArrayShape;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

final class RegisterUseCase
{
    private UserRepositoryContract $userRepository;
    private AuthCodeRepositoryContract $authCodeRepository;
    private NotificatorRepositoryContract $notificatorRepository;
    private TokenRepositoryContract $tokenRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepositoryContract::class);
        $this->authCodeRepository = app()->make(AuthCodeRepositoryContract::class);
        $this->notificatorRepository = app()->make(NotificatorRepositoryContract::class);
        $this->tokenRepository = app()->make(TokenRepositoryContract::class);
    }

    /**
     * Creates a new user
     * @param array $userData
     * @return array
     * @throws Exception
     */
    #[ArrayShape([0 => "array", 'role' => "string", 'status' => "mixed"])]
    public function registerResidentUser(array $userData): array
    {
        $userData['role_id'] = Role::resident;
        $userData['status_id'] = UserStatus::registered;

        $user = $this->userRepository->create(UserModelDTO::prepareDataToRepository($userData));

        return $user->publish();
    }

    /**
     * @param array $companyData
     * @return void
     * @throws Exception
     */
    public function requestForRegistrationServiceCompany(array $companyData)
    {
        $userData['role_id'] = Role::serviceCompanyDirector;
        $userData['status_id'] = UserStatus::registered;

        $user = $this->userRepository->create(UserModelDTO::prepareDataToRepository($companyData));

        return $user->publish();
    }

    /**
     * @param array $userData
     * @return UseCaseResult
     * @throws Exception
     * @throws MaxAttemptsExceededException
     */
    public function sendAuthenticationCall(array $userData): UseCaseResult
    {
        try {
            $user = $this->userRepository->findByLogin($userData['phone']);

            if ($this->authCodeRepository->getAllAttemptsForUser() === config('auth.phone_confirmation.max_attempts')) {
                //TODO: ban the user

                throw new MaxAttemptsExceededException();
            }

            $phone = $this->authCodeRepository->create(
                CallAuthCode::generate(
                    userId: $user->id,
                    sourceList: $this->notificatorRepository->getNotUsedNotificatorsBy($user->id)
                )->toDB()
            )->getNotificator()->value;

            $user->callNotify($phone);

            return new UseCaseResult(status: UseCaseResult::StatusSuccess);
        } catch (TwilioException|ConfigurationException $exception) {
            // TODO: handle twilio cash shortage and connection error
            return new UseCaseResult(status: UseCaseResult::StatusFail, message: "configuration error");
        } catch (AllNotificatorsUsedException $exception) {
            return new UseCaseResult(status: UseCaseResult::StatusFail, message: "all phones are out, wait 5 minutes");
        }
    }

    /**
     * @param array $data
     * @return UseCaseResult
     * @throws BindingResolutionException|Exception
     */
    public function confirmAuthenticationCode(array $data): UseCaseResult
    {
        try {
            $user = $this->userRepository->findByLogin($data['phone']);

            $user->generateAccessToken();

            if ($user->isBlocked())
                throw new Exception('User is blocked');

            $authCode = $this->authCodeRepository->findLastAuthCodeForUser($user->id);

            $user->setAuthCode($authCode);

            if ($user->isAuthCodeValid($data['code'])) {
                $this->userRepository->update(UserModelDTO::prepareDataToRepository([
                    'id' => $user->id,
                    'status_id' => $user->statusId
                ]));

                $accessToken = $this->tokenRepository->create(Token::generate($user->id)->toDB());

                return new UseCaseResult(
                    status: UseCaseResult::StatusSuccess,
                    content: ['access_token' => $accessToken->publish()]
                );
            } else {
                return new UseCaseResult(status: UseCaseResult::StatusFail, message: "auth code is not valid");
            }
        } catch (ModelNotFoundException $exception) {
            return new UseCaseResult(status: UseCaseResult::StatusFail, message: "user is not found");
        }
    }
}
