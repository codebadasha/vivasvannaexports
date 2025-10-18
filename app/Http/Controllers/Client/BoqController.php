<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoqItem;
use App\Models\Boq;
use App\Models\Project;
use App\Models\ProductVariation;
use Auth;

class BoqController extends Controller
{
    public function __construct(){
        $this->middleware('client');
    }

    public function index(Request $request){

        $filter  = 0;

        $query = Boq::where('client_id',Auth::guard('client')->user()->id);

        if(isset($request->boq_start_date) && $request->boq_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->boq_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->boq_end_date))))]);
        }

        if(isset($request->project) && $request->project != ''){
            $filter = 1;
            $query->whereHas('project',function($q) use ($request){
                $q->where('name','LIKE','%'.$request->project.'%');
            });
        }


        $getBoq = $query->where('is_delete',0)->orderBy('id','desc')->with(['project','client'])->get();

        return view('client.boq.list',compact('getBoq','filter'));
    }

    public function create(){
        return view('client.boq.add');
    }

    public function store(Request $request){

        $boq = new Boq;
        $boq->name = $request->name;
        $boq->client_id = Auth::guard('client')->user()->id;
        $boq->project_id = $request->project_id;
        $boq->save();

        if(!is_null($request->item)){
            foreach($request->item as $ik => $iv){
                $item = new BoqItem;
                $item->boq_id = $boq->id;
                $item->category_id = $iv['category_id'];
                $item->variation_id = $iv['variation'];
                $item->qty = $iv['qty'];
                $item->remaining_qty = $iv['qty'];
                $item->unit = $iv['unit'];
                $item->save();
            }
        }

        $route = $request->btn_value == 'save_and_update' ? 'client.boq.create' : 'client.boq.index';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Project',
                'message' => 'Project successfully added',
            ],
        ]); 
    }

    public function edit($id){

        $detail = Boq::where('id',base64_decode($id))->with(['item'])->first();

        return view('client.boq.edit',compact('detail'));
    }

    public function update(Request $request){

        $boq = Boq::findOrFail($request->id);
        $boq->name = $request->name;
        $boq->client_id = Auth::guard('client')->user()->id;
        $boq->project_id = $request->project_id;
        $boq->save();

        if(!is_null($request->item)){
            BoqItem::where('boq_id',$request->id)->delete();
            foreach($request->item as $ik => $iv){
                $item = new BoqItem;
                $item->boq_id = $boq->id;
                $item->category_id = $iv['category_id'];
                $item->variation_id = $iv['variation'];
                $item->qty = $iv['qty'];
                $item->remaining_qty = $iv['qty'];
                $item->unit = $iv['unit'];
                $item->save();
            }
        }

        return redirect(route('client.boq.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'BOQ',
                'message' => 'BOQ successfully updated',
            ],
        ]);
    }

    public function delete($id){

        $project = Boq::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('client.project.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'BOQ',
                'message' => 'BOQ successfully deleted',
            ],
        ]); 
    }

    public function getNewItem(Request $request){

        $html = view('client.boq.item',compact('request'))->render();

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

        $html = view('client.boq.boq_detail',compact('boq'))->render();

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
