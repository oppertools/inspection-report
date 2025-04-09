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

        $mainLine = trim($this->address->line1);

        $additionalInfo = $this->address->line2;

        if ($mainLine && $additionalInfo) {
            $mainLine .= ", $additionalInfo";
        } elseif (! $mainLine && $additionalInfo) {
            $mainLine = $additionalInfo;
        }

        $cityLine = trim("{$this->address->postalCode} {$this->address->city}");

        if ($mainLine && $cityLine) {
            return "$mainLine, $cityLine";
        } elseif ($mainLine) {
            return $mainLine;
        } elseif ($cityLine) {
            return $cityLine;
        }

        return null;
    }
}
