<?php

namespace App\Domain\InspectionReports\ViewModels;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Data\Key\KeyData;
use App\Domain\InspectionReports\Data\MeterData;
use App\Domain\InspectionReports\Data\Room\RoomData;
use App\Domain\InspectionReports\Data\SignatoryData;
use App\Domain\InspectionReports\Enums\InspectionReportType;
use App\Domain\InspectionReports\Helpers\ExtractPictures;
use App\Domain\InspectionReports\ViewModels\Property\PropertyViewModel;
use App\Domain\InspectionReports\ViewModels\Room\RoomViewModel;
use App\Domain\InspectionReports\ViewModels\Signatory\SignatoriesViewModel;
use App\Domain\InspectionReports\ViewModels\Signatory\SignatoryViewModel;
use Spatie\LaravelData\DataCollection;
use Spatie\ViewModels\ViewModel;

class InspectionReportViewModel extends ViewModel
{

    public function __construct(
        public readonly InspectionReportData $data,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (property_exists($this->data, $name)) {
            return $this->data->$name;
        }

        return null;
    }

    public function title(): ?string
    {
        return $this->data->type?->label() ?? 'État des lieux';
    }

    public function description(): ?string
    {
        if ($this->data->type === InspectionReportType::CHECK_IN) {
            return 'État des lieux contradictoire à annexer au contrat de location dont il ne peut être dissocié.';
        }

        return 'État des lieux contradictoire établi lors de la restitution des clés en fin de bail.';
    }

    public function formatedFinalizedDate(): string
    {
        return $this->data->finalizedAt?->translatedFormat('d M Y') ?? 'Non renseigné';
    }

    public function formatedNumericFinalizedDate(): string
    {
        return $this->data->finalizedAt?->translatedFormat('d/m/Y') ?? 'Non renseigné';
    }

    public function formatedCheckInDate(): string
    {
        return $this->data->checkInDate?->translatedFormat('d M Y') ?? 'Non renseigné';
    }

    public function property(): PropertyViewModel
    {
        return new PropertyViewModel($this->data->property);
    }

    public function keys(): ?array
    {
        return collect($this->data->keys)
            ->map(fn (array $key) => new KeyViewModel(KeyData::from($key), $this->picturesWithIndex()))
            ->all();
    }

    public function meters(): ?array
    {
        return collect($this->data->meters)
            ->map(fn (array $meter) => new MeterViewModel(MeterData::from($meter), $this->picturesWithIndex()))
            ->all();
    }

    public function rooms(): ?array
    {
        return collect($this->data->rooms)
            ->map(fn (array $room) => new RoomViewModel(RoomData::from($room), $this->picturesWithIndex()))
            ->all();
    }

    public function signatoriesByType(): SignatoriesViewModel
    {
        return new SignatoriesViewModel($this->data->signatories);
    }

    public function signatories(): ?array
    {
        return collect($this->data->signatories)
            ->map(function (array $signatory, $index) {
                return new SignatoryViewModel(
                    SignatoryData::from($signatory),
                    $this->data->id,
                    $index
                );
            })
            ->all();
    }

	public function keyPicturesWithNumber(): array
	{

		return $this->extractPictures(
			$this->data->keys ?? [],
			fn ($item, $picture, $number) => "Photo {$number} — {$item->type->label()}"
		);
	}

	public function meterPicturesWithNumber(): array
	{
		return $this->extractPictures(
			$this->data->meters ?? [],
			fn ($meter, $picture, $number) => "Photo {$number} — {$meter->type->label()}"
		);
	}

	public function roomPicturesWithNumber(int|string $roomId): array
	{
		if (empty($this->data->rooms)) {
			return [];
		}

		$room = $this->data->rooms->toCollection()->firstWhere('id', $roomId);

		if (! $room) {
			return [];
		}

		$pictures = [];
		$pictureIndexes = $this->picturesWithIndex();

		foreach ($room->elements ?? [] as $element) {
			$elementName = $element->name ?? 'Élément';

			foreach ($element->pictures ?? [] as $picture) {
				$number = $pictureIndexes[$picture->id] ?? null;

				$pictures[] = [
					'id' => $picture->id,
					'url' => $picture->url,
					'number' => $number,
					'label' => "Photo {$number} — {$elementName}",
				];
			}
		}

		return $pictures;
	}

	public function propertyPictures(): array
    {
        $pictureIndexes = $this->picturesWithIndex();
        $pictures = [];

        foreach ($this->data->pictures ?? [] as $picture) {
            $number = $pictureIndexes[$picture->id] ?? null;

            $pictures[] = [
                'id' => $picture->id,
                'url' => $picture->url,
                'number' => $number,
                'label' => $this->data->finalizedAt->toDateString() > $picture->createdAt->toDateString()
                    ? "Photo {$number} — État des lieux d'entrée"
                    : "Photo {$number} — État des lieux de sortie",

            ];
        }

        return $pictures;
    }

	public function picturesWithIndex(): array
	{
		$pictures = [];
		$index = 1;

		if (!empty($this->data->meters)) {
			foreach ($this->data->meters as $meter) {
				foreach ($meter->pictures ?? [] as $picture) {
					$pictures[$picture->id] = $index++;
				}
			}
		}

		if (!empty($this->data->rooms)) {
			foreach ($this->data->rooms as $room) {
				foreach ($room->elements ?? [] as $element) {
					foreach ($element->pictures ?? [] as $picture) {
						$pictures[$picture->id] = $index++;
					}
				}
			}
		}

		if (!empty($this->data->keys)) {
			foreach ($this->data->keys as $key) {
				foreach ($key->pictures ?? [] as $picture) {
					$pictures[$picture->id] = $index++;
				}
			}
		}

		if (!empty($this->data->pictures)) {
			foreach ($this->data->pictures as $picture) {
				$pictures[$picture->id] = $index++;
			}
		}

		return $pictures;
	}

	public function signaturesCount()
    {
	    $signatories = is_countable($this->data->signatories ?? null)
		    ? count($this->data->signatories)
		    : 0;
	    $signaturesPath = storage_path(config('app.temp_storage_path') . $this->data->id . '/signatures');
        $signaturesCount = count(glob($signaturesPath.'/*'));

        return json_decode(json_encode([
            'signatories' => $signatories,
            'signatures' => $signaturesCount,
        ]));
    }

    public function getRepresentative(): ?SignatoryData
    {
        return $this->signatoriesByType()->representative;
    }

	public function getTenants(): ?DataCollection
	{
		return $this->signatoriesByType()->tenants;
	}

	private function extractPictures(iterable $items, callable $makeLabel): array
	{
		$pictureIndexes = $this->picturesWithIndex();
		$pictures = [];

		foreach ($items as $item) {
			foreach ($item->pictures ?? [] as $picture) {
				$number = $pictureIndexes[$picture->id] ?? null;

				$pictures[] = [
					'id' => $picture->id,
					'url' => $picture->url,
					'number' => $number,
					'label' => $makeLabel($item, $picture, $number),
				];
			}
		}

		return $pictures;
	}
}
