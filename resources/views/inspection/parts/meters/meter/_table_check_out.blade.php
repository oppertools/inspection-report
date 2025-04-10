<table class="table-variant">
    <thead>
        <tr>
            <th rowspan="2" class="w-[220px]">Numéro de compteur</th>
            <th colspan="2" class="w-[180px]">Relevé</th>
            <th rowspan="2">Observation(s)</th>
        </tr>
        <tr>
            <th class="w-[90px]">Entrée</th>
            <th class="w-[90px]">Sortie</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">{{ $meter->number }}</td>
            <td class="text-right">
            @include('inspection.parts.meters.meter._index', [
                'meter' => $meter,
                'checkIn' => $meter->checkIn,
                'context' => 'check_in',
        ])
            </td>
            <td class="text-right">
                @include('inspection.parts.meters.meter._index', [
                'meter' => $meter,
                'context' => 'check_out',
            ])
            </td>
            <td>
                <div class="flex flex-col gap-1">
                    {{ $meter->comment }}
                    <div class="flex gap-1.5 flex-wrap">
                        @foreach($meter->pictures() as $picture)
                            <a href="#{{ $picture->id }}" class="badge-media">Photo {{ $picture->number }}</a>
                        @endforeach
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
