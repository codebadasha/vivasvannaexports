<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\CreditRequest;
use App\Models\CreditRequestBankStatementReport;
use App\Models\CreditRequestGstScoreReport;
use App\Models\CreditRequestBalanceSheet;
use App\Services\PerfiosService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ClientCompany;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MailHelper;

class CreditController extends GlobalController
{
    protected $perfios;
        
    public function __construct(PerfiosService $perfios)
    {
        $this->middleware('client');
        $this->perfios = $perfios;
    }

    public function list()
    {
        $companyId = Auth::guard('client')->user()->id;

        $creditRequests = CreditRequest::where('client_company_id',$companyId)
            ->latest()
            ->get();

        return view('client.credit.list',compact('creditRequests'));
    }

    public function showApplyForm()
    {
        $companyId = Auth::guard('client')->user()->id;

        $lastRequest = CreditRequest::with('bankReport')->where('client_company_id',$companyId)
                        ->latest()
                        ->first();

        if($lastRequest){

            if($lastRequest->status == 'submitted'){
                return back()->with('messages', [[
                    'type' => 'error',
                    'message' => 'Your credit request is submitted. Our team will review it soon.',
                ]]);
            }

            if ($lastRequest->status == 'approved') {

                if ($lastRequest->updated_at->addMonths(6)->gt(now())) {

                    $nextApplyDate = $lastRequest->updated_at->addMonths(6)->format('d M Y');

                    return back()->with('messages', [[
                        'type' => 'error',
                        'message' => "Your previous credit request was approved. You can apply for an increased credit limit after {$nextApplyDate}.",
                    ]]);
                }
            }

            if ($lastRequest->status == 'rejected') {

                if ($lastRequest->updated_at->addMonths(3)->gt(now())) {

                    $nextApplyDate = $lastRequest->updated_at->addMonths(3)->format('d M Y');

                    return back()->with('messages', [[
                        'type' => 'error',
                        'message' => "Your previous credit request was rejected. You can submit a new request after {$nextApplyDate}.",
                    ]]);
                }
            }

            if($lastRequest->status == 'document_pending' && $lastRequest->created_at->addMonth()->lt(now())){
                
                $lastRequest->update([
                    'status'=>'cancelled',
                    'reason'=>'Request expired after one month without completing documents'
                ]);

                $lastRequest = null;
            }
        }

        $pending = $lastRequest;
        $banks = Bank::all();

        return view('client.credit.apply', compact('pending','banks'));
    }

    public function initBank(Request $request)
    {
        $request->validate([
            'credit_amount' => 'required|numeric|min:10000',
            'bank_id'       => 'required|exists:banks,perfios_institution_id',
        ]);

        try {
            $credit = CreditRequest::where('client_company_id', auth('client')->id())
                ->where('status', 'document_pending')
                ->latest()
                ->first();

            $isNew = !$credit;

            if (!$credit) {
                $credit = CreditRequest::create([
                    'client_company_id' => auth('client')->id(),
                    'status'            => 'document_pending'
                ]);
            }

            $existingReport = CreditRequestBankStatementReport::where('credit_request_id', $credit->id)
                            ->where('bank_id', $request->bank_id)
                            ->where('created_at', '>=', now()->subMinutes(45))
                            ->first();

            if ($existingReport && $existingReport->perfiosTransactionId) {

                Log::info('Using existing Perfios transaction', [
                    'credit_request_id' => $credit->id,
                    'perfiosTransactionId' => $existingReport->perfiosTransactionId
                ]);

                return response()->json([
                    'success' => true,
                    'credit_request_id' => $credit->id,
                    'perfiosTransactionId' => $existingReport->perfiosTransactionId,
                ]);
            }

            $uuid = Str::uuid()->toString();           // with hyphens
            $txnId = str_replace('-', '', $uuid);

            $payloadData = [
                'loanAmount'                     => $request->credit_amount,
                'loanDuration'                   => 3,
                'loanType'                       => 'Personal',
                'processingType'                 => 'STATEMENT',
                // "transactionCompleteCallbackUrl" => 'https://portal.vivasvannaexports.com/webhooks-perfios/bsa',
                'transactionCompleteCallbackUrl' => route('perfios.webhook'),
                'txnId'                          => $txnId,
                'acceptancePolicy'               => 'atLeastOneTransactionInRange',
                'institutionId'                  => $request->bank_id, // ← from bank_id (update mapping later)
                'uploadingScannedStatements'     => 'false',
                'yearMonthFrom'                  => now()->subMonths(6)->format('Y-m'),
                'yearMonthTo'                    => now()->format('Y-m'),
            ];

            $result = $this->perfios->initBankTransaction($payloadData);

            if (!$result['success'] || !$result['perfiosTransactionId']) {
                if ($isNew) $credit->delete();
                Log::error('Bank init failed', ['payload' => $payloadData, 'result' => $result]);
                return response()->json(['success' => false, 'message' => $result['message'] ?? 'Failed to init transaction']);
            }

            CreditRequestBankStatementReport::updateOrCreate(
                ['credit_request_id' => $credit->id],
                [
                    'request_amount'       => $request->credit_amount,
                    'bank_id'              => $request->bank_id,
                    'perfiosTransactionId' => $result['perfiosTransactionId'],
                    'txn_id'               => $txnId,
                ]
            );

            return response()->json([
                'success'              => true,
                'credit_request_id'    => $credit->id,
                'perfiosTransactionId' => $result['perfiosTransactionId'],
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in initBank', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function uploadBankStatement(Request $request)
    {
        $request->validate([
            'credit_request_id'      => 'required|exists:credit_requests,id',
            'perfios_transaction_id' => 'required|string',
            'statement'              => 'required|file|mimes:pdf|max:20480',
            'password'               => 'nullable|string',
        ]);

        try {
            $report = CreditRequestBankStatementReport::where('credit_request_id', $request->credit_request_id)
                ->where('perfiosTransactionId', $request->perfios_transaction_id)
                ->firstOrFail();

            $file = $request->file('statement');
            $path = $file->store('bank-statements', 'public');
            // $fullPath = storage_path('app/public/' . $path);

            $uploadResult = $this->perfios->uploadBankFile(
                $report->perfiosTransactionId,
                $path,
                $file->getClientOriginalName()
            );

            if (!$uploadResult['success']) {

                Log::error('Perfios Upload File Failed', [
                    'report_id' => $report->id,
                    'perfios_transaction_id' => $report->perfiosTransactionId,
                    'error_code' => $uploadResult['error_code'] ?? null,
                    'technical_message' => $uploadResult['technical_message'] ?? null
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $this->perfiosUserMessage($uploadResult['error_code'] ?? null)
                ]);
            }

            $report->update([
                'perfiosFileId' => $uploadResult['fileId'],
                'file'          => $path,
                'filepassword'  => $request->password,
                'status'  => "uploaded",
            ]);

            $processResult = $this->perfios->processBankStatement(
                $report->perfiosTransactionId,
                $uploadResult['fileId'],
                $request->password
            );

            if (!$processResult['success']) {

                Log::error('Perfios Process Statement Failed', [
                    'report_id' => $report->id,
                    'perfios_transaction_id' => $report->perfiosTransactionId,
                    'error_code' => $processResult['error_code'] ?? null,
                    'technical_message' => $processResult['technical_message'] ?? null
                ]);
                return response()->json([
                    'success' => false,
                    'message' => $this->perfiosUserMessage($processResult['error_code'] ?? null)
                ]);
            }

            $report->update([
                'accountId'     => $processResult['data']['accountId'],
                'accountNumber' => $processResult['data']['accountNumber'],
                'accountType'   => $processResult['data']['accountType'],
                'status'        => "uploaded"
            ]);

            $reportResult = $this->perfios->generateReport($report->perfiosTransactionId);
            
           if (!$reportResult['success']) {

                Log::error('Perfios Report Generation Failed', [
                    'report_id' => $report->id,
                    'perfios_transaction_id' => $report->perfiosTransactionId,
                    'error_code' => $reportResult['error_code'] ?? null,
                    'technical_message' => $reportResult['technical_message'] ?? null
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $this->perfiosUserMessage($reportResult['error_code'] ?? null)
                ]);
            }
            
            $report->update([
                'status'     => "report_generating",
            ]);

            CreditRequest::find($request->credit_request_id)->update(['request_step' => "statement_uploaded"]);
            return response()->json([
                'success' => true,
                'message' => 'Bank statement uploaded successfully. We are analysing your statement.'
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in uploadBankStatement', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while processing your request. Please try again.'
            ]);
        }
    }

    public function initGstOtp(Request $request)
    {
        $request->validate([
            'username'          => 'required|string',
            'credit_request_id' => 'required|exists:credit_requests,id',
        ]);

        try {
            $client = auth('client')->user();
            $company = ClientCompany::where('client_id', $client->id)->first(); // ← fixed: use client_id

            $uuid = Str::uuid()->toString();           // with hyphens
            $refId = str_replace('-', '', $uuid);

            $result = $this->perfios->initiateGstOtp(
                $request->username,
                $company->gstn,
                $refId
            );

            if (!$result['success']) {
                Log::error('GST OTP initiate failed', ['company_id' => $company->id, 'result' => $result]);
                return response()->json(['success' => false, 'message' => $result['message']]);
            }

            CreditRequestGstScoreReport::create([
                'credit_request_id' => $request->credit_request_id,
                'refID'             => $refId,
                'prfios_requestId'  => $result['requestId'],
                'prfios_stamessage' => $result['statusMessage'],
                'status'            => "otp_generated"
            ]);

            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            Log::error('Exception in initGstOtp', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function submitGstOtp(Request $request)
    {
        $request->validate([
            'otp'               => 'required|digits:6',
            'credit_request_id' => 'required|exists:credit_requests,id',
        ]);

        try {
            $gstReport = CreditRequestGstScoreReport::where('credit_request_id', $request->credit_request_id)
                ->latest()
                ->firstOrFail();

            $result = $this->perfios->submitGstOtp($gstReport->prfios_requestId, $request->otp);

            if (!$result['success']) {
                Log::error('GST OTP submit failed', ['report_id' => $gstReport->id, 'result' => $result]);
                return response()->json(['success' => false, 'message' => $result['message']]);
            }

            $gstReport->update([
                'prfios_requestId'  => $result['newRequestId'],
                'prfios_stamessage' => $result['statusMessage'],
                'status'            => "report_generating"
            ]);

            CreditRequest::find($request->credit_request_id)->update(['request_step' => "gst_report_fetched"]);

            return response()->json(['success' => true, 'message' => 'GST authenticated successfully']);
        } catch (\Exception $e) {
            Log::error('Exception in submitGstOtp', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function uploadBalanceSheets(Request $request)
    {
        $request->validate([
            'credit_request_id' => 'required|exists:credit_requests,id',
            'balance_sheets.*'  => 'required|file|mimes:pdf|max:20480',
        ]);

        try {
            $credit = CreditRequest::findOrFail($request->credit_request_id);

            foreach ($request->file('balance_sheets') as $year => $file) {
                $path = $file->store("balance-sheets/{$credit->id}", 'public');
                // $fullPath = storage_path('app/public/' . $path);

                CreditRequestBalanceSheet::create([
                    'credit_request_id' => $credit->id,
                    'year'              => $year,
                    'filepath'          => $path,
                ]);
            }

            $credit->update([
                'request_step' => "balance_sheet_uploaded",
                'status'        => 'submitted'
            ]);

            try {
                $client = ClientCompany::where('id', $credit->client_company_id)->first();

                $subject = 'Credit Request Submitted';
                $viewFile = 'mail-template.credit-request-submitted';

                $response = MailHelper::send(
                    $client->email,
                    $subject,
                    $viewFile,
                );

                if (!$response['status']) {
                    Log::error("credit request submitted mail failed for {$client->email}: " . $response['message']);
                } else {
                    Log::info("credit request submitted mail sent to {$client->email}");
                }

            } catch (\Throwable $e) {
                Log::error("credit request submitted mail error: " . $e->getMessage());
            }

            return redirect()->route('client.dashboard')->with('success', 'Credit request submitted!');
        } catch (\Exception $e) {
            Log::error('Exception in uploadBalanceSheets', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to upload balance sheets');
        }
    }

    public function isPdfPasswordProtected($filePath)
    {
        $fp = fopen($filePath, 'rb');
        $contents = fread($fp, 2000); // read first part
        fclose($fp);

        return strpos($contents, '/Encrypt') !== false;
    }

    private function perfiosUserMessage($code)
    {
        $messages = [

            // PROCESS STATEMENT
            'E_DATE_RANGE' => 'No transactions were found in the uploaded statement for the selected period.',
            'E_FILE_NO_PASSWORD' => 'This bank statement is password protected. Please enter the PDF password.',
            'E_FILE_WRONG_PASSWORD' => 'The password you entered for the bank statement is incorrect.',
            'E_STATEMENT_AMBIGUOUS_INSTITUTION' => 'We could not clearly identify the bank from the uploaded statement.',
            'E_STATEMENT_UNSUPPORTED_FORMAT' => 'The uploaded statement format is not supported. Please upload the original bank PDF.',
            'E_STATEMENT_WRONG_INSTITUTION' => 'The uploaded statement does not belong to the selected bank.',
            'E_STATEMENT_NO_INSTITUTION_MATCHED' => 'We could not identify the bank from this statement.',
            'E_OTHER' => 'We could not process the bank statement. Please try again.',

            // FILE UPLOAD
            'CannotProcessFile' => 'We could not process the uploaded file. Please upload a valid bank statement.',
            'FileTooLarge' => 'The uploaded file is too large. Please upload a smaller file.',
            'InsecureFileType' => 'This file type is not allowed. Please upload a PDF statement.',
            'UnsupportedFileType' => 'Unsupported file type. Please upload a PDF bank statement.',
            'LimitExceeded' => 'You have reached the maximum number of file uploads for this request.',
            'NoActiveTransaction' => 'Your session has expired. Please restart the bank statement upload.',
            'RemoteAddressNotPermitted' => 'Access to this service is not permitted.',
            'TransactionLimitExceeded' => 'Transaction limit exceeded. Please try again later.',
            'InternalError' => 'Something went wrong while processing your statement. Please try again later.',
        ];

        return $messages[$code] ?? 'Unable to process the bank statement. Please try again.';
    }
}