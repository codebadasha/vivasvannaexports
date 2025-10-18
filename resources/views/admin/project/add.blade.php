@extends('layouts.admin')
@section('title','Add Project')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Project</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Project List</a></li>
                            <li class="breadcrumb-item active">Add Project</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.project.store') }}" method="post" id="project" enctype="multipart/form-data">
            @csrf  
            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Select Client<span class="mandatory">*</span></label>
                                <select class="form-control select2" name="client_id" required>
                                    <option value="">Select Client</option>
                                    @forelse(\App\Models\ClientCompany::where('is_active',1)->where('is_delete',0)->get() as $sk => $sv)
                                        <option value="{{ $sv->id }}">{{ $sv->company_name }}</option>
                                    @empty
                                        <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Name <span class="mandatory">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Description </label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-secondary waves-effect waves-light mr-1" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.project.index') }}" class="btn btn-danger waves-effect">
                                        Cancel
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
