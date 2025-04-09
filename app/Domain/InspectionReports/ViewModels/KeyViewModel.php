<?php

namespace App\Domain\InspectionReports\ViewModels;

use App\Domain\InspectionReports\Data\Key\KeyData;
use App\Domain\InspectionReports\Data\PictureData;
use Spatie\ViewModels\ViewModel;

class KeyViewModel extends ViewModel
{
    public function __construct(
        private readonly ?KeyData $key,
        protected readonly array $pictureIndexes = [],

    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->key, $name)) {
            return $this->key->$name;
        }

        return null;
    }

    public function name(): ?string
    {
        return $this->key->type?->label() ?? null;
    }

    public function pictures(): array
    {
        return $this->key->pictures->map(function (PictureData $picture) {
            $number = $this->pictureIndexes[$picture->id] ?? null;

            return new PictureData(
                id: $picture->id,
                url: $picture->url,
                number: $number,
                createdAt: $picture->createdAt,
            );
        })->all();
    }
}
