<?php

namespace App\Domain\InspectionReports\ViewModels;

use App\Data\InspectionReportData;
use App\Data\PictureData;
use Spatie\ViewModels\ViewModel;

class InspectionReportPicturesViewModel extends ViewModel
{
    private static int $pictureCounter = 1;

    public function __construct(
        public readonly InspectionReportData $data,
    ) {

        self::$pictureCounter = 1;
    }

    /**
     * Renvoie toutes les photos organisées par type (meters, rooms, keys)
     */
    public function pictures(): array
    {
        return [
            'meters' => $this->metersPictures(),
            'rooms' => $this->roomsPictures(),
            'keys' => $this->keysPictures(),
        ];
    }

    /**
     * Récupère les photos des compteurs, organisées par type de compteur
     */
    public function metersPictures(): array
    {
        $metersByType = [];

        foreach ($this->data->meters as $meter) {
            $type = $meter->type ?? 'other';

            if (! isset($metersByType[$type])) {
                $metersByType[$type] = [];
            }

            if (! empty($meter->pictures)) {
                foreach ($meter->pictures as $picture) {
                    $metersByType[$type][] = $this->formatPicture(
                        $picture,
                        'meter',
                        $meter->id,
                        [
                            'meter_id' => $meter->id,
                            'meter_type' => $type,
                            'meter_object' => $meter->object ?? null,
                        ]
                    );
                }
            }
        }

        // Conversion en collections pour garder la même structure
        return collect($metersByType)->map(fn ($items) => collect($items))->all();
    }

    /**
     * Récupère les photos des pièces et de leurs éléments
     */
    public function roomsPictures(): array
    {
        $roomsById = [];

        foreach ($this->data->rooms as $roomIndex => $room) {
            $id = $room->id;
            $type = $room->type ?? 'other';

            $roomData = [
                'id' => $room->id,
                'name' => $room->name ?? ('Pièce '.($roomIndex + 1)),
                'object' => $room->object ?? null,
                'elements' => [],
                'pictures' => collect(),
            ];

            if (! empty($room->pictures)) {
                foreach ($room->pictures as $picture) {
                    $roomData['pictures']->push($this->formatPicture(
                        $picture,
                        'room',
                        $room->id,
                        [
                            'room_id' => $room->id,
                            'room_type' => $type,
                            'room_object' => $room->object ?? null,
                        ]
                    ));
                }
            }

            // Gestion des éléments de la pièce
            if (! empty($room->elements)) {
                foreach ($room->elements as $elementIndex => $element) {
                    $elementId = $element->id;

                    $elementData = [
                        'id' => $elementId,
                        'name' => $element->name ?? ('Élément '.($elementIndex + 1)),
                        'object' => $element->object ?? null,
                        'pictures' => collect(),
                    ];

                    if (! empty($element->pictures)) {
                        foreach ($element->pictures as $picture) {
                            $elementData['pictures']->push($this->formatPicture(
                                $picture,
                                'element',
                                $elementId,
                                [
                                    'element_id' => $elementId,
                                    'element_object' => $element->object ?? null,
                                    'room_id' => $room->id,
                                    'room_type' => $type,
                                ]
                            ));
                        }
                    }

                    $roomData['elements'][$elementId] = (object) $elementData;
                }
            }

            $roomsById[$id] = (object) $roomData;
        }

        return $roomsById;
    }

    /**
     * Récupère les photos des clés
     */
    public function keysPictures(): \Illuminate\Support\Collection
    {
        $keyPictures = collect();

        foreach ($this->data->keys as $key) {
            if (! empty($key->pictures)) {
                foreach ($key->pictures as $picture) {
                    $keyPictures->push($this->formatPicture(
                        $picture,
                        'key',
                        $key->id
                    ));
                }
            }
        }

        return $keyPictures;
    }

    /**
     * Formate une photo avec un numéro incrémental
     */
    private function formatPicture(PictureData $picture, string $type, string $parentId, array $metadata = []): object
    {
        return (object) array_merge([
            'id' => $picture->id,
            'label' => 'Photo '.self::$pictureCounter++,
            'anchorId' => "picture-{$type}-{$parentId}",
            'url' => $picture->url,
        ], $metadata);
    }

    /**
     * Obtient toutes les photos avec une numérotation continue
     */
    public function allPictures(): array
    {
        $allPictures = [];

        // Reset counter for consistency
        self::$pictureCounter = 1;

        // Collect all pictures in order: meters, keys, rooms
        $pictures = $this->pictures();

        // Meters
        foreach ($pictures['meters'] as $typeGroup) {
            foreach ($typeGroup as $picture) {
                $allPictures[] = $picture;
            }
        }

        // Keys
        foreach ($pictures['keys'] as $picture) {
            $allPictures[] = $picture;
        }

        // Rooms and elements
        foreach ($pictures['rooms'] as $room) {
            foreach ($room->pictures as $picture) {
                $allPictures[] = $picture;
            }

            foreach ($room->elements as $element) {
                foreach ($element->pictures as $picture) {
                    $allPictures[] = $picture;
                }
            }
        }

        return $allPictures;
    }
}
