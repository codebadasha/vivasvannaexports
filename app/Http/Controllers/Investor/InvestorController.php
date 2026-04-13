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
use App\Models\Project;
use App\Models\SalesOrderInvoice;
use App\Models\SalesOrder;
use App\Models\Investor;
use App\Models\SalesOrderItem;

class InvestorController extends GlobalController
{
    private $investorclient;

    public function __construct()
    {
        $this->middleware('investor');
    }

    /**
     * Index page
     *
     * @return to dashboard page
     **/
    public function index()
    {

        $investorId = Auth::guard('investor')->id();

        $items = SalesOrderItem::query()
            ->with([
                'salesOrder' => function ($q) {
                    $q->select(
                        'id',
                        'zoho_salesorder_id',
                        'salesorder_number',
                        'project_id',
                        'customer_id',
                        'company_name'
                    )->with([
                        'project' => fn($q) => $q->select('id', 'name'),
                        'invoices' => fn($q) => $q->select('id', 'sales_order_id')
                            ->with([
                                'items' => fn($q) => $q->select(
                                    'id',
                                    'invoice_id',
                                    'item_id',
                                    'quantity'
                                )
                            ])
                    ]);
                }
            ])
            ->whereHas('salesOrder.investors', function ($q) use ($investorId) {
                $q->where('investor_id', $investorId);
            })
            ->orderByDesc('id')
            ->get();
   
        $data = [
            'total_projects' => Project::where('is_active', 1)
                ->where('is_delete', 0)
                ->count(),

            'total_po_count' => SalesOrder::count(),

            'total_po_amount' => SalesOrder::sum('total'),

            'total_invoice_count' => SalesOrderInvoice::whereNotIn('status', ['draft','void','viewed'])->count(),

            'total_invoice_amount' => SalesOrderInvoice::whereNotIn('status', ['draft','void','viewed'])->sum('total'),
            
            'total_assigned_invoice_count' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->count(),

            'total_assigned_invoice_amount' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->sum('total'),

            'paid_invoice_count' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->where('status','paid')->count(),

            'paid_invoice_amount' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->where('status','paid')->sum('total'),

            'overdue_invoice_count' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->where('status','overdue')->count(),

            'overdue_invoice_amount' => SalesOrderInvoice::where('investor_id', $investorId)->whereNotIn('status', ['draft','void','viewed'])->where('status','overdue')->sum('total'),
        ];

        return view(
            'investor.dashboard.dashboard',
            compact('data','items')
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
        $profile = Investor::where('id', Auth::guard('investor')->user()->id)->first();

        return view('investor.dashboard.edit_profile', compact('profile'));
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

        $update = Investor::findOrFail(Auth::guard('investor')->user()->id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->mobile = $request->mobile_number;
        /*if(isset($request->profile_image)){
            $fileName = $this->uploadImage($request->profile_image,'profile');
            $update->profile_image = $fileName;
        }*/
        $update->save();

        return redirect(route('investor.dashboard'))->with('messages', [
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
    public function changeinvestorPassword()
    {
        return view('investor.dashboard.change_password');
    }

    /**
     * Update admin password
     *
     * @param $password field save in Admin database
     *
     * @return to index page with data store in Admin database
     **/
    public function updateinvestorPassword(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $user = Investor::where('id', '=', Auth::guard('investor')->user()->id)->first();

        if (Hash::check($request->old_password, $user->password)) {

            if ($request->new_password === $request->confirm_password) {

                $user->password = Hash::make($request->new_password);
                $user->save();

                return redirect(route('investor.dashboard'))->with('messages', [
                    [
                        'type' => 'success',
                        'title' => 'Password',
                        'message' => 'Password Successfully changed',
                    ],
                ]);
            } else {
                return redirect()->back()->with('messages', [
                    [
                        'type' => 'error',
                        'title' => 'Password Mismatch',
                        'message' => 'The new password and confirm password do not match. Please try again.',
                    ],
                ]);
            }
        } else {

            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Password',
                    'message' => 'Plese check your current password',
                ],
            ]);
        }
    }
}
