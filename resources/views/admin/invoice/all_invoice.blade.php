@extends('layouts.admin')
@section('title','All Invoices')
@section('content')
@php
    $showActionColumn = !empty(array_intersect(['view','view-document','download'], $selectedAction['invoice']));
@endphp
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Invoices </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            @if(request()->has('from_client') && request()->from_client == 1 && isset($client))
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.client.clientDashboard', base64_encode($client->id)) }}">
                                        {{ $client->company_name }} Dashboard
                                    </a>
                                </li>
                            @endif
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
                        <form action="{{ route('admin.so.allinvoice.index') }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="control-label">Invoice Number</label>
                                    <input class="form-control" name="invoice_number" value="{{ request()->invoice_number }}" placeholder="Invoice Number">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse($clients as $sk => $sv)
                                            <option value="{{ $sv->zoho_contact_id }}" {{ request()->client == $sv->zoho_contact_id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Sales Orders</label>
                                    <select class="form-select select2" name="order">
                                        <option value="">Select Sales Order</option>
                                        @forelse($so as $sk => $sv)
                                        <option value="{{ $sv->id }}" {{ request()->order == $sv->id ? 'selected' : '' }} >{{ $sv->salesorder_number }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="control-label">Investors</label>
                                    <select class="form-select select2" name="investor">
                                        <option value="" selected>Select Investor</option>
                                        @forelse(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                        <option value="{{ $sv->id }}" {{ request()->investor == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Invoice Status</label>
                                    <select class="form-select" name="status">
                                        <option value="" selected>All</option>
                                        <option value="1" {{ request()->status == 1 ? 'selected' : '' }}>Paid</option>
                                        <option value="2" {{ request()->status == 2 ? 'selected' : '' }}>Un Paid</option>
                                        <option value="3" {{ request()->status == 3 ? 'selected' : '' }}>Overdue</option>
                                    </select>
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

                                <div class="col-md-4 mb-3">
                                    <label class="control-label">Select Financial Year</label>
                                    <select class="form-select" name="fin_year">
                                        <option value="" selected>Financial Year</option>
                                        @forelse(getFinYear() as $fk => $sv)
                                        <option value="{{ $sv }}" {{ request()->fin_year == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                    <a href="{{ route('admin.so.allinvoice.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Sales Orders</p>
                                        <h4 class="mb-0">{{ $data['total_so_count'] }}</h4>
                                        <h5 class="mb-0">₹ {{ number_format($data['total_so_amount'], 2, '.', ',') }}</h5>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">

                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0">{{ $data['total_invoice_count'] }}</h4>
                                        <h5 class="mb-0">₹ {{ number_format($data['total_invoice_amount'], 2, '.', ',') }}</h5>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Received Payment</p>
                                        <h4 class="mb-0">{{ $data['paid_invoice_count'] }}</h4>
                                        <h5 class="mb-0">₹ {{ number_format($data['paid_invoice_amount'], 2, '.', ',') }}</h5>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    @if(array_key_exists('invoice',$selectedAction) && in_array('assign-investor',$selectedAction['invoice']))
                    <div class="card-header">
                        <button type="button"
                                class="btn btn-warning waves-effect waves-light float-right"
                                data-bs-toggle="modal"
                                data-bs-target="#assignInvestorModal">
                            Assign Investor
                        </button>
                    </div>
                    @endif
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Investor Name</th>
                                    <th>Client Name</th>
                                    <th>Invoice</th>
                                    <th>Order Number</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Balance Due</th>
                                    <th>E-Way Bill</th>
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($invoice))
                                @foreach($invoice as $ik => $iv)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($iv->date)->format('d/m/Y') }}</td>
                                    <td>{{ $iv->investor->name ?? '---' }}</td>
                                    <td>{{ $iv->customer_name ?? '---' }}</td>
                                    <td>{{ $iv->invoice_number }}</td>
                                    <td>{{ $iv->reference_number }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $iv->status)) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($iv->due_date)->format('d/m/Y') }}</td>
                                    <td>₹ {{ number_format($iv->total, 2, '.', ',') }}</td>
                                    <td>₹ {{ number_format($iv->balance, 2, '.', ',') }}</td>
                                    <td>
                                        @if($iv->ewayBills)
                                            <a href="javascript:void(0);" class="viewEwayBill" data-token="{{ csrf_token() }}" data-url="{{ route('admin.invoice.ewaybill',base64_encode($iv->ewayBills->ewaybill_id)) }}">{{ $iv->ewayBills?->ewaybill_number }}</a>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    @if($showActionColumn)
                                    <td>
                                        @if(array_key_exists('invoice',$selectedAction) && in_array('view',$selectedAction['invoice']))
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary waves-effect waves-light viewInvoiceBtn"
                                            data-id="{{ base64_encode($iv->invoice_id) }}"
                                            role="button" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif
                                        @if(array_key_exists('invoice',$selectedAction) && in_array('download',$selectedAction['invoice']))
                                            <div class="btn-group">
                                                <button type="button" 
                                                    class="btn btn-danger dropdown-toggle waves-effect waves-light"
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false"
                                                    title="Download">
                                                    <i class="fa fa-download"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item downloadInvoiceBtn"
                                                        href="javascript:void(0);"
                                                        data-id="{{ base64_encode($iv->invoice_id) }}">
                                                            <i class="fa fa-file-pdf text-danger me-2"></i> Download Invoice PDF
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item downloadInvoiceZipBtn"
                                                        href="javascript:void(0);"
                                                        data-id="{{ base64_encode($iv->invoice_id) }}">
                                                            <i class="fa fa-file-archive text-warning me-2"></i> Download All ZIP
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                        @if(!empty($iv->documents) && count($iv->documents) > 0 && array_key_exists('invoice',$selectedAction) && in_array('view-document',$selectedAction['invoice']))
                                            <div class="btn-group">
                                                <button type="button" 
                                                    class="btn btn-info dropdown-toggle waves-effect waves-light"
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                    <i class="fa fa-paperclip"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="min-width: 250px;">
                                                    @foreach($iv->documents as $index => $doc)
                                                        <li>
                                                            <a class="dropdown-item openDocument"
                                                            style="font-sixe:16px;"
                                                            href="javascript:void(0);"
                                                            data-token="{{ csrf_token() }}"
                                                            data-type="invoices"
                                                            data-url="{{ route('admin.so.openDocument') }}"
                                                            data-id="{{ $iv->invoice_id }}"
                                                            data-document-id="{{ $doc['document_id'] }}">
                                                                @if($doc['file_type'] == 'pdf')
                                                                <i class="fa fa-file-pdf" style="margin-right: 6px; font-size: 20px;"></i>
                                                                @else
                                                                <i class="fas fa-image" style="margin-right: 6px; font-size: 20px;"></i>
                                                                @endif
                                                                {{ $doc['file_name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    @endif
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

<div class="modal fade" id="invoiceViewModal" tabindex="-1" aria-labelledby="invoiceViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="invoiceViewModalLabel">Invoice Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="invoiceHtmlContent">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="assignInvestorModal" tabindex="-1" aria-labelledby="assignInvestorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.so.assignInvestor') }}" method="post">
                @csrf
                <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="assignInvestorModalLabel">Assign Investor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <div class="form-group mb-3">
                        <label for="investor_id">Select Investor</label>
                        <select name="investor_id" id="investor_id" class="form-control select2" required>
                            <option value="">-- Select Investor --</option>
                             @foreach(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $investor)
                            <option value="{{ $investor->id }}">{{ $investor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="invoices">Select Invoices</label>
                        <select name="invoices[]" id="invoices" class="form-control select2" multiple required>
                            <option value="">-- Select Invoices --</option>
                            @foreach($invoice as $ok => $ov)
                            <option value="{{ $ov->id }}" {{ $ov->investor_id ? 'disabled' : ''}}>{{ $ov->invoice_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('inc.documentModal')
@endsection
@section('js')

<script>
    
    $('#assignInvestorModal').on('shown.bs.modal', function() {
        $('#investor_id').select2({
            dropdownParent: $('#assignInvestorModal')
        });
        $('#invoices').select2({
            dropdownParent: $('#assignInvestorModal')
        });
    });

    $(document).on('submit', '#assignInvestorModal form', function(e) {
        e.preventDefault();

        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');

        // Disable button
        submitBtn.prop('disabled', true);

        // Show SweetAlert Loader
        Swal.fire({
            title: 'Please Wait...',
            text: 'Assigning Investor...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function(data) {
                Swal.close();
                if (data.status) {
                    toastr.success(data.message);
                    $('#assignInvestorModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(data.message);
                    submitBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                Swal.close();

                let message = 'Something went wrong';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                toastr.error(message);

                submitBtn.prop('disabled', false);
            }
        });
    });

     $(document).on('hidden.bs.modal', '#assignInvestorModal', function () {

        $('#assignInvestorModal #invoices')
            .val(null)
            .trigger('change');

        $('#assignInvestorModal #investor_id')
            .val(null)
            .trigger('change');

        // Optional: disable invoices again
        $('#assignInvestorModal #invoices')
            .prop('disabled', true)
            .empty()
            .append('<option value="">-- Select invoices --</option>');
    });

    $(document).on('click', '.viewInvoiceBtn', function() {
        let invoiceId = $(this).data('id');
        let modal = $('#invoiceViewModal');
        let content = $('#invoiceHtmlContent');

        // Show modal & loading spinner
        content.html('<div class="text-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        modal.modal('show');

        let url = "{{ route('admin.so.viewinvoice', ['id' => ':id']) }}";
        url = url.replace(':id', invoiceId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                content.html(response);
            },
            error: function(xhr) {
                let msg = 'Failed to load invoice. Please try again later.';
                content.html('<div class="text-danger text-center p-3">' + msg + '</div>');
            }
        });
    });
</script>
<script>
    $(document).on('click', '.downloadInvoiceBtn', function() {
        let invoiceId = $(this).data('id');
        let url = "{{ route('admin.so.invoicedownload', ['id' => ':id']) }}";
        url = url.replace(':id', invoiceId);

        window.open(url, '_blank');
    });

    $(document).on('click', '.downloadInvoiceZipBtn', function() {
        let invoiceId = $(this).data('id');
        let url = "{{ route('admin.so.invoicezip', ['id' => ':id']) }}";
        url = url.replace(':id', invoiceId);

        Swal.fire({
            title: 'Please Wait...',
            text: 'Preparing ZIP file...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);

        setTimeout(() => {
            Swal.close();
        }, 2500);
    });
</script>
@endsection