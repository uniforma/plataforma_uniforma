<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submissao;
use App\Http\Requests\UpdateUserSubmissionRequest;
use App\Repositories\Eloquent\SubmissaoRepository;


class UserSubmissionController extends Controller
{
      private SubmissaoRepository $submissaoRepository;


    public function __construct(SubmissaoRepository $submissaoRepository)
    {
        $this->submissaoRepository = $submissaoRepository;
    }


    public function edit(string $id){
    $demand = Submissao::findOrFail($id);
 
    
    abort_if($demand->autor_id !== auth('user')->id(), 403, 'Acesso não autorizado');
    abort_if($demand->status->value !== 'Em votação', 403, 'Esta demanda não pode mais ser editada');

    return view('users.submissions.create', compact('demand'));
}

public function update(UpdateUserSubmissionRequest $request, string $id)
{
    
    $dadosValidados = $request->validated();

    
    $this->submissaoRepository->update((int) $id, $dadosValidados);

   
    return redirect()->route('user.submissions.index')->with('success', 'Demanda atualizada com sucesso!');
}


public function destroy(string $id){
   $demand = $this->submissaoRepository->find((int) $id);
   abort_if(! $demand, 404);
   abort_if((int) $demand->autor_id !== (int) auth('user')->id(), 403, 'Acesso não autorizado.');
   abort_if($demand->status->value !== 'Em votação', 403, 'Esta demanda não pode ser excluída.');

    
    $this->submissaoRepository->delete((int) $id);

    return redirect()->route('user.submissions.index')->with('success', 'Demanda excluída com sucesso!');
}



}
