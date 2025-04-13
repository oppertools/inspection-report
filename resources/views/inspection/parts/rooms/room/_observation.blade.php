<div class="flex flex-col gap-1.5">
    <div class="flex flex-col gap-2">
        <!-- Cleanliness / Operating State -->
        @if($element->cleanlinessState || $element->operatingState)
        <div class="flex gap-2 items-center font-medium flex-wrap">
            @if($element->cleanlinessState)
            <span class="text-{{ $element->cleanlinessState?->color() }}-500">
                {{ $element->cleanlinessState?->label() }}
            </span>
            @endif
            @if($element->cleanlinessState && $element->operatingState)
                <span class="text-muted">-</span>
            @endif
                @if($element->operatingState)
                <span class="text-{{ $element->operatingState?->color() }}-500">
                    {{ $element->operatingState?->label() }}
                </span>
                @endif
        </div>
        @endif
        <div class="flex flex-col">
            <p>{{ $element->materialsAndDefects }} </p>
            <p>{{ $element->comment }} </p>
        </div>
        <!-- Pictures
        <div class="flex gap-1.5 flex-wrap">

        </div> -->
    </div>
</div>
