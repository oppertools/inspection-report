@php
    $presence = $data?->presence();
    $condition = $data?->condition();
    $state = $data?->smokeDetectorCondition();
@endphp

@if ($state === \App\Domain\InspectionReports\Enums\OperatingState::UNKNOW)
    <div class="flex gap-1.5 items-center">
        <x-icon name="question" class="size-4" />
        <span>Non communiqué</span>
    </div>
@elseif ($data?->isPresent())
    <div class="flex gap-0.5 items-center text-{{ $presence->color }}-500">
        <x-icon name="{{ $presence->icon }}" class="size-4" />
        {{ $presence->label }}
    </div>
    <div class="flex gap-0.5 items-center text-{{ $condition->color }}-500">
        <x-icon name="{{ $condition->icon }}" class="size-4" />
        {{ $condition->label }}
    </div>
@else
    <div class="flex gap-1.5 items-center text-gray-600">
        <x-icon name="warning" class="text-red-500 size-4" />
        <span class="text-red-500">Non équipé</span>
    </div>
@endif
