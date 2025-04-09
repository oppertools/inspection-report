<div class="flex gap-2 flex-wrap justify-between">
    <span>{{ $name }}</span>

    @if($colors)
        <div class="flex gap-1.5 justify-end">
            @foreach($colors as $color)
                <div class="flex gap-1 items-center">
                    <span class="size-3.5 rounded-full border border-gray-100" style="background: {{ $color->hex }}"></span>
                    <span class="text-muted text-xs capitalize">{{ $color->name }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
