<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('sales', SaleController::class)->middleware(['auth', 'verified']);
Route::post('sales/{sale}/trash', [SaleController::class, 'trash'])->name('sales.trash');
Route::get('/trashed', [SaleController::class, 'trashed'])->name('sales.trashed');
Route::post('sales/{sale}/restore', [SaleController::class, 'restore'])->name('sales.restore');
Route::delete('sales/{sale}/force-delete', [SaleController::class, 'forceDelete'])->name('sales.forceDelete');


require __DIR__.'/auth.php';
