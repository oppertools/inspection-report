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
		$this->prepareWorkingDirectory();
		$this->storeOriginalPdf();
		$this->copyExtractionScript();
		$this->runExtractionProcess();

		Cache::put("inspection:{$this->inspectionReportData->id}:signatures", $this->getSignaturePath());
	}

	private function prepareWorkingDirectory(): void
	{
		if (! is_dir($this->getWorkingDir())) {
			mkdir($this->getWorkingDir(), 0755, true);
		}
	}

	private function storeOriginalPdf(): void
	{
		$pdfContent = file_get_contents($this->inspectionReportData->documents->inspection_report_pdf);
		file_put_contents($this->getOriginalFilePath(), $pdfContent);
	}

	private function copyExtractionScript(): void
	{
		$scriptSource = base_path('scripts/extract_signatures.bash');
		$scriptDestination = $this->getLocalScriptPath();

		copy($scriptSource, $scriptDestination);
		chmod($scriptDestination, 0755);
	}

	private function runExtractionProcess(): void
	{
		$process = new Process(['bash', './extract_signatures.bash'], cwd: $this->getWorkingDir());
		$process->run();

		if (! $process->isSuccessful()) {
			Log::error($process->getErrorOutput());
			throw new ProcessFailedException($process);
		}
	}

	private function getWorkingDir(): string
	{
		return storage_path(config('app.temp_storage_path') . $this->inspectionReportData->id);
	}

	private function getSignaturePath(): string
	{
		return $this->getWorkingDir() . '/signatures/';
	}

	private function getOriginalFilePath(): string
	{
		return $this->getWorkingDir() . '/original.pdf';
	}

	private function getLocalScriptPath(): string
	{
		return $this->getWorkingDir() . '/extract_signatures.bash';
	}

}
