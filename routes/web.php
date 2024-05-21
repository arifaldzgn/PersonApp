<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MuscleGroupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/muscle_group', [MuscleGroupController::class, 'index'])->name('muscle_group');
Route::get('/muscle_group/{id}', [MuscleGroupController::class, 'variation'])->name('variation');

Route::POST('/add_variation', [MuscleGroupController::class, 'addVariation'])->name('addVariation');

Route::get('/record', [WorkoutController::class, 'index']);

Route::POST('/add_record', [WorkoutController::class, 'add_record'])->name('addRecord');

Route::get('/record_list', [WorkoutController::class, 'record_list']);

Route::get('/fetch-variations', [WorkoutController::class, 'fetch_variation']);

Route::get('/workouts/{workout}/sessions', [WorkoutController::class, 'getSessions'])->name('workouts.sessions');

Route::get('/testdata', [WorkoutController::class, 'test']);

Route::get('/progressive-overload', [WorkoutController::class, 'showProgressiveOverload'])->name('progressiveOverload');

Route::get('/progressive-overload/chest', [WorkoutController::class, 'showProgressiveOverloadChest']);

