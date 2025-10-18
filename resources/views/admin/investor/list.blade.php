@extends('layouts.admin')
@section('title','All Investor')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Investor</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Investor</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="text-end mb-4">
                    @if(array_key_exists('investor',$selectedAction) && in_array('add',$selectedAction['investor']))
                    <a href="{{ route('admin.investor.create') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Add</a>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Investor Name</th>
                                    <th>Mobile Number</th>
                                    <th>Email ID</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($investors))
                                @foreach($investors as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ov->name }}</td>
                                        <td>{{ $ov->mobile }}</td>
                                        <td>{{ $ov->email }}</td>
                                        <td>
                                            @if(array_key_exists('investor',$selectedAction) && in_array('edit',$selectedAction['investor']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.investor.edit',base64_encode($ov->id)) }}" role="button">
                                                    Edit
                                                </a>
                                            @endif
                                            @if(array_key_exists('investor',$selectedAction) && in_array('delete',$selectedAction['investor']))
                                                <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.investor.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this investor?');">
                                                    Delete
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection