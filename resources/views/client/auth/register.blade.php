@extends('layouts.login')
@section('title','Client Registration')
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <!-- <h5 class="text-primary">Welcome Back !</h5> -->
                                    <p>Sign Up to continue to Vivasvanna.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div class="auth-logo">
                            <a href="{{ route('client.login') }}" class="auth-logo-dark">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ asset('images/logo-vis.png') }}" alt="" class="" height="60">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 mt-2">
                            <form class="form-horizontal" action="{{ route('client.postregister') }}" id="registerForm" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group">
                                    <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                                </div>

                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo<span class="mandatory red">*</span></label>
                                    <input type="file" class="form-control" name="logo" id="logo" placeholder="Enter email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name<span class="mandatory red">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="mandatory red">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gstn" class="form-label">GSTN<span class="mandatory red">*</span></label>
                                    <input type="text" class="form-control" name="gstn" id="gstn" placeholder="Enter GSTN" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cin" class="form-label">CIN<span class="mandatory red">*</span></label>
                                    <input type="text" class="form-control" name="cin" id="cin" placeholder="Enter CIN" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cin" class="form-label">PAN Number<span class="mandatory red">*</span></label>
                                    <input type="text" name="pan_number" maxlength="10" minlength="10" class="form-control" id="panNumber" placeholder="PAN Number" required>
                                </div>
        
                                <div class="mb-3">
                                    <label class="form-label">Password<span class="mandatory red">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password<span class="mandatory red">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password" id="userpassword" placeholder="Enter confirm password" required>
                                </div>

                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  