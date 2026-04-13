@extends('layouts.admin')
@section('title','All SOs')
@section('content')
@php
    $showActionColumn = !empty(array_intersect(['view','view-document','download'], $selectedAction['so']));
@endphp

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Sales Order</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Main Dashboard</a>
                            </li>
                            @if(request()->has('from_client') && request()->from_client == 1 && isset($client))
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.client.clientDashboard', base64_encode($client->id)) }}">
                                        {{ $client->company_name }} Dashboard
                                    </a>
                                </li>
                            @endif
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
                                <div class="col-md-4">
                                    <label class="control-label">Sales Order Number</label>
                                    <input class="form-control" name="order_number" value="{{ request()->order_number }}" placeholder="Sales Order Number">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse($clients as $sk => $sv)
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
                                        @forelse($projects as $sk => $sv)
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

                                <div class="col-md-2 mt-4">
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
                    @if(array_key_exists('so',$selectedAction) && in_array('assign-project',$selectedAction['so']))
                    <div class="card-header">
                        <button type="button"
                                class="btn btn-warning waves-effect waves-light float-right"
                                data-bs-toggle="modal"
                                data-bs-target="#assignProjectModal">
                            Assign Project
                        </button>
                    </div>
                    @endif
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order details</th>
                                    <th>Customer Name</th>
                                    <th>Status</th>
                                    <th>Invoiced</th>
                                    <th>Payment</th>
                                    <th>Invoiced Amount</th>
                                    <th>Amount</th>
                                    <th>Expected Shipment Date</th>
                                    <th>Order Status</th>
                                    <th>Delivery Method</th>
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($so))
                                @foreach($so as $ok => $ov)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ov->date)->format('d/m/Y') }}</td>
                                    <td>
                                        Order Number :- <b>{{ $ov->salesorder_number ?? '---' }}</b><br>
                                        Project Name :- <b>{{ $ov->project?->name ?? '---' }}</b><br>
                                        Reference Number :- <b>{{ $ov->reference_number ?? '---' }}</b><br>
                                    </td>
                                    <td>{{ $ov->customer_name ?? '---' }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->current_sub_status == 'open' ? 'Confirmed' : $ov->current_sub_status)) }}</td>
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
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->current_sub_status == 'open' ? 'Confirmed' : $ov->current_sub_status)) }}</td>
                                    <td>{{ $ov->delivery_method }}</td>
                                    @if($showActionColumn)
                                    <td>
                                        @if(array_key_exists('so',$selectedAction) && in_array('view',$selectedAction['so']))
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.so.viewso',base64_encode($ov->id)) }}" role="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif
                                        @if(array_key_exists('so',$selectedAction) && in_array('download',$selectedAction['so']))
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger waves-effect waves-light downloadSalesOrderBtn"
                                            data-id="{{ base64_encode($ov->zoho_salesorder_id) }}"
                                            role="button"
                                            title="Download Sales Order PDF">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @endif
                                        @if(!empty($ov->documents) && count($ov->documents) > 0 && array_key_exists('so',$selectedAction) && in_array('view-document',$selectedAction['so']))
                                            <div class="btn-group">
                                                <button type="button" 
                                                    class="btn btn-info dropdown-toggle waves-effect waves-light"
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                    <i class="fa fa-paperclip"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="min-width: 250px;">
                                                    @foreach($ov->documents as $index => $doc)
                                                        <li>
                                                            <a class="dropdown-item openDocument" 
                                                            data-token="{{ csrf_token() }}"
                                                            data-type="salesorders"
                                                            data-url="{{ route('admin.so.openDocument') }}"
                                                            data-id="{{ $ov->zoho_salesorder_id }}"
                                                            data-document-id="{{ $doc['document_id'] }}"
                                                            href="javascript:void(0);">
                                                                @if($doc['file_type'] == 'pdf')
                                                                <i class="fa fa-file-pdf" style="margin-right: 6px; font-size: 20px;"></i>
                                                                @else
                                                                <i class="fas fa-image" style="margin-right: 6px; font-size: 20px;"></i>
                                                                @endif
                                                                {{ $doc['file_name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
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
<div class="modal fade" id="assignProjectModal" tabindex="-1" aria-labelledby="assignProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.so.assignProject') }}"  method="post">
                @csrf
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="assignProjectModalLabel">Assign Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="project_id">Select Project</label>
                        <select name="project_id" id="project_id" class="form-control select2" required>
                            <option value="">-- Select Project --</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" data-id="{{$project->zoho_client_id}}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="salesorders">Select SalesOrder</label>
                        <select name="salesorders[]" id="salesorders" class="form-control select2" multiple required disable>
                            <option value="">-- Select SalesOrder --</option>
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
@include('inc.documentModal')
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('submit', '#assignProjectModal form', function(e) {
            e.preventDefault();

            let form = $(this);
            let submitBtn = form.find('button[type="submit"]');

            // Disable button
            submitBtn.prop('disabled', true);

            // Show SweetAlert Loader
            Swal.fire({
                title: 'Please Wait...',
                text: 'Assigning Project...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: form.serialize(),
                success: function(data) {
                    Swal.close();
                    if (data.status) {
                        toastr.success(data.message);
                        $('#assignProjectModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {
                        toastr.error(data.message);
                        submitBtn.prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    toastr.error(data.message);
                    submitBtn.prop('disabled', false);
                }
            });
        });
        
        $(document).on('click', '.downloadSalesOrderBtn', function() {
            let soId = $(this).data('id');
            let url = "{{ route('admin.so.salesorderdownload', '') }}/" + soId;
            window.open(url, '_blank');
        });

    });
</script>
<script>
    const salesOrdersData = @json($so);
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#assignProjectModal').on('shown.bs.modal', function() {
            $('#project_id').select2({
                dropdownParent: $('#assignProjectModal')
            });
            $('#salesorders').select2({
                dropdownParent: $('#assignProjectModal')
            });
        });
        
        $(document).on('change', '#assignProjectModal #project_id', function () {
            $('#salesorders').prop('disabled', true);
            const selectedOption = $(this).find(':selected');
            const zohoClientId = selectedOption.data('id');
            const id = selectedOption.val();
        
            const clientId = $(this).val();

            // Enable salesorder dropdown
            $('#assignProjectModal #salesorders').prop('disabled', false);
            $('#assignProjectModal #salesorders').val('').trigger('change');
            // Clear existing options
            $('#assignProjectModal #salesorders').empty();

            // Add default option
            $('#assignProjectModal #salesorders').append('<option value="">-- Select SalesOrder --</option>');

            // Loop through JS salesOrdersData
            salesOrdersData.forEach(function (so) {

                // Match customer_id with zoho_client_id
                if (so.customer_id == zohoClientId) {
                    let selected = '';
                    if(so.project_id == id){
                        selected = 'selected';
                    }
                    $('#assignProjectModal #salesorders').append(
                        `<option value="${so.id}" ${selected}>
                            ${so.salesorder_number}
                        </option>`
                    );
                }
            });

            // Refresh Select2
            
        });

        $(document).on('hidden.bs.modal', '#assignProjectModal', function () {

            $('#assignProjectModal #salesorders')
                .val(null)
                .trigger('change');

            $('#assignProjectModal #project_id')
                .val(null)
                .trigger('change');
        });
    });
</script>
@endsection