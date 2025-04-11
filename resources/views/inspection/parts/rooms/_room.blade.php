<div class="mx-container flex flex-col gap-6">
    <div class="flex flex-col gap-3">
        <x-block-header
                :icon="$room->type->value"
                subtitle="Pièce"
                :title="$room->name"
        />
        <div class="break-inside-auto">
            @if($data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_IN)
                @include('inspection.parts.rooms.room._table-check_in', ['room' => $room])
            @else
                @include('inspection.parts.rooms.room._table-check_out', ['room' => $room])
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-5 gap-y-4">
        @foreach($data->roomPicturesWithNumber($room->id) as $picture)
            <div id="{{ $picture['id'] }}" class="break-inside-avoid flex flex-col gap-1.5 text-center">
                <strong>{{ $picture['label'] }}</strong>
                <img src="{{ $picture['url'] }}" class="w-full object-cover">
            </div>
        @endforeach
    </div>
</div>
