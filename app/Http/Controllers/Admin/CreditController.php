<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreditRequest;
use ZipArchive;

class CreditController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){

        $filter = 0;

        $query = CreditRequest::query();

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_id',$request->client);
        }

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;
            $query->whereBetween(\DB::raw('date(created_at)'),[date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date)))),date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))))]);
        }

        $list = $query->with(['client'])->orderBy('id','desc')->get();

        return view('admin.credit.list',compact('list','filter'));
    }

    public function viewCreditForm($id){

        $creditRequest = CreditRequest::where('id',base64_decode($id))->with(['client','sheet','statement'])->first();

        return view('admin.credit.view_credit_form',compact('creditRequest'));

    }

    public function downloadCreditDocument($id){

        $document = CreditRequest::where('id',base64_decode($id))->with(['sheet','statement'])->first();

        $files = array();

        if(!is_null($document->sheet)){
            foreach($document->sheet as $sk => $sv){
                $files[] = public_path('uploads/balance_sheet/'.$sv->file);
            }
        }

        if(!is_null($document->statement)){
            foreach($document->statement as $sk => $sv){
                $files[] = public_path('uploads/bank_statement/'.$sv->bank_statement);
            }
        }



        $zip = new ZipArchive;
        $zipFileName = date('dmyhis').".zip";
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Add files to the ZIP file
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
        }

        return \Response::download($zipFilePath)->deleteFileAfterSend(true);
    }
}
