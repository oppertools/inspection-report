<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    <span class="font-semibold text-muted uppercase">Le bailleur</span>
    <div class="flex flex-col gap-1">
        @if($data->signatoriesByType->owner?->legalName)
            <p>
                <span class="font-semibold">{{ $data->signatoriesByType->owner?->legalName }}</span> représentée par <br /><strong>{{ $data->signatoriesByType->owner?->fullName }}</strong>
            </p>
        @else
        <span class="font-semibold">{{ $data->signatoriesByType->owner?->fullName ?? 'Non communiqué' }}</span>
        @endif
        <span class="text-muted">{{ $data->signatoriesByType->owner?->formatedAddress ?? 'Non communiqué' }}</span>
    </div>
</div>
