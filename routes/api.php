<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentStatusController;
use App\Http\Controllers\CounselorScheduleController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidationController;
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

Route::middleware(['auth:sanctum', 'valid'])->group (function () {
    Route::get('/user/validate', [ValidationController::class, 'validateUser']);
    Route::resource('users', UserController::class, ['except' => ['store']]);
    Route::resource('institutions', InstitutionController::class, ['except' => ['index']]);
    Route::resources([
        'notes' => NoteController::class,
        'appointments' => AppointmentController::class,
        'schedules' => CounselorScheduleController::class,
        'statuses' => AppointmentStatusController::class
    ]);
});