<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoqItem;
use App\Models\Boq;
use App\Models\Project;
use App\Models\ProductVariation;
use App\Models\ClientInvestor;
use Auth;

class BoqController extends Controller
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

        $filter  = 0;

        $query = Boq::query();

        if(isset($request->boq_start_date) && $request->boq_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->boq_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->boq_end_date))))]);
        }

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        } else {
            $query->whereIn('client_id',$this->investorclient);
        }

        if(isset($request->project) && $request->project != ''){
            $filter = 1;
            $query->whereHas('project',function($q) use ($request){
                $q->where('name','LIKE','%'.$request->project.'%');
            });
        }


        $getBoq = $query->where('is_delete',0)->orderBy('id','desc')->with(['project','client'])->get();

        return view('investor.boq.list',compact('getBoq','filter'));
    }

    public function getNewItem(Request $request){

        $html = view('investor.boq.item',compact('request'))->render();

        return \Response::json(['status' => 'success','html' => $html]);
    }

    public function getProductVariation(Request $request){

        $getProductVariation = ProductVariation::where('product_id',$request->product_id)->get();

        return $getProductVariation;
    }

    public function getUnit(Request $request){

        $getUnit = ProductVariation::where('id',$request->id)->first();

        return $getUnit;
    }

    public function viewBoq(Request $request){

        $boq = Boq::where('id',$request->boq_id)->with(['item' => function($q) { $q->with(['category','grade']); }])->first();

        $html = view('investor.boq.boq_detail',compact('boq'))->render();

        return \Response::json(['status' => 'success','html' => $html]);
    }

    public function boqName(Request $request){

        $query = Boq::where('name',$request->name)->where('project_id',$request->project_id)->where('client_id',$request->client_id)->where('is_delete',0);
        if(isset($request->id) && $request->id != ''){
            $query->where('id','!=',$request->id);
        }
        $boq = $query->first();

        return \Response::json(['status' => !is_null($boq) ? false : true,'message' => !is_null($boq) ? 'Same BOQ is existed for this client and project combination' : 'success']);
    }

    public function getClientProject(Request $request){

        $projects = Project::where('client_id',$request->client_id)->get();

        return $projects;
    }
}
