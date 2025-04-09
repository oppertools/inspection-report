<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    @if($data->property->reference)
        <span class="font-semibold text-blue-600">Référence : {{ $data->property->reference }}</span>
    @endif
    <div class="flex flex-col gap-1">
        <span class="font-semibold">{{$data->property->title }}</span>
        <span class="text-muted">{{ $data->property->formatedAddress }}</span>
    </div>
    <div class="flex flex-col gap-1">
        <span class="font-semibold">Détecteur de fumée</span>
        <div class="flex gap-4 items-center font-medium">
            <div class="flex gap-0.5 items-center text-{{ $data->property->smokeDetector->isPresent->color }}-600">
                <x-icon name="{{ $data->property->smokeDetector->presenceIcon }}" class="size-4" />
                {{ $data->property->smokeDetector->isPresent->label }}
            </div>
            <div class="flex gap-0.5 items-center text-{{ $data->property->smokeDetector->condition->color }}-600">
                <x-icon name="{{ $data->property->smokeDetector->condition->icon }}" class="size-4" />
                {{ $data->property->smokeDetector->condition->label }}
            </div>
        </div>
    </div>
</div>
