<?php

namespace App\Contracts\Repositories;

use App\Exceptions\AllNotificatorsUsedException;
use App\Models\Notificator;
use App\Models\User;

interface NotificatorRepositoryContract
{
    public function create(array $data): Notificator;
    public function update(): Notificator;
    public function softDelete(): Notificator;
    public function delete(): Notificator;
    public function find(int $id): Notificator;

    /**
     * @param int|User $user
     * @throws AllNotificatorsUsedException
     * @return array
     */
    public function getNotUsedNotificatorsBy(int|User $user): array;
}
