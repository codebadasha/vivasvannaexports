@extends('layouts.admin')
@section('title','View Purchase Order')
@section('content')
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
                                    <td>{{ $ov->ewaybill->ewaybill_id ?? '---' }}</td>
                                    <td>
                                        @if(array_key_exists('po',$selectedAction) && in_array('view',$selectedAction['po']))
                                        <a class="btn btn-warning waves-effect waves-light assignInvestor" href="javascript:void(0);" role="button" title="Edit" data-investor_id="{{ $ov->investor_id }}" data-id="{{ base64_encode($ov->invoice_id) }}">
                                            Assign Investor
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary waves-effect waves-light viewInvoiceBtn"
                                            data-id="{{ base64_encode($ov->invoice_id) }}"
                                            role="button" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger waves-effect waves-light downloadInvoiceBtn"
                                            data-id="{{ base64_encode($ov->invoice_id) }}"
                                            role="button" title="Download PDF">
                                            <i class="fa fa-download"></i>
                                        </a>
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
<div class="modal fade" id="assignInvestorModal" tabindex="-1" aria-labelledby="assignInvestorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="assignForm">
                @csrf
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="assignInvestorModalLabel">Assign Investor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="invoice_id" id="invoice_id">
                    <div class="form-group mb-3">
                        <label for="investor_id">Select Investor</label>
                        <select name="investor_id" id="investor_id" class="form-control select2" required>
                            <option value="">-- Select Investor --</option>
                            @foreach(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $investor)
                            <option value="{{ $investor->id }}">{{ $investor->name }}</option>
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
@endsection
@section('js')

<script>
    $(document).on('click', '.assignInvestor', function() {
        // Get values from button
        let invoice_Id = $(this).data('id');
        let investorId = $(this).data('investor_id');

        // Decode base64 values (if present)
        investorId = investorId ? investorId : '';

        // Set hidden SO ID
        $('#invoice_id').val(invoice_Id);

        // Reset selects

        $('#investor_id').val('').trigger('change');


        if (investorId) {
            $('#investor_id').val(investorId).trigger('change');
        }

        // Open modal
        $('#assignInvestorModal').modal('show');
    });
    $('#assignInvestorModal').on('shown.bs.modal', function() {
        $('#investor_id').select2({
            dropdownParent: $('#assignInvestorModal')
        });
    });

    // Handle form submit (AJAX)
    $('#assignForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.so.assignInvestor') }}", // route for update
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#assignInvestorModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Investor assigned successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        location.reload(); // reload to reflect changes
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Something went wrong.'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Server error.'
                });
            }
        });
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

    $(document).on('click', '.downloadInvoiceBtn', function() {
        let invoiceId = $(this).data('id');
        let url = "{{ route('admin.so.invoicedownload', ['id' => ':id']) }}";
        url = url.replace(':id', invoiceId);
        window.open(url, '_blank'); // open PDF in new tab or trigger browser download
    });
</script>

@endsection