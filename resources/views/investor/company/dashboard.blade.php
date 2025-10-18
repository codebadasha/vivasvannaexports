@extends('layouts.investor')
@section('title','Dashboard for')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Dashboard for </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard for</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Company Detail</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" border="1">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td>{{ $client->company_name }}</td>
                                        <td><b>GSTN</b></td>
                                        <td>{{ $client->gstn }}</td>
                                        <td><b>PAN</b></td>
                                        <td>{{ $client->pan_number }}</td>

                                    </tr>
                                </table>
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
                        <h4 class="card-title mb-3">Contact Detail</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" border="1">
                                    @if(!is_null($client->contact))
                                        @foreach($client->contact as $ck => $cv)
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td>{{ $cv->name }}</td>
                                                <td><b>Email</b></td>
                                                <td>{{ $cv->email }}</td>
                                                <td><b>Mobile</b></td>
                                                <td>{{ $cv->mobile }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Projects</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.project.index') }}?client={{ $client->id }}">{{ \App\Models\Project::where('client_id',$client->id)->where('is_active',1)->where('is_delete',0)->count() }}</a></h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">Total PO Amount</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.po.index') }}?client={{ $client->id }}">{{ \App\Models\PurchaseOrder::where('client_id',$client->id)->where('is_active',1)->where('is_delete',0)->sum('subtotal') }}</a></h4>
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
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.invoice.index') }}?client={{ $client->id }}">{{ \App\Models\PurchaseOrderInvoice::wherehas('po',function($q) use ($client) { $q->where('client_id',$client->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.invoice.index') }}?client={{ $client->id }}">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->wherehas('po',function($q) use ($client) { $q->where('client_id',$client->id); })->where('is_active',1)->where('is_delete',0)->count() }}</a></h4>
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
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Received Payment</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.invoice.index') }}?client={{ $client->id }}">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->wherehas('po',function($q) use ($client) { $q->where('client_id',$client->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Over Due Amount</p>
                                        <h4 class="mb-0"><a href="{{ route('admin.invoice.index') }}?client={{ $client->id }}">{{ \App\Models\PurchaseOrderInvoice::whereDate('due_date','<',date('Y-m-d'))->where('mark_as_paid',0)->wherehas('po',function($q) use ($client) { $q->where('client_id',$client->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                        <div class="card mini-stats-wid">
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
                                    <th>Item</th>
                                    <th>BOQ Qty</th>
                                    <th>PO Qty</th>
                                    <th>Delivered Qty</th>
                                    <th class='notexport'>Remaining Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($detail))
                                @foreach($detail as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !is_null($ov->po) && !is_null($ov->po->project) ? $ov->po->project->name : '--' }}</td>
                                        <td>{{ !is_null($ov->varation) ? $ov->varation->product->product_type.' '.$ov->varation->grade : '--' }}</td>
                                        <td>{{ $ov->remaining_boq_qty }}</td>
                                        <td>{{ $ov->qty }}</td>
                                        <td>Coming Soon</td>
                                        <td>Coming Soon</td>
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