<?php

use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome from WebPos API',
            'developed_by' => 'Thet Thet Mon',
            'for' => 'Trust Link Senior',
            'documentation_url' => env('APP_DOC_URL', 'https://mms-it.com'),
        ]);
    });

    Route::apiResource('staffs', StaffController::class);
});