@extends('layouts.admin')
@section('title','All Invoices')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Invoices for PO {{ $po->po_number }} of Project - 1</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Invoices</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td>PO Number</td>
                                        <td>{{ $poDetail->po_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>PO Date</td>
                                        <td>{{ date('d/m/Y',strtotime($poDetail->created_at))  }}</td>
                                    </tr>
                                    <tr>
                                        <td>Client</td>
                                        <td>{{ !is_null($poDetail->client) ? $poDetail->client->company_name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Project</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>BOQ</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>Download PO</td>
                                        <td><a href="{{ asset('uploads/po') }}/{{ $poDetail->po_copy }}" class="btn btn-danger" target="_blank">Download PO</a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td>PO Total</td>
                                        <td>{{ $poDetail->subtotal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Paid Amount</td>
                                        <td>{{ $poDetail->received_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Unpaid Amount</td>
                                        <td>{{ $poDetail->subtotal - $poDetail->received_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Edit PO</td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.edit',base64_encode($poDetail->id)) }}" role="button">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>View PO</td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.viewPurchaseOrder',base64_encode($poDetail->id)) }}" role="button">
                                                View PO
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.po.invoiceList',$id) }}">
                            <div class="row">  
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Invoice Uploaded Daterange</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="upload_start_date" autocomplete="off" value="{{ request()->upload_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="upload_end_date" autocomplete="off" value="{{ request()->upload_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Invoice Due Daterange</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="due_start_date" autocomplete="off" value="{{ request()->due_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="due_end_date" autocomplete="off" value="{{ request()->due_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <label class="control-label">Invoice Status</label>
                                    <select class="form-select" name="status">
                                        <option value="" selected>All</option>
                                        <option value="1" {{ request()->status == 1 ? 'selected' : '' }}>Paid</option>
                                        <option value="2" {{ request()->status == 2 ? 'selected' : '' }}>Un Paid</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Investor</label>
                                    <select class="form-select" name="investor">
                                        <option value="" selected>Select Investor</option>
                                        @forelse(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}" {{ request()->investor == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Invoice Number</label>
                                    <input class="form-control" name="invoice_number" value="{{ request()->invoice_number }}" placeholder="Invoice Number">
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                        <a href="{{ route('admin.po.invoiceList',$id) }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.po.addInvoice',$id) }}" class="btn btn-primary float-right">Add Invoice</a><br /><br /><br />
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Product name</th>
                                    <th>Qty</th>
                                    <th>Investor Name</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Amount</th>
                                    <th>Invoice Uploaded On</th>
                                    <th>Invoice Due Date</th>
                                    <th>Status</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($invoice))
                                @foreach($invoice as $ik => $iv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $iv->item->varation->product->product_type ?? '--' }} - {{ $iv->item->varation->grade ?? '--' }}</td>
                                        <td>{{ $iv->billing_qty ?? '--' }}</td>
                                        <td>{{ !is_null($iv->investor) ? $iv->investor->name : '--' }}</td>
                                        <td>{{ $iv->invoice_number }}</td>
                                        <td>{{ $iv->invoice_amount }}</td>
                                        <td>{{ date('d/m/Y',strtotime($iv->created_at)) }}</td>
                                        <td>{{ date('d/m/Y',strtotime($iv->due_date)) }}</td>
                                        <td>{{ $iv->mark_as_paid == 1 ? 'Paid' : 'Unpaid' }}</td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.editInvoice',base64_encode($iv->id)) }}" role="button">
                                                Edit
                                            </a>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.downloadInvoiceDocumentZip',base64_encode($iv->id)) }}" role="button" target="_blank">
                                                Download Documents
                                            </a>
                                            <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.po.deleteInvoice',base64_encode($iv->id)) }}" role="button" onclick="return confirm('Do you want to delete this invoice?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection