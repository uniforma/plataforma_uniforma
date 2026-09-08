<?php

namespace App\Repositories\Eloquent;

use App\Models\Submissao;

class SubmisssaoRepository extends BaseRepository
{
    /**
     * @var Submissao
     */
    protected $model;

    public function __construct(Submissao $model)
    {
        $this->model = $model;
    }
    public function create(array $data)
    {
        $this->model->create($data);
    }
    public function getName()
    {
        // Busca as submissões e já traz os dados do autor de cada uma
        $this->model->Submissao::with('autor')->get();
    }
}
