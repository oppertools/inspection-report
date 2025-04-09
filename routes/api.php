<?php

use Illuminate\Support\Facades\Route;

Route::get('/webhook/nockee', \App\Http\Controllers\InspectionReport\WebhookController::class);
