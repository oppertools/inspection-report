<div class="mx-container grid grid-cols-[55%_auto] gap-x-6 gap-y-5 mb-8">
    @include('inspection.parts.stakeholders._property')
    @include('inspection.parts.stakeholders._owner')
    @include('inspection.parts.stakeholders._tenants')
    @if($data->signatoriesByType()->representative())
    @include('inspection.parts.stakeholders._representative', [
	    'representative' => $data->signatoriesByType->representative,
    ])
    @endif
</div>
