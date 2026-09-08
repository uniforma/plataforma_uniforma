<?php

namespace App\Http\Controllers;

use App\Models\Submissao;
use App\Http\Requests\StoreSubmissaoRequest;
use App\Http\Requests\UpdateSubmissaoRequest;
use App\Repositories\Eloquent\SubmisssaoRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Repositories\Contracts;

class SubmissaoController extends Controller implements HasMiddleware
{
    /**
     * The repository instance.
     */
    protected $submissaoRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(SubmisssaoRepository $submissaoRepository)
    {
        $this->submissaoRepository = $submissaoRepository;
    }

    /**
     * Get the middleware the controller uses.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_submissoes', ['only' => ['index', 'show']]),
            new Middleware('permission:create_submissoes', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_submissoes', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_submissoes', ['only' => ['destroy']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->submissaoRepository->all();
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
       return view('submissao.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmissaoRequest $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(Submissao $submissao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submissao $submissao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissaoRequest $request, Submissao $submissao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submissao $submissao)
    {
        //
    }
}
