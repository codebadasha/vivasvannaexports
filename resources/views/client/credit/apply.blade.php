@extends('layouts.client')
@section('title','Apply For Credit')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Apply For Credit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Apply For Credit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('client.credit.store') }}" method="post" id="creditStatement" enctype="multipart/form-data">
            @csrf  
            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>
                            <h3 class="card-title">Upload 6 month statement</h3><br />
                            <div class="statement">
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label>Statement <span class="mandatory">*</span></label>
                                        <input type="file" name="item[0][statement]" class="form-control" data-msg="Please upload statement" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Bank <span class="mandatory">*</span></label>
                                        <select class="form-control select2" name="item[0][bank]" data-msg="Please select bank" required>
                                            <option value="">Select Bank</option>
                                            @forelse(\App\Models\Bank::all() as $bk => $bv)
                                                <option value="{{ $bv->id }}">{{ $bv->name }}</option>
                                            @empty 
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>  
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2 mb-3 addNewPoItems" data-id="1">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Balance sheet of last three years</h3><br />
                            <div class="row">
                                @for($i = 0; $i < 3; $i++) 
                                    @php 
                                        $fy = date('y') - $i;
                                        $fy_label = ($fy - 1) . "-" . $fy;
                                    @endphp
                                    <div class="col-md-12 mb-3">
                                        <label>Balance sheet for FY {{ $fy_label }}<span class="mandatory">*</span></label>
                                        <input type="file" name="balance[{{ $i }}][file]" class="form-control" data-msg="Please upload statement" required>
                                        <input type="hidden" name="balance[{{ $i }}][label]" class="form-control" value="Balance sheet for FY {{ $fy_label }}">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                    Save
                                </button>
                                <a href="{{ route('client.po.index') }}" class="btn btn-danger waves-effect">
                                    Cancel
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.addNewPoItems',function(){
        var id = $(this).data('id');
        $.ajax({
            url: "/client/credit/get-statement",
            type: "POST",
            data:{key : id},
            success: function(data){
                $('.statement').append(data.html);
                $('.select2').select2();
                $('.addNewPoItems').data('id',++id);
            } 
        });
    });

    $(document).on('click','.removeRow',function(){
        $(this).closest('.row').remove();
    })
</script>
@endsection
