<?php

namespace App\DTO;

use App\Enums\ContactInformationType;
use App\Models\ResidentUser;
use Exception;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

final class UserModelDTO extends BaseModelDTO
{
    public function __construct(
        public array $userEntityData,
        public array $contactInformationEntityData,
        public array $statusEntityData,
        public array $userAttributesData,
    )
    {

    }

    static public function repositoryCreateData(array $systemValidatedData): static
    {
        $selfDTO = new self(
            userEntityData: [],
            contactInformationEntityData: [],
            statusEntityData: [],
            userAttributesData: []
        );

        $dataProcessed = collect($systemValidatedData)->reduce(function ($accum, $nextValue, $nextKey) {
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $selfDTO->prepareUserEntityData($dataProcessed);
        $selfDTO->prepareContactInformationEntityData($dataProcessed);
        $selfDTO->prepareStatusEntityData($dataProcessed);
        $selfDTO->prepareUserAttributesData($dataProcessed);

        return $selfDTO;
    }

    static public function repositoryUpdateData(array $systemValidatedData): static
    {
        $selfDTO = new self(
            userEntityData: [],
            contactInformationEntityData: [],
            statusEntityData: [],
            userAttributesData: []
        );

        $dataProcessed = collect($systemValidatedData)->reduce(function ($accum, $nextValue, $nextKey) {
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $selfDTO->prepareUserEntityData($dataProcessed);
        $selfDTO->prepareContactInformationEntityData($dataProcessed);
        $selfDTO->prepareStatusEntityData($dataProcessed);
        $selfDTO->prepareUserAttributesData($dataProcessed);

        return $selfDTO;
    }

    /**
     * @throws Exception
     */
    //TODO: divide this into update and create methods (why? in order to check existence of id property)
    static public function prepareDataToRepository(array|ResidentUser $data): static
    {
        $userEntityData = [];
        $contactInformationEntityData = [];
        $statusEntityData = [];

        if ($data instanceof ResidentUser)
            $data = self::modelToArray($data);

        $dataProcessed = collect($data)->reduce(function ($accum, $nextValue, $nextKey) {
            return [...$accum, Str::snake($nextKey) => $nextValue];
        }, []);

        $processedUserData = collect($dataProcessed)->filter(function ($val, $key) {
            return in_array($key, ['id', 'role_id', 'status_id', 'first_name', 'last_name', 'phone', 'password']);
        })->toArray();

        foreach ($processedUserData as $userEntityKey => $value) {
            $saveKey = match ($userEntityKey) {
                'phone' => 'login',
                default => $userEntityKey
            };

            $userEntityData[$saveKey] = $value;
        }

        $processedContactsData = collect($dataProcessed)->filter(function ($val, $key) {
            return in_array($key, ['phone', 'email']);
        })->toArray();

        foreach ($processedContactsData as $contactInformationEntityKey => $value) {
            $contactInformationEntityData[] = match ($contactInformationEntityKey) {
                'phone' => [
                    'type_id' => ContactInformationType::phone,
                    'value' => $processedContactsData['phone'],
                    'is_preferable' => true
                ],
                'email' => [
                    'type_id' => ContactInformationType::email,
                    'value' => $processedContactsData['email']
                ],
                default => throw new Exception('Unknown data for contact information')
            };
        }

        if (in_array('status_id', array_keys($dataProcessed))) {
            $statusEntityData['status_id'] = $dataProcessed['status_id'];
        }

        return new self(
            userEntityData: $userEntityData,
            contactInformationEntityData: $contactInformationEntityData,
            statusEntityData: $statusEntityData
        );
    }

    static public function repositoryDeleteData(array|ResidentUser $data): static
    {
        return new self();
    }

    #[ArrayShape([
        'id' => "int",
        'first_name' => "string",
        'last_name' => "string",
        'phone' => "string",
        'email' => "string",
        'role_id' => "int",
        'status_id' => "int"
    ])]
    static private function modelToArray(ResidentUser $user): array
    {
        return [
            ...collect(get_object_vars($user))->reduce(function ($accum, $nextValue, $nextKey) {
                return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
            }, []),
        ];
    }

    private function prepareUserEntityData(array $formattedData){
        $processedUserData = collect($formattedData)->only(
            ['id', 'role_id', 'first_name', 'last_name', 'phone', 'password']
        )->all();

        foreach ($processedUserData as $userEntityKey => $value) {
            $safeKey = match ($userEntityKey) {
                'phone' => 'login',
                default => $userEntityKey
            };

            $this->userEntityData[$safeKey] = $value;
        }
    }

    private function prepareContactInformationEntityData(array $formattedData){
        $processedContactsData = collect($formattedData)->only(['phone', 'email'])->all();

        foreach ($processedContactsData as $contactInformationEntityKey => $value) {
            $this->contactInformationEntityData[] = match ($contactInformationEntityKey) {
                'phone' => [
                    'type_id' => ContactInformationType::phone,
                    'value' => $processedContactsData['phone'],
                    'is_preferable' => true
                ],
                'email' => [
                    'type_id' => ContactInformationType::email,
                    'value' => $processedContactsData['email']
                ],
                default => throw new Exception('Unknown data for contact information')
            };
        }
    }

    private function prepareStatusEntityData(array $formattedData){
        $userId = collect($formattedData)->only(['user_id'])->first();

        $statusId = collect($formattedData)->only(['status_id'])->first();

        if($statusId) {
            $this->statusEntityData['status_id'] = $statusId;

            if($userId)
                $this->statusEntityData['user_id'] = $userId;
        }
    }

    private function prepareUserAttributesData(array $formattedData){
        $processedUserData = collect($formattedData)->only(
            ['company_id', 'user_registration_comment']
        )->all();

        $userId = collect($formattedData)->only(['user_id'])->first();

        foreach ($processedUserData as $userAttributeKey => $value) {
            $safeKey = match ($userAttributeKey) {
                default => $userAttributeKey
            };

            $preparedAttributeData = [
                'key' => $safeKey,
                'value' => $value
            ];

            if($userId)
                $preparedAttributeData['user_id'] = $userId;


            $this->userEntityData[] = $preparedAttributeData;
        }
    }
}
