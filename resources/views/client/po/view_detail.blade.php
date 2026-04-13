@extends('layouts.client')
@section('title','View Purchase Order')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">View Purchase Order</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.po.index') }}">All POs</a></li>
                            <li class="breadcrumb-item active">View Purchase Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

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
                                    <th class='notexport'>Actions</th>
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
                                            <a href="javascript:void(0);" class="viewEwayBill" data-token="{{ csrf_token() }}" data-url="{{ route('client.invoice.ewaybill',base64_encode($ov->ewayBills->ewaybill_id)) }}">{{ $ov->ewayBills?->ewaybill_number }}</a>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary waves-effect waves-light viewInvoiceBtn"
                                            data-id="{{ base64_encode($ov->invoice_id) }}"
                                            role="button" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary waves-effect waves-light viewInvoiceBtn"
                                            data-id="{{ base64_encode($ov->invoice_id) }}"
                                            role="button" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
                                        @if(!empty($ov->documents) && count($ov->documents) > 0)
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
                                                            data-url="{{ route('client.po.openDocument') }}"
                                                            data-id="{{ $ov->invoice_id }}"
                                                            data-document-id="{{ $doc['document_id'] }}">
                                                                {{ $doc['file_name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
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
@endsection
@section('js')

<script>
    $(document).on('click', '.viewInvoiceBtn', function() {
        let invoiceId = $(this).data('id');
        let modal = $('#invoiceViewModal');
        let content = $('#invoiceHtmlContent');

        // Show modal & loading spinner
        content.html('<div class="text-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        modal.modal('show');

        let url = "{{ route('client.po.viewinvoice', ['id' => ':id']) }}";
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
        let url = "{{ route('client.so.invoicedownload', ['id' => ':id']) }}";
        url = url.replace(':id', invoiceId);

        window.open(url, '_blank');
    });

    $(document).on('click', '.downloadInvoiceZipBtn', function() {
        let invoiceId = $(this).data('id');
        let url = "{{ route('client.so.invoicezip', ['id' => ':id']) }}";
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