<?php

namespace App\DTO;

use App\Enums\ContactInformationType;
use Exception;
use Illuminate\Support\Str;

final class UserModelDTO extends BaseModelDTO
{
    public function __construct(
        public array $userEntityData,
        public array $contactInformationEntityData,
        public array $statusEntityData,
    )
    {

    }

    /**
     * @throws Exception
     */
    static public function prepareDataToRepository(array $data): static
    {
        $userEntityData = [];
        $contactInformationEntityData = [];
        $statusEntityData = [];

        $dataProcessed = collect($data)->reduce(function ($accum, $nextValue, $nextKey) {
            return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
        }, []);

        $processedUserData = collect($dataProcessed)->filter(function ($val, $key) {
            return in_array($key, ['id', 'role_id', 'status_id', 'first_name', 'last_name', 'phone', 'password']);
        })->toArray();

        foreach ($processedUserData as $userEntityKey => $value) {
            $saveKey = match ($userEntityKey) {
                'phone' => 'login',
                default => $userEntityKey
            };

            $userEntityData[$saveKey] = $processedUserData[$userEntityKey];
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
}
