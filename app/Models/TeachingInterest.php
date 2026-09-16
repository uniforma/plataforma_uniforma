<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class TeachingInterest extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['submissao_id', 'user_id'];

    public function submissao()
    {
        return $this->belongsTo(Submissao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Interesse de Ensino')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }
}
