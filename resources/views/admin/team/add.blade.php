@extends('layouts.admin')
@section('title','Add Team Member')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Team Member</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team Member List</a></li>
                            <li class="breadcrumb-item active">Add Team Member</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     

        <form class="custom-validation" action="{{ route('admin.team.store') }}" method="post" id="addTeamMember" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" name="full_name"
                                    class="form-control @error('full_name') is-invalid @enderror"
                                    id="investorName"
                                    placeholder="Enter Full Name"
                                    value="{{ old('full_name') }}" required>
                                @error('full_name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Assign Role <span class="mandatory">*</span></label>
                                <select class="form-select select2 @error('role_id') is-invalid @enderror"
                                    name="role_id" id="role_id" required>
                                    <option value="">Select Role</option>
                                    @forelse(\App\Models\Role::where('is_active',1)->where('is_delete',0)->get() as $rv)
                                    <option value="{{ $rv->id }}" {{ old('role_id') == $rv->id ? 'selected' : '' }}>
                                        {{ $rv->name }}
                                    </option>
                                    @empty
                                    <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="role"></span>
                                @error('role_id')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Mobile Number <span class="mandatory">*</span></label>
                                <input type="text" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror numeric"
                                    id="mobileNumber"
                                    placeholder="Mobile Number"
                                    value="{{ old('mobile') }}" required>
                                @error('mobile')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="emailId"
                                    placeholder="Email ID"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Password <span class="mandatory">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password" placeholder="Enter Password" required>
                                    <span class="input-group-text p-viewer m-0" style="cursor:pointer;">
                                        <i class="fa fa-eye-slash fa-color password" aria-hidden="true"></i>
                                    </span>
                                </div>
                                @error('password')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Confirm Password <span class="mandatory">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control" id="confirmPassword"
                                        placeholder="Enter Confirm Password" required>
                                    <span class="input-group-text p-viewer2 m-0" style="cursor:pointer;">
                                        <i class="fa fa-eye-slash fa-color confirmpassword" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-secondary waves-effect waves-light mr-1" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.team.index') }}" class="btn btn-danger waves-effect">
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