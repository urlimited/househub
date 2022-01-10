<?php

namespace App\Repositories;

use App\Contracts\Repositories\NotificatorRepositoryContract;
use App\Enums\NotificatorType;
use App\Exceptions\AllNotificatorsUsedException;
use App\Models\Notificator;
use App\Models\ResidentUser;
use App\Repositories\Entities\NotificatorEntity;

class NotificatorRepository implements NotificatorRepositoryContract
{

    public function create(array $data): Notificator
    {
        return new Notificator();
    }

    public function update(): Notificator
    {
        // TODO: Implement update() method.

        return new Notificator();
    }

    public function softDelete(): Notificator
    {
        // TODO: Implement softDelete() method.

        return new Notificator();
    }

    public function delete(): Notificator
    {
        // TODO: Implement delete() method.

        return new Notificator();
    }

    public function find(int $id): Notificator
    {
        $notificator = NotificatorEntity::find($id);

        return new Notificator(
            id: $id,
            value: $notificator->value,
            typeId: $notificator->typeId
        );
    }

    /**
     * @return array<Notificator>
     * @throws AllNotificatorsUsedException
     */
    public function getNotUsedNotificatorsBy(int|ResidentUser $user, int $type = NotificatorType::call): array
    {
        if ($user instanceof ResidentUser)
            $user = $user->id;

        $notificators = NotificatorEntity::where('type_id', $type)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('notificator_id')
                    ->from('auth_codes')
                    ->where('user_id', $user)
                    ->where('sent_at', '>', now()->subMinutes(5));
            })->get()->toArray();

        if(empty($notificators))
            throw new AllNotificatorsUsedException();

        return $notificators;
    }
}
