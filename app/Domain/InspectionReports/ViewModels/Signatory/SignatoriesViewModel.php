<?php

namespace App\Domain\InspectionReports\ViewModels\Signatory;

use App\Domain\InspectionReports\Data\SignatoryData;
use App\Domain\InspectionReports\Enums\Signatory\SignatoryType;
use Spatie\LaravelData\DataCollection;
use Spatie\ViewModels\ViewModel;

class SignatoriesViewModel extends ViewModel
{
    /** @param  DataCollection<SignatoryData>  $signatories */
    public function __construct(public ?DataCollection $signatories) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->signatories, $name)) {
            return $this->signatories->$name;
        }

        return null;
    }

    public function owner(): ?SignatoryData
    {
        return $this->signatories
            ?->first(fn (SignatoryData $signatory) => $signatory->type === SignatoryType::OWNER);
    }

    public function representative(): ?SignatoryData
    {
        return $this->signatories
            ?->first(fn (SignatoryData $signatory) => $signatory->type === SignatoryType::REPRESENTATIVE);
    }

	public function tenants(): DataCollection
	{
		$filtered = $this->signatories?->filter(
			fn (SignatoryData $signatory) => $signatory->type === SignatoryType::TENANT
		)->values() ?? collect();

		return new DataCollection(SignatoryData::class, $filtered);
	}

    public function hasDuplicateAddresses(): bool
    {
        foreach ($this->tenants() as $tenant) {
            $addressKey = $tenant->formatedAddress();

            if (isset($addressMap[$addressKey])) {
                return true;
            }

            $addressMap[$addressKey] = true;
        }

        return false;
    }
}
