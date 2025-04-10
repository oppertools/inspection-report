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

	public function smokeDetectorCondition(): OperatingState
	{
		return $this->features?->smokeDetectorCondition ?? OperatingState::UNKNOW;
	}

	public function isPresent(): bool
	{
		return $this->smokeDetectorCondition() !== OperatingState::MISSING;
	}

	public function presence(): object
	{
		$present = $this->isPresent();

		return (object) [
			'label' => $present ? 'Présent' : 'Absent',
			'icon'  => $present ? 'check' : 'x',
			'color' => $present ? 'green' : 'red',
		];
	}

	public function condition(): object
	{
		$condition = $this->isPresent()
			? $this->smokeDetectorCondition()
			: OperatingState::UNKNOW;

		return (object) [
			'label' => $condition->label(),
			'icon'  => $condition->icon(),
			'color' => $condition->color(),
		];
	}
}


