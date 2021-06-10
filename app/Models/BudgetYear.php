<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetYear extends Model
{
    use HasFactory;

    protected $fillable = [ 
    	'CodeNo',
    	'BudgetYear',
    	'FromDate',
    	'ToDate',
	];
}
