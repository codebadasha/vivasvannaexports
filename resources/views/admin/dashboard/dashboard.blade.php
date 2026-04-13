@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
@php
$receivedAmount = \App\Models\SalesOrderInvoice::sum(\DB::raw('total - balance'));
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard {{ Auth::guard('admin')->user()->role_id }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> 

        @php $element = \App\Models\RoleElement::where('role_id',Auth::guard('admin')->user()->role_id)->pluck('element_id')->toArray(); @endphp


        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    @if(in_array(1,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid" style="height: -webkit-fill-available;">
                                <a href="{{ route('admin.project.index') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Projects</p>
                                                <h4 class="mb-0">{{ $data['total_projects']}}</h4>
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
                    @endif
                    @if(in_array(2,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('admin.so.index') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Sales Order</p>
                                                <h4 class="mb-0">{{ $data['total_so_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['total_so_amount'], 2, '.', ',') }}</h5>
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
                    @endif
                    @if(in_array(3,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('admin.so.allinvoice.index') }}">
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
                                </a>
                            </div>
                        </div>
                    @endif
                    @if(in_array(4,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('admin.so.allinvoice.index', ['status' => 1]) }}">
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
                                </a>
                            </div>
                        </div>
                    @endif
                    @if(in_array(6,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('admin.so.allinvoice.index', ['status' => 3]) }}">
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
                                </a>
                            </div>
                        </div>
                    @endif
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
        @if(in_array(7,$element))
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
                                        <th>So Number</th>
                                        <th>Item</th>
                                        <th>So Qty</th>
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
        @endif
    </div>
</div>
@endsection