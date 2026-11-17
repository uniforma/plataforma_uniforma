<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeTerm extends Model
{
    public const AREA = 'area';

    public const SKILL = 'skill';

    protected $fillable = ['kind', 'name'];

    /** Normalize names at the persistence boundary, including user-created terms. */
    public static function normalize(string $value): string
    {
        return mb_strtoupper(trim(preg_replace('/\s+/u', ' ', $value) ?? $value), 'UTF-8');
    }

    public static function remember(string $kind, iterable $names): void
    {
        foreach ($names as $name) {
            $normalized = self::normalize((string) $name);
            if ($normalized !== '') {
                self::query()->firstOrCreate(['kind' => $kind, 'name' => $normalized]);
            }
        }
    }

    public static function options(string $kind)
    {
        return self::query()->where('kind', $kind)->orderBy('name')->pluck('name');
    }
}
