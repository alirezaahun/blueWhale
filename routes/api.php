<?php

use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\WorkSampleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    Route::get('/blogs' ,  [BlogController::class , 'getAll']);
    Route::get('/blog/{blog}' , [BlogController::class , 'getBlog']);

    Route::get('/works' , [WorkSampleController::class , 'getAll' ]);
    Route::get('/works/{work}' , [WorkSampleController::class , 'get']);
});
