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
    )
    {

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
    static protected function modelToArray(ResidentUser $user): array
    {
        return [
            ...collect(get_object_vars($user))->reduce(function ($accum, $nextValue, $nextKey) {
                return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
            }, []),
        ];
    }
}
