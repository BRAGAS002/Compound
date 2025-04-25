<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

Route::get('/', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');
Route::get('/calculation/{id}', [CalculatorController::class, 'show'])->name('calculator.show');
Route::delete('/calculation/{id}', [CalculatorController::class, 'destroy']);
