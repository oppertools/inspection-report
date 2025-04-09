@props(['title' => '', 'content' => ''])
<div class="flex flex-col gap-1 p-3 bg-gray-50 rounded-sm">
    <span class="font-bold uppercase text-muted">{{ $title }}</span>
    @if(!$content)
        Aucune observation ni réserve.
    @else
        {{ $content }}
    @endif

</div>
