@extends('layouts.admin')
@section('title','ADD BOQ')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">ADD BOQ</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All BOQ</a></li>
                            <li class="breadcrumb-item active">ADD BOQ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.boq.store') }}" method="post" id="boqForm" enctype="multipart/form-data">
            @csrf  
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
                                    <select class="form-control select2" name="client_id" id="clientId" required>
                                        <option value="">Select Client</option>
                                        @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}">{{ $sv->company_name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                    <span id="client"></span>
                                </div>

                                <div class="col-md-4">
                                    <label>Project <span class="mandatory">*</span></label>
                                    <select class="form-control select2" name="project_id" id="projectId" required>
                                        <option value="">Select Project</option>
                                        @forelse(\App\Models\Project::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                    <span id="project"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Name <span class="mandatory">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="boqItems">
                        <div class="removeBoqItems">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3 item">
                                        <div class="col-md-3 mb-3">
                                            <label>Category <span class="mandatory">*</span></label>
                                            <select class="form-control category" name="item[0][category_id]" data-key="0" data-msg="Please select category" required>
                                                <option value="">Select Category</option>
                                                @forelse(\App\Models\Product::where('is_active',1)->where('is_delete',0)->get() as $pk => $pv)
                                                    <option value="{{ $pv->id }}">{{ $pv->product_type }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Variation <span class="mandatory">*</span></label>
                                            <select class="form-control variation variation0" name="item[0][variation]" data-msg="Please select variation" data-key="0" required>
                                                <option value="">Select Variation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Qty <span class="mandatory">*</span></label>
                                            <input type="text" name="item[0][qty]" class="form-control qty qty0 width" data-msg="Please enter qty" placeholder="Qty" data-id="0" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Unit <span class="mandatory">*</span></label>
                                            <select class="form-control unit0" name="item[0][unit]" data-msg="Please select unit" required>
                                                <option value="">Select Unit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2 mb-3 addNewBoqItems" data-id="1"><i class="fa fa-plus"></i></a>
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
                                    <a href="{{ route('admin.boq.index') }}" class="btn btn-danger waves-effect">
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
    $(document).on('change','.category',function(){
        var element = $(this);
        $.ajax({
            url: "/vivasvanna-admin/boq/get-product-variation",
            type: "POST",
            dataType: "JSON",
            data:{ product_id : $(this).val()},
            success: function(data){
                $('.variation'+element.data('key')).empty().append('<option value="">Select Variation</option>');
                $.each(data,function(key,value){
                    $('.variation'+element.data('key')).append('<option value="'+value.id+'">'+value.grade+'</option>');
                });
            }
        });
    })

    $(document).on('change','.variation',function(){
        var element = $(this);
        $.ajax({
            url: "/vivasvanna-admin/boq/get-unit",
            type: "POST",
            dataType: "JSON",
            data:{ id : $(this).val()},
            success: function(data){
                var arr = data.unit.split(',');
                $('.unit'+element.data('key')).empty().append('<option value="">Select Unit</option>');
                $.each(arr,function(key,value){
                    $('.unit'+element.data('key')).append('<option value="'+value+'">'+value+'</option>');
                });
            }
        });
    })

    $(document).on('click','.addNewBoqItems',function(){
        var id = $(this).data('id');
        
        $.ajax({
            url : '/vivasvanna-admin/boq/get-new-item',
            method:'post',
            data:{ key : id},
            success:function(data){
                $('.boqItems').append(data.html);
            }
        })

        $('input.width').keyup(function() {
            match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
            this.value = match[1] + match[2];
        });

        $('.addNewBoqItems').data('id',++id)
    })

    $(document).on('click','.removeItem',function(){
        $(this).closest('.removeBoqItems').remove();
    })

    $(document).on('change','#clientId, #projectId',function(){
        $('#boqForm').valid();
    })

    $(document).on('submit','#boqForm',function(e){
        e.preventDefault();
        $.ajax({
            url: "/vivasvanna-admin/boq/boq-name",
            type: "POST",
            dataType: "JSON",
            data:{ project_id : $('#projectId').val(), client_id : $('#clientId').val(), name : $('#name').val()},
            success: function(data){
                if(data.status){
                    $('#boqForm')[0].submit();
                } else {
                    toastr.error(data.message)
                }
            } 
        });
    })

    $(document).on('change','#clientId',function(){
        $.ajax({
            url: "/vivasvanna-admin/boq/get-client-project",
            type: "POST",
            dataType: "JSON",
            data:{ client_id : $(this).val()},
            success: function(data){
                $('#projectId').empty().append('<option value="">Select Project</option>');
                $.each(data,function(key,value){
                    $('#projectId').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
        });  
    })
</script>
@endsection
                                