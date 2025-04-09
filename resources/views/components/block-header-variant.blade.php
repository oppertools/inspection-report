@props(['icon', 'title' => null])

<div class="flex gap-2 pb-2 border-b-2 border-primary">
    <x-icon :name="$icon" class="text-secondary-500 size-5" />
    <h2 class="font-bold uppercase">{{ $title }}</h2>
</div>
