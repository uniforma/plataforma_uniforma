<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Submissao;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Submissao::offered()
            ->with('approvedProposal')
            ->latest()
            ->paginate(15);

        return view('users.offers.index', compact('offers'));
    }

    public function show(Submissao $submissao)
    {
        $submissao = Submissao::offered()
            ->with('approvedProposal.user')
            ->findOrFail($submissao->id);

        $user = auth('user')->user();
        $registered = $user && Registration::query()
            ->where('submissao_id', $submissao->id)
            ->where('user_id', $user->id)
            ->exists();

        return view('users.offers.show', compact('submissao', 'user', 'registered'));
    }

    public function store(Submissao $submissao)
    {
        DB::transaction(function () use ($submissao) {
            $offer = Submissao::offered()
                ->lockForUpdate()
                ->findOrFail($submissao->id);

            Registration::firstOrCreate([
                'submissao_id' => $offer->id,
                'user_id' => auth('user')->id(),
            ]);
        }, 3);

        return redirect()
            ->route('offers.show', $submissao)
            ->with('status', 'Inscrição confirmada.');
    }
}