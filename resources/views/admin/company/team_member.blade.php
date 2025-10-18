@extends('layouts.admin')
@section('title','Assign Team Member')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Assign Team Member</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All Client Company</a></li>
                            <li class="breadcrumb-item active">Assign Team Member</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">   
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation" action="{{ route('admin.client.storeTeamMember') }}" method="post" id="addInvestor" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ base64_decode($id) }}" >

                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Team Member <span class="mandatory">*</span></label>
                                <select class="form-control select2" name="member[]" data-placholder="Select Team Member" required multiple>
                                    @forelse(\App\Models\Admin::where('is_active',1)->where('is_delete',0)->where('role_id','!=',1)->get() as $ak => $av)
                                        <option value="{{ $av->id }}" {{ count($team) > 0 && in_array($av->id,$team) ? 'selected' : '' }}>{{ $av->name }}</option>
                                    @empty
                                        <option value=""></option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <a href="{{ route('admin.client.index') }}" class="btn btn-danger waves-effect">
                                        Cancel
                                    </a>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
