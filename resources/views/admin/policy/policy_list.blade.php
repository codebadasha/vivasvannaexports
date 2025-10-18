@extends('layouts.admin')
@section('title','Policy List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Policies</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Policies</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($policy))
                                @foreach($policy as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->title }}</td>
                                        <td>
                                            @if(array_key_exists('policy',$selectedAction) && in_array('edit',$selectedAction['policy']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{route('admin.editPolicy',$gv->key)}}" role="button">Edit
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