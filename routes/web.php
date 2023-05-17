<?php

use App\Http\Controllers\ProfileController;
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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/** Routes for the administrator views */
Route::middleware('auth', 'role:Administrator')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', \App\Http\Livewire\Admin\Index::class)->name('index');
    Route::get('/roles', \App\Http\Livewire\Admin\Roles\Index::class)->name('roles');
    Route::get('/permissions', \App\Http\Livewire\Admin\Permissions\Index::class)->name('permissions');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
