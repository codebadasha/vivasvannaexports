@extends('layouts.admin')
@section('title','Add Product')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Product</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Product List</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.product.store') }}" method="post" id="product" enctype="multipart/form-data">
            @csrf  
            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Product Type <span class="mandatory">*</span></label>
                                <input type="text" name="product_type" class="form-control" id="productType" placeholder="Product Type" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>GST <span class="mandatory">*</span></label>
                                <input type="text" name="gst" class="form-control width" id="gst" placeholder="GST" required>
                            </div>

                            <div class="productVariation">
                                <label>Variation <span class="mandatory">*</span></label>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Grade <span class="mandatory">*</span></label>
                                        <input type="text" name="variation[0][grade]" class="form-control grade" placeholder="Grade" data-msg="Please enter grade" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>HSN Code <span class="mandatory">*</span></label>
                                        <input type="text" name="variation[0][hsn_code]" class="form-control numeric" placeholder="HSN Code" data-msg="Please enter HSN code" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Unit <span class="mandatory">*</span></label>
                                        <select class="form-control select2" name="variation[0][unit][]" multiple required data-msg="Please select unit" data-id="0">
                                            <option value="MT">MT</option>
                                            <option value="KG">KG</option>
                                            <option value="PERBAG">Per Bag</option>
                                        </select>
                                        <span id="unitError0"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Remarks </label>
                                        <textarea class="form-control" name="variation[0][remark]"></textarea>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2 mb-3 addNewVariation" data-id="1"><i class="fa fa-plus"></i></a>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-secondary waves-effect waves-light mr-1" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-danger waves-effect">
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
    $(document).on('click','.addNewVariation',function(){
        var id = $(this).data('id');

        var html = '<div class="mb-3 variation row"><div class=col-md-3><label>Grade <span class=mandatory>*</span></label> <input class="form-control grade" data-msg="Please enter grade"name=variation['+id+'][grade] placeholder=Grade required></div><div class="col-md-2"><label>HSN Code <span class="mandatory">*</span></label><input type="text" name="variation['+id+'][hsn_code]" class="form-control numeric" placeholder="HSN Code" data-msg="Please enter HSN code" required></div><div class=col-md-3><label>Unit <span class=mandatory>*</span></label> <select class="form-control select2"data-msg="Please select unit"multiple name="variation['+id+'][unit][]" data-id="'+id+'" required><option value="MT">MT<option value="KG">KG<option value="PERBAG">Per Bag</select><span id="unitError'+id+'"></span></div><div class=col-md-3><label>Remarks</label> <textarea class=form-control name=variation['+id+'][remark]></textarea></div><div class="col-md-1 mt-4"><a href="javascript:void(0);" class="removeVariation btn btn-danger mt-1"><i class="fa fa-trash"></i></a></div></div>';

        $('.productVariation').append(html);
        $('.select2').select2();
        $('.addNewVariation').data('id',++id);
    })
    $(document).on('click','.removeVariation',function(){
        $(this).closest('.variation').remove();
    })

    var grade = [];

    $(document).on('focusout','.grade',function(){
        if(jQuery.inArray($(this).val(), grade) === -1){
            grade.push($(this).val());
        } else {
            toastr.error('Same grade can not be added under product type')
            $(this).val('');
        }              
    })
</script>
@endsection