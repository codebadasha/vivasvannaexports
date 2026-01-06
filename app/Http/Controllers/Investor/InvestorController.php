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
use App\Models\SalesOrderItem;

class InvestorController extends GlobalController
{
    private $investorclient;

    public function __construct()
    {

        $this->middleware('investor');

        if (Auth::guard('investor')->user()) {
            $invClient = ClientInvestor::where('investor_id', Auth::guard('investor')->user()->id)->pluck('client_id')->toArray();
            $this->investorclient = $invClient;
        }
    }

    /**
     * Index page
     *
     * @return to dashboard page
     **/
    public function index()
    {
        // 1. Filter invoices by logged-in client's zoho_contact_id via SalesOrder
        $investor = Auth::guard('investor')->user()->id;

        $invoices = \App\Models\SalesOrderInvoice::with(['salesOrder'])
            ->whereHas('salesOrder', function ($q) use ($investor) {
                $q->where('investor_id', $investor);
            })
            ->whereNotIn('status', ['draft', 'void', 'viewed'])
            ->orderBy('id', 'desc')
            ->get();

        $projectCount = $invoices
            ->pluck('salesOrder.project_id')
            ->filter()
            ->unique()
            ->count();

        $PoAmount = $invoices
            ->pluck('salesOrder')          // get all related sales orders
            ->unique('id')                 // keep only unique sales orders
            ->pluck('total')               // extract `total`
            ->sum();

        $invoiceAmount = $invoices->pluck('total')->sum();

        $invoicePaidCount = $invoices
            ->where('status', 'paid')
            ->count();

        $invoicePaidAmount = $invoices
            ->where('status', 'paid')
            ->pluck('total')
            ->sum();

        $invoiceOverdueAmount = $invoices
            ->where('status', 'overdue')
            ->pluck('total')
            ->sum();

        $clients = $this->investorclient;

        $projectCount = $invoices
            ->pluck('salesOrder.project_id')
            ->filter()
            ->unique()
            ->count();

        $invoiceOrderIds = $invoices
            ->pluck('salesorder_id')
            ->unique()
            ->toArray();

        $detail = SalesOrderItem::with([
            'salesOrder.project',
            'salesOrder.client',
            'product'
        ])
            ->whereIn('sales_order_id', $invoiceOrderIds)
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'investor.dashboard.dashboard',
            compact(
                'projectCount',
                'PoAmount',
                'invoiceAmount',
                'invoicePaidCount',
                'invoicePaidAmount',
                'invoiceOverdueAmount',
                'clients',
                'detail'
            )
        );
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
