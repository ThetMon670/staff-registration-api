<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
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

    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('logout', [AuthController::class,'logout']);

        Route::apiResource('staffs', StaffController::class);

    });
    
    // Staff routes
    Route::post('attendance/check-in', [AttendanceController::class,'checkIn']);
    Route::post('attendance/check-out', [AttendanceController::class,'checkOut']);
    Route::get('attendance/my', [AttendanceController::class,'myAttendance']);

    // Admin routes
    Route::get('attendance', [AttendanceController::class,'index']); // all attendance
});