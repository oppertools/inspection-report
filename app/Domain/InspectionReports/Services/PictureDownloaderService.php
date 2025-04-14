<?php

namespace App\Domain\InspectionReports\Services;

use App\Domain\InspectionReports\Data\InspectionReportData;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class PictureDownloaderService
{
    private InspectionReportData $inspectionReportData;

    /**
     * @throws Exception
     */
    public function downloadPictures(array $pictures, InspectionReportData $inspectionReportData): string
    {
        $this->inspectionReportData = $inspectionReportData;
        $basePath = storage_path(config('app.temp_storage_path')."{$inspectionReportData->id}/pictures");

        $this->getKeyPictures($basePath, $pictures);
        $this->getMeterPictures($basePath, $pictures);
        $this->getGeneralPictures($basePath, $pictures);
        $this->getRoomsPictures($basePath, $pictures);

        if (! is_dir($basePath) || ! file_exists($basePath)) {
	        mkdir($basePath, 0777, true);
        }

        return $basePath;
    }

    protected function getKeyPictures(string $basePath, array $pictureIndexes): void
    {
        foreach ($this->inspectionReportData->keys as $key) {
            $type = $key->type->label() ?? 'Inconnu';
            foreach ($key->pictures ?? [] as $picture) {
                $this->savePicture($picture, "{$basePath}/Clés/{$type}", $pictureIndexes[$picture->id] ?? null);
            }
        }
    }

    protected function getMeterPictures(string $basePath, array $pictureIndexes): void
    {
        foreach ($this->inspectionReportData->meters as $meter) {
            $type = $meter->type->label() ?? 'Inconnu';
            foreach ($meter->pictures ?? [] as $picture) {
                $this->savePicture($picture, "{$basePath}/Compteurs/{$type}", $pictureIndexes[$picture->id] ?? null);
            }
        }
    }

    protected function getGeneralPictures(string $basePath, array $pictureIndexes): void
    {
        foreach ($this->inspectionReportData->pictures ?? [] as $picture) {
            $this->savePicture($picture, "{$basePath}/Photos Générales", $pictureIndexes[$picture->id] ?? null);
        }
    }

    protected function getRoomsPictures(string $basePath, array $pictureIndexes): void
    {
        foreach ($this->inspectionReportData->rooms as $room) {
            $roomName = $room->name ?? 'Pièce';
            foreach ($room->elements ?? [] as $element) {
                $elementName = $element->name ?? 'Élément';
                foreach ($element->pictures ?? [] as $picture) {
                    $this->savePicture($picture, "{$basePath}/Pièces/{$roomName}/{$elementName}", $pictureIndexes[$picture->id] ?? null);
                }
            }
        }
    }

	/**
	 * @throws ConnectionException
	 */
	private function savePicture(object $picture, string $folderPath, ?int $index): void
    {
        if (! $index || ! $picture->url) {
            return;
        }

        $filename = 'photo-'.$index.'.jpg';
        $fullPath = "{$folderPath}/{$filename}";

        if (! file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $response = Http::get($picture->url);
        if ($response->successful()) {
            file_put_contents($fullPath, $response->body());
        } else {
            logger()->error("Échec du téléchargement pour {$picture->url}");
        }
    }
}
