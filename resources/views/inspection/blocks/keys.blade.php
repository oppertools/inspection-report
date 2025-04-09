<div class="mx-container flex flex-col gap-6">
    <div class="flex flex-col gap-3">
        <x-block-header icon="key" subtitle="Remise des" title="Clés" />
        <div class="break-inside-auto">
            @if($data->keys)
                @if($data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_IN)
                    @include('inspection.parts.keys._table-check_in', ['keys' => $data->keys])
                @else
                    @include('inspection.parts.keys._table-check_out', ['keys' => $data->keys])
                @endif
            @else
                <p>Aucune clés n'a été remise.</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-10 gap-y-4">
        @foreach($data->keyPicturesWithNumber() as $picture)
            <div id="{{ $picture['id'] }}" class="break-inside-avoid flex flex-col gap-1.5 text-center">
               <strong>{{ $picture['label'] }}</strong>
                <img src="{{ $picture['url'] }}" class="w-full object-cover">
            </div>
        @endforeach
    </div>
</div>
