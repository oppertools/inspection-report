<div class="mx-container flex flex-col gap-6">
    <div class="flex flex-col gap-4">
        <x-block-header
                icon="speed"
                subtitle="Relévé des"
                title="Compteurs"
        />
        <div class="flex gap-8">
            <div class="flex flex-col gap-1">
                <span class="text-muted font-medium">Mode de chauffage :</span>
                <span>{{ $data->property->heatingSource }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-muted font-medium">Production d'eau chaude :</span>
                <span>{{ $data->property->hotWaterSource }}</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-6">
        @foreach ($data->meters as $meter)
            <div class="break-inside-avoid flex flex-col gap-1">
                <span class="font-bold uppercase">{{ $meter->typeLabel }}</span>
                @if($data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_IN)
                    @include('inspection.parts.meters.meter._table_check_in')
                @else
                    @include('inspection.parts.meters.meter._table_check_out')
                @endif
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-x-5 gap-y-4">
        @foreach($data->meterPicturesWithNumber() as $picture)
            <div id="{{ $picture['id'] }}" class="break-inside-avoid flex flex-col gap-1.5 text-center">
                <strong>{{ $picture['label'] }}</strong>
                <img src="{{ $picture['url'] }}" class="w-full object-cover">
            </div>
        @endforeach
    </div>
</div>
