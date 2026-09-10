<?php

namespace App\Enums;

enum SubmissaoStatus: string
{
    case EmVotacao = 'Em votação';
    case AltaRelevancia = 'Alta Relevancia';
    case EmCuradoria = 'Em curadoria';
    case Oficializado = 'Oficializado';
    case Arquivado = 'Arquivado';

    public function label(): string
    {
        return match ($this) {
            self::EmVotacao => 'Em votação',
            self::AltaRelevancia => 'Alta Relevância',
            self::EmCuradoria => 'Em curadoria',
            self::Oficializado => 'Oficializado',
            self::Arquivado => 'Arquivado',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function allowsInteractions(): bool
    {
        return in_array($this, [
            self::EmVotacao,
            self::AltaRelevancia,
            self::EmCuradoria,
        ], true);
    }
}
