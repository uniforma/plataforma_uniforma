<?php

namespace App\Models;

use App\Traits\Searchable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use LogsActivity, Searchable;

    protected $table = 'permissions';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['name', 'description', 'guard_name'];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'name' => 'like',
        'description' => 'like',
        'guard_name' => '=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'guard_name',
    ];

     /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'guard_name' => 'string',
    ];

     /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Permissão')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }
}
