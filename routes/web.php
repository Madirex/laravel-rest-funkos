<?php

use App\Http\Controllers\CategoryController;
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

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create')->middleware(['auth', 'admin']);
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store')->middleware(['auth', 'admin']);
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['auth', 'admin']);
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware(['auth', 'admin']);
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware(['auth', 'admin']);
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
