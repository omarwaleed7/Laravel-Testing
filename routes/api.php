<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->controller(AuthController::class)->group(function (){
    Route::post('register','register')->name('auth.register');
    Route::post('login','login')->name('auth.login');
});

Route::prefix('tasks')->controller(TaskController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/','store')->name('tasks.store');
    Route::get('/','index')->name('tasks.index');
    Route::get('/{task}','show')->name('tasks.show');
    Route::patch('/{task}','update')->name('tasks.update');
    Route::delete('/{task}','delete')->name('tasks.delete');
});
