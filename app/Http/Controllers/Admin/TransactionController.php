<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Transaction;
use App\Models\PurchaseOrderInvoice;

class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){

        $filter = 0;

        $query = Transaction::where('is_delete',0);

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        }

        if(isset($request->project) && $request->project != ''){
            $filter = 1;
            $query->whereHas('project',function($q) use ($request){
                $q->where('name','LIKE','%'.$request->name.'%');
            });
        }

        if(isset($request->po_number) && $request->po_number != ''){
            $filter = 1;
            $query->whereHas('po',function($q) use ($request){
                $q->where('po_number','LIKE','%'.$request->po_number.'%');
            });
        }

        if(isset($request->entry_type) && $request->entry_type != ''){
            $filter = 1;
            $query->where('type',$request->entry_type);
        }

        if(isset($request->payment_start_date) && $request->payment_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(payment_date)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->payment_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->payment_end_date))))]);
        }

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        if(isset($request->fin_year) && $request->fin_year != ''){
            $filter = 1;
            $explode = explode('-',$request->fin_year);
            $start = $explode[0]."-04-01 00:00:00";
            $end = $explode[1]."-03-31 23:59:59";
            $query->whereBetween('created_at',[$start,$end]);
        }

        // $getTotalInvoiceAmount = $query->sum('amount');

        $trasnaction = $query->with(['client','project'])->where('is_delete',0)->orderby('id','desc')->get();

        //get total po sum
        $totalPoAmount = PurchaseOrder::where('is_delete',0)->sum('subtotal');


        //purchase invoice
        $query = PurchaseOrderInvoice::query();

        // if(isset($request->entry_type) && $request->entry_type != ''){
        //     $filter = 1;
        //     $entry = $request->entry_type == 'PAID' ? 1 : 0;
        //     $query->where('mark_as_paid',$entry);
        // }

        $totalInvoice = $query->where('is_delete',0)->sum('invoice_amount');

        $totalPaidAmount = PurchaseOrderInvoice::where('is_delete',0)->where('mark_as_paid',1)->sum('invoice_amount');

        return view('admin.transaction.list',compact('trasnaction','filter','totalPoAmount','totalInvoice','totalPaidAmount'));
    }
}
