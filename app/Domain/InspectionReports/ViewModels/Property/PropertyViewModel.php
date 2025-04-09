<?php

namespace App\Domain\InspectionReports\ViewModels\Property;

use App\Domain\InspectionReports\Data\Property\PropertyData;
use App\Domain\InspectionReports\ViewModels\AddressViewModel;
use Spatie\ViewModels\ViewModel;

class PropertyViewModel extends ViewModel
{
    public function __construct(
        private readonly ?PropertyData $property,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return null;
    }

    public function formatedAddress(): ?string
    {
        return $this->property?->address ?
            (new AddressViewModel($this->property?->address))->formatAddress()
            : null;
    }

    public function heatingSource(): ?string
    {
        return (new EnergyViewModel($this->property?->energy))->heatingSource;
    }

    public function hotWaterSource(): ?string
    {
        return (new EnergyViewModel($this->property?->energy))->hotWaterSource;
    }

    public function smokeDetector(): SmokeDetectorViewModel
    {
        return new SmokeDetectorViewModel($this->property?->features);
    }

	public function furnishedLabel(): string
	{
		if (!isset($this->property?->furnished)) {
			return 'Non communiqué';
		}

		return $this->property->furnished ? 'meublé' : 'non meublé';
	}

    public function roomsCount(): ?string
    {
        return $this->property?->roomsCount ?
            $this->property?->roomsCount.' pièce'.($this->property?->roomsCount > 1 ? 's' : '') :
            null;
    }

    public function surfaceArea(): ?string
    {
        return $this->property?->surfaceArea ?
            $this->property?->surfaceArea.' m²' :
            null;
    }

    public function type(): ?string
    {
        return $this->property?->type?->label() ?? 'Non communiqué';
    }

    public function title(): ?string
    {
        $parts = [
            $this->type(),
            $this->furnishedLabel(),
        ];

        if ($this->surfaceArea()) {
            $parts[] = $this->surfaceArea();
        }

        if ($this->roomsCount()) {
            $parts[] = $this->roomsCount();
        }

        return implode(' - ', $parts);
    }
}
