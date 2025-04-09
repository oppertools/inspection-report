<?php

namespace App\Http\Controllers\Api\InspectionReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompletedInspectionWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {

        // 2. Dispatch du traitement asynchrone
        BuildInspectionReportJob::dispatch($data);

        // 3. Réponse rapide à l’API externe
        return response()->noContent(); // 204
    }
}
