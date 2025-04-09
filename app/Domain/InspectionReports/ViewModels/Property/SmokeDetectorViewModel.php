<?php

namespace App\Domain\InspectionReports\ViewModels\Property;

use App\Domain\InspectionReports\Data\Property\FeaturesData;
use App\Domain\InspectionReports\Enums\OperatingState;
use Spatie\ViewModels\ViewModel;

class SmokeDetectorViewModel extends ViewModel
{
    public function __construct(
        private readonly ?FeaturesData $features,
    ) {}

    public function __get($name)
    {
        return method_exists($this, $name) ? $this->$name() : null;
    }

    protected function smokeDetectorCondition(): ?OperatingState
    {
        return $this->features?->smokeDetectorCondition;
    }

    public function isPresent(): object
    {
        $condition = $this->smokeDetectorCondition();

        if (! $condition) {
            return (object) [
                'label' => 'Non communiqué',
                'color' => 'black',
            ];
        }

        $isPresent = $condition->value !== OperatingState::MISSING;

        return (object) [
            'label' => $isPresent ? 'Présent' : 'Absent',
            'color' => $isPresent ? 'green' : 'red',
        ];
    }

    public function presenceIcon(): string
    {
        if (! $this->smokeDetectorCondition()) {
            return 'circle-minus';
        }

        return $this->isPresent()->label === 'Présent' ? 'check' : 'x';
    }

    public function condition(): object
    {
        $condition = $this->smokeDetectorCondition();

        return (object) [
            'label' => $condition?->label() ?? 'Non communiqué',
            'icon' => $condition?->icon() ?? 'circle-minus',
            'color' => $condition?->color() ?? 'gray',
        ];
    }

    public function presence(): object
    {
        return (object) [
            'label' => $this->isPresent()->label,
            'color' => $this->isPresent()->color,
            'icon' => $this->presenceIcon(),
        ];
    }
}
