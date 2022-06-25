<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentStatusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CounselorScheduleController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Models\AppointmentStatus;
use App\Models\CounselorSchedule;
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

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group (function () {
    Route::post('/users/{id}', [UserController::class, 'update']);

    Route::resource('users', UserController::class, ['except' => ['store', 'update']]);
    Route::resource('institutions', InstitutionController::class, ['except' => ['index', 'show', 'update']]);

    Route::prefix('users/{id}')->group(function () {
        Route::resource('notes', [NoteController::class]);
        Route::resource('appointments', [AppointmentController::class]);
        Route::resource('schedules', [CounselorSchedule::class]);
    });

    Route::resource('statuses', [AppointmentStatus::class]);

    Route::get('/institutions', [InstitutionController::class, 'index']);
    Route::get('/institutions/{id}', [InstitutionController::class, 'show']);
    Route::post('/institutions/{id}', [InstitutionController::class, 'update']);


    Route::post('/logout', [AuthController::class, 'logout']);
});
