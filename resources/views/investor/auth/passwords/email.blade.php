@extends('layouts.login')
@section('title','Investor Login')
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
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Sign in to continue to Vivasvanna.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div class="auth-logo">
                            <a href="{{ route('admin.login') }}" class="auth-logo-light">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                       <img src="{{ asset('images/logo-vis.png') }}" alt="" class="" height="60">
                                    </span>
                                </div>
                            </a>

                            <a href="{{ route('admin.login') }}" class="auth-logo-dark">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ asset('images/logo-vis.png') }}" alt="" class="" height="60">
                                    </span>
                                </div>
                            </a>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="p-2">
                            <form class="form-horizontal" action="{{ route('investor.passwordemail') }}" id="forgotPassword" method="post">
                                @csrf
                                
                                <div class="form-group">
                                    <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                                </div>

                                <div class="form-group">
                                    <label for="username">Email<span class="mandatory red">*</span></label>
                                    <input type="email" class="form-control" name="email" id="username" placeholder="Enter email" required>
                                </div>
        
                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Send Password Reset Link</button>
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