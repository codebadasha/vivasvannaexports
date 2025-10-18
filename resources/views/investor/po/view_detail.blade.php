@extends('layouts.investor')
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
                            <li class="breadcrumb-item"><a href="{{ route('investor.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">View Purchase Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('investor.po.update') }}" method="post" id="addClientCompany" enctype="multipart/form-data">
            @csrf  
            <input type="hidden" name="id" value="{{ $detail->id }}" />
            <div class="row">   
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div><br />

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Client <span class="mandatory">*</span></label>
                                    <select class="form-control" name="client_id" disabled required>
                                        <option value="">Select Client</option>
                                        @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}" {{ $sv->id == $detail->client_id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Project </label>
                                    <select class="form-control" name="project_id" disabled>
                                        <option value="">Select Project</option>
                                        <option value="1" {{ $detail->project_id == 1 ? 'selected' : '' }}>Project 1</option>
                                        <option value="2" {{ $detail->project_id == 2 ? 'selected' : '' }}>Project 2</option>
                                        <option value="3" {{ $detail->project_id == 3 ? 'selected' : '' }}>Project 3</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>BOQ </label>
                                    <select class="form-control" name="boq_id" disabled>
                                        <option value="">Select BOQ</option>
                                        <option value="1" {{ $detail->boq_id == 1 ? 'selected' : '' }}>BOQ 1</option>
                                        <option value="2" {{ $detail->boq_id == 2 ? 'selected' : '' }}>BOQ 2</option>
                                        <option value="3" {{ $detail->boq_id == 3 ? 'selected' : '' }}>BOQ 3</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>PO Number <span class="mandatory">*</span></label>
                                    <input type="text" name="po_number" class="form-control" placeholder="PO Number" value="{{ $detail->po_number }}" disabled required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <h4 class="mb-3 font-size-18">PO Items</h4>
                <div class="col-lg-12">
                    <div class="poItems">
                    @if(!is_null($detail->item))
                        @foreach($detail->item as $ik => $iv)
                            <div class="removePoItems">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row mb-3 item">
                                            <div class="col-md-4 mb-3">
                                                <label>Product <span class="mandatory">*</span></label>
                                                <input type="text" name="item[{{ $ik }}][product]" class="form-control product" data-msg="Please select product" placeholder="Product" data-key="{{ $ik }}" value="{{ $iv->varation->product->product_type }} - {{ $iv->varation->grade }}" disabled required>
                                                <input type="hidden" name="item[{{ $ik }}][product_id]" value="{{ $iv->category_id }}" class="product_id">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Remaining BOQ Qty</label>
                                                <input type="text" name="item[{{ $ik }}][remaining_boq_qty]" class="form-control width" value="{{ $iv->remaining_boq_qty ? $iv->remaining_boq_qty : 0}}" placeholder="Remaining BOQ Qty" disabled>
                                            </div>
                                            @php $unitValue = explode(',',$iv->varation->unit); @endphp
                                            <div class="col-md-4">
                                                <label>Unit <span class="mandatory">*</span></label>
                                                <select class="form-control productUnit{{ $ik }}" name="item[{{ $ik }}][unit]" data-msg="Please select unit" disabled required>
                                                    <option value="">Select Unit</option>   
                                                    @foreach($unitValue as $uk => $uv)
                                                        <option value="{{ $uv }}" {{ $uv == $iv->unit ? 'selected' : '' }}>{{ $uv }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PO Qty <span class="mandatory">*</span></label>
                                                <input type="text" name="item[{{ $ik }}][po_qty]" class="form-control qty qty{{ $ik }} width" data-msg="Please enter PO qty" placeholder="PO Qty" value="{{ $iv->qty }}" data-id="{{ $ik }}" disabled required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Rate Per Unit <span class="mandatory">*</span></label>
                                                <input type="text" name="item[{{ $ik }}][rate_per_unit]" class="form-control rate rate{{ $ik }} width" data-msg="Please enter rate per unit" placeholder="Rate Per Unit" value="{{ $iv->rate }}" data-id="{{ $ik }}" disabled required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Subtotal <span class="mandatory">*</span></label>
                                                <input type="text" name="item[{{ $ik }}][subtotal]" class="form-control subtotal subtotal{{ $ik }} width" data-msg="Please enter subtotal" placeholder="Subtotal" value="{{ $iv->subtotal }}" disabled required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="contactPerson">
                                <div class="row mb-3 contactperson">
                                    <div class="col-md-6">
                                        <label>Subtotal <span class="mandatory">*</span></label>
                                        <input type="text" name="subtotal" class="form-control subtotalInput" data-msg="Please enter subtotal" value="{{ $detail->subtotal }}" placeholder="Subtotal" disabled required>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ asset('uploads/po') }}/{{ $detail->po_copy }}" class="btn btn-danger mt-4" target="_blank">Download PO</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
