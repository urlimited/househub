<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use Exception;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class User
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public ?string $email;
    public int $roleId;
    public int $statusId;

    protected ?AuthCode $authCode;

    // TODO: refactor in 8.0 style
    public function __construct(array $data = [])
    {
        $this->id = $data['id'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->phone = $data['phone'];
        $this->roleId = $data['role_id'];
        $this->statusId = $data['status_id'];
        array_key_exists('email', $data) && $this->email = $data['email'];
    }

    #[ArrayShape([
        0 => "array",
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

        $message = $twilio->calls
            ->create($this->phone,
                $fromPhone,
                [
                    "url" => "http://demo.twilio.com/docs/voice.xml",
                    "timeLimit" => config('services.twilio.time_limit'),
                    "timeout" => config('services.twilio.timeout')
                ]
            );

        print($message->sid);
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
}
