@extends('layouts.admin')
@section('title','All POs')
@section('content')
@php
    $showActionColumn = !empty(array_intersect(['view','view-document','download'], $selectedAction['po']));
@endphp
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All PO</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All PO</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.po.index') }}">
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="control-label">Purchase Order Number</label>
                                    <input class="form-control" name="order_number" value="{{ request()->order_number }}" placeholder="Purchase Order Number">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse($client as $sk => $sv)
                                            <option value="{{ $sv->zoho_contact_id }}" {{ request()->client == $sv->zoho_contact_id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>PO Uploaded Daterange</label>
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
                                    <a href="{{ route('admin.po.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Purchase Order</th>
                                    <th>Reference</th>
                                    <th>Vendor Name</th>
                                    <th>Status</th>
                                    <th>Billed Status</th>
                                    <th>Amount</th>
                                    <th>Delivery Date</th>
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($po))
                                @foreach($po as $ok => $ov)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ov->date)->format('d/m/Y') }}</td>
                                    <td>{{ $ov->location_name }}</td>
                                    <td>{{ $ov->purchaseorder_number }}</td>
                                    <td>{{ $ov->reference_number }}</td>
                                    <td>{{ $ov->vendor_name }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->status)) }}</td>
                                    <td>{{ Str::title(str_replace('_', ' ', $ov->billed_status)) }}</td>
                                    <td>₹ {{ number_format($ov->total, 2, '.', ',') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ov->delivery_date)->format('d/m/Y') }}</td>
                                    @if($showActionColumn)
                                    <td>
                                        @if(array_key_exists('po',$selectedAction) && in_array('view',$selectedAction['po']))
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.viewPurchaseOrder',base64_encode($ov->purchaseorder_id)) }}" role="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger waves-effect waves-light downloadPurchaseOrderBtn"
                                            data-id="{{ base64_encode($ov->purchaseorder_id) }}"
                                            role="button"
                                            title="Download Sales Order PDF">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @endif
                                        <!-- @if(array_key_exists('po',$selectedAction) && in_array('supplier',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.poItems',base64_encode($ov->purchaseorder_id)) }}" role="button">
                                                    Assign Supplier
                                                </a>
                                            @endif -->
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
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.downloadPurchaseOrderBtn', function() {
            let soId = $(this).data('id');
            let url = "{{ route('admin.po.purchaseorderdownload', '') }}/" + soId;
            window.open(url, '_blank');
        });
    });
</script>
@endsection