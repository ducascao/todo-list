<?php

use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('shared-task/{code}', [TaskController::class, 'verifySharedCode']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/share/{code}', [TaskController::class, 'getTaskByShareCode']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::put('/tasks/{id}/share', [TaskController::class, 'sendSharedCode']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    Route::get('/tasks/{id}/items', [TaskController::class, 'getItems']);
});

Route::apiResource('task-items', App\Http\Controllers\TaskItemController::class);

Route::middleware('auth:sanctum')->get('user/{id}/tasks', [TaskController::class, 'getTasksByUser']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
