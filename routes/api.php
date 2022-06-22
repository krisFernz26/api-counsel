<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentStatusController;
use App\Http\Controllers\CounselorScheduleController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/token/generate', [TokenController::class, 'generate']);

Route::middleware(['auth:sanctum'])->group (function () {
    Route::resources([
        'users' => UserController::class,
        'institutions' => InstitutionController::class,
        'notes' => NoteController::class,
        'appointments' => AppointmentController::class,
        'schedules' => CounselorScheduleController::class,
        'statuses' => AppointmentStatusController::class
    ]);
});