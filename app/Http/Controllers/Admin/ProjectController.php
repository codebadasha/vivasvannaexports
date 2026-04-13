<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Models\SalesOrder;
use App\Models\ClientCompany;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){

        $filter = 0;
        $user = Auth::guard('admin')->user();

        $query = Project::query();
        $clientquery = ClientCompany::select('id','company_name');

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        }

        $client = null;
        if(isset($request->from_client) && $request->from_client !=''){
            $client = ClientCompany::select('id', 'company_name')->where('id', $request->client)->first();   // or whatever your model name is
        }

        if(isset($request->created_start_date) && $request->created_start_date != ''){
            $filter = 1;
            $query->whereBetween(DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->created_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->created_end_date))))]);
        }

        if (!in_array($user->user_role, ['Super Admin', 'admin'])) {
            $clientquery->where('admin_id', $user->id);
        }

        $project = $query->with([
                        'client' => function ($q) use ($user) {$q->select('id','company_name');
                            if(!in_array($user->user_role, ['Super Admin', 'admin'])){
                                    $q->where('admin_id', $user->id);
                            }
                        }
                    ])->orderBy('id','desc')->where('is_delete',0)->get();

        $clients = $clientquery->get();

        return view('admin.project.list',compact('project','filter','clients','client'));
    }

    public function create(){
        $user = Auth::guard('admin')->user();
        $salesOrderQuery = SalesOrder::select('id','salesorder_number','customer_id');
        $clientquery = ClientCompany::select('id','company_name','zoho_contact_id');

        if (!in_array($user->user_role, ['Super Admin', 'admin'])) {
            $salesOrderQuery->where('created_by_id', $user->zoho_user_id);
            $clientquery->where('admin_id', $user->id);
        }
        $so = $salesOrderQuery->whereNull('project_id')->get();
        $clients = $clientquery->get();
        return view('admin.project.add', compact('so','clients'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'     => 'required|exists:client_companies,id',
            'zoho_client_id'=> 'required',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'salesorders'   => 'nullable|array',
            'salesorders.*' => 'exists:sales_orders,id',
        ], [
            'client_id.required' => 'Please select client.',
            'name.required'      => 'Project name is required.',
        ]);

        DB::beginTransaction();

        try {

            $project = Project::create([
                'client_id'      => $validated['client_id'],
                'zoho_client_id' => $validated['zoho_client_id'],
                'name'           => $validated['name'],
                'description'    => $validated['description'] ?? null,
            ]);

            if (!empty($validated['salesorders'])) {

                SalesOrder::whereIn('id', $validated['salesorders'])
                    ->update([
                        'project_id' => $project->id
                    ]);
            }

            DB::commit();

            $route = $request->btn_value === 'save_and_update' ? 'admin.project.create' : 'admin.project.index';

            return redirect(route($route))->with('messages', [['type' => 'success', 'message' => 'Project successfully added.',]]);
        } catch (\Exception $e) {
            
            DB::rollBack();
            return back()->with('messages', [[
                'type' => 'error',
                'message' => 'Something wrong Please try Again',
            ]]);
        }
    }

    public function edit($id){

        $detail = Project::where('id',base64_decode($id))->first();

        $user = Auth::guard('admin')->user();

        $salesOrderQuery = SalesOrder::select('id','salesorder_number','customer_id', 'project_id');
        $clientquery = ClientCompany::select('id','company_name','zoho_contact_id');
    
        if (!in_array($user->user_role, ['Super Admin', 'admin'])) {
            $salesOrderQuery->where('created_by_id', $user->zoho_user_id);
            $clientquery->where('admin_id', $user->id);
        }

        $so = $salesOrderQuery->where(function ($query) use ($detail) {
            $query->whereNull('project_id')->orWhere('customer_id', $detail->zoho_client_id);
            })
            ->get();

        $clients = $clientquery->get();
        return view('admin.project.edit',compact('detail','clients', 'so'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'client_id'   => 'required|exists:client_companies,id',
            'name'        => 'required|string|max:255',
            'zoho_client_id'=> 'required',
            'description' => 'nullable|string',
            'salesorders'   => 'nullable|array',
            'salesorders.*' => 'exists:sales_orders,id',
        ], [
            'client_id.required' => 'Please select client.',
            'name.required'      => 'Project name is required.',
        ]);

        DB::beginTransaction();

        try {

            $project = Project::findOrFail($request->id);

            $project->update([
                'client_id'   => $validated['client_id'],
                'zoho_client_id' => $validated['zoho_client_id'],
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            SalesOrder::where('project_id', $project->id)
                        ->update([
                            'project_id' => null
                        ]);
            if (!empty($validated['salesorders'])) {
                SalesOrder::whereIn('id', $validated['salesorders'])
                    ->update([
                        'project_id' => $project->id
                    ]);
            }

            DB::commit();

            return redirect(route('admin.project.index'))->with('messages', [['type' => 'success', 'message' => 'Project successfully updated.',]]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('messages', [
                    ['type' => 'error', 'message' => 'Something wrong Please try Again']
                ]);
        }
    }

    public function delete($id){

        $project = Project::where('id',base64_decode($id))->update(['is_delete' => 1]);
        SalesOrder::where('project_id', $project->id)
                        ->update([
                            'project_id' => null
                        ]);
        return redirect(route('admin.project.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Project',
                'message' => 'Project successfully deleted',
            ],
        ]); 
    }
}
