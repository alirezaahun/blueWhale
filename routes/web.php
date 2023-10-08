<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WorkSampleController;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
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
})->middleware('auth')->name('root');
Route::get('/logout' , function(){
    auth()->logout();
});
Route::get('/log' , function(){
    return view('auth.login');
})->name('auth');
Route::post('/checkAuth' , function(Request $request){
    $user = User::where('email' , $request->email)->first();
    if (!$user) {
        Session::flash('failed', 'login failed check your name and password');
        return redirect()->route('auth');
    }
    if (Hash::check($request->password, $user->password)) {
        auth()->login($user , $remember = true);
        return redirect()->route('root');
    }else{
        return redirect()->back();
    }
})->name('checkAuth');
Route::prefix('adminpanel_management')->name('admin.')->middleware('auth')->group(function(){
    Route::resource('/blogs', BlogController::class);
    Route::resource('/works' , WorkSampleController::class);
    Route::delete('/deleteImage/{id}' , [WorkSampleController::class , 'destroyImage'])->name('works.destroyImage');
    Route::post('/createCategory' , [CategoryController::class , 'create'])->name('categoryCreate');
});
