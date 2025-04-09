<table class="table-variant">
    <thead>
    <tr>
        <th class="w-[220px]">Numéro de compteur</th>
        <th class="w-[200px]">Relevé</th>
        <th>Observation(s)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="w-[220px]">{{ $meter->number }}</td>
        <td class="w-[270px] text-right ">
            @include('inspection.parts.meters.meter._index', [
	'context' => $data->type->value,
])
        </td>
        <td>
            <div class="flex flex-col gap-1">
                {{ $meter->comment }}
                @if($meter->pictures())
                    @foreach($meter->pictures() as $picture)
                        <div class="flex gap-1.5 flex-wrap">
                            <a href="#{{ $picture->id }}" class="badge-media">Photo {{ $picture->number }}</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </td>
    </tr>
    </tbody>
</table>
