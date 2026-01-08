<?php

use App\Http\Controllers\DaylyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DaylyController::class, 'index']);
Route::post('/process', [DaylyController::class, 'process']);
