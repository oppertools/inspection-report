<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\Services\InspectionUploader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $inspectionReportId;

    public function __construct(string $inspectionReportId)
    {
        $this->inspectionReportId = $inspectionReportId;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $uploader = new InspectionUploader;
        $zipPath = Cache::get("inspection:{$this->inspectionReportId}:zip");
        $qrCodePath = Cache::get("inspection:{$this->inspectionReportId}:qrcode");
        $pdfPath = Cache::get("inspection:{$this->inspectionReportId}:pdf");

        $result = $uploader->uploadFiles([
            'zip' => $zipPath,
            'qrcode' => $qrCodePath,
            'pdf' => $pdfPath,
        ], $this->inspectionReportId);

        if (count($result) === 3) {
	        $modelId = Cache::get("inspection:{$this->inspectionReportId}:modelId");
			$storagePath = "inspection-report/{$this->inspectionReportId}";
			$pdfName = Cache::get("inspection:{$this->inspectionReportId}:pdfName");
			$zipName = Cache::get("inspection:{$this->inspectionReportId}:zipName");


	        if ($modelId) {
		        $model = InspectionReport::findOrFail($modelId);
		        $model->pdf_path = Storage::disk('s3')->path($storagePath . '/' . $pdfName);
		        $model->zip_path = Storage::disk('s3')->path($storagePath . '/' . $zipName . '.pdf');
		        $model->save();
	        }

            Cache::forget("inspection:{$this->inspectionReportId}:zip");
            Cache::forget("inspection:{$this->inspectionReportId}:qrcode");
            Cache::forget("inspection:{$this->inspectionReportId}:pdf");
            Cache::forget("inspection:{$this->inspectionReportId}:modelId");
	        Cache::forget("inspection:{$this->inspectionReportId}:pdfName");
			Cache::forget("inspection:{$this->inspectionReportId}:zipName");


        } else {
            throw new \Exception('Erreur lors de l\'upload des fichiers');
        }

		// Delete the files from the local storage
	    if(File::exists(storage_path('app/private/temp/inspection-report/' . $this->inspectionReportId))) {
			File::deleteDirectory(storage_path('app/private/temp/inspection-report/' . $this->inspectionReportId));
	    }
    }
}
