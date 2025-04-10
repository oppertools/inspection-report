<?php

namespace App\Domain\InspectionReports\ViewModels;

use App\Domain\InspectionReports\Data\Property\AddressData;
use Spatie\ViewModels\ViewModel;

class AddressViewModel extends ViewModel
{
    public function __construct(
        private readonly ?AddressData $address,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return null;
    }

	public function formatAddress(): ?string
	{
		if (! $this->address) {
			return null;
		}

		$parts = [];

		// Ligne principale
		if ($this->address->line1) {
			$parts[] = trim($this->address->line1);
		}

		// Ligne secondaire
		if ($this->address->line2) {
			$parts[] = trim($this->address->line2);
		}

		// Ajout dynamique de "Étage" et "Porte"
		$floorDoorParts = [];

		if ($this->address->floorNumber) {
			$floorDoorParts[] = "Étage {$this->address->floorNumber}";
		}

		if ($this->address->door) {
			$floorDoorParts[] = "Porte {$this->address->door}";
		}

		if (!empty($floorDoorParts)) {
			$parts[] = implode(' - ', $floorDoorParts);
		}

		// Code postal + Ville
		$cityLine = trim(collect([
			$this->address->postalCode,
			$this->address->city,
		])->filter()->implode(' '));

		if ($cityLine) {
			$parts[] = $cityLine;
		}

		return $parts ? implode(', ', $parts) : null;
	}

}
