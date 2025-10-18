@extends('layouts.admin')
@section('title','All Roles')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Roles</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Roles</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Role</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($roles))
                                    @foreach($roles as $rk => $rv)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rv->name }}</td>
                                            <td>
                                                @if($rk != 0)
                                                    @if(array_key_exists('role',$selectedAction) && in_array('edit',$selectedAction['role']))
                                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.editRole',base64_encode($rv->id)) }}" role="button" title="Edit">Edit </a>
                                                    @endif
                                                    @if(array_key_exists('role',$selectedAction) && in_array('delete',$selectedAction['role']))
                                                        <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.deleteRole',base64_encode($rv->id)) }}" role="button" onclick="return confirm('Do you want to delete this role?');" title="Delete">
                                                            Delete
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection