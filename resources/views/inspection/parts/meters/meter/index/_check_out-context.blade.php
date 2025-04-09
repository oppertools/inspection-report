@switch($meter->type)
    @case(\App\Domain\InspectionReports\Enums\MeterType::ELECTRICITY)
        @if($meter->inaccessible)
            <p class="italic">non relevé</p>
            <p class="italic">(compteur inaccessible/introuvable)</p>
        @else
            @if ($meter?->index_1 && $meter?->index_2)
                <p><span class="underline text-nowrap">HP :</span> {{ $meter->index_1 }} kWh</p>
                <p><span class="underline text-nowrap">HC :</span> {{ $meter->index_2 }} kWh</p>
            @elseif ($meter?->index_1)
                <p><span class="underline text-nowrap">Base :</span> {{ $meter->index_1 }} kWh</p>
            @elseif ($meter?->index_2)
                <p><span class="underline text-nowrap">HC :</span> {{ $meter->index_2 }} kWh</p>
            @else
                <span>non relevé</span>
            @endif
        @endif
        @break

    @case(\App\Domain\InspectionReports\Enums\MeterType::WATER)
        @if($meter->inaccessible)
            <p class="italic text-nowrap">non relevé</p>
            <p class="italic text-nowrap">(compteur inaccessible/introuvable)</p>
        @else
            @if ($meter?->index_1 && $meter?->index_2)
                <p><span class="underline text-nowrap">Eau froide :</span> {{ $meter->index_1 }} m³</p>
                <p><span class="underline text-nowrap">Eau chaude :</span> {{ $meter->index_2 }} m³</p>
            @elseif ($meter?->index_1)
                <p><span class="underline text-nowrap">Eau froide :</span> {{ $meter->index_1 }} m³</p>
            @elseif ($meter?->index_2)
                <p><span class="underline text-nowrap">Eau chaude :</span> {{ $meter->index_2 }} m³</p>
            @else
                <p>non relevé</p>
            @endif
        @endif
        @break

    @default
        @if($meter?->inaccessible)
            <p class="italic text-nowrap">non relevé</p>
            <p class="italic text-nowrap">(compteur inaccessible/introuvable)</p>
        @else
            @if ($meter?->index_1)
                <p class="text-nowrap">{{ $meter->index_1 }} m³</p>
            @endif
            @if ($meter?->index_2)
                <p class="text-nowrap">{{ $meter->index_2 }} m³</p>
            @endif
            @unless ($meter?->index_1 || $meter->index_2)
                <p class="text-nowrap">non relevé</p>
            @endunless
        @endif
@endswitch
