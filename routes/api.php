<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('projects', ProjectController::class)->except('store', 'update', 'destroy');

//qui vogliamo i progetti relativi a quel tipo
Route::get('/type/{type_id}/projects', [ProjectController::class, 'getProjectsByType']);

//qui vogliamo i commenti relativi a quel progetto
Route::get('project/{project_id}/comments', [CommentController::class, 'getCommentsByProject']);
Route::post('comments', [CommentController::class, 'store']);