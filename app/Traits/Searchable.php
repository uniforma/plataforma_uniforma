<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Searchable
{
    /**
     * Aplica o escopo de busca na query com suporte a filtros avançados.
     *
     * @param Builder $query A instância do Eloquent Query Builder.
     * @param Request|object|null $request O request ou objeto com parâmetros de busca.
     * @return Builder
     */
    public function scopeApplyQueryFilters(Builder $query, $request = null): Builder
    {
        if (!$request) {
            return $query;
        }

        // Converte objeto request em array se necessário
        $filters = $this->extractFilters($request);

        // Aplica busca global por texto
        if (!empty($filters['search'])) {
            $this->applyGlobalSearch($query, $filters['search']);
        }

        // Aplica filtros específicos
        $this->applyFilters($query, $filters);

        // Aplica ordenação
        $this->applySorting($query, $filters);

        return $query;
    }

    /**
     * Extrai filtros do request
     */
    private function extractFilters($request): array
    {
        if (is_array($request)) {
            return $request;
        }

        if (is_object($request) && method_exists($request, 'all')) {
            return $request->all();
        }

        if (is_object($request)) {
            return (array) $request;
        }

        return [];
    }

    /**
     * Retorna as colunas reais definidas em $filterable (considera mapeamentos "param:column").
     */
    private function getFilterableDbColumns(): array
    {
        if (!property_exists($this, 'filterable') || !is_array($this->filterable)) {
            return [];
        }

        $cols = [];
        foreach ($this->filterable as $key => $_op) {
            if (str_contains($key, ':')) {
                [, $dbColumn] = explode(':', $key, 2);
            } else {
                $dbColumn = $key;
            }
            $cols[] = $dbColumn;
        }

        return array_unique($cols);
    }

    /**
     * Verifica se a coluna é filtrável (considerando mapeamentos).
     */
    private function isFilterableColumn(string $column): bool
    {
        return in_array($column, $this->getFilterableDbColumns(), true);
    }

    /**
     * Aplica busca global por texto nas colunas searchable
     */
    private function applyGlobalSearch(Builder $query, string $term): void
    {
        if (!property_exists($this, 'searchable') || !is_array($this->searchable)) {
            return;
        }

        $query->where(function (Builder $q) use ($term) {
            $searchTerm = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $term) . '%';

            foreach ($this->searchable as $column) {
                // Suporte a busca em relacionamentos (ex: 'user.name')
                if (str_contains($column, '.')) {
                    $this->applyRelationshipSearch($q, $column, $searchTerm);
                } else {
                    $q->orWhere($column, 'like', $searchTerm);
                }
            }
        });
    }

    /**
     * Aplica filtros específicos baseados nas colunas filterable
     */
    private function applyFilters(Builder $query, array $filters): void
    {
        if (!property_exists($this, 'filterable') || !is_array($this->filterable)) {
            return;
        }

        foreach ($this->filterable as $key => $operator) {
            // Extrai o nome do parâmetro e o nome da coluna
            $paramName = $key;
            $dbColumn = $key;
            if (str_contains($key, ':')) {
                [$paramName, $dbColumn] = explode(':', $key);
            }

            if (!isset($filters[$paramName])) {
                continue;
            }

            $value = $filters[$paramName];

            // Verifica se o valor é nulo
            if (is_null($value)) {
                $this->applyNullFilter($query, $dbColumn, true);
                continue;
            }

            if ($operator === 'nullable') {
                $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                $this->applyNullFilter($query, $dbColumn, !$boolValue);
                continue;
            }

            // Suporte para scopes
            if ($operator === 'scope') {
                $query->{$dbColumn}($value);
                continue;
            }

            // Suporte para status
            if ($operator === 'status') {
                if (strtolower($value) === 'active') {
                    $query->whereNull('deleted_at');
                } elseif (strtolower($value) === 'inactive') {
                    $query->onlyTrashed();
                } else {
                    $query->where('status', $value);
                }
                continue;
            }

            // Suporte para filtros booleanos
            if ($operator === 'boolean') {
                $val = strtolower((string) $value);
                if (in_array($val, ['active', 'true', '1'], true)) {
                    $query->where($dbColumn, true);
                } elseif (in_array($val, ['inactive', 'false', '0'], true)) {
                    $query->where($dbColumn, false);
                }
                continue;
            }

            // Suporte para filtros de maior que e menor que
            if ($operator === 'more_than') {
                $query->where($dbColumn, '>', $value);
                continue;
            }
            if ($operator === 'less_than') {
                $query->where($dbColumn, '<', $value);
                continue;
            }

            // Suporte para filtros em relacionamentos (ex: 'roles.name:=')
            if (str_contains($operator, '.')) {
                [$relationAndField, $op] = explode(':', $operator);
                [$relation, $field] = explode('.', $relationAndField);

                $query->whereHas($relation, function (Builder $q) use ($field, $op, $value) {
                    $q->where($field, $op, $value);
                });
                continue;
            }

            // Suporte para filtros de data
            if ($operator === 'date_from') {
                $query->whereDate($dbColumn, '>=', $value);
                continue;
            }
            if ($operator === 'date_to') {
                $query->whereDate($dbColumn, '<=', $value);
                continue;
            }

            // Verifica se o valor é um array para filtros IN ou BETWEEN
            if (is_array($value)) {
                if ($operator === 'in') {
                    $this->applyInFilter($query, $dbColumn, $value);
                } elseif ($operator === 'between') {
                    $this->applyBetweenFilter($query, $dbColumn, $value);
                }
                continue;
            }

            // Aplica filtro de LIKE
            if ($operator === 'like') {
                $this->applyLikeFilter($query, $dbColumn, $value);
                continue;
            }

            // Aplica filtro de data
            if ($operator === 'date') {
                $this->applyDateFilter($query, $dbColumn, $value);
                continue;
            }

            // Aplica outros operadores
            $query->where($dbColumn, $operator, $value);
        }
    }

    /**
     * Aplica busca em relacionamentos
     */
    private function applyRelationshipSearch(Builder $query, string $column, string $term): void
    {
        $parts = explode('.', $column);
        $relation = $parts[0];
        $field = $parts[1];

        $query->orWhereHas($relation, function (Builder $q) use ($field, $term) {
            $q->where($field, 'like', $term);
        });
    }

    /**
     * Aplica filtro de busca por LIKE
     */
    private function applyLikeFilter(Builder $query, string $column, string $value): void
    {
        if ($this->isFilterableColumn($column)) {
            $query->where($column, 'like', '%' . $value . '%');
        }
    }

    /**
     * Aplica filtro de data
     */
    private function applyDateFilter(Builder $query, string $column, string $value, string $operator = '='): void
    {
        if ($this->isFilterableColumn($column)) {
            if ($operator === 'date') {
                $query->whereDate($column, $value);
            } else {
                $query->where($column, $operator, $value);
            }
        }
    }

    /**
     * Aplica filtro de NULL
     */
    private function applyNullFilter(Builder $query, string $column, bool $isNull): void
    {
        if ($this->isFilterableColumn($column)) {
            if ($isNull) {
                $query->whereNull($column);
            } else {
                $query->whereNotNull($column);
            }
        }
    }

    /**
     * Aplica filtro de IN
     */
    private function applyInFilter(Builder $query, string $column, array $values): void
    {
        if ($this->isFilterableColumn($column)) {
            $query->whereIn($column, $values);
        }
    }

    /**
     * Aplica filtro de BETWEEN
     */
    private function applyBetweenFilter(Builder $query, string $column, array $values): void
    {
        if ($this->isFilterableColumn($column)) {
            if (is_array($values) && count($values) === 2) {
                $query->whereBetween($column, $values);
            }
        }
    }

    /**
     * Aplica ordenação
     */
    private function applySorting(Builder $query, array $filters): void
    {
        $sortBy = $filters['sort_by'] ?? $filters['sortBy'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? $filters['sortDirection'] ?? 'desc';

        // Valida se a coluna é ordenável
        if (property_exists($this, 'sortable') && is_array($this->sortable)) {
            if (!in_array($sortBy, $this->sortable)) {
                $sortBy = 'created_at';
            }
        }

        // Valida direção
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);
    }
}