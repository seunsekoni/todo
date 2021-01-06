<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;

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



// mark a specific todo as completed
Route::patch('todos/completed/{todo}', [TodoController::class, 'mark_completed']);

// mark a specific todo as incomplete
Route::patch('todos/incomplete/{todo}', [TodoController::class, 'mark_incomplete']);

Route::apiResource('todos', TodoController::class);
