@extends('layouts.admin')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard {{ Auth::guard('admin')->user()->role_id }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> 

        @php $element = \App\Models\RoleElement::where('role_id',Auth::guard('admin')->user()->role_id)->pluck('element_id')->toArray(); @endphp

        <div class="row mb-3">
            <div class="col-xl-12">
                <a href="{{ route('admin.po.addAllInvoice') }}" class="btn btn-primary float-right" ><i class="fa fa-plus"></i> Add Invoice</a>
                <a href="{{ route('admin.po.create') }}" class="btn btn-danger float-right mr-2" style="margin-right:10px"><i class="fa fa-plus"></i> Add PO</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    @if(in_array(1,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Projects</p>
                                            <h4 class="mb-0">{{ \App\Models\Project::where('is_active',1)->where('is_delete',0)->count() }}</h4>
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
                    @endif
                    @if(in_array(2,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">Total PO Amount</p>
                                            <h4 class="mb-0">{{ \App\Models\PurchaseOrder::where('is_active',1)->where('is_delete',0)->sum('subtotal') }}</h4>
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
                    @endif
                    @if(in_array(3,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Invoice Raised</p>
                                            <h4 class="mb-0">{{ \App\Models\PurchaseOrderInvoice::where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</h4>
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
                    @endif
                    @if(in_array(4,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Invoice Paid</p>
                                            <h4 class="mb-0">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->where('is_active',1)->where('is_delete',0)->count() }}</h4>
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
                    @endif
                    @if(in_array(5,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Received Payment</p>
                                            <h4 class="mb-0">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</h4>
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
                    @endif
                    @if(in_array(6,$element))
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Over Due Amount</p>
                                            <h4 class="mb-0">{{ \App\Models\PurchaseOrderInvoice::whereDate('due_date','<',date('Y-m-d'))->where('mark_as_paid',0)->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</h4>
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
                    @endif
                    <!-- <div class="col-md-4">
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
                    </div> -->
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
                                        <th>PO Number</th>
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
                                            <td>{{ !is_null($ov->po) && !is_null($ov->po->client) ? $ov->po->client->company_name : '--' }}</td>
                                            <td>{{ !is_null($ov->po) ? $ov->po->po_number : '--' }}</td>
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
        @endif
    </div>
</div>
@endsection