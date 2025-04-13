<div class="flex flex-col gap-3">
    @if($data->cleanliness?->state)
        <div class="flex flex-col gap-1">
            <span class="uppercase text-muted font-semibold">État de propreté générale</span>
            <span class="text-{{ $data->cleanliness?->state?->color() }}-500">{{ $data->cleanliness?->state?->label() }}</span>
        </div>
    @endif
    <div class="grid grid-cols-2 gap-x-10 gap-y-4">
        @foreach($data->propertyPictures() as $picture)
            <div id="{{ $picture['id'] }}" class="flex flex-col gap-1.5 text-center">
                {{ $picture['label'] }}
                <img src="{{ $picture['url'] }}" class="w-full object-cover">
            </div>
        @endforeach
    </div>
</div>
