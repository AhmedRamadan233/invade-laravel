<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/toggle-status/{id}', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::get('/edit/{id}', [TaskController::class, 'editTask'])->name('tasks.edit');
    Route::put('update', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/trashed', [TaskController::class, 'getTasksTrashing'])->name('tasks.trashed');
    Route::post('/restore/{id}', [TaskController::class, 'getTasksRestoring'])->name('tasks.restore');
    Route::delete('/force-delete/{id}', [TaskController::class, 'deleteTasksForced'])->name('tasks.forceDelete');
});


Route::prefix('categories')->group(function () {

    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/edit/{id}', [CategoryController::class, 'editCategory'])->name('categories.edit');
    Route::put('update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
