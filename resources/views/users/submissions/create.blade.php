@extends('layouts.user-layout')

@section('title', 'Nova Demanda — UniForma')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700"><i class="ph ph-arrow-left"></i> Voltar</a>
            <h1 class="mt-4 text-3xl font-bold text-slate-950">Nova Demanda</h1>
            <p class="mt-2 text-slate-600">Compartilhe uma necessidade de formação com a comunidade acadêmica.</p>
        </div>

        <form method="POST" action="{{ route('user.submissions.store') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <div class="space-y-6">
                <x-input name="title" label="Título" :value="old('title')" required autofocus :messages="$errors->get('title')" />

                <div>
                    <label for="background" class="mb-1 block text-sm font-medium text-gray-700">Contexto</label>
                    <textarea id="background" name="background" rows="7" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" placeholder="Descreva o problema, a necessidade e o resultado esperado...">{{ old('background') }}</textarea>
                    @error('background')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <x-input name="target_audience" label="Público-alvo" :value="old('target_audience')" required :messages="$errors->get('target_audience')" />
                    <x-input name="knowledge_field" label="Área do conhecimento" :value="old('knowledge_field')" required :messages="$errors->get('knowledge_field')" />
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <x-button href="{{ route('home') }}" variant="secondary">Cancelar</x-button>
                <x-button type="submit">Publicar demanda</x-button>
            </div>
        </form>
    </div>
@endsection
