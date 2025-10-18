@extends('layouts.admin')
@section('title','Add Investor')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Investor</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Investor List</a></li>
                            <li class="breadcrumb-item active">Add Investor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation" action="{{ route('admin.investor.store') }}" method="post" id="addInvestor" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" name="investor_name"
                                    class="form-control @error('investor_name') is-invalid @enderror"
                                    id="investorName"
                                    placeholder="Investor Name"
                                    value="{{ old('investor_name') }}" required>
                                @error('investor_name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Mobile Number <span class="mandatory">*</span></label>
                                <input type="text" name="mobile_number"
                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                    id="mobileNumber"
                                    placeholder="Mobile Number"
                                    value="{{ old('mobile_number') }}" required>
                                @error('mobile_number')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="email" name="email_id"
                                    class="form-control @error('email_id') is-invalid @enderror"
                                    id="emailId"
                                    placeholder="Email ID"
                                    value="{{ old('email_id') }}" required>
                                @error('email_id')
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
                                    <a href="{{ route('admin.investor.index') }}" class="btn btn-danger waves-effect">
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