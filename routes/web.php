<?php

use App\Http\Controllers\FunkoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('funkos.index');
});

Route::group(['prefix' => 'funkos'], function () {
    Route::get('/', [FunkoController::class, 'index'])->name('funkos.index');
    Route::get('/create', [FunkoController::class, 'create'])->name('funkos.create')->middleware(['auth', 'admin']);
    Route::post('/', [FunkoController::class, 'store'])->name('funkos.store')->middleware(['auth', 'admin']);
    Route::get('/{funko}', [FunkoController::class, 'show'])->name('funkos.show');
    Route::get('/{funko}/edit', [FunkoController::class, 'edit'])->name('funkos.edit')->middleware(['auth', 'admin']);
    Route::put('/{funko}', [FunkoController::class, 'update'])->name('funkos.update')->middleware(['auth', 'admin']);
    Route::delete('/{funko}', [FunkoController::class, 'destroy'])->name('funkos.destroy')->middleware(['auth', 'admin']);
    Route::get('/{funko}/edit-image', [FunkoController::class, 'editImage'])->name('funkos.editImage')->middleware(['auth', 'admin']);
    Route::patch('/{funko}/edit-image', [FunkoController::class, 'updateImage'])->name('funkos.updateImage')->middleware(['auth', 'admin']);
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
