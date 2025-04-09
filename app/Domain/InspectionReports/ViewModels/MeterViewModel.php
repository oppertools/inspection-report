<?php

namespace App\Domain\InspectionReports\ViewModels;

use App\Domain\InspectionReports\Data\MeterData;
use App\Domain\InspectionReports\Data\PictureData;
use Spatie\ViewModels\ViewModel;

class MeterViewModel extends ViewModel
{
    public function __construct(
        private readonly ?MeterData $meter,
        protected readonly array $pictureIndexes = [],
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->meter, $name)) {
            return $this->meter->$name;
        }

        return null;
    }

    public function typeLabel(): ?string
    {
        return $this->meter->type?->label() ?? null;
    }

    public function checkIn()
    {
        return json_decode(json_encode($this->meter->checkIn));
    }

    public function pictures(): ?array
    {
        return $this->meter->pictures?->map(function (PictureData $picture) {
            $number = $this->pictureIndexes[$picture->id] ?? null;

            return new PictureData(
                id: $picture->id,
                url: $picture->url,
                number: $number,
                createdAt: $picture->createdAt
            );
        })->all();
    }
}
