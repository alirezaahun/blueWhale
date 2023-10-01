<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\WorkSampleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('adminpanel_management')->name('admin.')->group(function(){
    Route::resource('/blogs', BlogController::class);
    Route::resource('/works' , WorkSampleController::class);
    Route::delete('/deleteImage/{id}' , [WorkSampleController::class , 'destroyImage'])->name('works.destroyImage');
});
