<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class VoteSubmission extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'vote_submissions';

    protected $fillable = ['request_id', 'user_id'];

    public function submissao()
    {
        return $this->belongsTo(Submissao::class, 'request_id');
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
            ->setDescriptionForEvent(fn (string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Voto Submissao')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }
}
