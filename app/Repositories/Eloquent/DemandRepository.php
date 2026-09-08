<?php

// app/Repositories/Eloquent/DemandaRepository.php

namespace App\Repositories\Eloquent;

use App\Models\Submissao;

class DemandRepository extends BaseRepository
{
    public function __construct(Submissao $model)
    {
        parent::__construct($model);
    }

    // 1. Lógica para buscar as mais votadas
    public function getmoreVoted(int $limit = 10)
    {
        return $this->model->with(['autor', 'curador'])->withCount('votes')->orderBy('votes_count', 'desc')->take($limit)->get();
    }

    // 2. Lógica para buscar as mais recentes
    public function getMoreRecent(int $limit = 10)
    {
        return $this->model->with(['autor', 'curador'])->orderBy('created_at', 'desc')->take($limit)->get();
    }
}
