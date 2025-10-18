@extends('layouts.admin')
@section('title','Assign Supplier')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Assign Supplier</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Assign Supplier</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.po.postSupplierItem') }}" id="poItems">
                            @csrf
                            <input type="hidden" name="po_id" value="{{ base64_decode($poId) }}" />
                            @if(!is_null($getItems))
                                @foreach($getItems as $gk => $gv)
                                    <div class="mb-5">
                                        <h4>{{ $gv->varation->product->product_type }} - {{ $gv->varation->grade }} - Qty : {{ $gv->qty }}</h4>
                                        <div class="supplier supplier{{ $gv->id }}">
                                            @if(count($gv->item) > 0)
                                                @foreach($gv->item as $ik => $iv)
                                                    <div class="row removeItem">
                                                        <div class="col-lg-5 mb-3">
                                                            <label>Supplier <span class="mandatory">*</span></label>
                                                            <input type="text" name="data[{{ $gv->id }}][{{ $ik }}][supplier_name]" class="form-control supplier" placeholder="Supplier" value="{{ $iv->supplier->company_name }}" data-msg="Please enter qty" required>
                                                            <input type="hidden" class="supplierId" name="data[{{ $gv->id }}][{{ $ik }}][supplier_id]" value="{{ $iv->supplier_id }}">
                                                        </div>
                                                        <div class="col-lg-5 mb-3">
                                                            <label>Qty <span class="mandatory">*</span></label>
                                                            <input type="text" name="data[{{ $gv->id }}][{{ $ik }}][qty]" class="form-control width" placeholder="Qty" data-msg="Please enter qty" value="{{ $iv->qty }}" required>
                                                        </div>
                                                        @if($ik > 0)
                                                            <div class="col-lg-2 mb-3">
                                                                <a href="javascript:void(0)" class="btn btn-danger mt-4 remove"><i class="fa fa-trash mt-1"></i></a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row">
                                                    <div class="col-lg-5 mb-3">
                                                        <label>Supplier <span class="mandatory">*</span></label>
                                                        <input type="text" name="data[{{ $gv->id }}][0][supplier_name]" class="form-control supplier" placeholder="Supplier" required>
                                                        <input type="hidden" class="supplierId" name="data[{{ $gv->id }}][0][supplier_id]" value="">
                                                    </div>
                                                    <div class="col-lg-5 mb-3">
                                                        <label>Qty <span class="mandatory">*</span></label>
                                                        <input type="text" name="data[{{ $gv->id }}][0][qty]" class="form-control width" placeholder="Qty" value="" data-msg="Please enter qty" required>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <a href="javascript:void(0);" class="btn btn-primary addNewItem btn-sm" data-id="{{ $gv->id }}" data-value="1"><i class="fa fa-plus"></i></a>
                                    </div>
                                @endforeach
                            @endif

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
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.addNewItem',function(){
        var item = $(this);
        var id = item.data('id');
        var value = item.data('value');
        var html =  '<div class="row removeItem"><div class="col-lg-5 mb-3"><label>Supplier <span class="mandatory">*</span></label><input type="text" name="data['+id+']['+value+'][supplier_name]" class="form-control supplier" placeholder="Supplier" required><input type="hidden" class="supplierId" name="data['+id+']['+value+'][supplier_id]" value=""></div><div class="col-lg-5 mb-3"><label>Qty <span class="mandatory">*</span></label><input type="text" name="data['+id+']['+value+'][qty]" class="form-control width" placeholder="Qty" required></div><div class="col-lg-2 mb-3"><a href="javascript:void(0)" class="btn btn-danger mt-4 remove"><i class="fa fa-trash mt-1"></i></a></div></div>';
        $('.supplier'+id).append(html);
        $('input.width').keyup(function() {
            match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
            this.value = match[1] + match[2];
        });
        $(this).data('value',++value);
    })

    $(document).on('click','.remove',function(){
        $(this).closest('.removeItem').remove();
    })

    $(document).on('keypress','.supplier',function(){
        var element = $(this);
        $.ajax({
            url: "/vivasvanna-admin/po/supplier-list",
            type: "POST",
            dataType: "JSON",
            data:{ title : $(this).val()},
            success: function(data){
                autocompletedatalist = data;
                element.autocomplete({ 
                    source: autocompletedatalist,
                    focus: function(event, ui) {
                        event.preventDefault();
                        this.value = ui.item.label;
                    },
                    select: function(event, ui) {
                        element.val(ui.item.label);
                        element.siblings('.supplierId').val(ui.item.value);
                        return false;
                    },
                });
            }
        });
    })
</script>
@endsection