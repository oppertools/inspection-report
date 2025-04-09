<?php

namespace App\Domain\InspectionReports\ViewModels\Signatory;

use App\Domain\InspectionReports\Data\SignatoryData;
use App\Domain\InspectionReports\ViewModels\AddressViewModel;
use Spatie\ViewModels\ViewModel;

class SignatoryViewModel extends ViewModel
{
    public function __construct(
        private readonly ?SignatoryData $signatory,
        private readonly ?string $id,
        private readonly ?int $index,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->signatory, $name)) {
            return $this->signatory->$name;
        }

        return null;
    }

    public function formatedAddress(): ?string
    {
        return $this->signatory->address ?
            (new AddressViewModel($this->signatory->address))->formatAddress()
            : null;
    }

    public function formatedMoveOutAddress(): ?string
    {
        return $this->signatory->moveOutAddress ?
            (new AddressViewModel($this->signatory->moveOutAddress))->formatAddress()
            : null;
    }

    public function personType(): ?string
    {
        return $this->signatory->personType?->label() ?? null;
    }

    public function type(): ?string
    {
        return $this->signatory->type?->label() ?? null;
    }

    public function fullName(): ?string
    {
        return $this->signatory->firstName.' '.$this->signatory->lastName;
    }

    public function signature(): ?string
    {
        $documentPath = 'documents/'.$this->id.'/signatures/';
        $fullPath = storage_path('app/'.$documentPath);

        if (! file_exists($fullPath)) {
            return null;
        }

        $filename = $this->index.'.png';

        if (! file_exists($fullPath.$filename)) {
            return null;
        }

        return 'storage/'.$documentPath.$filename;
    }

    public function signatureWithIndex(int $index): ?string
    {
	    $basePath = storage_path(config('app.temp_storage_path')."{$this->id}/signatures/{$index}.png");

        if (! file_exists($basePath)) {
            return null;
        }
        return $basePath;
    }
}
