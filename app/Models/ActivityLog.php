<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use Searchable;
    
    /**
     * The attributes that should be used for searching.
     */
    protected $searchable = [
        'log_name',
        'description',
        'subject_type',
        'properties',
    ];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'subject_type' => 'like',
        'causer_type' => 'like',
        'event' => '=',
        'causer_id' => '=',
        'created_from:created_at' => 'date_from',
        'created_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that can be sorted.
     */
    protected $sortable = [
        'id',
        'description',
        'subject_type',
        'causer_type',
        'event',
        'created_at',
        'updated_at',
        'causer_id',
    ];

    /**
     * Tradução dos nomes dos campos para o português.
     */
    public function getEvento()
    {
        return static::getEventoTraducao($this->event);
    }

    /**
     * Tradução dos nomes dos campos para o português.
     */
    public static function getEventoTraducao($eventName)
    {
        switch ($eventName) {
            case 'created':
                return 'Criado';
            case 'updated':
                return 'Atualizado';
            case 'deleted':
                return 'Deletado';
            case 'restored':
                return 'Restaurado';
            default:
                return $eventName;
        }
    }

    /**
     * Tradução dos nomes dos campos para o português.
     */
    public function getDescricao()
    {
        switch ($this->description) {
            case 'created':
                return 'Criação';
            case 'updated':
                return 'Atualização';
            case 'deleted':
                return 'Remoção';
            case 'restored':
                return 'Restauração';
            default:
                return $this->description;
        }
    }

    /**
     * Tradução dos nomes dos campos para o português.
     */
    public static function getDescricaoGenericaEvento($eventName)
    {
        $evento = static::getEventoTraducao($eventName);

        return "Este registro foi {$evento}";
    }

    /**
     * Registra um evento de remoção.
     */
    public static function logDisabledEvent($subject)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($subject)
            ->event('disabled')
            ->log('Este registro foi desativado');
    }

    /**
     * Registra um evento de ativação.
     */
    public static function logEnabledEvent($subject)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($subject)
            ->event('enabled')
            ->log('Este registro foi ativado');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
