@extends('layouts.client')
@section('title','Add Purchase Order')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Purchase Order</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Add Purchase Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('client.po.store') }}" method="post" id="addClientCompany" enctype="multipart/form-data">
            @csrf  
            <div class="row">   
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div><br />

                            <div class="row">
                                <input type="hidden" name="client_id" value="{{ Auth::guard('client')->user()->id }}" />

                                <div class="col-md-4">
                                    <label>Project </label>
                                    <select class="form-control" name="project_id" id="projectId">
                                        <option value="">Select Project</option>
                                        @forelse(\App\Models\Project::where('client_id',Auth::guard('client')->user()->id)->where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>BOQ </label>
                                    <select class="form-control" name="boq_id" id="boqId">
                                        <option value="">Select BOQ</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>PO Number <span class="mandatory">*</span></label>
                                    <input type="text" name="po_number" class="form-control" placeholder="PO Number" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 customItem">
                    <div class="poItems">
                        <div class="removePoItems">
                            <div class="card">
                                <div class="card-body">
                                    <label>Item <span class="mandatory">*</span></label>
                                    <div class="row mb-3 item">
                                        <div class="col-md-4 mb-3">
                                            <label>Product <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][product]" class="form-control product" data-msg="Please select product" placeholder="Product" data-key="0"required>
                                            <input type="hidden" name="item[0][product_id]" value="" class="product_id">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Remaining BOQ Qty</label>
                                            <input type="text" name="item[0][remaining_boq_qty]" class="form-control" placeholder="Remaining BOQ Qty" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Unit <span class="mandatory">*</span></label>
                                            <select class="form-control productUnit0" name="item[0][unit]" data-msg="Please select unit" required>
                                                <option value="">Select Unit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>PO Qty <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][po_qty]" class="form-control normalqty normalqty0 width" data-msg="Please enter PO qty" placeholder="PO Qty" data-id="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Rate Per Unit <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][rate_per_unit]" class="form-control normalrate normalrate0 width" data-msg="Please enter rate per unit" placeholder="Rate Per Unit" data-id="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Freight <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][freight]" class="form-control normalfreight normalfreight0 width" data-msg="Please enter freight" placeholder="Freight" data-id="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Freight Selection <span class="mandatory">*</span></label>
                                            <select class="form-control normalfreightOption normalfreightOption0" name="item[0][fright_selection]" required data-msg="Please select Freight" data-id="0">
                                                <option value="">Select Freight</option>
                                                <option value="1">(Rate + Freight) x Qty</option>
                                                <option value="2">(Rate x Qty) + Freight)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>GST <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][gst]" class="form-control normalgst normalgst0 width" data-msg="Please enter rate per unit" placeholder="GST" data-id="0" value="" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Subtotal <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][subtotal]" class="form-control normalsubtotal normalsubtotal0 width" data-msg="Please enter subtotal" placeholder="Subtotal" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2 mb-3 addNewPoItems" data-id="1"><i class="fa fa-plus"></i></a>
                </div>

                <div class="col-lg-12 boqItem items hide">
                    
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="contactPerson">
                                <div class="row mb-3 contactperson">
                                    <div class="col-md-6">
                                        <label>Subtotal <span class="mandatory">*</span></label>
                                        <input type="text" name="subtotal" class="form-control subtotalInput" data-msg="Please enter subtotal" placeholder="Subtotal" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Upload PO Copy <span class="mandatory">*</span></label>
                                        <input type="file" name="po_copy" class="form-control dropify" data-msg="Please upload po copy" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-secondary waves-effect waves-light mr-1" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('client.po.index') }}" class="btn btn-danger waves-effect">
                                        Cancel
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).on('keyup', '.qty, .rate', function(){
        subtotal($(this).data('id'));
    });

    function subtotal(index){
        var rate = $('.rate'+index).val();
        var qty = $('.qty'+index).val();
        $('.subtotal'+index).val(rate * qty);

        var subtotal = 0;
        $('.subtotal').each(function(){
            subtotal += +this.value; // Convert to number using unary plus
        });
        console.log(subtotal);
        $('.subtotalInput').val(subtotal);
    }

    $(document).on('keypress','.product',function(){
        var element = $(this);
        $.ajax({
            url: "/client/po/product-list",
            type: "POST",
            dataType: "JSON",
            data:{ title : $(this).val()},
            success: function(data){
                autocompletedatalist = data;
                $('.product').autocomplete({ 
                    source: autocompletedatalist,
                    focus: function(event, ui) {
                        event.preventDefault();
                        this.value = ui.item.label;
                    },
                    select: function(event, ui) {
                        element.val(ui.item.label);
                        element.siblings('.product_id').val(ui.item.value);
                        var arr = ui.item.unit.split(',');
                        $('.productUnit'+element.data('key')).empty().append('<option value="">Select Unit</option>');
                        $.each(arr,function(key,value){
                            $('.productUnit'+element.data('key')).append('<option value="'+value+'">'+value+'</option>');
                        });
                        $('.normalgst'+element.data('key')).val(ui.item.gst);
                        return false;
                    },
                });
            }
        });
    })

    $(document).on('click','.addNewPoItems',function(){
        var id = $(this).data('id');
        $('.poItems').append('<div class="removePoItems"><div class="card"><div class="card-body"><a href="javscript:void(0);" class="btn btn-danger removePoItem float-right"><i class="fa fa-trash"></i></a><br /><br/><div class="row mb-3 item"><div class="col-md-4 mb-3"><label>Product <span class="mandatory">*</span></label><input type="text" name="item['+id+'][product]" class="form-control product" data-msg="Please select product" placeholder="Product" data-key="'+id+'" required><input type="hidden" name="item['+id+'][product_id]" value="" class="product_id"></div><div class="col-md-4"><label>Remaining BOQ Qty</label><input type="text" name="item['+id+'][remaining_boq_qty]" class="form-control" placeholder="Remaining BOQ Qty" readonly></div><div class="col-md-4"><label>Unit <span class="mandatory">*</span></label><select class="form-control productUnit'+id+'" name="item['+id+'][unit]" data-msg="Please select unit" required><option value="">Select Unit</option></select></div><div class="col-md-4 mb-3"><label>PO Qty <span class="mandatory">*</span></label><input type="text" name="item['+id+'][po_qty]" class="form-control normalqty normalqty'+id+' width" data-id="'+id+'" data-msg="Please enter PO qty" placeholder="PO Qty" required></div><div class="col-md-4"><label>Rate Per Unit <span class="mandatory">*</span></label><input type="text" name="item['+id+'][rate_per_unit]" class="form-control normalrate normalrate'+id+' width" data-id="'+id+'" data-msg="Please enter rate per unit" placeholder="Rate Per Unit" required></div><div class="col-md-4"><label>Freight <span class="mandatory">*</span></label><input type="text" name="item['+id+'][freight]" class="form-control normalfreight normalfreight'+id+' width" data-msg="Please enter freight" placeholder="Freight" data-id="'+id+'" required></div><div class="col-md-4"><label>Freight Selection <span class="mandatory">*</span></label><select class="form-control normalfreightOption normalfreightOption'+id+'" name="item['+id+'][fright_selection]" required data-msg="Please select Fright" data-id="'+id+'"><option value="">Select Fright</option><option value="1">(Rate + Freight) x Qty</option><option value="2">(Rate x Qty) + Freight)</option></select></div><div class="col-md-4"><label>GST <span class="mandatory">*</span></label><input type="text" name="item['+id+'][gst]" class="form-control normalgst normalgst'+id+' width data-msg="Please enter rate per unit" placeholder="GST" data-id="'+id+'" value="" readonly required></div><div class="col-md-4"><label>Subtotal <span class="mandatory">*</span></label><input type="text" name="item['+id+'][subtotal]" class="form-control normalsubtotal normalsubtotal'+id+' width" data-id="'+id+'" data-msg="Please enter subtotal" placeholder="Subtotal" required></div></div></div></div></div>');

        $('input.width').keyup(function() {
            match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
            this.value = match[1] + match[2];
        });

        $('.addNewPoItems').data('id',++id)
    })

    $(document).on('click','.removePoItem',function(){
        $(this).closest('.removePoItems').remove();
    })

    $(document).on('change','#projectId',function(){
        $.ajax({
            url: "/client/po/get-boq",
            type: "POST",
            dataType: "JSON",
            data:{ project_id : $('#projectId').val()},
            success: function(data){
                $('#boqId').empty().append('<option value="">Select BOQ</option>');
                $.each(data,function(key,value){
                    $('#boqId').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
        });  
    })

    $(document).on('change','#boqId',function(){
        if($(this).val()){
            $('.customItem').addClass('hide');
            $('.boqItem').removeClass('hide');
            $.ajax({
                url: "/client/po/get-boq-item",
                type: "POST",
                dataType: "JSON",
                data:{ boq_id : $(this).val()},
                success: function(data){
                    $('.items').html(data.html);
                }
            });
        } else {
            $('.boqItem').addClass('hide');
            $('.items').empty();
            $('.customItem').removeClass('hide');
        }
    })

    $(document).on('click', '.removeItem', function () {
        $(this).closest('.boqItem').remove();
    });

    $(document).on('focusout', '.boqqty, .boqrate, .freight', function () {
        calculateRowData($(this));
    });
    $(document).on('change', '.freightOption', function () {
        calculateRowData($(this));
    });
    
    function calculateRowData(element) {
        var id = element.data('id');
        var qty = $('.boqqty' + id).val();
        var rate = $('.boqrate' + id).val();
        var freight = $('.freight' + id).val();
        var gst = $('.gst' + id).val();
        var freightOption = $('.freightOption' + id).val();

        console.log("qty"+qty,"rate"+rate,"freight"+freight);
        var part1, part2, subtotal;

        if (freightOption == 1) {
            part1 = (parseFloat(rate) + parseFloat(freight)) * qty;
        } else if (freightOption == 2) {
            part1 = (parseFloat(rate) * parseFloat(qty)) + parseFloat(freight);
        }

        part2 = part1 * gst / 100;
        subtotal = (parseFloat(part1) + parseFloat(part2)).toFixed(2);

        $('.boqsubtotal' + id).val(subtotal);

        var sum = $('.boqsubtotal').toArray().reduce(function (acc, el) {
            return acc + (isNaN(parseFloat($(el).val())) ? 0 : parseFloat($(el).val()));
        }, 0);

        $('.subtotalInput').val(sum);
    }

    $(document).on('focusout', '.normalqty, .normalrate, .normalfreight', function () {
        calculateItemRawData($(this));
    });

    $(document).on('change', '.normalfreightOption', function () {
        calculateItemRawData($(this));
    });
    
    function calculateItemRawData(element) {
        var id = element.data('id');
        var qty = $('.normalqty' + id).val();
        var rate = $('.normalrate'+ id).val();
        var freight = $('.normalfreight' + id).val();
        var gst = $('.normalgst'+ id).val();
        var freightOption = $('.normalfreightOption' + id).val();

        var part1, part2, subtotal;

        if (freightOption == 1) {
            part1 = (parseFloat(rate) + parseFloat(freight)) * qty;
        } else if (freightOption == 2) {
            part1 = (parseFloat(rate) * parseFloat(qty)) + parseFloat(freight);
        }
        console.log('heelloasdasd');
        part2 = part1 * gst / 100;
        subtotal = (parseFloat(part1) + parseFloat(part2)).toFixed(2);

        $('.normalsubtotal' + id).val(subtotal);

        var sum = $('.normalsubtotal').toArray().reduce(function (acc, el) {
            return acc + (isNaN(parseFloat($(el).val())) ? 0 : parseFloat($(el).val()));
        }, 0);

        $('.subtotalInput').val(sum);
    }

</script>
@endsection