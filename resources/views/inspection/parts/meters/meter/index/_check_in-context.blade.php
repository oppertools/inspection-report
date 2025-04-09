@switch($meter->type)
    @case(\App\Domain\InspectionReports\Enums\MeterType::ELECTRICITY)
        @if ($checkIn?->index_1 && $checkIn?->index_2)
            <p><span class="underline text-nowrap">HP :</span> {{ $checkIn->index_1 }} kWh</p>
            <p><span class="underline text-nowrap">HC :</span> {{ $checkIn->index_2 }} kWh</p>
        @elseif ($checkIn?->index_1)
            <p><span class="underline text-nowrap">Base :</span> {{ $checkIn->index_1 }} kWh</p>
        @elseif ($checkIn?->index_2)
            <p><span class="underline text-nowrap">HC :</span> {{ $checkIn->index_2 }} kWh</p>
        @endif
        @break

    @case(\App\Domain\InspectionReports\Enums\MeterType::WATER)
        @if ($checkIn?->index_1 && $checkIn?->index_2)
            <p><span class="underline text-nowrap">Eau froide :</span> {{ $checkIn->index_1 }} m³</p>
            <p><span class="underline text-nowrap">Eau chaude :</span> {{ $checkIn->index_2 }} m³</p>
        @elseif ($checkIn?->index_1)
            <p><span class="underline text-nowrap">Eau froide :</span> {{ $checkIn->index_1 }} m³</p>
        @elseif ($checkIn?->index_2)
            <p><span class="underline text-nowrap">Eau chaude :</span> {{ $checkIn->index_2 }} m³</p>
        @endif
        @break

    @default
        @if ($checkIn?->index_1)
            <p class="text-nowrap">{{ $checkIn->index_1 }} m³</p>
        @endif
        @if ($checkIn?->index_2)
            <p class="text-nowrap">{{ $checkIn->index_2 }} m³</p>
        @endif

@endswitch
