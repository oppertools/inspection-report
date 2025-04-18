<?php

namespace App\Http\Controllers\InspectionReport;

use App\Domain\InspectionReports\Actions\MakeInspectionReportPdfAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WebhookController extends Controller
{
    /**
     * @throws \Exception
     */
	public function __invoke(Request $request)
	{

		if (!$this->checkSignature($request)) {
			Log::error('Nockee webhook received', [
				'status' => 'Bad Signature',
			]);
			return response()->json(['error' => 'Signature invalide'], 401);
		}

		$id = request('data.object.id');
		(new MakeInspectionReportPdfAction($id))->handle();

		return response()->json(['success' => true], 200);
	}

	private function checkSignature(Request $request): bool {
		$expectedSignature = $request->header('X-Nockee-Signature-256');

		if (!$expectedSignature) {
			return false;
		}

		$payload = $request->getContent();
		$secret = config('app.services.nockee.webhook_secret');

		$digest = hash_hmac('sha256', $payload, $secret);
		$computedSignature = "sha256=" . $digest;

		return hash_equals($expectedSignature, $computedSignature);
	}
}
