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

    }

    public function index(Request $request){

        $filter = 0;

        $query = Project::whereHas('client.investors', function ($q) {
                        $q->where('investor_id', Auth::guard('investor')->id());
                    });

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client);
            });
        }

        $client = null;
        if(isset($request->from_client) && $request->from_client !=''){
            $client = ClientCompany::select('id', 'company_name')->where('id', $request->client)->first();   // or whatever your model name is
        }

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        $project = $query->with([
            'client' => function ($q) {$q->select('id','company_name');}
            ])->orderBy('id','desc')->where('is_delete',0)->get();
        
        $clients = Auth::guard('investor')
                ->user()
                ->clients()
                ->select([
                   'client_companies.id','company_name',
                ])
                ->get();
        return view('investor.project.list',compact('project','filter','clients', 'client'));
    }
}
