<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\FileController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/hero/{nick}', [HeroController::class, 'show']);
Route::post('/create', [HeroController::class, 'create']);
Route::put('/update', [HeroController::class, 'update']);
Route::get('/heroList', [HeroController::class, 'heroList']);
Route::delete('/delete/{id}', [HeroController::class, 'delete']);
Route::get('/show', [HeroController::class, 'show']);

Route::post('/setImages', [FileController::class, 'setImages']);
Route::get('/getImages', [FileController::class, 'getImages']);
Route::delete('/deleteImage', [FileController::class, 'deleteImage']);
