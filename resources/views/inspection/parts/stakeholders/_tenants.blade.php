<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    <span class="font-semibold text-muted uppercase">Le(s) locataire(s)</span>
    <div class="flex gap-6">
        @if($data->signatoriesByType->hasDuplicateAddresses)
            <div class="flex flex-col gap-1">
                <span class="font-semibold">
                    @php
                        $tenants = $data->signatoriesByType->tenants;
                    @endphp
                    @foreach($tenants as $index => $tenant)
                        {{ $tenant->fullName }}
                        @if($index < count($tenants) - 2),
                        @elseif($index === count($tenants) - 2) et
                        @endif
                    @endforeach
                </span>
                <div class="text-muted">
                    <p>{{ $data->signatoriesByType->tenants[0]->formatedAddress ?? 'Adresse non communiquée' }}</p>
                </div>
            </div>
        @else
            @if($data->signatories && $data->signatoriesByType->tenants->count() > 0)
                @foreach($data->signatoriesByType->tenants as $tenant)
                    <div class="flex flex-col gap-1">
                    <span class="font-semibold">{{ $tenant->fullName }}</span>
                    <div class="text-muted">
                        @if($data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_OUT)
                            <p class="font-semibold">Nouvelle adresse :</p>
                            <p>{{ $tenant->formatedMoveOutAddress }}</p>
                        @else
                            <p>{{ $tenant->formatedAddress }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <span>Non communiqué</span>
            @endif
        @endif
    </div>
</div>
