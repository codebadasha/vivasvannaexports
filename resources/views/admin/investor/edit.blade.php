@extends('layouts.admin')
@section('title','Edit Investor')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Investor</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Investor List</a></li>
                            <li class="breadcrumb-item active">Edit Investor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">   
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation" action="{{ route('admin.investor.update') }}" method="post" id="editInvestor" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ base64_encode($investor->id) }}">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Investor Name <span class="mandatory">*</span></label>
                                <input type="text" name="investor_name" class="form-control" id="investorName" placeholder="Investor Name" value="{{ old('investor_name', $investor->name) }}" required>
                                @error('investor_name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Mobile Number <span class="mandatory">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" id="mobileNumber" placeholder="Mobile Number" value="{{ old('mobile_number', $investor->mobile) }}" required>
                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="email" name="email_id" class="form-control" id="emailId" placeholder="Email ID " value="{{ old('email_id', $investor->email) }}" required>
                                @error('email_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
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
