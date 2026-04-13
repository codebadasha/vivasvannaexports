<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreditRequest;
use ZipArchive;
use Illuminate\Support\Facades\Log;
use App\Helpers\MailHelper;

class CreditController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $filter = 0;

        $query = CreditRequest::query();

        if(isset($request->client) && $request->client != ''){
            $filter = 1;
            $query->where('client_company_id',$request->client);
        }

        if(isset($request->po_start_date) && $request->po_start_date != ''){
            $filter = 1;

            $start = date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_start_date))));
            $end   = date('Y-m-d',strtotime(str_replace('/','-',trim($request->po_end_date))));

            $query->whereBetween(\DB::raw('date(created_at)'),[$start,$end]);
        }

        $list = $query->with([
            'client:id,company_name,gstn,pan_number',

            'bankReport' => function ($q) {
                $q->select(
                    'id',
                    'credit_request_id',
                    'bank_id',
                    'upload_filepath',
                    'report_file_path',
                    'status',
                    'reason'
                )->with('bank:perfios_institution_id,name');
            },

            'gstReport' => function ($q) {
                $q->select(
                    'id',
                    'credit_request_id',
                    'local_excexlfilepath',
                    'local_pdffilepath',
                    'status',
                    'reason'
                );
            },

            'balanceSheets' => function ($q) {
                $q->select('id','credit_request_id','year','filepath');
            }

        ])
        ->where('status','!=','document_pending')
        ->orderByDesc('id')
        ->get();

        return view('admin.credit.list',compact('list','filter'));
    }

    public function approve($id)
    {
        $credit = CreditRequest::findOrFail(base64_decode($id));

        $credit->update([
            'status' => 'approved'
        ]);
        try {
            $client = ClientCompany::where('id', $credit->client_company_id)->first();

            $subject = 'Congratulations! Your credit is Approved';
            $viewFile = 'mail-template.credit-approved';

            $response = MailHelper::send(
                $client->email,
                $subject,
                $viewFile,
            );

            if (!$response['status']) {
                Log::error("credit request Approved mail failed for {$client->email}: " . $response['message']);
            } else {
                Log::info("credit request Approved mail sent to {$client->email}");
            }

        } catch (\Throwable $e) {
            Log::error("credit request Approved mail error: " . $e->getMessage());
        }

        return redirect()->back()->with('messages', [['type' => 'success', 'message' => 'Credit request approved successfully',]]);
    }
        
        
        public function reject($id)
        {
            $credit = CreditRequest::findOrFail(base64_decode($id));

            $credit->update([
                'status' => 'rejected'
            ]);
            try {
                $client = ClientCompany::where('id', $credit->client_company_id)->first();

                $subject = 'Request Not Approved';
                $viewFile = 'mail-template.credit-rejected';

                $response = MailHelper::send(
                    $client->email,
                    $subject,
                    $viewFile,
                );

                if (!$response['status']) {
                    Log::error("credit request rejected mail failed for {$client->email}: " . $response['message']);
                } else {
                    Log::info("credit request rejected mail sent to {$client->email}");
                }

            } catch (\Throwable $e) {
                Log::error("credit request rejected mail error: " . $e->getMessage());
            }

            return redirect()->back()->with('messages', [['type' => 'success', 'message' => 'Credit request rejected successfully',]]);
        }
}
