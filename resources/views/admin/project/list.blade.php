@extends('layouts.admin')
@section('title','All Projects')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Projects</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Projects</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.project.index') }}">
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
                                        <a href="{{ route('admin.project.index') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list">
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div

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
                                    <th>Project</th>
                                    <th>Description</th>
                                    <th>Created On</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($project))
                                @foreach($project as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !is_null($ov->client) ? $ov->client->company_name : '--' }}</td>
                                        <td>{{ $ov->name }}</td>
                                        <td><a href="javascript:void(0);" class="btn btn-secondary btn-sm viewDescription" data-content="{{ $ov->description }}"><i class="fa fa-info"></i></a></td>
                                        <td>{{ date('d/m/Y',strtotime($ov->created_at)) }}</td>
                                        <td>
                                            @if(array_key_exists('project',$selectedAction) && in_array('edit',$selectedAction['project']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.project.edit',base64_encode($ov->id)) }}" role="button">
                                                    Edit
                                                </a>
                                            @endif
                                            @if(array_key_exists('project',$selectedAction) && in_array('delete',$selectedAction['project']))
                                                <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.project.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this project?');">
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
<div class="modal fade" id="overdueIntrestSetting" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Project Description</h4>
                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBodyIntrest">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.viewDescription',function(){
        $('#modalBodyIntrest').text($(this).data('content'));
        $('#overdueIntrestSetting').modal('show');
    })
</script>
@endsection