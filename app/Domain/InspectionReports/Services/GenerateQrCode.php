<?php

namespace App\Domain\InspectionReports\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    public function generate(string $id): string
    {
        $basePath = storage_path(config('app.temp_storage_path')."{$id}/");
        if (! is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $filename = 'qrcode.svg';
        $fullPath = $basePath.$filename;

        $qrCode = QrCode::size(300)
            ->color(2, 77, 175)
            ->backgroundColor(143, 191, 255, 1)
            ->generate(route('inspection-report.show', $id));

        file_put_contents($fullPath, $qrCode);

        return $fullPath;
    }
}
