@extends('layouts.admin')
@section('title','Add Supplier Company')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Supplier Company</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Supplier Company List</a></li>
                            <li class="breadcrumb-item active">Add Supplier Company</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <form class="custom-validation" action="{{ route('admin.supplier.store') }}" method="post" id="addSupplier" enctype="multipart/form-data">
            @csrf
            <div class="row">   
                <div class="col-lg-6 offset-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Company Logo</label>
                                <input type="file" name="company_logo" class="form-control dropify" id="companyLogo" placeholder="Company Logo">
                            </div>

                            <div class="form-group mb-3">
                                <label>Company Name <span class="mandatory">*</span></label>
                                <input type="text" name="company_name" class="form-control" id="companyName" placeholder="Company Name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Address <span class="mandatory">*</span></label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label>State <span class="mandatory">*</span></label>
                                <select class="form-control" name="state_id" required>
                                    <option value="">Select State</option>
                                    @forelse(\App\Models\State::all() as $sk => $sv)
                                        <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                                    @empty
                                        <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Contact Number <span class="mandatory">*</span></label>
                                <input type="text" name="mobile_number" class="form-control numeric" id="mobileNumber" placeholder="Contact Number" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="email" name="email_id" class="form-control" id="emailId" placeholder="Email ID " required>
                            </div>

                            <div class="form-group mb-3">
                                <label>GSTN <span class="mandatory">*</span></label>
                                <input type="text" name="gstn" class="form-control" id="gstn" maxlength="15" minlength="15" placeholder="GSTN" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>GSTN File<span class="mandatory">*</span></label>
                                <input type="file" name="gstn_image" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>IEC Code <span class="mandatory">*</span></label>
                                <input type="text" name="iec_code" class="form-control" id="iec_code" placeholder="IEC Code" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>IEC Code File<span class="mandatory">*</span></label>
                                <input type="file" name="iec_code_image" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>PAN Number <span class="mandatory">*</span></label>
                                <input type="text" name="pan_number" maxlength="10" minlength="10" class="form-control" id="panNumber" placeholder="PAN Number" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>PAN Number File <span class="mandatory">*</span></label>
                                <input type="file" name="pancard_image" class="form-control dropify" data-allowed-file-extensions="pdf" required>
                            </div>

                            <div class="authorizedPerson">
                                <label>Authorized Person <span class="mandatory">*</span></label>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Name <span class="mandatory">*</span></label>
                                        <input type="text" name="authorized[0][name]" class="form-control" placeholder="Name" data-msg="Please enter name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="email" name="authorized[0][email]" class="form-control" placeholder="Email" data-msg="Please enter email" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Mobile <span class="mandatory">*</span></label>
                                        <input type="text" name="authorized[0][mobile_number]" class="form-control numeric" placeholder="Mobile Number" data-msg="Please enter mobile number" maxlength="10" minlength="10" required>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-3 addAuthorizedPerson" data-id="1"><i class="fa fa-plus"></i></a>

                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Supplier Products</h3>
                            <div class="products">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Product Title <span class="mandatory">*</span></label>
                                        <input type="text" name="product[0][title]" class="form-control productTitle" placeholder="Name"  data-msg="Please enter product title" data-key="0" required>
                                        <input type="hidden" name="product[0][product_id]" class="productId" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Capacity <span class="mandatory">*</span></label>
                                        <input type="text" name="product[0][capacity]" class="form-control numeric" placeholder="Capacity" data-msg="Please enter capacity" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Unit <span class="mandatory">*</span></label>
                                        <select class="form-control productUnit0" name="product[0][unit]" data-msg="Please select unit" required>
                                            <option value="">Select Units</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-3 addNewProduct" data-id="1"><i class="fa fa-plus"></i></a>
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
                                    <a href="{{ route('admin.supplier.index') }}" class="btn btn-danger waves-effect">
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
    var product = [];
    $(document).on('click','.addAuthorizedPerson',function(){
        var id = $(this).data('id');

        var html = '<div class="row mb-3 authorized"><div class="col-md-4"><label>Name <span class="mandatory">*</span></label><input type="text" name="authorized['+id+'][name]" class="form-control" placeholder="Name" data-msg="Please enter name" required></div><div class="col-md-4"><label>Email <span class="mandatory">*</span></label><input type="email" name="authorized['+id+'][email]" class="form-control" placeholder="Email" data-msg="Please enter email" required></div><div class="col-md-3"><label>Mobile Number <span class="mandatory">*</span></label><input type="text" name="authorized['+id+'][mobile_number]" class="form-control numeric" placeholder="Mobile Number" data-msg="Please enter mobile number" maxlength="10" minlength="10" required></div><div class="col-md-1 mt-4"><a href="javascript:void(0);" class="removeAuthorizedPerson btn btn-danger mt-1"><i class="fa fa-trash"></i></a></div></div>';

        $('.authorizedPerson').append(html);
        $('.addAuthorizedPerson').data('id',++id);
    })
    $(document).on('click','.removeAuthorizedPerson',function(){
        $(this).closest('.authorized').remove();
    })

    $(document).on('click','.addNewProduct',function(){
        var id = $(this).data('id');

        var html = '<div class="mb-3 productRow row"><div class=col-md-4><label>Product Title <span class=mandatory>*</span></label> <input name="product['+id+'][title]" class="form-control productTitle" data-msg="Please enter product title" placeholder="Name" data-key="'+id+'" required> <input name="product['+id+'][product_id]" type="hidden" class="productId"></div><div class="col-md-4"><label>Capacity <span class=mandatory>*</span></label> <input name="product['+id+'][capacity]" class="form-control numeric" data-msg="Please enter capacity" placeholder="Capacity" required type="text"></div><div class=col-md-3><label>Unit <span class=mandatory>*</span></label> <select class="form-control productUnit'+id+'" data-msg="Please select unit" name="product['+id+'][unit]" required><option value="">Select Unit</select></div><div class="col-md-1 mt-4"><a href="javascript:void(0);" class="removeProductRow btn btn-danger mt-1"><i class="fa fa-trash"></i></a></div></div>';

        $('.products').append(html);
        $('.products').data('id',++id);
    })

    $(document).on('click','.removeProductRow',function(){
        $(this).closest('.productRow').remove();
    })

    $(document).on('keypress','.productTitle',function(){
        var element = $(this);
        $.ajax({
            url: "/admin/supplier-company/get-product-list",
            type: "POST",
            dataType: "JSON",
            data:{ title : $(this).val()},
            success: function(data){
                autocompletedatalist = data;
                $('.productTitle').autocomplete({ 
                    source: autocompletedatalist,
                    focus: function(event, ui) {
                        event.preventDefault();
                        this.value = ui.item.label;
                    },
                    select: function(event, ui) {
                        if(jQuery.inArray($(this).val(), product) === -1){
                            product.push(ui.item.label);
                            element.val(ui.item.label);
                            element.siblings('.productId').val(ui.item.value);
                            var arr = ui.item.unit.split(',');
                            $('.productUnit'+element.data('key')).empty().append('<option value="">Select Unit</option>');
                            $.each(arr,function(key,value){
                                $('.productUnit'+element.data('key')).append('<option value="'+value+'">'+value+'</option>');
                            });
                            return false;
                        } else {
                            toastr.error('Same product type can not be added in supplier company')
                            element.val('');
                            return false;
                        }
                    },
                });
            }
        });
    })



</script>
@endsection
                                