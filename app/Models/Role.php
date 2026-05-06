<?php

namespace App\Models;

use App\Traits\Searchable;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Role extends ModelsRole
{
    use LogsActivity, Searchable;

    protected $table = 'roles';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['name', 'guard_name'];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'name' => 'like',
        'guard_name' => '=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

     /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name' => 'string',
        'guard_name' => 'string',
    ];

     /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Função')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }
}
