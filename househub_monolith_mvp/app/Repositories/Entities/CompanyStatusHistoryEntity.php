<?php

namespace App\Repositories\Entities;

use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $companyId
 * @property int $statusId
 * @property Carbon $savedAt
 */
final class CompanyStatusHistoryEntity extends BaseEntity
{
    protected $table = 'company_status_histories';

    protected $fillable = [
        'id',
        'company_id',
        'status_id',
        'saved_at'
    ];
}
