@props(['signatory' => null, 'type' => null, 'name' => null, 'index' => null, 'date' => null])

<div class="flex flex-col gap-3 break-inside-avoid">
    <div class="flex flex-col gap-0.5">
        <span class="font-semibold">{{ $type }}</span>
        <span>{{ $name }}</span>
    </div>
    <div class="flex flex-col gap-1 items-start justify-start text-left">
        @if ($signatory->signatureWithIndex($index) && file_exists($signatory->signatureWithIndex($index)))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($signatory->signatureWithIndex($index))) }}" alt="Signature" class="object-contain max-h-28 h-full">
            @if($date)
                <span>Signé le {{ $date }}</span>
            @endif
        @endif
    </div>
</div>
