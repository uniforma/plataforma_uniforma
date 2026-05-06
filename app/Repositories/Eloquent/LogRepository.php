<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;

class LogRepository extends BaseRepository
{
    /**
     * @var ActivityLog
     */
    protected $model;

    public function __construct(ActivityLog $model)
    {
        $this->model = $model;
    }
}