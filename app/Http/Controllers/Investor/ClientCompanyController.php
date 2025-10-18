<?php

namespace App\Http\Controllers\Investor;

use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\Models\ClientCompany;
use App\Models\PurchaseOrderItem;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientInvestor;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Auth;

class ClientCompanyController extends GlobalController
{   
    private $investorclient;

    public function __construct(){
        $this->middleware('investor');

        if(Auth::guard('investor')->user()){
            $invClient = ClientInvestor::where('investor_id',Auth::guard('investor')->user()->id)->pluck('client_id')->toArray();
            $this->investorclient = $invClient;
        }
    }

    public function index(){

        $client = ClientCompany::whereIn('id',$this->investorclient)->where('is_delete',0)->orderBy('id','desc')->get();

        return view('investor.company.list',compact('client'));
    }

    public function downloadCompanyDocumentZip($companyId){

        $document = ClientCompany::where('id',base64_decode($companyId))->first();

        $zip = new ZipArchive;
        $zipFileName = date('dmyhis').".zip";
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Add files to the ZIP file
            $filesToAdd = [
                public_path('uploads/company/'.$document->uuid.'/'.$document->registration_cetificate),
                public_path('uploads/company/'.$document->uuid.'/'.$document->incorporation),
                public_path('uploads/company/'.$document->uuid.'/'.$document->gst_certificate),
                public_path('uploads/company/'.$document->uuid.'/'.$document->pan_card),
                public_path('uploads/company/'.$document->uuid.'/'.$document->aoa),
            ];

            foreach ($filesToAdd as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
        }

        return Response::download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function clientDashboard($clientId){

        $client = ClientCompany::where('id',base64_decode($clientId))->with(['contact'])->first();

        $detail = PurchaseOrderItem::with(['po' => function($q) { $q->with(['project']); },'varation' => function($q) { $q->with(['product']); }])->whereHas('po',function($q) use ($clientId) { $q->where('client_id',base64_decode($clientId)); })->get();

        return view('investor.company.dashboard',compact('client','detail'));
    }

    public function getCompanyAuthorizedPerson(Request $request){

        $getCompanyAuthorizedPerson = ClientCompanyAuthorizedPerson::where('client_company_id',$request->id)->get();

        $getClientCompanyContact = ClientCompanyContact::where('client_company_id',$request->id)->get();

        return view('investor.company.authorized_person',compact('getCompanyAuthorizedPerson','getClientCompanyContact'));
    }
}
