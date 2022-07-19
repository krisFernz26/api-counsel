<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentStatusController;
use App\Http\Controllers\DailyScheduleController;
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

Route::get('/', function () {
    return 'API for counsel';
});
Route::post('/token/generate', [TokenController::class, 'generate']);

Route::post('/register', [UserController::class, 'store']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/institutions/login', [AuthController::class, 'loginInstitution']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/validate', [AuthController::class, 'validateToken']);
Route::resource('statuses', AppointmentStatusController::class, [
    'except' => [
        'update',
        'destroy',
    ]
]);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::resource('users', UserController::class, ['except' => ['store', 'update', 'getCurrentUser']]);
    Route::get('/user/current', [UserController::class, 'getCurrentUser']);
    Route::post('/users/{id}', [UserController::class, 'update']);

    Route::resource('institutions', InstitutionController::class, [
        'except' => [
            'index',
            'show',
            'update',
            'approve'
        ]
    ]);
    Route::get('/institutions', [InstitutionController::class, 'index']);
    Route::get('/institutions/names', [InstitutionController::class, 'indexNames']);
    Route::get('/institutions/{id}', [InstitutionController::class, 'show']);
    Route::post('/institutions/{id}', [InstitutionController::class, 'update']);
    Route::put('/institutions/{id}/approve', [InstitutionController::class, 'approve']);

    Route::get('/notes', [NoteController::class, 'index']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::get('/notes/{id}', [NoteController::class, 'show']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::put('/notes/{id}/restore', [NoteController::class, 'restore']);
    Route::delete('/notes/{id}', [NoteController::class, 'destroy']);
    Route::get('/notes/students/{student_id}', [NoteController::class, 'getAllNotesOnStudent']);
    Route::get('/notes/counselors/{counselor_id}', [NoteController::class, 'getAllNotesOfCounselor']);
    Route::get('/notes/counselors/{counselor_id}/students/{student_id}', [NoteController::class, 'getNotesOfCounselorOnStudent']);

    Route::resource('appointments', AppointmentController::class, [
        'except' => [
            'getAllAppointmentsOfUser',
            'getAllAppointmentsOfStudent',
            'getAllAppointmentsOfCounselor',
            'restore',
            'start',
            'complete',
            'cancel'
        ]
    ]);
    Route::get('/users/{id}/appointments', [AppointmentController::class, 'getAllAppointmentsOfUser']);
    Route::put('/appointments/{id}/restore', [AppointmentController::class, 'restore']);
    Route::put('/appointments/{id}/start', [AppointmentController::class, 'start']);
    Route::put('/appointments/{id}/complete', [AppointmentController::class, 'complete']);
    Route::put('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);

    Route::put('/statuses/{id}', [AppointmentStatusController::class, 'update']);
    Route::delete('/statuses/{id}', [AppointmentStatusController::class, 'destroy']);

    // TODO: Test these routes
    Route::get('/schedules', [DailyScheduleController::class, 'index']);
    Route::get('/schedules/{id}', [DailyScheduleController::class, 'show']);
    Route::get('/counselors/{counselor_id}/schedules', [DailyScheduleController::class, 'getAllDailySchedulesOfCounselor']);
    Route::post('/schedules', [DailyScheduleController::class, 'store']);
    Route::put('/schedules/{id}', [DailyScheduleController::class, 'update']);
    Route::delete('/schedules/{id}', [DailyScheduleController::class, 'destroy']);

    Route::get('/logout', [AuthController::class, 'logout']);
});
