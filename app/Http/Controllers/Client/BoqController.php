<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoqItem;
use App\Models\Boq;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProductVariation;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        // 🔹 Step 1: Validate input
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'project_id'  => 'required|exists:projects,id',
            'item'        => 'required|array|min:1',
            'item.*.product_id' => 'required|exists:products,zoho_item_id',
            'item.*.qty'        => 'required|numeric|min:0.01',
            'item.*.unit'       => 'required|string|max:50',
        ], [
            'name.required' => 'Please enter BOQ name.',
            'project_id.required' => 'Please select a project.',
            'item.required' => 'Please add at least one item.',
            'item.*.product_id.required' => 'Product field is required for each item.',
            'item.*.qty.required' => 'Quantity is required for each item.',
            'item.*.unit.required' => 'Unit is required for each item.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 🔹 Step 2: Begin Transaction
        DB::beginTransaction();

        try {
            $boq = Boq::create([
                'name'       => $request->name,
                'client_id'  => Auth::guard('client')->user()->id,
                'project_id' => $request->project_id,
            ]);

            foreach ($request->item as $iv) {
                BoqItem::create([
                    'boq_id'        => $boq->id,
                    'product_id'    => $iv['product_id'],
                    'qty'           => $iv['qty'],
                    'remaining_qty' => $iv['qty'],
                    'unit'          => $iv['unit'],
                ]);
            }

            DB::commit();

            $route = $request->btn_value === 'save_and_update' ? 'client.boq.create' : 'client.boq.index';

            return redirect(route($route))->with('messages', [
                [
                    'type'    => 'success',
                    'title'   => 'BOQ',
                    'message' => 'BOQ successfully created.',
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BOQ Store Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()->withInput()->with('messages', [
                [
                    'type'    => 'error',
                    'title'   => 'Error',
                    'message' => 'Failed to create BOQ. Please try again later.',
                ],
            ]);
        }
    }

    /**
     * Update existing BOQ.
     */
    public function update(Request $request)
    {
        // dd($request->toArray());s
        // 🔹 Step 1: Validate input
        $validator = Validator::make($request->all(), [
            'id'          => 'required|exists:boqs,id',
            'name'        => 'required|string|max:255',
            'project_id'  => 'required|exists:projects,id',
            'item'        => 'required|array|min:1',
            'item.*.product_id' => 'required|exists:products,zoho_item_id',
            'item.*.qty'        => 'required|numeric|min:0.01',
            'item.*.unit'       => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->toArray());
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 🔹 Step 2: Begin Transaction
        DB::beginTransaction();

        try {
            $boq = Boq::findOrFail($request->id);

            $boq->update([
                'name'       => $request->name,
                'client_id'  => Auth::guard('client')->user()->id,
                'project_id' => $request->project_id,
            ]);

            // Recreate BOQ items
            BoqItem::where('boq_id', $boq->id)->delete();

            foreach ($request->item as $iv) {
                BoqItem::create([
                    'boq_id'        => $boq->id,
                    'product_id'    => $iv['product_id'],
                    'qty'           => $iv['qty'],
                    'remaining_qty' => $iv['qty'],
                    'unit'          => $iv['unit'],
                ]);
            }

            DB::commit();

            return redirect(route('client.boq.index'))->with('messages', [
                [
                    'type'    => 'success',
                    'title'   => 'BOQ',
                    'message' => 'BOQ successfully updated.',
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BOQ Update Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()->withInput()->with('messages', [
                [
                    'type'    => 'error',
                    'title'   => 'Error',
                    'message' => 'Failed to update BOQ. Please try again later.',
                ],
            ]);
        }
    }

    public function edit($id){

        $detail = Boq::where('id',base64_decode($id))->with(['item'])->first();

        return view('client.boq.edit',compact('detail'));
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

        $unit = Product::where('zoho_item_id', $request->id)->value('unit');

        return ['unit' => $unit];
    }

    public function viewBoq(Request $request){

        $boq = Boq::where('id',$request->boq_id)->with(['item' => function($q) { $q->with(['product']); }])->first();

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
