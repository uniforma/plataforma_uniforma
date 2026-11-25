<div x-data="accessibilityControls()" class="border-b border-slate-600 bg-[#28303d] text-white" role="region" aria-label="Ferramentas de acessibilidade">
    <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-2 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:px-6 lg:px-8">
        <span class="flex items-center gap-2 text-xs font-bold tracking-wide"><i class="ph ph-universal-access text-lg text-[#4be0bc]" aria-hidden="true"></i>Acessibilidade</span>
        <div class="flex flex-wrap items-center gap-1.5 sm:justify-end" role="group" aria-label="Ajustes de leitura">
            <button type="button" @click="decrease()" :disabled="scale <= 100" class="min-h-10 min-w-10 rounded-lg border border-white/30 px-2 text-sm font-bold text-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white disabled:opacity-50" aria-label="Diminuir tamanho da fonte" title="Diminuir fonte">A−</button>
            <span class="min-w-12 text-center text-xs font-semibold text-white" x-text="`${scale}%`" aria-hidden="true">100%</span>
            <button type="button" @click="increase()" :disabled="scale >= 150" class="min-h-10 min-w-10 rounded-lg border border-white/30 px-2 text-sm font-bold text-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white disabled:opacity-50" aria-label="Aumentar tamanho da fonte" title="Aumentar fonte">A+</button>
            <button type="button" @click="toggleContrast()" :aria-pressed="contrast.toString()" :class="contrast ? 'border-[#4be0bc] bg-[#4be0bc]/20' : 'border-white/30'" class="min-h-10 rounded-lg border px-3 text-xs font-bold text-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white" aria-label="Ativar ou desativar alto contraste"><i class="ph ph-circle-half mr-1 text-base" aria-hidden="true"></i>Contraste</button>
        </div>
        <span class="sr-only" role="status" aria-live="polite" x-text="announcement"></span>
    </div>
</div>
