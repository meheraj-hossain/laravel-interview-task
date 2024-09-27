<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubTaskController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api', 'throttle:60,1'])->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::get('projects/{id}/report', [ProjectController::class, 'report'])->name('projects.report');
    Route::apiResource('projects.tasks', TaskController::class);
    Route::post('projects/{project}/tasks/upload', [TaskController::class, 'uploadTasks'])->name('projects.tasks.upload');
    Route::apiResource('tasks.subtasks', SubTaskController::class);
});
