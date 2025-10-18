@extends('layouts.admin')
@section('title','Add Role')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Role</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.roleList') }}">Role List</a></li>
                            <li class="breadcrumb-item active">Add Role</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     

        <form class="custom-validation" action="{{ route('admin.saveRole') }}" method="post" id="addRole" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-6 ">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="color:red;float:right;" class=" pull-left">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Role<span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Role" autocomplete="off" required/>
                            </div>

                            <div class="form-group mb-3">
                                <label>Module Access<span class="mandatory">*</span></label>
                                <span class="selectAllModule float-right"><input type="checkbox" class="moduleAccess">&nbsp;&nbsp;Select All Module</span>
                                <select class="form-control select2 role_module" multiple="multiple" name="modules[]" id="role_modules" data-placeholder="Select Module(s)" required >
                                    @forelse ($modules as $mk => $mv)
                                        <option value="{{ $mv->id }}" data-id="{{ $mv->id }}">{{ $mv->name }}</option>
                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="module"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Dashboard Access</label>
                                <span class="selectAllModule float-right"><input type="checkbox" class="dashboardElement">&nbsp;&nbsp;Select All Dashboard Element</span>
                                <select class="select2 form-control select2-multiple" multiple="multiple" name="elements[]" id="elements" data-placeholder="Select Dashboard Access" >
                                    @forelse ($elements as $ek => $ev)
                                        <option value="{{ $ev->id }}">{{ $ev->name }}</option>
                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="element"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Role Wise Action</h3>
                            <div class="action">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
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
                                    <a href="{{ route('admin.roleList') }}" class="btn btn-danger waves-effect">
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
    $(document).on('click','.moduleAccess',function(){
        if($('.moduleAccess').is(':checked') ){
            $('.action').empty();
            $("#role_modules > option").prop("selected","selected");
            $("#role_modules").trigger("change");
            selectAllRole();
        } else {
            $("#role_modules > option").prop("selected",false);
            $("#role_modules").trigger("change");
            $('.action').empty();
         }
    });

    $(document).on('click','.dashboardElement',function(){
        if($('.dashboardElement').is(':checked') ){
            $("#elements > option").prop("selected","selected");
            $("#elements").trigger("change");
        } else {
            $("#elements > option").prop("selected",false);
            $("#elements").trigger("change");
         }
    });

    $(document).on("select2:select",".role_module",function (e) { 
        var role = e.params.data.id;
        $.ajax({
            url : '/admin/role/get-role-action',
            method : 'post',
            data : { role : role },
            success:function(data){
                $('.action').append(data.html);
            }
        })
    })

    function selectAllRole(){
        var role = $('.role_module').val();
        $.ajax({
            url : '/admin/role/get-role-action',
            method : 'post',
            data : { role : role },
            success:function(data){
                $('.action').append(data.html);
            }
        })
    }

    $(document).on("select2:unselecting",".role_module",function(e){
        console.log('hello')
        var id = e.params.args.data.id;
        $('.action_'+id).remove();
    });
</script>
@endsection