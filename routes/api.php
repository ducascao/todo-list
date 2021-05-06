<?php

use App\Http\Controllers\SharedTaskController;
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

Route::put('/restore', [TaskController::class, 'restoreTasks']);

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/share/{code}', [SharedTaskController::class, 'getTaskByShareCode']);
    Route::put('/share/{code}', [SharedTaskController::class, 'update']);
    Route::post('/share/{code}/item', [SharedTaskController::class, 'addItem']);
    Route::put('/share/item/{id}', [SharedTaskController::class, 'updateItem']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
