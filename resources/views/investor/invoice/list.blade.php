@extends('layouts.investor')
@section('title','All Invoices')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Invoices for PO {{ $po->po_number }} of Project - 1</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('investor.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Invoices</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('investor.po.invoiceList',$id) }}">
                            <div class="row">  
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Invoice Uploaded Daterange</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="upload_start_date" autocomplete="off" value="{{ request()->upload_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="upload_end_date" autocomplete="off" value="{{ request()->upload_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Invoice Due Daterange</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="due_start_date" autocomplete="off" value="{{ request()->due_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="due_end_date" autocomplete="off" value="{{ request()->due_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <label class="control-label">Invoice Status</label>
                                    <select class="form-select" name="status">
                                        <option value="" selected>All</option>
                                        <option value="1" {{ request()->status == 1 ? 'selected' : '' }}>Paid</option>
                                        <option value="2" {{ request()->status == 2 ? 'selected' : '' }}>Un Paid</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Invoice Number</label>
                                    <input class="form-control" name="invoice_number" value="{{ request()->invoice_number }}" placeholder="Invoice Number">
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                        <a href="{{ route('investor.po.invoiceList',$id) }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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
                                    <th>Sr. No</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Amount</th>
                                    <th>Invoice Uploaded On</th>
                                    <th>Invoice Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($invoice))
                                @foreach($invoice as $ik => $iv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $iv->invoice_number }}</td>
                                        <td>{{ $iv->invoice_amount }}</td>
                                        <td>{{ date('d/m/Y',strtotime($iv->created_at)) }}</td>
                                        <td>{{ date('d/m/Y',strtotime($iv->due_date)) }}</td>
                                        <td>{{ $iv->mark_as_paid == 1 ? 'Paid' : 'Unpaid' }}</td>
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