@php
    $source = $data->type === \App\Domain\InspectionReports\Enums\InspectionReportType::CHECK_OUT ? $meter->checkIn : $meter;
@endphp

@if($context === 'check_in')
    @include('inspection.parts.meters.meter.index._check_in-context', [
	'checkIn' => $checkIn
])
@else
    @include('inspection.parts.meters.meter.index._check_out-context')
@endif
