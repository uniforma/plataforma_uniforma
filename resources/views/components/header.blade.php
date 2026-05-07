@props(['title', 'description' => null])

<div class="mb-6 flex items-center gap-4 sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $title }}</h2>
        @if($description)
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
        @endif
    </div>
    
    @if(isset($actions))
        <div class="flex h-fit gap-2">
            {{ $actions }}
        </div>
    @endif
</div>