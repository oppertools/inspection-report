<?php

namespace App\Domain\InspectionReports\Data;

use App\Domain\InspectionReports\Enums\MeterType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class MeterData extends Data
{
    public function __construct(
        public string $id,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]

        #[MapInputName('check_in')]
        public ?array $checkIn,

        public ?string $comment,
        public ?bool $inaccessible,

        #[MapInputName('index_1')]
        public ?int $index_1,

        #[MapInputName('index_2')]
        public ?int $index_2,

        public ?string $number,
        public MeterType $type,
        /** @var DataCollection<PictureData> */
        public ?DataCollection $pictures
    ) {}
}
