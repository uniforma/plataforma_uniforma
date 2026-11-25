<div x-data="{
        hasSearch: @js(request()->filled($name ?? 'search')),
        showFilters: @js(request()->filled('knowledge_field') || request()->filled('type') || request()->filled('modality') || request()->filled('sort') || request()->filled('status') || request()->filled('trash')),
        checkSearch(e) {
            this.hasSearch = e.target.value.trim().length > 0;
        },
        clearSearch() {
            this.$refs.searchInput.value = '';
            this.hasSearch = false;
        }
    }"
    class="w-full">

    <div class="flex flex-wrap items-center gap-2 sm:flex-nowrap">
        <!-- Search Input Container -->
        <div class="relative min-w-full flex-1 sm:min-w-0">
            <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>

            <input
                type="text"
                name="{{ $name ?? 'search' }}"
                x-ref="searchInput"
                @input="checkSearch"
                value="{{ request($name ?? 'search') }}"
                class="block w-full rounded-xl border border-slate-300 bg-white p-3 ps-10 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-primary-500 focus:ring-primary-500"
                placeholder="{{ $placeholder ?? 'Pesquisar...' }}"
            >

            <button
                type="button"
                x-show="hasSearch"
                x-transition
                @click="clearSearch"
                class="absolute inset-y-0 right-0 flex items-center pe-3 text-gray-400 hover:text-gray-600 "
            >
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Filter Toggle Button -->
        @if(isset($filters))
        <button
            type="button"
            @click="showFilters = !showFilters"
            class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:flex-none"
        >
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filtros
        </button>
        @endif

        <button type="submit" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#142c59] px-4 py-3 text-sm font-semibold text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 sm:flex-none">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span>Pesquisar</span>
        </button>
    </div>

    <!-- Filters Card (Slot) -->
    @if(isset($filters))
    <div
        x-show="showFilters"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm  "
        style="display: none;"
    >
        {{ $filters }}
    </div>
    @endif
</div>
