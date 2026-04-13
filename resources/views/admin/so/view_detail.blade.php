@extends('layouts.admin')
@section('title','View sales Order')
@section('content')
@php
    $showActionColumn = !empty(array_intersect(['view','view-document','download'], $selectedAction['invoice']));
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">View Sales Order</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.so.index') }}">All SO</a></li>
                            <li class="breadcrumb-item active">View Sales Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if(!is_null($invoice) && array_key_exists('invoice',$selectedAction) && in_array('assign-investor',$selectedAction['invoice']))
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
                        @if(array_key_exists('invoice',$selectedAction))
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Investor</th>
                                    <th>Invoice</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Balance Due</th>
                                    <th>E-way Bill</th>
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($invoice))
                                @foreach($invoice as $ok => $ov)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ov->date)->format('d/m/Y') }}</td>
                                    <td>{{ $ov->investor ? $ov->investor->name : '---' }}</td>
                                    <td>{{ $ov->invoice_number }}</td>
                                    <td>{{ $ov->reference_number }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->status)) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ov->due_date)->format('d/m/Y') }}</td>
                                    <td>₹ {{ number_format($ov->total, 2, '.', ',') }}</td>
                                    <td>₹ {{ number_format($ov->balance, 2, '.', ',') }}</td>
                                    <td>
                                        @if($ov->ewayBills)
                                            <a href="javascript:void(0);" class="viewEwayBill" data-token="{{ csrf_token() }}" data-url="{{ route('admin.invoice.ewaybill',base64_encode($ov->ewayBills->ewaybill_id)) }}">{{ $ov->ewayBills?->ewaybill_number }}</a>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    @if($showActionColumn)
                                    <td>
                                        @if(array_key_exists('invoice',$selectedAction) && in_array('view',$selectedAction['invoice']))
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary waves-effect waves-light viewInvoiceBtn"
                                            data-id="{{ base64_encode($ov->invoice_id) }}"
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
                                                    data-id="{{ base64_encode($ov->invoice_id) }}">
                                                        <i class="fa fa-file-pdf text-danger me-2"></i> Download Invoice PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item downloadInvoiceZipBtn"
                                                    href="javascript:void(0);"
                                                    data-id="{{ base64_encode($ov->invoice_id) }}">
                                                        <i class="fa fa-file-archive text-warning me-2"></i> Download All ZIP
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                        @if(!empty($ov->documents) && count($ov->documents) > 0 && array_key_exists('invoice',$selectedAction) && in_array('view-document',$selectedAction['invoice']))
                                            <div class="btn-group">
                                                <button type="button" 
                                                    class="btn btn-info dropdown-toggle waves-effect waves-light"
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                    <i class="fa fa-paperclip"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="min-width: 250px;">
                                                    @foreach($ov->documents as $index => $doc)
                                                        <li>
                                                            <a class="dropdown-item openDocument"
                                                            href="javascript:void(0);"
                                                            data-token="{{ csrf_token() }}"
                                                            data-type="invoices"
                                                            data-url="{{ route('admin.so.openDocument') }}"
                                                            data-id="{{ $ov->invoice_id }}"
                                                            data-document-id="{{ $doc['document_id'] }}">
                                                                {{ $doc['file_name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <!--@if(array_key_exists('po',$selectedAction) && in_array('invoice',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.invoiceList',base64_encode($ov->id)) }}" role="button">
                                                    Upload Invoice
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('edit',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.edit',base64_encode($ov->id)) }}" role="button">
                                                    Edit
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('delete',$selectedAction['po']))
                                                <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.po.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this po?');">
                                                    Delete
                                                </a>
                                            @endif -->
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <div>
            {!! $html !!}
        </div>
    </div>
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
@include('inc.documentModal')
<div class="modal fade" id="assignInvestorModal" tabindex="-1" aria-labelledby="assignInvestorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.so.assignInvestor') }}" method="post">
                @csrf
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