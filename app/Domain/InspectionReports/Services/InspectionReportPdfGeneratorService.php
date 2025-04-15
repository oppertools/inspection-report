<?php

namespace App\Domain\InspectionReports\Services;

use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Exception;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;
use Illuminate\Support\Facades\Cache;

class InspectionReportPdfGeneratorService
{
    /**
     * @throws Exception
     */
    public function generate(InspectionReportViewModel $data): string
    {

        $html = view('inspection.layout', ['data' => $data])->render();
        $basePath = storage_path(config('app.temp_storage_path')."{$data->id}");
        $filename = "etat-des-lieux-{$data->property()->formatedAddress()}-{$data->finalizedAt->format('d-m-Y')}";
	    Cache::put("inspection:{$data->id}:pdfName", $filename . '.pdf');

        $directory = dirname($basePath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $request = Gotenberg::chromium(config('app.gotenberg.url'))
            ->pdf()
            ->outputFilename($filename)
            ->assets(Stream::string('style.css', file_get_contents(public_path('css/app.css'))))
            ->html(Stream::string('index.html', $html));

        $result = Gotenberg::save($request, $basePath);


        if ($result !== $filename.'.pdf') {
            throw new Exception('Failed to generate PDF');
        }

        return $basePath.'/'.$filename.'.pdf';

    }
}
