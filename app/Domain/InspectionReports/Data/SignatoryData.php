<?php

namespace App\Domain\InspectionReports\Data;

use App\Domain\InspectionReports\Data\Property\AddressData;
use App\Domain\InspectionReports\Enums\Signatory\PersonType;
use App\Domain\InspectionReports\Enums\Signatory\SignatoryType;
use App\Domain\InspectionReports\ViewModels\AddressViewModel;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class SignatoryData extends Data
{
    public function __construct(
        public string $id,

        #[MapInputName('first_name')]
        public ?string $firstName,

        #[MapInputName('last_name')]
        public ?string $lastName,

        public ?string $email,

        #[MapInputName('legal_name')]
        public ?string $legalName,
        public ?AddressData $address,

        #[MapInputName('move_out_address')]
        public ?AddressData $moveOutAddress,

        #[MapInputName('person_type')]
        public ?PersonType $personType,

        public SignatoryType $type,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return null;
    }

    public function fullName(): ?string
    {
        return $this->firstName && $this->lastName ?
            $this->firstName.' '.$this->lastName
            : null;
    }

    public function formatedAddress(): ?string
    {
        return $this->address ?
            (new AddressViewModel($this->address))->formatAddress()
            : null;
    }
}
