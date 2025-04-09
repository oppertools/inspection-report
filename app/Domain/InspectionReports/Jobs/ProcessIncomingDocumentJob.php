<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Services\InspectionReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessIncomingDocumentJob implements ShouldQueue
{
    use Queueable;

    public InspectionReportData $inspectionReport;

    /**
     * Create a new job instance.
     */
    public function __construct(
        InspectionReportData $inspectionReport
    ) {
        $this->inspectionReport = $inspectionReport;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (! $this->inspectionReport->documents->inspection_report_pdf) {
            return;
        }

        $workingDir = storage_path("app/documents/{$this->inspectionReport->id}");
        $originalPath = "{$workingDir}/original.pdf";
        $lastPath = "{$workingDir}/last.pdf";
        $outputPdf = "{$workingDir}/final.pdf";
        $scriptPath = base_path('scripts/extract_signatures.bash');
        $localScriptPath = "{$workingDir}/extract_signatures.bash";

        if (! is_dir($workingDir)) {
            mkdir($workingDir, 0777, true);
        }

        file_put_contents($originalPath, file_get_contents($this->inspectionReport->documents->inspection_report_pdf));

        copy($scriptPath, $localScriptPath);
        chmod($localScriptPath, 0755);

        $process = new Process([
            'bash', './extract_signatures.bash',
        ], cwd: $workingDir);

        $process->run();

        Log::info($process->getOutput());
        Log::error($process->getErrorOutput());

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        (new InspectionReportService)->generateInspectionReport();
    }
}
