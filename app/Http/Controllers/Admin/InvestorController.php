<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class InvestorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        try {
            $investors = Investor::where('is_delete', 0)->get();
            return view('admin.investor.list', compact('investors'));
        } catch (Exception $e) {
            Log::error('Investor Index Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Investor',
                    'message' => 'Something went wrong while fetching investors.',
                ],
            ]);
        }
    }

    public function create()
    {
        return view('admin.investor.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'investor_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10|unique:investors,mobile,NULL,id,is_delete,0',
            'email_id'      => 'required|email|unique:investors,email,NULL,id,is_delete,0',
            'password'      => 'required|string|min:8|confirmed',
        ], [
            'investor_name.required' => 'Investor name is required.',

            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.digits'   => 'Mobile number must be exactly 10 digits.',
            'mobile_number.unique'   => 'This mobile number is already registered.',

            'email_id.required' => 'Email address is required.',
            'email_id.email'    => 'Please enter a valid email address.',
            'email_id.unique'   => 'This email address is already registered.',

            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 8 characters long.',
            'password.confirmed'  => 'Confirm password must match password',
        ]);

        try {
            $investor = new Investor();
            $investor->name = $request->investor_name;
            $investor->mobile = $request->mobile_number;
            $investor->email = $request->email_id;
            $investor->password = bcrypt($request->password);
            $investor->save();

            $route = $request->btn_value === 'save_and_update' ? 'admin.investor.create' : 'admin.investor.index';

            return redirect(route($route))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Investor',
                    'message' => 'Investor successfully added',
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Investor Store Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Investor',
                    'message' => 'Something went wrong while adding investor.',
                ],
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $investor = Investor::findOrFail(base64_decode($id));
            return view('admin.investor.edit', compact('investor'));
        } catch (Exception $e) {
            Log::error('Investor Edit Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect(route('admin.investor.index'))->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Investor',
                    'message' => 'Investor not found.',
                ],
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'investor_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10|unique:investors,mobile,' . base64_decode($request->id) . ',id,is_delete,0',
            'email_id'      => 'required|email|unique:investors,email,' . base64_decode($request->id) . ',id,is_delete,0',
            'password'      => 'nullable|string|min:8|confirmed',
        ], [
            'investor_name.required' => 'Investor name is required.',

            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.digits'   => 'Mobile number must be exactly 10 digits.',
            'mobile_number.unique'   => 'This mobile number is already registered.',

            'email_id.required' => 'Email address is required.',
            'email_id.email'    => 'Please enter a valid email address.',
            'email_id.unique'   => 'This email address is already registered.',

            'password.min'       => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Confirm password must match password',
        ]);

        try {
            $investor = Investor::findOrFail(base64_decode($request->id));
            $investor->name = $request->investor_name;
            $investor->mobile = $request->mobile_number;
            $investor->email = $request->email_id;
            if (!empty($request->password)) {
                $investor->password = bcrypt($request->password);
            }
            $investor->save();

            return redirect(route('admin.investor.index'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Investor',
                    'message' => 'Investor successfully updated',
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Investor Update Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Investor',
                    'message' => 'Something went wrong while updating investor.',
                ],
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Investor::where('id', base64_decode($id))->update(['is_delete' => 1]);

            return redirect(route('admin.investor.index'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Investor',
                    'message' => 'Investor successfully deleted',
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Investor Delete Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Investor',
                    'message' => 'Something went wrong while deleting investor.',
                ],
            ]);
        }
    }

    public function checkInvestorEmail(Request $request)
    {
        try {
            $query = Investor::where('email', $request->email_id);
            if (isset($request->id)) {
                $query->where('id', '!=', base64_decode($request->id));
            }
            $email = $query->where('is_delete', 0)->first();

            return $email ? 'false' : 'true';
        } catch (Exception $e) {
            Log::error('Investor Email Check Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return 'false';
        }
    }

    public function checkInvestorMobile(Request $request)
    {
        try {
            $query = Investor::where('mobile', $request->mobile_number);
            if (isset($request->id)) {
                $query->where('id', '!=', base64_decode($request->id));
            }
            $mobile = $query->where('is_delete', 0)->first();

            return $mobile ? 'false' : 'true';
        } catch (Exception $e) {
            Log::error('Investor Mobile Check Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return 'false';
        }
    }
}
