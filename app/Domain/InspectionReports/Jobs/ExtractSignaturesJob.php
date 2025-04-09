<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ExtractSignaturesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public InspectionReportData $inspectionReportData;

    public function __construct(InspectionReportData $inspectionReportData)
    {
        $this->inspectionReportData = $inspectionReportData;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $workingDir = storage_path(config('app.temp_storage_path').$this->inspectionReportData->id);
        $path = $workingDir.'/signatures/';
        $originalFilePath = "{$workingDir}/original.pdf";
        $workingFilePath = "{$workingDir}/last.pdf";
        $scriptPath = base_path('scripts/extract_signatures.bash');
        $localScriptPath = "{$workingDir}/extract_signatures.bash";

        if (! is_dir($workingDir)) {
            mkdir($workingDir, 0777, true);
        }

        file_put_contents($originalFilePath, file_get_contents($this->inspectionReportData->documents->inspection_report_pdf));

        copy($scriptPath, $localScriptPath);
        chmod($localScriptPath, 0755);

        $process = new Process([
            'bash', './extract_signatures.bash',
        ], cwd: $workingDir);

        $process->run();

        if (! $process->isSuccessful()) {
            Log::error($process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

		Log::error($process->getOutput());
        Cache::put("inspection:{$this->inspectionReportData->id}:signatures", $path);
    }
}
