@extends('layouts.client')
@section('title','All Projects')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Credit Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Credit Request</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-end mb-4">
                    <a href="{{ route('client.credit.apply') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Request</a>
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Credit Amount</th>
                                    <th>Status</th>
                                    <th>Step</th>
                                    <th>Reason</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($creditRequests))
                               @foreach($creditRequests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ number_format($request->credit_amount,2) }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                        {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_',' ',$request->request_step)) }}</td>
                                    <td>{{ $request->reason }}</td>
                                    <td>{{ date('d/m/Y',strtotime($request->created_at)) }}</td>
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
<div class="modal fade" id="overdueIntrestSetting" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Project Description</h4>
                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBodyIntrest">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.viewDescription',function(){
        $('#modalBodyIntrest').text($(this).data('content'));
        $('#overdueIntrestSetting').modal('show');
    })
</script>
@endsection