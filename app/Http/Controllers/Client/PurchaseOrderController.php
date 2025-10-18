<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderInvoice;
use App\Models\ProductVariation;
use App\Models\PurchaseOrderItem;
use App\Models\SupplierCompany;
use App\Models\ItemQty;
use App\Models\Project;
use App\Models\Boq;
use App\Models\BoqItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use ZipArchive;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class PurchaseOrderController extends GlobalController
{
    public function __construct(){
        $this->middleware('client');
    }

    public function index(Request $request){

        $filter = 0;

        $query = PurchaseOrder::where('client_id',Auth::guard('client')->user()->id);

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        if(isset($request->boq_id) && $request->boq_id != ''){
            $query->whereHas('item',function($q) use ($request){
                $q->where('boq_item_id',base64_decode($request->boq_id));
            });
        }

        $po = $query->where('is_delete',0)->with(['client','project'])->orderBy('id','desc')->get();

        return view('client.po.list',compact('po','filter'));
    }

    public function create(){

        return view('client.po.add');
    }

    public function store(Request $request){

        $po = new PurchaseOrder;
        $po->client_id = Auth::guard('client')->user()->id;
        $po->project_id = $request->project_id; 
        $po->boq_id = $request->boq_id;
        $po->po_number = $request->po_number;
        $po->subtotal = $request->subtotal;
        $po->po_copy = $this->uploadImage($request->po_copy,'po');
        $po->save();

        if(!isset($request->boq) && !is_null($request->item)){
            foreach($request->item as $ik => $iv){
                $item = new PurchaseOrderItem;
                $item->po_id = $po->id;
                $item->category_id = $iv['product_id'];
                $item->remaining_boq_qty = $iv['remaining_boq_qty'];
                $item->unit = $iv['unit'];
                $item->qty = $iv['po_qty'];
                $item->rate = $iv['rate_per_unit']; 
                $item->subtotal = $iv['subtotal'];
                $item->freight = $iv['freight'];
                $item->fright_selection = $iv['fright_selection'];
                $item->save();
            }
        } else {
            foreach($request->boq as $ik => $iv){
                $item = new PurchaseOrderItem;
                $item->boq_item_id = $iv['boq_item_id'];
                $item->po_id = $po->id;
                $item->category_id = $iv['product_id'];
                $item->remaining_boq_qty = $iv['remaining_boq_qty'];
                $item->unit = $iv['unit'];
                $item->qty = $iv['po_qty'];
                $item->rate = $iv['rate_per_unit']; 
                $item->subtotal = $iv['subtotal'];
                $item->freight = $iv['freight'];
                $item->fright_selection = $iv['fright_selection'];
                $item->save();
            }

            if($request->boq_id != ''){
                $decremtnQty = BoqItem::where('id',$iv['boq_item_id'])->decrement('remaining_qty',$iv['po_qty']);
            }
        }

        $route = $request->btn_value == 'save_and_update' ? 'client.po.create' : 'client.po.index';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order',
                'message' => 'Purchase order successfully created',
            ],
        ]);
    }

    public function edit($id){

        $detail = PurchaseOrder::where('id',base64_decode($id))->with(['item' => function($q) { $q->with(['varation' => function($q) { $q->with(['product']); }]); }])->first();

        return view('client.po.edit',compact('detail'));
    }

    public function update(Request $request){

        $this->editOrder($request->id);

        $po = PurchaseOrder::findOrFail($request->id);
        $po->client_id = Auth::guard('client')->user()->id;
        $po->project_id = $request->project_id; 
        $po->boq_id = $request->boq_id;
        $po->po_number = $request->po_number;
        $po->subtotal = $request->subtotal;
        if(isset($request->po_copy)){
            $po->po_copy = $this->uploadImage($request->po_copy,'po');
        }
        $po->save();

        if(!is_null($request->item)){
            PurchaseOrderItem::where('po_id',$request->id)->delete();
            foreach($request->item as $ik => $iv){
                $item = new PurchaseOrderItem;
                $item->boq_item_id = $iv['boq_item_id'] ? $iv['boq_item_id'] : null;
                $item->po_id = $po->id;
                $item->category_id = $iv['product_id'];
                $item->remaining_boq_qty = $iv['remaining_boq_qty'];
                $item->unit = $iv['unit'];
                $item->qty = $iv['po_qty'];
                $item->rate = $iv['rate_per_unit']; 
                $item->subtotal = $iv['subtotal'];
                $item->freight = $iv['freight'];
                $item->fright_selection = $iv['fright_selection'];
                $item->save();

                if($request->boq_id != ''){
                    $decremtnQty = BoqItem::where('id',$iv['boq_item_id'])->decrement('remaining_qty',$iv['po_qty']);
                }
            }
        }

        return redirect(route('client.po.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order',
                'message' => 'Purchase order successfully updated',
            ],
        ]);
    }

    public function delete($id){

        $delete = PurchaseOrder::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('client.po.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order',
                'message' => 'Purchase order successfully deleted',
            ],
        ]);
    }

    public function editOrder($poOrderId){

        $detail = PurchaseOrder::where('id',$poOrderId)->with(['item'])->first();

        if(!is_null($detail->item)){
            foreach($detail->item as $ik => $iv){
                $boqItem = BoqItem::where('id',$iv->boq_item_id)->increment('remaining_qty',$iv->qty);
            }
        }
    }

    public function viewPurchaseOrder($id){

        $detail = PurchaseOrder::where('id',base64_decode($id))->with(['item' => function($q) { $q->with(['varation' => function($q) { $q->with(['product']); }]); }])->first();

        return view('client.po.view_detail',compact('detail'));
    }

    public function invoiceList($id,Request $request){

        $filter = 0;

        $query = PurchaseOrderInvoice::where('po_id',base64_decode($id))->where('is_delete',0);

        if(isset($request->upload_start_date) && $request->upload_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->upload_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->upload_end_date))))]);
        }

        if(isset($request->due_start_date) && $request->due_start_date != ''){
            $filter = 1;
            $query->whereBetween('due_date',[date('Y-m-d',strtotime(str_replace('/','-',trim($request->due_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->due_end_date))))]);
        }

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status == 1 ? 1 : 0;
            $query->where('mark_as_paid',$status);
        }

        if(isset($request->invoice_number) && $request->invoice_number != ''){
            $filter = 1;
            $query->where('invoice_number','LIKE','%'.$request->invoice_number.'%');
        }

        if(isset($request->investor) && $request->investor != ''){
            $filter = 1;
            $query->where('investor_id',$request->investor);
        }

        $invoice = $query->with(['investor'])->get();

        $po = PurchaseOrder::where('id',base64_decode($id))->first();

        $poDetail = PurchaseOrder::where('id',base64_decode($id))->with(['client'])->first();

        return view('client.invoice.list',compact('id','invoice','po','filter','poDetail'));
    }

    public function addInvoice($id){

        $po = PurchaseOrder::where('id',base64_decode($id))->first();

        return view('client.invoice.add',compact('id','po'));
    }

    public function saveInvoice(Request $request){

        $uuid = (string) Str::uuid();

        $invoice = new PurchaseOrderInvoice;
        $invoice->uuid = $uuid;
        $invoice->po_id = $request->po_id;
        $invoice->invoice_number = $request->invoicenumber;
        $invoice->invoice_amount = $request->invoice_amount;
        if(isset($request->invoice_copy)){
            $fileName = $this->uploadImage($request->invoice_copy,'invoice/'.$uuid);
            $invoice->invoice_copy = $fileName;
        }
        $invoice->mark_as_paid = isset($request->mark_as_paid) ? 1 : 0;
        $invoice->due_days = $request->due_days;
        $invoice->due_date = date('Y-m-d',strtotime('+'.$request->due_days.' days'));
        $invoice->investor_id = $request->investor_id;
        if(isset($request->grm)){
            $fileName = $this->uploadImage($request->grm,'invoice/'.$uuid);
            $invoice->grm = $fileName;
        }
        if(isset($request->lr_copy)){
            $fileName = $this->uploadImage($request->lr_copy,'invoice/'.$uuid);
            $invoice->lr_copy = $fileName;
        }
        if(isset($request->eway_bill)){
            $fileName = $this->uploadImage($request->eway_bill,'invoice/'.$uuid);
            $invoice->eway_bill = $fileName;
        }
        $invoice->save();

        if(isset($request->mark_as_paid)){
            $updateReceivedAmount = PurchaseOrder::where('id',$request->po_id)->increment('received_amount',$request->invoice_amount);
        }

        $this->addTransactionLog($request,$invoice);

        return redirect(route('client.po.invoiceList',base64_encode($request->po_id)))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order',
                'message' => 'Purchase order successfully created',
            ],
        ]);
    }

    public function editInvoice($id){

        $detail = PurchaseOrderInvoice::where('id',base64_decode($id))->with(['po'])->first();

        return view('client.invoice.edit',compact('detail'));
    }

    public function saveEditedInvoice(Request $request){

        $updateAmount = PurchaseOrderInvoice::where('id',$request->id)->first();

        if(!is_null($updateAmount) && $updateAmount->mark_as_paid == 1){
            PurchaseOrder::where('id',$updateAmount->po_id)->decrement('received_amount',$updateAmount->invoice_amount);
        }

        $invoice = PurchaseOrderInvoice::findOrFail($request->id);
        $invoice->po_id = $request->po_id;
        $invoice->invoice_number = $request->invoicenumber;
        $invoice->invoice_amount = $request->invoice_amount;
        if(isset($request->invoice_copy)){
            $fileName = $this->uploadImage($request->invoice_copy,'invoice/'.$request->uuid);
            $invoice->invoice_copy = $fileName;
        }
        $invoice->mark_as_paid = isset($request->mark_as_paid) ? 1 : 0;
        $invoice->due_days = $request->due_days;
        $invoice->due_date = date('Y-m-d',strtotime('+'.$request->due_days.' days'));
        $invoice->investor_id = $request->investor_id;
        if(isset($request->grm)){
            $fileName = $this->uploadImage($request->grm,'invoice/'.$request->uuid);
            $invoice->grm = $fileName;
        }
        if(isset($request->lr_copy)){
            $fileName = $this->uploadImage($request->lr_copy,'invoice/'.$request->uuid);
            $invoice->lr_copy = $fileName;
        }
        if(isset($request->eway_bill)){
            $fileName = $this->uploadImage($request->eway_bill,'invoice/'.$request->uuid);
            $invoice->eway_bill = $fileName;
        }
        $invoice->save();

        if(isset($request->mark_as_paid)){
            $updateReceivedAmount = PurchaseOrder::where('id',$request->po_id)->increment('received_amount',$request->invoice_amount);
        }

        $this->addTransactionLog($request,$invoice);

        return redirect($request->url)->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order',
                'message' => 'Purchase order successfully created',
            ],
        ]);
    }

    public function deleteInvoice($id){

        $updateAmount = PurchaseOrderInvoice::where('id',base64_decode($id))->first();

        if(!is_null($updateAmount)){
            PurchaseOrder::where('id',$updateAmount->po_id)->decrement('received_amount',$updateAmount->invoice_amount);
            Transaction::where('invoice_id',base64_decode($id))->delete();
        }

        $delete = PurchaseOrderInvoice::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect()->back()->with('messages', [
            [
                'type' => 'success',
                'title' => 'Purchase Order Invoice',
                'message' => 'Purchase order invoice successfully deleted',
            ],
        ]);
    }

    public function getProductList(Request $request){

        $variation = ProductVariation::whereHas('product',function($q) use ($request){
                                         $q->where('product_type','LIKE','%'.$request->title.'%');
                                     })
                                     ->with(['product'])->get();

        $productJson = array();

        if(!is_null($variation)){
            foreach($variation as $vk => $vv){
                $productJson[$vk]['label'] = $vv->product->product_type." - ".$vv->grade;
                $productJson[$vk]['value'] = $vv->id;
                $productJson[$vk]['unit'] = $vv->unit;
                $productJson[$vk]['gst'] = $vv->product->gst;
            }
        }

        return $productJson;
    }

    public function poItems($poId){

        $getItems = PurchaseOrderItem::where('po_id',base64_decode($poId))->with(['item' => function($q) { $q->with(['supplier']);} ,'varation' => function($q) { $q->with(['product']); }])->get();

        return view('client.po.supplier_item',compact('getItems','poId'));
    }

    public function supplierList(Request $request){

        $supplier = SupplierCompany::where('company_name','LIKE','%'.$request->title.'%')->select('id as value','company_name as label')->where('is_delete',0)->get();

        return $supplier;
    }

    public function postSupplierItem(Request $request){

        if(!is_null($request->data)){
            foreach($request->data as $dk => $dv){
                ItemQty::where('po_item_id',$dk)->delete();
                foreach($dv as $ik => $iv){
                    $item = new ItemQty;
                    $item->po_item_id = $dk;
                    $item->supplier_id = $iv['supplier_id'];
                    $item->qty = $iv['qty'];
                    $item->save();
                }
            }
        }

        return redirect(route('client.po.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Item',
                'message' => 'Item Successfully assigned',
            ],
        ]);
    }

    public function getProject(Request $request){

        $data['projects'] = Project::where('client_id',Auth::guard('client')->user()->id)->get();
        $data['boq'] = Boq::where('client_id',Auth::guard('client')->user()->id)->get();

        return $data;
    }

    public function getBoq(Request $request){

        $boq = Boq::where('client_id',Auth::guard('client')->user()->id)->where('project_id',$request->project_id)->get();

        return $boq;
    }

    public function getBoqItem(Request $request){

        $item = BoqItem::where('boq_id',$request->boq_id)->with(['category','grade'])->get();

        $html = view('client.po.boq_item',compact('item','request'))->render();

        return \Response::json(['status' => 'success','html' => $html]);
    }

    public function downloadInvoiceDocumentZip($invoiceId){

        $document = PurchaseOrderInvoice::where('id',base64_decode($invoiceId))->first();

        $zip = new ZipArchive;
        $zipFileName = date('dmyhis').".zip";
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Add files to the ZIP file
            $filesToAdd = [
                public_path('uploads/invoice/'.$document->uuid.'/'.$document->invoice_copy),
                public_path('uploads/invoice/'.$document->uuid.'/'.$document->grm),
                public_path('uploads/invoice/'.$document->uuid.'/'.$document->lr_copy),
                public_path('uploads/invoice/'.$document->uuid.'/'.$document->eway_bill),
            ];

            foreach ($filesToAdd as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
        }

        return Response::download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function allInvoice(Request $request){

        $filter = 0;

        $query = PurchaseOrderInvoice::whereHas('po',function($q) { $q->where('client_id', Auth::guard('client')->user()->id);});



        $invoice = $query->with(['investor'])->orderBy('id','desc')->get();

        return view('client.invoice.all_invoice',compact('invoice','filter'));
    }

    public function addTransactionLog($request,$invoice){

        $status = isset($request->mark_as_paid) ? 'PAID' : 'PENDING';

        $detail = Transaction::where('type',$status)->where('invoice_id',$invoice->id)->first();

        if(!is_null($detail)){
            $removeInvoice = Transaction::where('id',$detail->id)->delete();
            if($status == 'PENDING'){
                $update = Transaction::where('invoice_id',$invoice->id)->update(['type' => 'PENDING']);
                return $update ? true : false;
            }
        }

        

        $po = PurchaseOrder::where('id',$request->po_id)->first();

        $log = new Transaction;
        $log->client_id = $po->client_id;
        $log->project_id = $po->project_id;
        $log->po_id = $request->po_id;
        $log->invoice_id = $invoice->id;
        $log->reference_number = $request->invoicenumber;
        $log->type = isset($request->mark_as_paid) ? 'PAID' : 'PENDING';
        $log->amount = $request->invoice_amount;
        $log->payment_date = isset($request->mark_as_paid) ? date('Y-m-d') : null;
        $log->save();

        return $log ? true : false;
    }
}
