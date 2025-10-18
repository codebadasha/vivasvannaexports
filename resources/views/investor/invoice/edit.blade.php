@extends('layouts.admin')
@section('title','Edit Invoice')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Edit Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row">   
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                        </div><br />
                        <form class="custom-validation" action="{{ route('admin.po.saveEditedInvoice') }}" method="post" id="addClientCompany" enctype="multipart/form-data">
                            @csrf  
                            <input type="hidden" name="po_id" value="{{ $detail->po_id }}">
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                            <input type="hidden" name="uuid" id="uuid" value="{{ $detail->uuid }}" />
                            <input type="hidden" name="url" value="{{ url()->previous() }}" />

                            <div class="row">
                                <div class="mb-3">
                                    <label>PO Number <span class="mandatory">*</span></label>
                                    <input type="text" name="po_number" class="form-control" placeholder="PO Number" value="{{ $detail->po->po_number }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Invoice Number <span class="mandatory">*</span></label>
                                    <input type="text" name="invoicenumber" class="form-control" placeholder="Invoice Number" value="{{ $detail->invoice_number }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Invoice Amount <span class="mandatory">*</span></label>
                                    <input type="text" name="invoice_amount" class="form-control width" placeholder="Invoice Amount" value="{{ $detail->invoice_amount }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Upload Invoice Copy <span class="mandatory">*</span></label>
                                    <input type="file" name="invoice_copy" class="form-control dropify" placeholder="PO Number" data-allowed-file-extensions="pdf" data-default-file="{{ asset('uploads/invoice') }}/{{ $detail->invoice_Copy }}">
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                        <input class="form-check-input" type="checkbox" id="customSwitch0" name="mark_as_paid" {{ $detail->mark_as_paid == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customSwitch0">Mark As Paid</label>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label>Due Date <span class="mandatory">*</span></label>
                                    <input type="text" name="due_days" class="form-control numeric" placeholder="Due Days" value="{{ $detail->due_days }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Select Investor<span class="mandatory">*</span></label>
                                    <select class="form-control select2" name="investor_id" required>
                                        <option value="">Select Investor</option>
                                        @forelse(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}" {{ $sv->id == $detail->investor_id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>GRM <span class="mandatory">*</span></label>
                                    <input type="file" name="grm" class="form-control dropify" data-allowed-file-extensions="pdf" data-default-file="{{ asset('uploads/invoice') }}/{{ $detail->uuid }}/{{ $detail->grm }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>LR <span class="mandatory">*</span></label>
                                    <input type="file" name="lr_copy" class="form-control dropify" data-allowed-file-extensions="pdf" data-default-file="{{ asset('uploads/invoice') }}/{{ $detail->uuid }}/{{ $detail->lr_copy }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>E-way bill <span class="mandatory">*</span></label>
                                    <input type="file" name="eway_bill" class="form-control dropify" data-allowed-file-extensions="pdf" data-default-file="{{ asset('uploads/invoice') }}/{{ $detail->uuid }}/{{ $detail->eway_bill }}">
                                </div>

                                <div class="button-items">
                                    <center>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                            Update
                                        </button>
                                        </button>
                                        <a href="{{ url()->previous() }}" class="btn btn-danger waves-effect">
                                            Cancel
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
                 