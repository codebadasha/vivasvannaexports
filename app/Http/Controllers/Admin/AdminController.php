<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GlobalController;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BloodGroup;
use App\Models\Inquiry;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrderItem;
use App\Models\Project;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;
use App\Models\Team;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AdminController extends GlobalController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Index page
     *
     * @return to dashboard page
     **/
    public function index()
    {

        $user = Auth::guard('admin')->user();
        $itemsQuery = SalesOrderItem::with([
                    'salesOrder' => function ($q) {
                        $q->select(
                            'id',
                            'zoho_salesorder_id',
                            'salesorder_number',
                            'project_id',
                            'customer_id',
                            'company_name'
                        )->with([
                            'project' => function ($q) {
                                $q->select('id', 'name');
                            },
                            'invoices' => function ($q) {
                                $q->select('id', 'sales_order_id')
                                ->with([
                                    'items' => function ($q) {
                                        $q->select(
                                            'id',
                                            'invoice_id',
                                            'item_id',
                                            'quantity'
                                        );
                                    }
                                ]);
                            },
                        ]);
                    }
                ]);
            if (!in_array($user->user_role, ['Super Admin', 'admin'])) {
                $itemsQuery->whereHas('salesOrder', fn($q) => $q->where('created_by_id', $user->zoho_user_id));
            }

        $items = $itemsQuery->orderByDesc('id')->get();

        $data = [
            'total_projects' => Project::where('is_active', 1)->where('is_delete', 0)->count(),

            'total_so_count' => SalesOrder::count(),

            'total_so_amount' => SalesOrder::sum('total'),

            'total_invoice_count' => SalesOrderInvoice::whereNotIn('status', ['draft','void','viewed'])->count(),

            'total_invoice_amount' => SalesOrderInvoice::whereNotIn('status', ['draft','void','viewed'])->sum('total'),

            'paid_invoice_count' => SalesOrderInvoice::where('status','paid')->count(),

            'paid_invoice_amount' => SalesOrderInvoice::where('status','paid')->sum('total'),

            'overdue_invoice_count' => SalesOrderInvoice::where('status','overdue')->count(),

            'overdue_invoice_amount' => SalesOrderInvoice::where('status','overdue')->sum('balance'),
        ];

        return view('admin.dashboard.dashboard', compact('data', 'items'));
    }

    /**
     * Edit profile
     *
     * @param mixed $profile
     *
     * @return to edit profile page
     **/
    public function editProfile()
    {

        $profile = Admin::where('id', Auth::guard('admin')->user()->id)->first();

        return view('admin.dashboard.edit_profile', compact('profile'));
    }

    /**
     * Update admin profile
     *
     * @param $name, $email, $mobile fields save in Admin database
     *
     * @return to index page with data store in Admin database
     **/
    public function updateProfile(Request $request)
    {

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
    public function changeAdminPassword()
    {

        return view('admin.dashboard.change_password');
    }

    /**
     * Update admin password
     *
     * @param $password field save in Admin database
     *
     * @return to index page with data store in Admin database
     **/
    public function updateAdminPassword(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $adminId = Auth::guard('admin')->user()->id;
        $user = Admin::where('id', '=', $adminId)->first();

        if (Hash::check($request->old_password, $user->password)) {

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
