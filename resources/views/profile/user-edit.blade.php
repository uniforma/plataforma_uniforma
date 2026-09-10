@extends('layouts.user-layout')

@section('title', 'Meu Perfil — UniForma')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700"><i class="ph ph-arrow-left"></i> Voltar para o início</a>
            <h1 class="mt-4 text-3xl font-bold text-slate-950">Meu Perfil</h1>
            <p class="mt-2 text-slate-600">Atualize seus dados de acesso e preferências da conta.</p>
        </div>

        <div class="space-y-6">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
