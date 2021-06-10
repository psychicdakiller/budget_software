<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BudgetYear;
use Datatables;
use Illuminate\Support\Facades\DB;

class BudgetYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $budgetyear = BudgetYear::select('*');
        $budgetyear = DB::table('budget_years')
                    ->leftjoin('users','budget_years.user_id','=','users.id')
                    ->select('budget_years.*','users.name');

        if(request()->ajax()) {
            return datatables()->of($budgetyear)
            ->addColumn('action', 'budgetyears.budget-year-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->editColumn('updated_at', function ($budgetyear) {
                return date('j F, Y H:i:s', strtotime($budgetyear->updated_at));
            })
            ->filterColumn('CodeNo', function($query, $keyword) {
                $query->whereRaw("CodeNo like ?", ["%{$keyword}%"]);
            })
            ->make(true);
        }
        return view('budgetyears.budgetyears');
    }

    public function store(Request $request)
    {  
 
        $budgetyearID = $request->id;
 
        $budgetyear   =   BudgetYear::updateOrCreate(
                    [
                     'id' => $budgetyearID
                    ],
                    [
                    'CodeNo' => $request->CodeNo, 
                    'BudgetYear' => $request->BudgetYear,
                    'FromDate' => $request->FromDate,
                    'ToDate' => $request->ToDate
                    ]);    
                         
        return Response()->json($budgetyear);
 
    }
      
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $budgetyear  = BudgetYear::where($where)->first();
      
        return Response()->json($budgetyear);
    }
      
    public function destroy(Request $request)
    {
        $budgetyear = BudgetYear::where('id',$request->id)->delete();
      
        return Response()->json($budgetyear);
    }
}
