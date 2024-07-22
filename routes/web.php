<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'register'])->name('register');


Route::prefix('tasks')->middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/toggle-status/{id}', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::get('/edit/{id}', [TaskController::class, 'editTask'])->name('tasks.edit');
    Route::put('update', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
