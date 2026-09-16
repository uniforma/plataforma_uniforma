<?php

namespace App\Models;

use App\Enums\SubmissaoStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Submissao extends Model
{
    use HasFactory, LogsActivity, Searchable, SoftDeletes;

    protected $table = 'submissoes';

    protected $fillable = ['id', 'title', 'background', 'target_audience', 'knowledge_field', 'status', 'autor_id', 'curator_id'];

    protected $searchable = ['title', 'background', 'target_audience', 'knowledge_field', 'autor.name', 'curador.name'];

    protected $filterable = [
        'status' => '=',
        'curator_id' => '=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    protected $casts = [
        'status' => SubmissaoStatus::class,
    ];

    public function votes()
    {
        return $this->hasMany(VoteSubmission::class, 'request_id');
    }

    public function teachingInterests()
    {
        return $this->hasMany(TeachingInterest::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id')->withTrashed();
    }

    public function curador()
    {
        return $this->belongsTo(User::class, 'curator_id')->withTrashed();
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Submissao')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }
}
