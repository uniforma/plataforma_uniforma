<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Searchable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Submissao;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity, Searchable;

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
        ];
    }

     /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Usuário')
            ->dontLogEmptyChanges()
            ->logOnlyDirty()
            ->logAll();
    }

    public function UsuarioSubmissao(): HasMany
    {
        return $this->hasMany(Submissao::class, 'autor_id');
    }
}
