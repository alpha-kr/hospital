<?php

use App\Http\Controllers\Api\Patients\PatientController;
use App\Http\Controllers\Api\PatientsAssignments\PatientAssignmentController;
use App\Http\Controllers\Api\TopDiagnosesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('patients.assignments', PatientAssignmentController::class)->only(['store', 'destroy']);
    Route::get('top-diagnoses', TopDiagnosesController::class);
});


