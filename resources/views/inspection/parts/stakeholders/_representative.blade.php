<div class="p-4 bg-gray-50 rounded-sm flex flex-col gap-2.5">
    <span class="font-semibold text-muted uppercase">Le mandataire</span>
    <div class="flex flex-col gap-0.5">
        <p>
            Pour la réalisation de cet état des lieux, le bailleur a donné mandat à
            @if($representative?->personType === \App\Domain\InspectionReports\Enums\Signatory\PersonType::LEGAL)
                <strong>{{ $representative?->legalName }}</strong> représentée par
                <strong> {{ $representative->fullName }}</strong>
            @else
                <strong> {{ $representative->fullName }}</strong>
            @endif
        </p>
        <p class="text-muted">{{ $representative?->formatedAddress ?? 'Non communiqué'  }}</p>
    </div>
</div>
