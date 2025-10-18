@extends('layouts.admin')
@section('title','Edit BOQ')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit BOQ</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Edit BOQ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.boq.update') }}" method="post" id="boqForm" enctype="multipart/form-data">
            @csrf  
            <input type="hidden" name="id" id="id" value="{{ $detail->id }}" />
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
                                            <option value="{{ $sv->id }}" {{ $detail->client_id == $sv->id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Project <span class="mandatory">*</span></label>
                                    <select class="form-control select2" name="project_id" id="projectId" required>
                                        <option value="">Select Project</option>
                                        @forelse(\App\Models\Project::where('client_id',$detail->client_id)->where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->id }}" {{ $detail->project_id == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Name <span class="mandatory">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $detail->name }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="boqItems">
                    @if(!is_null($detail->item))
                        @foreach($detail->item as $ik => $iv)
                            <div class="removeBoqItems">
                                <div class="card">
                                    <div class="card-body">
                                        @if($ik > 0)
                                            <a href="javscript:void(0);" class="btn btn-danger float-right removeItem"><i class="fa fa-trash"></i></a><br /><br />
                                        @endif
                                        <div class="row mb-3 item">
                                            <div class="col-md-3 mb-3">
                                                <label>Category <span class="mandatory">*</span></label>
                                                <select class="form-control category" name="item[{{ $ik }}][category_id]" data-msg="Please select category" data-key="{{ $ik }}" required>
                                                    <option value="">Select Category</option>
                                                    @forelse(\App\Models\Product::where('is_active',1)->where('is_delete',0)->get() as $pk => $pv)
                                                        <option value="{{ $pv->id }}" {{ $iv->category_id == $pv->id ? 'selected' : '' }}>{{ $pv->product_type }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Variation <span class="mandatory">*</span></label>
                                                <select class="form-control variation variation0" name="item[{{ $ik }}][variation]" data-msg="Please select variation" data-key="{{ $ik }}" required>
                                                    <option value="">Select Variation</option>
                                                    @forelse(\App\Models\ProductVariation::where('product_id',$iv->category_id)->get() as $pk => $pv)
                                                        <option value="{{ $pv->id }}" {{ $iv->variation_id == $pv->id ? 'selected' : '' }}>{{ $pv->grade }} </option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Qty <span class="mandatory">*</span></label>
                                                <input type="text" name="item[{{ $ik }}][qty]" class="form-control qty width" data-msg="Please enter qty" placeholder="Qty" data-id="0" value="{{ $iv->qty }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Unit <span class="mandatory">*</span></label>
                                                <select class="form-control unit{{ $ik }}" name="item[{{ $ik }}][unit]" data-msg="Please select unit" required>
                                                    <option value="">Select Unit</option>
                                                    @php $unitArray =  \App\Models\ProductVariation::where('id',$iv->variation_id)->first(); @endphp
                                                    @if(!is_null($unitArray))
                                                        @foreach(explode(',',$unitArray->unit) as $uk => $uv)
                                                            <option value="{{ $uv }}" {{ $uv == $iv->unit ? 'selected' : '' }}>{{ $uv }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2 mb-3 addNewBoqItems" data-id="{{ $ik + 1 }}"><i class="fa fa-plus"></i></a>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Update
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger waves-effect">
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
            data:{ project_id : $('#projectId').val(), client_id : $('#clientId').val(), name : $('#name').val(), id : $('#id').val()},
            success: function(data){
                if(data.status){
                    $('#boqForm')[0].submit();
                } else {
                    toastr.error(data.message)
                }
            } 
        });
    })
</script>
@endsection
                                