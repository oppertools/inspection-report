<table>
    <thead>
    <tr>
        <th rowspan="2" class="w-auto">Élément / Équipement</th>
        <th colspan="2">Nombre</th>
        <th colspan="2">État d'usure</th>
        <th rowspan="2" class="w-80">Observation(s)</th>
    </tr>
    <tr>
        <th class="w-16">
            Entrée
        </th>
        <th class="w-16">
            Sortie
        </th>
        <th class="w-24">
            Entrée
        </th>
        <th class="w-24">
            Sortie
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($room->elements as $element)
        <tr>
            <td>
                @include('inspection.parts.rooms.room._name', [
                    'name' => $element->name,
                    'colors' => $element->colors,
                ])
            </td>
            <td class="text-nowrap text-center">
                {{ $element->checkIn?->count }}
            </td>
            <td @class([
        'text-nowrap text-center',
        $element->checkIn?->count > $element->count ? 'text-red-500 font-semibold' : ''
])>
                {{ $element->count }}
            </td>
            @if($element->checkIn?->condition !== $element->condition)
                <td class="text-nowrap condition {{ $element->checkIn?->condition?->value }}-condition">
                    {{ $element->checkIn?->condition?->label() }}
                </td>
            @endif
            <td colspan="{{ $element->checkIn?->condition !== $element->condition ? 1 : 2 }}" class="text-nowrap condition {{ $element->condition?->value }}-condition">
                {{ $element->condition?->label() }}
            </td>
            <td class="w-80">
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
