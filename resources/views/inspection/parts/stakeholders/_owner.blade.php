<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    <span class="font-semibold text-muted uppercase">Le bailleur</span>
    <div class="flex flex-col gap-1">
        <span class="font-semibold">{{ $data->signatoriesByType->owner?->fullName ?? 'Non communiqué' }}</span>
        <span class="text-muted">{{ $data->signatoriesByType->owner?->formatedAddress ?? 'Non communiqué' }}</span>
    </div>
</div>
