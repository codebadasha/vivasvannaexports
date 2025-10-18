<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\GlobalController;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BloodGroup;
use App\Models\Inquiry;
use App\Models\PurchaseOrderItem;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\ClientInvestor;

class InvestorController extends GlobalController
{   
    private $investorclient;

    public function __construct(){
        
        $this->middleware('investor');

        if(Auth::guard('investor')->user()){
            $invClient = ClientInvestor::where('investor_id',Auth::guard('investor')->user()->id)->pluck('client_id')->toArray();
            $this->investorclient = $invClient;
        }
    }

    /**
        * Index page
        *
        * @return to dashboard page
    **/
    public function index(){

        $clients = $this->investorclient;

        $detail = PurchaseOrderItem::whereHas('po',function($q) { $q->whereIn('client_id',$this->investorclient); })->with(['po' => function($q) { $q->with(['project','boq','client']); },'varation' => function($q) { $q->with(['product']); }])->get();

        return view('investor.dashboard.dashboard',compact('detail','clients'));
    }

    /**
        * Edit profile
        *
        * @param mixed $profile
        *
        * @return to edit profile page
    **/
    public function editProfile(){
        
        $profile = Admin::where('id',Auth::guard('admin')->user()->id)->first();

        return view('admin.dashboard.edit_profile',compact('profile')); 
    }

    /**
        * Update admin profile
        *
        * @param $name, $email, $mobile fields save in Admin database
        *
        * @return to index page with data store in Admin database
    **/
    public function updateProfile(Request $request){
        
        $update = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->mobile = $request->mobile_number;
        /*if(isset($request->profile_image)){
            $fileName = $this->uploadImage($request->profile_image,'profile');
            $update->profile_image = $fileName;
        }*/
        $update->save();

        return redirect(route('admin.dashboard'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Profile',
                'message' => 'Profile successfully updated!',
            ],
        ]);
    }

    /**
        * Change admin password
        *
        * @return to change admin password page
    **/
    public function changeAdminPassword(){

        return view('admin.dashboard.change_password');
    }

    /**
        * Update admin password
        *
        * @param $password field save in Admin database
        *
        * @return to index page with data store in Admin database
    **/
    public function updateAdminPassword(Request $request){

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $adminId = Auth::guard('admin')->user()->id;
        $user = Admin::where('id', '=', $adminId)->first();

        if(Hash::check($request->old_password,$user->password)){

            $users = Admin::findOrFail($adminId);
            $users->password = Hash::make($request->new_password);
            $users->save();

            return redirect(route('admin.dashboard'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Password',
                    'message' => 'Password Successfully changed',
                ],
            ]); 

        } else {
          
            return redirect(route('admin.changeAdminPassword'))->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Password',
                    'message' => 'Plese check your current password',
                ],
            ]); 
        }
    }

}
