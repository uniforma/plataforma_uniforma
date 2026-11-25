<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\Traits\Searchable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'cpf', 'gender', 'password', 'skills', 'knowledge_areas', 'recommendation_emails_enabled'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, LogsActivity, Notifiable, Searchable, SoftDeletes;

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['name', 'email'];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'name' => 'like',
        'email' => 'like',
        'role' => 'roles.name:=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    public function resolveAuthGuardName(): ?string
    {
        return $this->roles()
            ->limit(1)
            ->value('guard_name');
    }

    protected static function booted(): void
    {
        static::saved(function (self $user) {
            if ($user->wasChanged('skills') || $user->wasRecentlyCreated) {
                KnowledgeTerm::remember(KnowledgeTerm::SKILL, $user->skills ?? []);
            }
            if ($user->wasChanged('knowledge_areas') || $user->wasRecentlyCreated) {
                KnowledgeTerm::remember(KnowledgeTerm::AREA, $user->knowledge_areas ?? []);
            }
        });
    }

    public function setSkillsAttribute(?array $values): void
    {
        $this->attributes['skills'] = json_encode($this->normalizeTerms($values));
    }

    public function setKnowledgeAreasAttribute(?array $values): void
    {
        $this->attributes['knowledge_areas'] = json_encode($this->normalizeTerms($values));
    }

    private function normalizeTerms(?array $values): array
    {
        return collect($values ?? [])->map(fn ($value) => KnowledgeTerm::normalize((string) $value))
            ->filter()->unique()->values()->all();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
            'knowledge_areas' => 'array',
            'recommendation_emails_enabled' => 'boolean',
        ];
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Usuário')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }

    public function UsuarioSubmissao(): HasMany
    {
        return $this->hasMany(Submissao::class, 'autor_id');
    }

    public function submissoes(): HasMany
    {
        return $this->hasMany(Submissao::class, 'autor_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(VoteSubmission::class);
    }

    public function teachingInterests(): HasMany
    {
        return $this->hasMany(TeachingInterest::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
