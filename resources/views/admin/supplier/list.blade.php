@extends('layouts.admin')
@section('title','All Supplier Company')
@section('content')
@php
    $showActionColumn = !empty(array_intersect(['edit','delete','authorized'], $selectedAction['supplier-company']));
@endphp
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Supplier Company</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Supplier Company</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="text-end mb-4">
                    @if(array_key_exists('supplier-company',$selectedAction) && in_array('add',$selectedAction['supplier-company']))
                    <a href="{{ route('admin.supplier.create') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Add</a>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Company Name</th>
                                    <!-- <th>Address</th> -->
                                    <th width="200">Contact Info</th>
                                    <!-- <th>GSTN</th>
                                    <th>IEC Code</th>
                                    <th>PAN Number</th> -->
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($supplier))
                                @foreach($supplier as $ok => $ov)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ov->company_name }}</td>
                                   
                                    <!-- addr = $ov->addresses->first(); // Only billing address is loaded -->
                                    
                                    <!-- <td>
                                        
                                         collect([
                                            $addr->address,
                                            $addr->street2,
                                            trim("{$addr->city}, {$addr->state}", ' ,'),
                                            trim("{$addr->country} - {$addr->zip}", ' -'),
                                            ])
                                        ->filter() // remove empty/null values
                                        ->implode('<br>') 
                                  

                                        
                                    </td> -->
                                    <td>
                                        Email : <b>{{ $ov->email ?? $ov->email }}</b>
                                        <br>Mobile : {!! !empty($ov->mobile) ? '<b>'.$ov->mobile.'</b>' : '' !!}
                                    </td>
                                    <!-- <td>{{ $ov->gstn }}</td>
                                    <td>{{ $ov->pancard }}</td>
                                    <td>{{ $ov->iec_code }}</td> -->
                                     @if($showActionColumn)
                                    <td>
                                        @if(array_key_exists('supplier-company',$selectedAction) && in_array('authorized',$selectedAction['supplier-company']))
                                        <a href="javascript:void(0);" class="btn btn-info authorizedPerson mb-2" data-id="{{ $ov->id }}">
                                            Contact Person
                                        </a>
                                        <br>
                                        @endif
                                        @if(array_key_exists('supplier-company',$selectedAction) && in_array('edit',$selectedAction['supplier-company']))
                                        <a class="btn btn-primary waves-effect waves-light mb-2" href="{{ route('admin.supplier.edit',base64_encode($ov->id)) }}" role="button">
                                            Edit
                                        </a>
                                        <br>
                                        @endif
                                        @if(array_key_exists('supplier-company',$selectedAction) && in_array('delete',$selectedAction['supplier-company']))
                                        <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.supplier.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this supplier company?');">
                                            Delete
                                        </a>
                                        @endif
                                    </td>
                                    @endif
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
                <h4 class="modal-title">Authorized Person</h4>
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
    $(document).on('click', '.authorizedPerson', function() {
        $.ajax({
            url: "/admin/supplier-company/get-authorized-person",
            type: "POST",
            data: {
                id: $(this).data('id')
            },
            success: function(data) {
                $('#myModal').modal('show');
                $('#modalBody').html(data);
            }
        });
    })
</script>
@endsection