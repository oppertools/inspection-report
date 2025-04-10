<?php

namespace App\Domain\InspectionReports\Services;

use Illuminate\Support\Facades\Cache;
use ZipArchive;

readonly class PictureZipService
{
    public function createZip(string $picturePath, $zipName, string $inspectionReportId, $cacheKey): string
    {
        $basePath = storage_path(config('app.temp_storage_path')."{$inspectionReportId}/{$zipName}");
	    Cache::put("inspection:{$inspectionReportId}:{$cacheKey}", $zipName);

		if (! is_dir(dirname($basePath))) {
            mkdir(dirname($basePath), 0777, true);
        }

        if (file_exists($basePath)) {
            unlink($basePath);
        }

        $files = $this->getFilesRecursively($picturePath);
        $zip = new ZipArchive;

        if ($zip->open($basePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $prefixLength = strlen($picturePath.DIRECTORY_SEPARATOR);

            foreach ($files as $file) {
                $relativePath = substr($file, $prefixLength);
                $zip->addFile($file, $relativePath);
            }

            $zip->close();

            return $basePath;
        }

        throw new \RuntimeException("Unable to create zip file at: {$basePath}");
    }

    private function getFilesRecursively($dir): array
    {
        $files = [];

        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir.DIRECTORY_SEPARATOR.$file;

            if (is_dir($path)) {
                $files = array_merge($files, $this->getFilesRecursively($path));
            } else {
                $files[] = $path;
            }
        }

        return $files;
    }
}
