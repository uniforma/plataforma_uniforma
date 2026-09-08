<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\DemandRepository;

class DemandController extends Controller
{
    /**
     * 
     */
    public function __construct(protected DemandRepository $demandRepository){
        
    }

    public function index()
    {
        // O Controller não sabe COMO busca no banco, ele só pede os dados:
        $voteDemands = $this->demandRepository->getMoreVoted();
        $recentDemands = $this->demandRepository->getMoreRecent();

        // Envia para o Blade
        return view('users.vitrine-submissao', compact('voteDemands', 'recentDemands'));
    }
}
