<?php

use App\Http\Controllers\SiteController as Site;
use App\Http\Controllers\AuthController as Auth;
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


// Route::get('/', [Site::class, 'index'])->middleware('PreventScreenCapture');
// Route::get('/', [Site::class, 'index']);
Route::middleware(['isLogin'])->group(function(){
    Route::get('/', [Site::class, 'index']);

    Route::prefix('/user')->name('user.')->group(function(){
        Route::get('/show/{id}',[Site::class, 'show'])->name('show');
        Route::post('/update', [Site::class, 'update'])->name('update');
        Route::post('/create', [Site::class, 'create'])->name('create');
    });
});

Route::prefix('/auth')->name('auth.')->group(function(){
    Route::get('/index', [Auth::class, 'index'])->name('index');
    Route::post('/login', [Auth::class, 'login'])->name('login');
    Route::get('/logout', [Auth::class, 'logout'])->name('logout');
});
