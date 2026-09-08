@extends('layouts.user-layout')

@section('title', 'Vitrine de Submissões')

@section('content')

<div class="rounded-xl h-85 bg-white p-8 shadow">
    <div class="grid grid-cols-2 content-between gap-4 ">
    <div class="  ">
        
        <h1 class="text-3xl font-bold max-w-md ml-10">
            Transforme necessidades em oportunidades de formação
        </h1>
      
        <div class="max-w-md ml-10">
            <p class="mt-3 text-gray-500 pb-7">
                Colabore com a governança institucional propondo e apoiando demandas essenciais para a comunidade acadêmica.
            </p>
        </div>
        <a href="#" class=" ml-10 rounded-lg bg-[#0040A1] px-10 py-2 text-sm font-semibold text-white hover:bg-blue-950">+ NOVA DEMANDA</a>
    </div>
  
<!-- Container Principal (Empilha os 3 cards e alinha no canto direito ou onde desejar) -->
<div class="flex items-end flex-col gap-4 w-[550px] pr-11 ">
    <!-- Card 1: Demandas Ativas -->
    <div class="flex items-center gap-4 bg-white border border-[#D1D5DB] rounded-2xl p-4 shadow-sm w-[290px]  h-[70px] ">
        <!-- Ícone Redondo (Azul) -->
        <div class="flex items-center justify-center w-12 h-12 bg-[#DBEAFE] text-[#1E40AF] rounded-full shrink-0">
            <!-- Ícone de Documento -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <!-- Texto e Número -->
        <div>
            <span class="block text-xs font-bold text-[#6B7280] tracking-wider uppercase">Demandas Ativas</span>
            <span class="block text-2xl font-black text-black">124</span>
        </div>
    </div>

    <!-- Card 2: Votos Realizados -->
    <div class="flex items-center gap-4 bg-white border border-[#D1D5DB] rounded-2xl p-4 shadow-sm w-[290px]  h-[70px] ">
        <!-- Ícone Redondo (Roxo) -->
        <div class="flex items-center justify-center w-12 h-12 bg-[#F3E8FF] text-[#7E22CE] rounded-full shrink-0">
            <!-- Ícone de Check/Voto -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        </div>
        <!-- Texto e Número -->
        <div>
            <span class="block text-xs font-bold text-[#6B7280] tracking-wider uppercase">Votos Realizados</span>
            <span class="block text-2xl font-black text-black">2.5k</span>
        </div>
    </div>

    <!-- Card 3: Demandas Oficializadas -->
    <div class="flex items-center gap-4 bg-white border border-[#D1D5DB] rounded-2xl p-4 shadow-sm w-[290px] h-[70px] ">
        <!-- Ícone Redondo (Verde) -->
        <div class="flex items-center justify-center w-12 h-12 bg-[#DCFCE7] text-[#15803D] rounded-full shrink-0">
            <!-- Ícone de Selo/Oficializado -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
            </svg>
        </div>
        <!-- Texto e Número -->
        <div>
            <span class="block text-xs font-bold text-[#6B7280] tracking-wider uppercase">Demandas Oficializadas</span>
            <span class="block text-2xl font-black text-black">45</span>
        </div>
    </div>

</div>
    </div>

    
</div>
<div class="m-5 mb-2">
     <div class="flex items-center gap-6 border-b border-gray-200">
    
    <!-- Botão: Mais Votadas (Já começa com as cores de ATIVO) -->
    <button id="btn-votadas" 
            onclick="trocarAba('votadas')"
            class="aba-btn pb-2 font-semibold text-blue-700 border-b-2 border-blue-700 transition-colors">
        Mais votadas
    </button>

    <!-- Botão: Mais Recentes (Já começa com as cores de INATIVO) -->
    <button id="btn-recentes" 
            onclick="trocarAba('recentes')"
            class="aba-btn pb-2 font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 transition-colors">
        Mais recentes
    </button>

    </div>
</div>
     <div id="conteudo-votadas" class="aba-conteudo block">
    @foreach($voteDemands as $demand)

    <div class="rounded-xl h-70 bg-white p-8 mb-5 shadow">
    <h1 class="font-bold text-lg capitalize">{{$demand->title}}</h1> 
    <div class="flex flex-row pt-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-8 text-[#536579]">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" ></path>
        <circle cx="12" cy="7" r="4"></circle>
        </svg> 
        <div class="pl-2 pt-2 font-inter font-semibold text-[#536579]">{{$demand->autor->name}}</div>
    </div>
    <div class="mt-5 text-[#536579] font-inter">{{$demand->background}}</div>
    
    <div class="flex flex-row mt-4">
    <a href="#" class="m-3 rounded-lg bg-[#0040A1] px-10 py-2 text-sm font-semibold text-white hover:bg-blue-950"> Apoiar Demanda</a>
    <a href="#" class="m-3 rounded-lg bg-[#0040A1] px-10 py-2 text-sm font-semibold text-white hover:bg-blue-950"> Quero Ministrar</a>
    <a href="#" class="m-3 rounded-lg bg-[#0040A1] px-10 py-2 text-sm font-semibold text-white hover:bg-blue-950"> Ver Detalhes</a>
    </div>
    </div>
 
            
   
    </div>
    @endforeach
    </div>

    <!-- Conteúdo: Mais Recentes (Escondido por padrão com a classe 'hidden') -->
    <div id="conteudo-recentes" class="aba-conteudo hidden">
    @foreach($voteDemands as $demand)


         <div class="rounded-xl h-85 bg-white p-8 mb-5 shadow">
        {{$demand->title}}

      
            
  
        ellenn
        <h3 class="font-bold text-lg">Conteúdo das Mais Recentes</h3>
        <p>Aqui você coloca o foreach das demandas mais recentes...</p>
         </div>
        
  
    @endforeach
  </div>
</div>
<!-- 3. O JAVASCRIPT QUE FAZ A MÁGICA -->
<script>
    function trocarAba(abaSelecionada) {
        // 1. Pegar todos os botões e todos os conteúdos
        const botoes = document.querySelectorAll('.aba-btn');
        const conteudos = document.querySelectorAll('.aba-conteudo');

        // 2. Resetar todos os botões para o estado INATIVO (cinza sem borda)
        botoes.forEach(btn => {
            btn.classList.remove('text-blue-700', 'border-blue-700');
            btn.classList.add('text-gray-500', 'border-transparent');
        });

        // 3. Esconder todos os conteúdos (adicionando a classe 'hidden' do Tailwind)
        conteudos.forEach(conteudo => {
            conteudo.classList.add('hidden');
            conteudo.classList.remove('block');
        });

        // 4. Ativar apenas o botão clicado (azul com borda)
        const botaoAtivo = document.getElementById('btn-' + abaSelecionada);
        botaoAtivo.classList.remove('text-gray-500', 'border-transparent');
        botaoAtivo.classList.add('text-blue-700', 'border-blue-700');

        // 5. Mostrar apenas o conteúdo clicado
        const conteudoAtivo = document.getElementById('conteudo-' + abaSelecionada);
        conteudoAtivo.classList.remove('hidden');
        conteudoAtivo.classList.add('block');
    }
</script>


@endsection