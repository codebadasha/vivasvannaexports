<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ClientInvestor;
use Auth;

class ProjectController extends Controller
{   
    private $investorclient;

    public function __construct(){
        
        $this->middleware('investor');

        if(Auth::guard('investor')->user()){
            $invClient = ClientInvestor::where('investor_id',Auth::guard('investor')->user()->id)->pluck('client_id')->toArray();
            $this->investorclient = $invClient;
        }
    }

    public function index(Request $request){

        $filter = 0;

        $query = Project::query();
        // $investor = Auth::guard('investor')->user()->id;

        // $invoices = \App\Models\SalesOrderInvoice::with(['salesOrder'])
        //     ->whereHas('salesOrder', function ($q) use ($investor) {
        //         $q->where('investor_id', $investor);
        //     })
        //     ->whereNotIn('status', ['draft', 'void', 'viewed'])
        //     ->orderBy('id', 'desc')
        //     ->get();

        // $project = $invoices
        //     ->pluck('salesOrder.project')
        //     ->filter()
        //     ->unique()
            // ->values();

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        } 

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        $project = $query->with(['client'])->orderBy('id','desc')->where('is_delete',0)->get();

        return view('investor.project.list',compact('project','filter'));
    }
}
