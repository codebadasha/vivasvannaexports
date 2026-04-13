@extends('layouts.admin')
@section('title','All Credit Request')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Credit Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Credit Request</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.credit.index') }}">
                            <div class="row">  

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Daterange</label>
                                        <div>
                                            <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" autocomplete="off">
                                                <input type="text" class="form-control" name="po_start_date" autocomplete="off" value="{{ request()->po_start_date }}" placeholder="dd/mm/yyyy">
                                                <input type="text" class="form-control" name="po_end_date" autocomplete="off" value="{{ request()->po_end_date }}" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">Select Client</option>
                                            @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                                <option value="{{ $sv->id }}" {{ $sv->id == request()->client ? 'selected' : ''}}>{{ $sv->company_name }}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>
                                    @if($filter == 1)
                                        <a href="{{ route('admin.credit.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
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

                        <table id="datatable-buttons" class="table table-striped table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Company Details</th>
                                    <th>Requested Amount</th>
                                    <th>Bank Details</th>
                                    <th>GST Report</th>
                                    <th>Balance Sheets</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($list))
                                    @foreach($list as $ov)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $ov->client->company_name ?? '--' }}</strong><br>
                                                GSTN : {{ $ov->client->gstn ?? '--' }}<br>
                                                PAN : {{ $ov->client->pan_number ?? '--' }}
                                            </td>
                                            <td>
                                                ₹ {{ number_format($ov->request_amount ?? 0,2) }}
                                            </td>
                                            <td>
                                                Bank : {{ $ov->bankReport->bank->name ?? '--' }} <br>
                                                Statement : <a href="{{ asset('storage/'.$ov->bankReport->upload_filepath) }}" download>
                                                                <i class="fa fa-download text-success"></i>
                                                            </a> <br>
                                                Generated Report :  @if($ov->bankReport->status == 'generated')
                                                                        <a href="{{ asset('storage/'.$ov->bankReport->report_file_path) }}" download>
                                                                            <i class="fa fa-download text-success"></i>
                                                                        </a>
                                                                    @else  
                                                                        {{ ucfirst($ov->bankReport->status) }}
                                                                    @endif
                                                @if($ov->bankReport->reason)
                                                    <br>
                                                    <span style="color:red">{{ $ov->bankReport->reason }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ov->gstReport)
                                                    Report Excel :
                                                        @if($ov->gstReport->status !== 'generated')
                                                            {{ ucfirst($ov->gstReport->status) }}
                                                        @else
                                                            <a href="{{ asset('storage/'.$ov->gstReport->local_excexlfilepath) }}" download>
                                                                <i class="fa fa-download text-success"></i>
                                                            </a>
                                                        @endif
                                                    <br>
                                                    Report PDF :
                                                        @if($ov->gstReport->status !== 'generated')
                                                            {{ ucfirst($ov->gstReport->status) }}
                                                        @else
                                                            <a href="{{ asset('storage/'.$ov->gstReport->local_pdffilepath) }}" download>
                                                                <i class="fa fa-download text-success"></i>
                                                            </a>
                                                        @endif
                                                        @if($ov->gstReport->reason)
                                                            <br>
                                                            <span style="color:red">{{ $ov->gstReport->reason }}</span>
                                                        @endif
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($ov->balanceSheets->count())
                                                    @foreach($ov->balanceSheets as $bs)
                                                        {{ $bs->year }} :
                                                        <a href="{{ asset('storage/'.$bs->filepath) }}" download>
                                                            <i class="fa fa-download text-success"></i>
                                                        </a>
                                                        <br>
                                                    @endforeach
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d/m/Y h:i A',strtotime($ov->created_at)) }}
                                            </td>
                                            <td>
                                                <span class="">
                                                    {{ ucfirst($ov->status) }}
                                                </span>
                                                @if($ov->reason)
                                                    <br>
                                                    <span style="color:red">{{ $ov->reason }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ov->status == 'submitted')

                                                    <a href="{{ route('admin.credit.approve',base64_encode($ov->id)) }}"
                                                    class="btn btn-success btn-sm">
                                                    Approve
                                                    </a>

                                                    <a href="{{ route('admin.credit.reject',base64_encode($ov->id)) }}"
                                                    class="btn btn-danger btn-sm">
                                                    Reject
                                                    </a>
                                                @else
                                                    ---
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

