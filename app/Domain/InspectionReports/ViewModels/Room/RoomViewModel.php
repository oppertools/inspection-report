<?php

namespace App\Domain\InspectionReports\ViewModels\Room;

use App\Domain\InspectionReports\Data\PictureData;
use App\Domain\InspectionReports\Data\Room\RoomData;
use App\Domain\InspectionReports\Data\Room\RoomElementData;
use Spatie\ViewModels\ViewModel;

class RoomViewModel extends ViewModel
{
    public function __construct(
        private readonly ?RoomData $room,
        protected readonly array $pictureIndexes = [],
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->room, $name)) {
            return $this->room->$name;
        }

        return null;
    }

    public function elements(): array
    {
        return collect($this->room->elements)
            ->map(fn (array $element) => new RoomElementViewModel(RoomElementData::from($element), $this->pictureIndexes))
            ->all();
    }

    public function pictures(): array
    {
        $pictures = [];

        foreach ($this->room->elements as $element) {
            foreach ($element->pictures as $picture) {
                $number = $this->pictureIndexes[$picture->id] ?? null;

                $pictures[] = new PictureData(
                    id: $picture->id,
                    url: $picture->url,
                    number: $number,
                    createdAt: $picture->createdAt,
                );
            }
        }

        return $pictures;
    }
}
