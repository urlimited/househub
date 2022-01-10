<?php

namespace App\Contracts\Repositories;

use App\Exceptions\AllNotificatorsUsedException;
use App\Models\Notificator;
use App\Models\ResidentUser;

interface NotificatorRepositoryContract
{
    public function create(array $data): Notificator;
    public function update(): Notificator;
    public function softDelete(): Notificator;
    public function delete(): Notificator;
    public function find(int $id): Notificator;

    /**
     * @param int|ResidentUser $user
     * @return array
     *@throws AllNotificatorsUsedException
     */
    public function getNotUsedNotificatorsBy(int|ResidentUser $user): array;
}
