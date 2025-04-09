<?php

namespace App\Domain\InspectionReports\ViewModels\Room;

use App\Domain\InspectionReports\Data\PictureData;
use App\Domain\InspectionReports\Data\Room\ElementCheckInData;
use App\Domain\InspectionReports\Data\Room\RoomElementData;
use App\Domain\InspectionReports\Services\ColorNameResolverService;
use Spatie\ViewModels\ViewModel;

class RoomElementViewModel extends ViewModel
{
    public function __construct(
        private readonly ?RoomElementData $element,
        protected readonly array $pictureIndexes = [],
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->element, $name)) {
            return $this->element->$name;
        }

        return null;
    }

    public function checkIn(): ?ElementCheckInData
    {
        return $this->element->checkIn ?? null;
    }

    public function colors(): array
    {
        $colorResolverService = new ColorNameResolverService;

        return collect($this->element->colors)
            ->map(fn ($name) => $colorResolverService->resolve($name))
            ->filter()
            ->toArray();
    }

    public function defects(): ?string
    {
        return empty($this->element->defects) ? null : implode(', ', $this->element->defects);
    }

    public function materials(): ?string
    {
        return empty($this->element->materials) ? null : implode(', ', $this->element->materials);
    }

    public function materialsAndDefects(): ?string
    {
        $materials = $this->materials();
        $defects = $this->defects();

        if ($materials && $defects) {
            return "{$materials} - {$defects}";
        }

        return $materials ?? $defects;
    }

    public function pictures(): array
    {
        return $this->element->pictures->map(function (PictureData $picture) {
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
