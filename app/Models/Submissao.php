<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VoteSubmission;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Submissao extends Model
{
  use HasFactory, LogsActivity;

  protected $table = 'submissoes';
  protected $fillable = ['id', 'title', 'background', 'target_audience', 'knowledge_field', 'status', 'autor_id', 'curator_id'];

  public function votes()
  {
    return $this->hasMany(VoteSubmission::class, 'request_id');
  }

  public function autor()
  {
    // Se a FK for 'autor_id':
    return $this->belongsTo(User::class, 'autor_id');

    // Se for o padrão 'user_id', não precisa do segundo parâmetro:
    // return $this->belongsTo(User::class);
  }

  public function curador()
  {
    return $this->belongsTo(User::class, 'curator_id');
  }

  /**
   * Get the activity log options for the model.
   */
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
      ->useLogName('Submissao')
      ->dontLogEmptyChanges()
      ->logOnlyDirty()
      ->logAll();
  }
}
