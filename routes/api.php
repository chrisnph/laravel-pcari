<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheatreController;
use App\Http\Controllers\ScheduleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/movies', [MovieController::class, 'index']);
Route::post('/movies/add', [MovieController::class, 'add'], );

Route::post('/theatres', [TheatreController::class, 'index']);
Route::post('/theatres/add', [TheatreController::class, 'add']);

Route::post('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules/add', [ScheduleController::class, 'add']);
Route::post('/schedules/search', [ScheduleController::class, 'findByTheatre']);
Route::post('/schedules/search/timeslot', [ScheduleController::class, 'findByTimeslot']);

