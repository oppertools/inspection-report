<?php

namespace App\Domain\InspectionReports\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InspectionUploader
{
    public function uploadFiles(array $files, string $inspectionReportId): array
    {
        $results = [];

        foreach ($files as $type => $filePath) {
            $filename = basename($filePath);
            $storageFilePath = "inspection-report/{$inspectionReportId}/{$filename}";

            try {
                if (! file_exists($filePath)) {
                    throw new Exception("Le fichier {$type} n'existe pas à l'emplacement : {$filePath}");
                }

                $fileContent = file_get_contents($filePath);
                if ($fileContent === false) {
                    throw new Exception("Impossible de lire le fichier {$type} à l'emplacement : {$filePath}");
                }

                $success = Storage::disk('s3')->put($storageFilePath, $fileContent);
                if (! $success) {
                    throw new Exception("Échec du téléchargement du fichier {$type} vers le chemin : {$storageFilePath}");
                }

                $url = Storage::disk('s3')->url($storageFilePath);
                $results[$type] = $url;

            } catch (Exception $e) {
                Log::error("Erreur lors du traitement du fichier {$type}", [
                    'inspection_id' => $inspectionReportId,
                    'file_path' => $filePath,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        return $results;
    }
}
