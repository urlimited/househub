<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use Exception;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Jwt\JWT;
use Twilio\Rest\Client;

class User
{
    public function __construct(
        public int          $id,
        public string       $firstName,
        public string       $lastName,
        public string       $phone,
        public int          $roleId,
        public int          $statusId,
        public ?string      $email = null,
        protected ?AuthCode $authCode = null
    )
    {

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
        'status' => "mixed"
    ])]
    public function publish(): array
    {
        return [
            ...collect(get_object_vars($this))->filter(function ($val, $key) {
                return collect([
                    'id', 'first_name', 'last_name', 'phone', 'role_id', 'status_id'
                ])->contains(Str::snake($key));
            })->reduce(function ($accum, $nextValue, $nextKey) {
                return [...$accum, Str::snake($nextKey) => $nextValue];
            }, []),

            'role' => Role::getKey($this->roleId),
            'status' => UserStatus::getKey($this->statusId),
        ];
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function callNotify(string $fromPhone)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.auth_token');
        $twilio = new Client($sid, $token);

        //TODO: handle twilio cash shortage and connection errors
        $result = $twilio->calls
            ->create($this->phone,
                $fromPhone,
                [
                    "url" => "http://demo.twilio.com/docs/voice.xml",
                    "timeLimit" => config('services.twilio.time_limit'),
                    "timeout" => config('services.twilio.timeout')
                ]
            );
    }

    public function isBlocked(): bool
    {
        return $this->statusId === UserStatus::blocked;
    }

    public function setAuthCode(AuthCode $authCode): void
    {
        $this->authCode = $authCode;
    }

    /**
     * @param string $toValidateAuthCode
     * @return bool
     * @throws Exception
     */
    public function isAuthCodeValid(string $toValidateAuthCode): bool
    {
        if ($this->authCode === null)
            throw new Exception('Auth code is not set for User');

        $isValid = $this->authCode->code === $toValidateAuthCode;

        if ($isValid)
            $this->statusId = UserStatus::loginConfirmed;

        return $this->authCode->code === $toValidateAuthCode;
    }

    public function generateAccessToken () {

    }
}
