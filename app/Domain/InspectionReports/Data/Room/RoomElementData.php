<?php

namespace App\Domain\InspectionReports\Data\Room;

use App\Domain\InspectionReports\Data\PictureData;
use App\Domain\InspectionReports\Enums\Condition;
use App\Domain\InspectionReports\Enums\OperatingState;
use App\Domain\InspectionReports\Enums\Room\RoomElementCleanlinessState;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class RoomElementData extends Data
{
    public function __construct(
        public string $id,

        #[MapInputName('check_in')]
        public ?ElementCheckInData $checkIn,

        #[MapInputName('cleanliness_state')]
        public ?RoomElementCleanlinessState $cleanlinessState,

        public array $colors,
        public ?string $comment,
        public ?Condition $condition,
        public ?int $count,
        public array $defects,
        public array $materials,
        public ?string $name,

        #[MapInputName('operating_state')]
        public ?OperatingState $operatingState,

        /** @var DataCollection<PictureData> */
        public ?DataCollection $pictures = null
    ) {}
}
