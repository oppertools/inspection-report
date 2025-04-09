<?php

namespace App\Domain\InspectionReports\Data\Room;

use App\Domain\InspectionReports\Data\PictureData;
use App\Domain\InspectionReports\Enums\Room\RoomType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class RoomData extends Data
{
    public function __construct(
        public string $id,
        public ?string $name,
        public ?RoomType $type,

        /** @var DataCollection<RoomElementData> */
        public DataCollection $elements,

        /** @var DataCollection<PictureData> */
        public DataCollection $pictures
    ) {}
}
