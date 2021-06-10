<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetYearController;

Route::get('budget-years', [BudgetYearController::class, 'index']);
Route::post('store-budget-year', [BudgetYearController::class, 'store']);
Route::post('edit-budget-year', [BudgetYearController::class, 'edit']);
Route::post('delete-budget-year', [BudgetYearController::class, 'destroy']);

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
