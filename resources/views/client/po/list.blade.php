@extends('layouts.client')
@section('title','All POs')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Purchase Order</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All POs</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('client.po.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Purchase Order Number</label>
                                    <input class="form-control" name="order_number" value="{{ request()->order_number }}" placeholder="Sales Order Number">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Project</label>
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

                                <div class="col-md-3 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                    <a href="{{ route('client.po.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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
                                @if(!is_null($po))
                                @foreach($po as $ok => $ov)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ov->date)->format('d/m/Y') }}</td>
                                    <td>{{ $ov->project?->name ?? '---' }}</td>
                                    <td>{{ $ov->salesorder_number }}</td>
                                    <td>{{ $ov->reference_number }}</td>
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
                                    <td>
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('client.po.viewpo',base64_encode($ov->id)) }}" role="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger waves-effect waves-light downloadBtn"
                                            data-id="{{ base64_encode($ov->salesorder_id) }}"
                                            role="button"
                                            title="Download Sales Order PDF">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @if(!empty($ov->documents) && count($ov->documents) > 0)
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
                                                            data-url="{{ route('client.po.openDocument') }}"
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
@include('inc.documentModal')
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.downloadBtn', function() {
            let soId = $(this).data('id');
            let url = "{{ route('client.po.download', '') }}/" + soId;
            window.open(url, '_blank');
        });    
    });
    
</script>
@endsection