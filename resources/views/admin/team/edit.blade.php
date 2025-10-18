@extends('layouts.admin')
@section('title','Edit Team Member')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Team Member</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team Member List</a></li>
                            <li class="breadcrumb-item active">Edit Team Member</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <form class="custom-validation" action="{{ route('admin.team.update') }}" method="post" id="editTeamMember" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <input type="hidden" name="id" id="id" value="{{ base64_encode($member->id) }}">

                            <div class="form-group mb-3">
                                <label>Full Name<span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" autocomplete="off" value="{{ $member->name }}" required />
                            </div>

                            <div class="mb-3">
                                <label>Assign Role <span class="mandatory">*</span></label>
                                <select class="form-select select2 @error('role_id') is-invalid @enderror"
                                    name="role_id" id="role_id" required>
                                    @forelse(\App\Models\Role::where('is_active',1)->where('is_delete',0)->get() as $rv)
                                    <option value="{{ $rv->id }}"
                                        {{ old('role_id', $member->role_id) == $rv->id ? 'selected' : '' }}>
                                        {{ $rv->name }}
                                    </option>
                                    @empty
                                    <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                                <span id="role"></span>
                                @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Mobile Number<span class="mandatory">*</span></label>
                                <input type="text" class="form-control numeric" name="mobile" id="mobile" placeholder="Mobile Number" autocomplete="off" minlength="10" maxlength="10" value="{{ $member->mobile }}" required />
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email<span style="color:red;">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email" required autocomplete="off" value="{{ $member->email }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                    <span class="input-group-text p-viewer m-0" style="cursor:pointer;">
                                        <i class="fa fa-eye-slash fa-color password" aria-hidden="true"></i>
                                    </span>
                                </div>
                                @error('password')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Enter Confirm Password">
                                    <span class="input-group-text p-viewer2 m-0" style="cursor:pointer;">
                                        <i class="fa fa-eye-slash fa-color confirmpassword" aria-hidden="true"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Update
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