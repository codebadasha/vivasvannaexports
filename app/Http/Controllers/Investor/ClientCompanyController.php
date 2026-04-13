<?php

namespace App\Http\Controllers\Investor;

use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\Models\ClientCompany;
use App\Models\PurchaseOrderItem;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientInvestor;
use App\Models\SalesOrderInvoice;
use App\Models\InvestorClient;
use App\Models\SalesOrderItem;
use App\Models\Project;
use App\Models\SalesOrder;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Auth;

class ClientCompanyController extends GlobalController
{
    private $investorclient;

    public function __construct()
    {
        $this->middleware('investor');
    }

    public function index()
    {

        $clients = Auth::guard('investor')
                ->user()
                ->clients()
                ->select([
                   'client_companies.id','company_name','director_name','gstn','pan_number','cin','cin_verify','msme_register','turnover','is_active','address','is_verify'
                ])
                ->with([
                    'gstDetails:client_company_id,constitution_of_business'
                ])
                ->get();

        return view('investor.company.list', compact('clients'));
    }

    public function downloadCompanyDocumentZip($companyId)
    {

        $document = ClientCompany::where('id', base64_decode($companyId))->first();

        $zip = new ZipArchive;
        $zipFileName = date('dmyhis') . ".zip";
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Add files to the ZIP file
            $filesToAdd = [
                public_path('uploads/company/' . $document->uuid . '/' . $document->registration_cetificate),
                public_path('uploads/company/' . $document->uuid . '/' . $document->incorporation),
                public_path('uploads/company/' . $document->uuid . '/' . $document->gst_certificate),
                public_path('uploads/company/' . $document->uuid . '/' . $document->pan_card),
                public_path('uploads/company/' . $document->uuid . '/' . $document->aoa),
            ];

            foreach ($filesToAdd as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
        }

        return Response::download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function clientDashboard($clientId)
    {

        $client = ClientCompany::where('id', base64_decode($clientId))->with(['contact', 'authorized'])->first();
        $customerId = $client->zoho_contact_id;
        $items = SalesOrderItem::query()
                ->with([
                    'salesOrder' => function ($q) {
                        $q->select('id', 'zoho_salesorder_id', 'salesorder_number', 'project_id', 'customer_id')
                        ->with([
                            'project' => fn($q) => $q->select('id', 'name'),
                            'invoices' => fn($q) => $q->select('id', 'sales_order_id')
                                ->with(['items' => fn($q) => $q->select('id', 'invoice_id', 'item_id', 'quantity')])
                        ]);
                    }
                ])
                ->whereHas('salesOrder', fn($q) => $q->where('customer_id', $customerId))
                ->orderByDesc('id')
                ->get();
        
        $data = [
            'total_projects' => Project::where('client_id', $client->id)
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->count(),

            'total_po_count' => SalesOrder::where('customer_id', $customerId)->count(),

            'total_po_amount' => SalesOrder::where('customer_id', $customerId)->sum('total'),

            'total_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->whereNotIn('status', ['draft','void','viewed'])
                ->count(),

            'total_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->whereNotIn('status', ['draft','void','viewed'])
                ->sum('total'),

            'paid_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','paid')
                ->count(),

            'paid_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','paid')
                ->sum('total'),

            'overdue_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','overdue')
                ->count(),

            'overdue_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','overdue')
                ->sum('total'),
        ];

        return view('investor.company.dashboard', compact('client', 'items', 'data'));
    }

    public function getCompanyAuthorizedPerson(Request $request)
    {

        $getCompanyAuthorizedPerson = ClientCompanyAuthorizedPerson::where('client_company_id', $request->id)->get();

        $getClientCompanyContact = ClientCompanyContact::where('client_company_id', $request->id)->get();

        return view('investor.company.authorized_person', compact('getCompanyAuthorizedPerson', 'getClientCompanyContact'));
    }
}
