<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PolicyContent;

class PolicyController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    /**
        * Policy list
        *
        * @param  mixed  $policy
        *
        * @return to policy listing page
    */
    public function policyList(){

        $policy = PolicyContent::all();

        return view('admin.policy.policy_list',compact('policy'));
    }

    /**
        * Edit policy 
        *
        * @param $key
        *
        * @return to edit policy page
    */
    public function editPolicy($key){

        $policy = PolicyContent::where('key',$key)->first();

        return view('admin.policy.edit_policy',compact('policy'));
    }

    /**
        * save policy 
        *
        * @param $id, $content
        *
        * @return to policy listing page with data save in database of policy content
    */
    public function savePolicy(Request $request){

        $data = PolicyContent::findOrFail($request->id);
        $data->content = $request->content;
        $data->save();

        return redirect(route('admin.policyList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Policy',
                'message' => 'Content Updated',
            ],
        ]);
    }
}
