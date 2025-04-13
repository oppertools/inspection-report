<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    @if($data->property->reference)
        <span class="font-semibold text-blue-500">Référence : {{ $data->property->reference }}</span>
    @endif
    <div class="flex flex-col gap-1">
        <span class="font-semibold">{{$data->property->title }}</span>
        <span class="text-muted">{{ $data->property->formatedAddress }}</span>
    </div>
    <div class="flex flex-col gap-1">
        <span class="font-semibold">Détecteur de fumée</span>
        <div class="flex gap-4 items-center font-medium">
            <x-smoke-detector
                    :data="$data->property?->smokeDetector"
            />
        </div>
    </div>
</div>
