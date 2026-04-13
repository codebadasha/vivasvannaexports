@extends('layouts.investor')
@section('title','Dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid" style="height: -webkit-fill-available;">
                            <a href="{{ route('investor.project.index') }}">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Projects</p>
                                            <h4 class="mb-0">{{ $data['total_projects'] }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <a href="{{ route('investor.po.index') }}">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Purchase Orders</p>
                                            <h4 class="mb-0">{{ $data['total_po_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['total_po_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0">{{ $data['total_invoice_count'] }}</h4>
                                        <h5 class="mb-0">₹ {{ number_format($data['total_invoice_amount'], 2, '.', ',') }}</h5>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('investor.invoice.index') }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Assigned Invoice</p>
                                            <h4 class="mb-0">{{ $data['total_assigned_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['total_assigned_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('investor.invoice.index', ['status' => 1]) }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Paid Invoices</p>
                                            <h4 class="mb-0">{{ $data['paid_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['paid_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('investor.invoice.index', ['status' => 3]) }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Overdue Invoices</p>
                                            <h4 class="mb-0">{{ $data['overdue_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['overdue_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid" style="height: -webkit-fill-available;">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Interest on Over Dues</p>
                                        <h4 class="mb-0">Coming Soon</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Project</th>
                                    <th>Client</th>
                                    <th>PO Number</th>
                                    <th>Item</th>
                                    <th>PO Qty</th>
                                    <th>Delivered Qty</th>
                                    <th class='notexport'>Remaining Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @if($items->isNotEmpty())
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $item->salesOrder?->project?->name ?? '---' }}
                                            </td>
                                            <td>
                                                {{ $item->salesOrder?->company_name ?? '---' }}
                                            </td>
                                            <td>
                                                {{ $item->salesOrder?->salesorder_number ?? '--' }}
                                            </td>
                                            <td>
                                                {{ $item->name ?? '---' }}
                                            </td>
                                            <td>
                                                {{ intval($item->quantity) }} {{ $item->unit ?? '' }}
                                            </td>
                                            <td>
                                                {{ number_format($item->delivered_quantity, 2) }} {{ $item->unit ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $delivered = $item->delivered_quantity;
                                                    $remaining = max(0, $item->quantity - $delivered);
                                                @endphp
                                                {{ number_format($remaining, 2) }} {{ $item->unit ?? '' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No records found</td>
                                        </tr>
                                    @endif
                                </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
@endsection