<?php

namespace App\UseCases;

use App\Contracts\AuthCodeRepositoryContract;
use App\Contracts\NotificatorRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Enums\ContactInformationType;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Exceptions\AllNotificatorsUsedException;
use App\Models\CallAuthCode;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Queue\MaxAttemptsExceededException;
use JetBrains\PhpStorm\ArrayShape;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

final class RegisterUseCase
{
    private UserRepositoryContract $userRepository;
    private AuthCodeRepositoryContract $authCodeRepository;
    private NotificatorRepositoryContract $notificatorRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepositoryContract::class);
        $this->authCodeRepository = app()->make(AuthCodeRepositoryContract::class);
        $this->notificatorRepository = app()->make(NotificatorRepositoryContract::class);
    }

    /**
     * Creates a new user
     * @param array $userData
     * @return array
     */
    #[ArrayShape([0 => "array", 'role' => "string", 'status' => "mixed"])]
    public function registerResidentUser(array $userData): array
    {
        $user = $this->userRepository->create($this->prepareDataForRegisterResidentUser($userData));

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
        try{
            $user = $this->userRepository->findByLogin($userData['phone']);

            if($this->authCodeRepository->getAllAttemptsForUser() === config('auth.phone_confirmation.max_attempts')){
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
            // TODO: handle twilio cash shortage
            return new UseCaseResult(status: UseCaseResult::StatusFail, message: "configuration error");
        } catch (AllNotificatorsUsedException $exception) {
            return new UseCaseResult(status: UseCaseResult::StatusFail, message: "all phones are out, wait 5 minutes");
        }
    }

    // TODO: [SRP] remove this into different class
    private function prepareDataForRegisterResidentUser(array $data): array
    {
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

        if (array_key_exists('email', $data))
            $processedUserData['contact_information'][] = [
                'type_id' => ContactInformationType::email,
                'value' => $data['email']
            ];

        return $processedUserData;
    }
}
