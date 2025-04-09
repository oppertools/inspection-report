<div class="mx-container flex flex-col gap-6 mb-12">
    <x-block-header-variant icon="chat" title="Observations générales et réserves" />
    <div class="flex flex-col gap-3">
        @include('inspection.parts.observations.general-cleanliness')

        <x-observation
            title="observations et réserves du bailleur"
            :content="$data->observations?->owner"
            />
        <x-observation
                title="observations et réserves des locataires"
                :content="$data->observations?->tenant"
        />
        @include('inspection.parts.signatures.disclaimer')
    </div>
</div>
