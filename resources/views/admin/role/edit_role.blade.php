@extends('layouts.admin')
@section('title','Edit Role')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Role</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.roleList') }}">Role List</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     

        <form class="custom-validation" action="{{ route('admin.updateRole') }}" method="post" id="addRole" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <input type="hidden" name="id" id="id" value="{{ $role->id }}">

                            <div class="form-group mb-3">
                                <label>Role<span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Role" autocomplete="off" required/ value="{{ $role->name }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label">Module Access<span class="mandatory">*</span></label>
                                <span class="selectAllModule float-right"><input type="checkbox" class="moduleAccess">&nbsp;&nbsp;Select All Module</span>
                                <select class="select2 form-control select2-multiple role_module" multiple="multiple" name="modules[]" id="role_modules" data-placeholder="Select Module(s)" required >
                                    @forelse ($modules as $mk => $mv)
                                        <option value="{{ $mv->id }}" @if(in_array($mv->id,$moduleId)) selected @endif>
                                            {{ $mv->name }}
                                        </option>
                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="module"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label">Role Dashboard Elements</label>
                                <span class="selectAllModule float-right"><input type="checkbox" class="dashboardElement">&nbsp;&nbsp;Select All Dashboard Element</span>
                                <select class="select2 form-control select2-multiple" multiple="multiple" name="elements[]" id="elements" data-placeholder="Select Dashboard Access" >
                                    @forelse ($elements as $ek => $ev)
                                        <option value="{{ $ev->id }}" @if(in_array($ev->id,$elementsId)) selected @endif>
                                            {{ $ev->name }}
                                        </option>
                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="role_dashboard_elements" class="role_dashboard_elements"></span>
                            </div>

                            

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Role Wise Action</h3>
                            <div class="action">
                                @foreach($moduleId as $mk => $mv)
                                    @php $action = config('constants.module')[$mv]; @endphp
                                    <div class="mb-3 action_{{ $mv }}">
                                        <label class="d-block mb-3">{{ $action['name'] }}</label>
                                        @foreach($action['action'] as $ak => $av)
                                            <div class="form-check form-check-inline mb-3">
                                                <input class="form-check-input" type="checkbox" id="{{ $ak }}-{{ $mv }}" value="{{ $ak }}" name="role[{{ $mv }}][]"  {{ in_array($ak,$selected[$mv]) ? 'checked' : ''}} @if($av['selected']) onclick="return false" @endif>
                                                <label class="form-check-label" for="{{ $ak }}-{{ $mv }}">
                                                    {{ $av['name'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
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
                                        Update
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
            $("#role_modules > option").prop("selected","selected");
            $("#role_modules").trigger("change");
        } else {
            console.log('Hello');
            $("#role_modules > option").prop("selected",false);
            $("#role_modules").trigger("change");
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

    $(document).on("select2:unselecting",".role_module",function(e){
        var id = e.params.args.data.id;
        $('.action_'+id).remove();
    });
</script>
@endsection