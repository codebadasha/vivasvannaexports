@extends('layouts.admin')
@section('title','All POs')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All POs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
                        <form action="{{ route('admin.po.index') }}">
                            <div class="row">  
                                <div class="col-md-4">
                                    <label class="control-label">Project</label>
                                    <input class="form-control" name="project" value="{{ request()->project }}" placeholder="Project">
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

                                <div class="col-md-2 mt-2">
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

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Client</th>
                                    <th>Project Name</th>
                                    <th>PO Number</th>
                                    <th>PO Amount</th>
                                    <th>PO Uploaded On</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($po))
                                @foreach($po as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !is_null($ov->client) ? $ov->client->company_name : '--' }}</td>
                                        <td>{{ !is_null($ov->project) ? $ov->project->name : '--' }}</td>
                                        <td>{{ $ov->po_number }}</td>
                                        <td>{{ $ov->subtotal }}</td>
                                        <td>{{ date('d/m/Y h:i A',strtotime($ov->created_at)) }}</td>
                                        <td>
                                            @if(array_key_exists('po',$selectedAction) && in_array('view',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.viewPurchaseOrder',base64_encode($ov->id)) }}" role="button">
                                                    View PO
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('supplier',$selectedAction['po']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.po.poItems',base64_encode($ov->id)) }}" role="button">
                                                    Assign Supplier
                                                </a>
                                            @endif
                                            @if(array_key_exists('po',$selectedAction) && in_array('invoice',$selectedAction['po']))
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
@endsection