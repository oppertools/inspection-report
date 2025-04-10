<?php

namespace App\Domain\InspectionReports\Data\Key;

use App\Domain\InspectionReports\Casts\KeyTypeCast;
use App\Domain\InspectionReports\Casts\SmartDateCast;
use App\Domain\InspectionReports\Data\PictureData;
use App\Domain\InspectionReports\Enums\KeyType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class KeyData extends Data
{
    public function __construct(
        public string $id,

        #[MapInputName('check_in')]
        public ?KeyCheckInData $checkIn,

        public ?string $comment,
        public ?int $count,

	    #[WithCast(KeyTypeCast::class)]
        public ?KeyType $type,

        /** @var DataCollection<PictureData> */
        public DataCollection $pictures
    ) {}
}
