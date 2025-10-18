@extends('layouts.investor')
@section('title','All Client Company')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Client Company</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Client Company</li>
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

                        <table id="datatable-buttons" class="table table-striped table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Client Name</th>
                                    <th>Registered Address</th>
                                    <th>Director</th>
                                    <th>GSTN</th>
                                    <th>PAN Number</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($client))
                                @foreach($client as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ov->company_name }}</td>
                                        <td>{{ $ov->address }}</td>
                                        <td>{{ $ov->director_name }}</td>
                                        <td>{{ $ov->gstn }}</td>
                                        <td>{{ $ov->pan_number }}</td>
                                        <td>
                                            <a class="btn btn-success waves-effect waves-light" href="{{ route('investor.client.clientDashboard',base64_encode($ov->id)) }}" role="button" title="Dashboard" target="_blank">
                                                Dashboard    
                                            </a>
                                            <a class="btn btn-secondary waves-effect waves-light" href="{{ route('investor.client.downloadCompanyDocumentZip',base64_encode($ov->id)) }}" role="button" title="Edit">
                                                Download    
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-info authorizedPerson" data-id="{{ $ov->id }}">
                                                Users
                                            </a>
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Users</h4>
                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <p>Some text in the modal.</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.authorizedPerson',function(){
         $.ajax({
            url: "/investor-panel/client-company/get-company-authorized-person",
            type: "POST",
            data:{ id : $(this).data('id')},
            success: function(data){
                $('#myModal').modal('show');
                $('#modalBody').html(data);
            }
        });
    })
</script>
@endsection

