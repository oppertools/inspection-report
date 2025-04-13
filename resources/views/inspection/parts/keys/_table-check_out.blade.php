<table class="table-variant">
    <thead>
        <tr>
            <th rowspan="2" class="w-[220px]">Type de clé</th>
            <th colspan="2" class="w-[120px]">Nombre</th>
            <th rowspan="2" class="w-[120px]">Date de remise</th>
            <th rowspan="2">Observation(s)</th>
        </tr>
        <tr>
            <th>Entrée</th>
            <th>Sortie</th>
        </tr>
    </thead>
    <tbody>
    @foreach($keys as $key)
        <tr>
            <td class="w-[220px]">{{ $key->name }}</td>
            <td class="w-[120px] text-center">{{ $key->checkIn?->count }}</td>

            <td @class([
        'w-[120px] text-center',
         !$key->count ? 'bg-white' : '',
        $key->checkIn?->count > $key->count ? 'bg-red-100 text-red-500 font-semibold' : ''
])>{{ $key->count }}</td>
            <td class="w-[120px] text-center"> {{ $data->formatedNumericFinalizedDate() }}</td>
            <td>
                <div class="flex flex-col gap-1">
                    {{ $key->comment }}
                    @foreach($key->pictures() as $picture)
                        <div class="flex gap-1.5 flex-wrap">
                            <a href="#{{ $picture->id }}" class="badge-media">Photo {{ $picture->number }}</a>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
