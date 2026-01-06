@extends('layouts.admin')
@section('title','All POs')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Sales Order</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All SO</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.so.index') }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                            <option value="{{ $sv->zoho_contact_id }}" {{ request()->client == $sv->zoho_contact_id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Project</label>
                                    <!-- <input class="form-control" name="project" value="{{ request()->project }}" placeholder="Project"> -->
                                    <select class="form-control select2" name="project">
                                        <option value="">Select Project</option>
                                        @forelse(\App\Models\Project::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                        <option value="{{ $sv->id }}" {{ request()->project == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="po_start_date" autocomplete="off" value="{{ request()->po_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="po_end_date" autocomplete="off" value="{{ request()->po_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-2 mt-2">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                    <a href="{{ route('admin.so.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
                                        Reset
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
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
                                    <th>Date</th>
                                    <th>Project name</th>
                                    <th>Sales Order</th>
                                    <th>Reference</th>
                                    <th>Customer Name</th>
                                    <th>Status</th>
                                    <th>Invoiced</th>
                                    <th>Payment</th>
                                    <th>Invoiced Amount</th>
                                    <th>Amount</th>
                                    <th>Expected Shipment Date</th>
                                    <th>Order Status</th>
                                    <th>Delivery Method</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($so))
                                @foreach($so as $ok => $ov)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ov->date)->format('d/m/Y') }}</td>
                                    <td>{{ $ov->project?->name ?? '---' }}</td>
                                    <td>{{ $ov->salesorder_number }}</td>
                                    <td>{{ $ov->reference_number }}</td>
                                    <td>{{ $ov->customer_name }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->status)) }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->invoiced_status)) }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->paid_status)) }}</td>
                                    <td>₹ {{ number_format($ov->total_invoiced_amount, 2, '.', ',') }}</td>
                                    <td>₹ {{ number_format($ov->total, 2, '.', ',') }}</td>
                                    @php
                                    $shipmentDate = \Carbon\Carbon::parse($ov->shipment_date);
                                    $today = \Carbon\Carbon::today();
                                    $overdueDays = $today->gt($shipmentDate) ? $today->diffInDays($shipmentDate) : 0;
                                    @endphp

                                    <td>
                                        {{ $shipmentDate->format('d/m/Y') }}
                                        @if($overdueDays > 0)
                                        <br>
                                        <small class="text-danger">Overdue by {{ $overdueDays }} day{{ $overdueDays > 1 ? 's' : '' }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $ov->order_status }}</td>
                                    <td>{{ $ov->delivery_method }}</td>
                                    <td>
                                        @if(array_key_exists('po',$selectedAction) && in_array('view',$selectedAction['po']))
                                        <a class="btn btn-warning waves-effect waves-light assignProject" href="javascript:void(0);" role="button" title="Edit" data-project_id="{{ $ov->project_id }}" data-id="{{ base64_encode($ov->salesorder_id) }}">
                                            Assign Project
                                        </a>
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.so.viewso',base64_encode($ov->salesorder_id)) }}" role="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif
                                        @if(array_key_exists('po',$selectedAction) && in_array('supplier',$selectedAction['po']))
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger waves-effect waves-light downloadSalesOrderBtn"
                                            data-id="{{ base64_encode($ov->salesorder_id) }}"
                                            role="button"
                                            title="Download Sales Order PDF">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @endif
                                        <!--@if(array_key_exists('po',$selectedAction) && in_array('invoice',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.invoiceList',base64_encode($ov->id)) }}" role="button">
                                                    Upload Invoice
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('edit',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.edit',base64_encode($ov->id)) }}" role="button">
                                                    Edit
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('delete',$selectedAction['po']))
                                                <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.po.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this po?');">
                                                    Delete
                                                </a>
                                            @endif -->
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
<div class="modal fade" id="assignProjectModal" tabindex="-1" aria-labelledby="assignProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="assignForm">
                @csrf
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="assignProjectModalLabel">Assign Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="so_id" id="so_id">
                    <div class="form-group mb-3">
                        <label for="project_id">Select Project</label>
                        <select name="project_id" id="project_id" class="form-control select2" required>
                            <option value="">-- Select Project --</option>
                            @foreach(\App\Models\Project::all() as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.downloadSalesOrderBtn', function() {
            let soId = $(this).data('id');
            let url = "{{ route('admin.so.salesorderdownload', '') }}/" + soId;
            window.open(url, '_blank');
        });

        // When Assign Project button clicked
        $(document).on('click', '.assignProject', function() {
            // Get values from button
            let soId = $(this).data('id');
            let projectId = $(this).data('project_id');

            // Decode base64 values (if present)
            projectId = projectId ? projectId : '';

            // Set hidden SO ID
            $('#so_id').val(soId);

            // Reset selects
            $('#project_id').val('').trigger('change');

            // If data exists, set selected value
            if (projectId) {
                $('#project_id').val(projectId).trigger('change');
            }
            // Open modal
            $('#assignProjectModal').modal('show');
        });


        // Handle form submit (AJAX)
        $('#assignForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.so.assignProject') }}", // route for update
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#assignProjectModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Project assigned successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            location.reload(); // reload to reflect changes
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Something went wrong.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Server error.'
                    });
                }
            });
        });
    });
    $('#assignProjectModal').on('shown.bs.modal', function() {
        $('#project_id').select2({
            dropdownParent: $('#assignProjectModal')
        });
    });
</script>
@endsection