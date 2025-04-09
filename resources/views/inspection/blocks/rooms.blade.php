@foreach($data->rooms as $room)
    @include('inspection.parts.rooms._room', ['room' => $room])
    @pageBreak
@endforeach
