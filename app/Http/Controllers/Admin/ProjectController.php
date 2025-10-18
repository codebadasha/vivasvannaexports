<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){

        $filter = 0;

        $query = Project::query();

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        }

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        $project = $query->with(['client'])->orderBy('id','desc')->where('is_delete',0)->get();

        return view('admin.project.list',compact('project','filter'));
    }

    public function create(){
        return view('admin.project.add');
    }

    public function store(Request $request){

        $project = new Project;
        $project->client_id = $request->client_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        $route = $request->btn_submit == 'save_and_update' ? 'admin.project.create' : 'admin.project.index';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Project',
                'message' => 'Project successfully added',
            ],
        ]); 
    }

    public function edit($id){

        $detail = Project::where('id',base64_decode($id))->first();

        return view('admin.project.edit',compact('detail'));
    }

    public function update(Request $request){

        $project = Project::findOrFail($request->id);
        $project->client_id = $request->client_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        return redirect(route('admin.project.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Project',
                'message' => 'Project successfully updated',
            ],
        ]);
    }

    public function delete($id){

        $project = Project::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('admin.project.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Project',
                'message' => 'Project successfully deleted',
            ],
        ]); 
    }
}
