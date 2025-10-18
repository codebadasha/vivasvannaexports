@extends('layouts.admin')
@section('title','Add Invoice')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Add Invoice</li>
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
                        <form class="custom-validation" action="{{ route('admin.po.saveInvoice') }}" method="post" id="addClientCompany" enctype="multipart/form-data">
                            @csrf  
                            
                            <input type="hidden" name="po_id" value="{{ $po->id }}">
                            
                            <input type="hidden" name="redirection" value="{{ url()->previous() }}" />

                            <div class="row">
                                <div class="mb-3">
                                    <label>PO Number <span class="mandatory">*</span></label>
                                    <input type="text" name="po_number" class="form-control" placeholder="PO Number" value="{{ $po->po_number }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Invoice Number <span class="mandatory">*</span></label>
                                    <input type="text" name="invoicenumber" class="form-control" placeholder="Invoice Number" required>
                                </div>

                                <div class="mb-3">
                                    <label>Select Product <span class="mandatory">*</span></label>
                                    <select class="form-control" name="product_id" required id="productId">
                                        <option value="">Select Product</option>
                                        @if(!is_null($po->item))
                                            @foreach($po->item as $pk => $pv)
                                                <option value="{{ $pv->id }}">{{ $pv->varation->product->product_type }} - {{ $pv->varation->grade }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>PO Qty</label>
                                    <input type="text" name="po_qty" class="form-control" id="poQty" placeholder="PO Qty" readonly>
                                </div>


                                <div class="mb-3">
                                    <label>Billing Qty <span class="mandatory">*</span></label>
                                    <input type="text" name="billing_qty" class="form-control" id="billingQty" placeholder="Billing Qty" required>
                                </div>

                                <div class="mb-3">
                                    <label>Invoice Amount <span class="mandatory">*</span></label>
                                    <input type="text" name="invoice_amount" class="form-control width" id="invoiceAmount" placeholder="Invoice Amount" required>
                                </div>

                                <div class="mb-3">
                                    <label>Upload Invoice Copy <span class="mandatory">*</span></label>
                                    <input type="file" name="invoice_copy" class="form-control dropify" placeholder="PO Number" data-allowed-file-extensions="pdf" required>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                        <input class="form-check-input" type="checkbox" id="customSwitch0" name="mark_as_paid">
                                        <label class="form-check-label" for="customSwitch0">Mark As Paid</label>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label>Due Days <span class="mandatory">*</span></label>
                                    <input type="text" name="due_days" class="form-control" placeholder="Due Days" value="{{ $po->credit_day }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Due Date <span class="mandatory">*</span></label>
                                    <input type="date" name="due_date" class="form-control" placeholder="Due Days" value="{{ date('Y-m-d',strtotime('+ '.$po->credit_day.'days')) }}" required>
                                </div>


                                <div class="form-group mb-3">
                                    <label>Select Investor<span class="mandatory">*</span></label>
                                    <select class="form-control select2" name="investor_id" required>
                                        <option value="">Select Investor</option>
                                        @forelse(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>GRM <span class="mandatory">*</span></label>
                                    <input type="file" name="grm" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>LR <span class="mandatory">*</span></label>
                                    <input type="file" name="lr_copy" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>E-way bill <span class="mandatory">*</span></label>
                                    <input type="file" name="eway_bill" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                                </div>

                                <div class="button-items">
                                    <center>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                            Save
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
@section('js')
<script type="text/javascript">
    $(document).on('change','#productId',function(){
        if($(this).val() != ''){
            $.ajax({
                type : 'post',
                url : '/admin/po/get-item-detail',
                data : { 
                    id : $(this).val()
                },
                success:function(data){
                    $('#poQty').val(data.qty)
                }
            })
        } else { 
            $('#poQty').val(0)
        }
    })

    $(document).on('keyup','#billingQty',function(){
        if($('#productId').val() != ''){
            var billingQty = $(this).val();
            $.ajax({
                type : 'post',
                url : '/admin/po/get-item-detail',
                data : { 
                    id : $('#productId').val()
                },
                success:function(data){
                    if(data){
                        var qty = data.qty;
                        var total = data.subtotal;
                        var amount = (total * billingQty / qty).toFixed(2);
                        $('#invoiceAmount').val(amount);
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            })
        } else { 
            toastr.error("Please select product first");
        }
    })
</script>
@endsection
