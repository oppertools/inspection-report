@props(['icon', 'title' => null, 'subtitle' => null])

<div class="flex gap-3">
    <x-icon :name="$icon" class="text-secondary-500 size-6" />
    <div class="flex flex-col">
        @if($subtitle)
            <span class="font-semibold leading-5">{{ $subtitle }}</span>
        @endif
        <h2 class="font-bold text-lg leading-6 text-primary">{{ $title }}</h2>
    </div>
</div>
