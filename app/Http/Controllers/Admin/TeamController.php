<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DefaultResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        try {
            $filter = 0;

            $query = Admin::where('is_delete', 0);

            // ✅ Only filter if status is actually passed
            if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
                if($request->status != 'all'){
                    $filter = 1;
                    $status = $request->status == 2 ? 0 : 1;
                    $query->where('is_active', $status);
                }
            }

            if ($request->has('role_id') && $request->role_id != '') {
                $filter = 1;
                $query->where('role_id', $request->role_id);
            }

            $members = $query->with(['role'])->get();

            return view('admin.team.list', compact('members', 'filter'));
        } catch (\Exception $e) {
            Log::error('Error in TeamController@index: ' . $e->getMessage());
            return redirect()->back()->withErrors('Something went wrong while fetching team members.');
        }
    }

    public function create()
    {
        return view('admin.team.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'role_id'   => 'required|integer',
            'mobile'    => 'required|digits:10|unique:admins,mobile,NULL,id,is_delete,0',
            'email'     => 'required|email|unique:admins,email,NULL,id,is_delete,0',
            'password'  => 'required|string|min:8|confirmed',
        ], [
            'full_name.required' => 'Please enter full name',
            'role_id.required'   => 'Please select role',
            'mobile.required'    => 'Please enter mobile number',
            'mobile.digits'      => 'Mobile number must be 10 digits',
            'mobile.unique'      => 'This mobile number already exists',
            'email.required'     => 'Please enter email',
            'email.email'        => 'Please enter a valid email address',
            'email.unique'       => 'This email already exists',
            'password.required'  => 'Please enter password',
            'password.min'       => 'Password must be at least 8 characters',
            'password.confirmed' => 'Confirm password must match password',
        ]);

        try {
            $member = new Admin;
            $member->name = $request->full_name;
            $member->role_id = $request->role_id;
            $member->mobile = $request->mobile;
            $member->email = $request->email;
            $member->password = bcrypt($request->password);
            $member->save();

            $route = $request->btn_submit == 'save_and_update' ? 'admin.team.create' : 'admin.team.index';

            return redirect(route($route))->with('messages', [[
                'type' => 'success',
                'title' => 'Team',
                'message' => 'Team member successfully added',
            ]]);
        } catch (\Exception $e) {
            Log::error('Error in TeamController@store: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to add team member. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $member = Admin::where('id', base64_decode($id))->firstOrFail();
            return view('admin.team.edit', compact('member'));
        } catch (\Exception $e) {
            Log::error('Error in TeamController@edit: ' . $e->getMessage());
            return redirect()->back()->withErrors('Team member not found.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'role_id'   => 'required|integer',
            'mobile'    => 'required|digits:10|unique:admins,mobile,' . base64_decode($request->id) . ',id,is_delete,0',
            'email'     => 'required|email|unique:admins,email,' . base64_decode($request->id) . ',id,is_delete,0',
            'password'  => 'nullable|string|min:8|confirmed',
        ], [
            'full_name.required' => 'Please enter full name',
            'role_id.required'   => 'Please select role',
            'mobile.required'    => 'Please enter mobile number',
            'mobile.digits'      => 'Mobile number must be 10 digits',
            'mobile.unique'      => 'This mobile number already exists',
            'email.required'     => 'Please enter email',
            'email.email'        => 'Please enter a valid email address',
            'email.unique'       => 'This email already exists',
            'password.min'       => 'Password must be at least 8 characters',
            'password.confirmed' => 'Confirm password must match password',
        ]);

        try {
            $member = Admin::findOrFail(base64_decode($request->id));
            $member->name = $request->full_name;
            $member->role_id = $request->role_id;
            $member->mobile = $request->mobile;
            $member->email = $request->email;
            if ($request->password) {
                $member->password = bcrypt($request->password);
            }
            $member->save();

            return redirect(route('admin.team.index'))->with('messages', [[
                'type' => 'success',
                'title' => 'Team',
                'message' => 'Team member successfully updated',
            ]]);
        } catch (\Exception $e) {
            Log::error('Error in TeamController@update: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update team member. Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $admin = Admin::find($id);

            if ($admin->is_default == 1) {
                return response()->json(DefaultResponse::error('Default team member cannot be Delete'));
            }
            $admin->is_delete = 1;
            $updated = $admin->save();

            if ($updated) {
                return redirect(route('admin.team.index'))->with('messages', [[
                    'type' => 'success',
                    'title' => 'Team',
                    'message' => 'Team member successfully deleted',
                ]]);
            }

            return redirect()->back()->withErrors('Failed to delete team member.');
        } catch (\Exception $e) {
            Log::error('Error in TeamController@delete: ' . $e->getMessage());
            return redirect()->back()->withErrors('Something went wrong while deleting team member.');
        }
    }

    public function changeTeamMemberStatus(Request $request)
    {
        try {
            $admin = Admin::find($request->id);

            if (!$admin) {
                return response()->json(DefaultResponse::error('Team member not found'));
            }

            if ($admin->is_default == 1) {
                return response()->json(DefaultResponse::error('Default team member status cannot be changed'));
            }

            $admin->is_active = (int) $request->option;
            $updated = $admin->save();

            if ($updated) {
                return response()->json(DefaultResponse::success(null, 'Team member status updated successfully'));
            }

            return response()->json(DefaultResponse::error('Failed to update team member status'));
        } catch (\Exception $e) {
            Log::error('Error in TeamController@changeTeamMemberStatus: ' . $e->getMessage());
            return response()->json(DefaultResponse::error('Something went wrong'));
        }
    }

    public function setDefaultTeamMember(Request $request)
    {
        try {
            Admin::query()->update(['is_default' => 0]);
            $status = Admin::where('id', $request->id)->update(['is_default' => 1]);

            if ($status) {
                return response()->json(DefaultResponse::success(null, 'Default team member updated successfully'));
            }
            return response()->json(DefaultResponse::error('Failed to update default team member'));
        } catch (\Exception $e) {
            Log::error('Error in TeamController@setDefaultTeamMember: ' . $e->getMessage());
            return response()->json(DefaultResponse::error('Something went wrong'));
        }
    }

    public function checkMemberEmail(Request $request)
    {
        $query = Admin::where('is_delete', 0)->where('email', $request->email);
        if (isset($request->id)) {
            $query->where('id', '!=', base64_decode($request->id));
        }
        $email = $query->first();

        return $email ? 'false' : 'true';
    }

    public function checkMemberMobile(Request $request)
    {
        $query = Admin::where('is_delete', 0)->where('mobile', $request->mobile);
        if (isset($request->id)) {
            $query->where('id', '!=', base64_decode($request->id));
        }
        $email = $query->first();

        return $email ? 'false' : 'true';
    }
}
