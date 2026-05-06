@props(['title', 'description' => null])

<div class="mb-6 flex items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-primary-600">{{ $title }}</h2>
        @if($description)
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
        @endif
    </div>
    
    @if(isset($actions))
        <div class="flex gap-2 h-fit">
            {{ $actions }}
        </div>
    @endif
</div>