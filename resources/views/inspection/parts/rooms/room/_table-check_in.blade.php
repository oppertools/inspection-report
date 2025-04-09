<table>
    <thead>
    <tr>
        <th class="w-[200px]">Élément / Équipement</th>
        <th class="w-[90px]">Nombre</th>
        <th class="w-[120px]">État d'usure</th>
        <th>Observation(s)</th>
    </tr>
    </thead>
    <tbody>
        @foreach($room->elements as $element)
            <tr>
                <td class="w-[200px]">
                    @include('inspection.parts.rooms.room._name', [
                        'name' => $element->name,
                        'colors' => $element->colors,
                    ])
                </td>
                <td class="w-[90px] text-center">
                    {{ $element->count }}
                </td>
                <td class="w-[120px] condition {{ $element->condition->value }}-condition">
                    {{ $element->condition->label() }}
                </td>
                <td>
                    <div class="flex flex-col gap-1">
                        @include('inspection.parts.rooms.room._observation')
                        <div class="flex gap-1.5 flex-wrap">
                            @foreach($element->pictures as $picture)
                                <a href="#{{ $picture->id }}" class="badge-media">Photo {{ $picture->number }}</a>
                            @endforeach
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
