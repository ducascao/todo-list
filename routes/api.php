<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
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

ApiMaker::routes();

/** API Maker: Routes */
Route::apiResource('task-items', App\Http\Controllers\TaskItemController::class);
// Route::apiResource('tasks', App\Http\Controllers\TaskController::class);

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);

    Route::get('/{id}/items', [TaskController::class, 'getItems']);
});

Route::get('user/{id}/tasks', [TaskController::class, 'getTasksByUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
