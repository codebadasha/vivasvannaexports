@extends('layouts.admin')
@section('title','All Transactions')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Transactions</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Transactions</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.transaction.index') }}">
                            <div class="row">  

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                                <option value="{{ $sv->id }}" {{ request()->client == $sv->id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Project Name <span class="mandatory">*</span></label>
                                    <input type="text" name="project" class="form-control" id="project" placeholder="Project Name" >
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>PO Number <span class="mandatory">*</span></label>
                                    <input type="text" name="po_number" class="form-control" id="name" placeholder="PO Number" >
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Entry Type <span class="mandatory">*</span></label>
                                    <select class="form-control" name="entry_type">
                                        <option value="">All</option>
                                        <option value="PAID" {{ request()->entry_type == 'PAID' ? 'selected' : '' }}>Paid</option>
                                        <option value="PENDING" {{ request()->entry_type == 'PENDING' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="payment_start_date" autocomplete="off" value="{{ request()->payment_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="payment_end_date" autocomplete="off" value="{{ request()->payment_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Entry Date</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="entry_start_date" autocomplete="off" value="{{ request()->entry_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="entry_end_date" autocomplete="off" value="{{ request()->entry_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Select Financial Year</label>
                                    <select class="form-select" name="fin_year">
                                        <option value="" selected>Financial Year</option>
                                        @forelse(getFinYear() as $fk => $sv)
                                            <option value="{{ $sv }}" {{ request()->fin_year == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-2 mt-2">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                        <a href="{{ route('admin.transaction.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total PO Amount</p>
                                        <h4 class="mb-0">{{ number_format($totalPoAmount,2) }}</h4>
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
                                    <div class="flex-grow-1">Total Invoiced Amount</p>
                                        <h4 class="mb-0">{{ number_format($totalInvoice,2) }}</h4>
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
                                        <p class="text-muted fw-medium">Total Received Payment</p>
                                        <h4 class="mb-0">{{ number_format($totalPaidAmount,2) }}</h4>
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

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Client Name</th>
                                    <th>Project Name</th>
                                    <th>PO Number</th>
                                    <th>Reference Number</th>
                                    <th>Amount</th>
                                    <th>Invoice Date</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($trasnaction))
                                @foreach($trasnaction as $tk => $tv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !is_null($tv->client) ? $tv->client->company_name : '--' }}</td>
                                        <td>{{ !is_null($tv->project) ? $tv->project->name : '--' }}</td>
                                        <td>{{ !is_null($tv->po) ? $tv->po->po_number : '--' }}</td>
                                        <td>{{ $tv->reference_number }}</td>
                                        <td>{{ $tv->amount }}</td>
                                        <td>{{ date('d/m/Y',strtotime($tv->created_at)) }}</td>
                                        <td>{{ $tv->type }}</td>
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