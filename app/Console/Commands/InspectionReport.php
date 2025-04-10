<?php

namespace App\Console\Commands;

use App\Domain\InspectionReports\Actions\BuildInspectionReportAction;
use App\Domain\InspectionReports\Actions\MakeInspectionReportPdfAction;
use App\Domain\InspectionReports\Data\InspectionReportData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command as CommandAlias;

class InspectionReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspection-report:generate {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an inspection report pdf for a given inspection ID';

    /**
     * Execute the console command.
     */
	public function handle(): int
	{
		$id = $this->argument('id');

		$this->info("Génération du PDF pour l’inspection #{$id}...");

		try {
			(new MakeInspectionReportPdfAction($id))->handle();
			$this->info("✅ PDF généré avec succès");
			return CommandAlias::SUCCESS;
		} catch (\Throwable $e) {
			$this->error("❌ Erreur lors de la génération : {$e->getMessage()}");
			return CommandAlias::FAILURE;
		}
	}
}
