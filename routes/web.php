<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetYearController;
use App\Models\BudgetYear;
use Illuminate\Support\Facades\DB;

//BudgetYears
Route::get('budget-years', [BudgetYearController::class, 'index']);
Route::post('store-budget-year', [BudgetYearController::class, 'store']);
Route::post('edit-budget-year', [BudgetYearController::class, 'edit']);
Route::post('delete-budget-year', [BudgetYearController::class, 'destroy']);

Route::get('/qqq', function () {
	$budgetyear = DB::table('budget_years')
                    ->leftjoin('users','budget_years.user_id','=','users.id')
                    ->select('budget_years.*','users.name')->get();

    dd($budgetyear);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
