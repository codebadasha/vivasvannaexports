@extends('layouts.guest')
@section('title','Welcome to vivasvanna export')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    {{-- Success Card --}}
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body text-center p-5">

                            @if($status == 'already_registered' || $status == 'registered')
                            <div class="mb-4">
                                <i class="fa fa-check-circle text-success" style="font-size:80px;"></i>
                            </div>

                            @if($status == 'already_registered')
                            <h2 class="fw-bold text-dark mb-3">Already Registered</h2>
                            <p class="text-muted mb-4">
                                Your company is already registered with
                                <span class="fw-semibold text-primary">Vivasvanna Exports</span>.<br>
                                Please log in to our dashboard using your existing credentials.
                            </p>
                            @else
                            <h2 class="fw-bold text-dark mb-3">🎉 Registration Successful</h2>
                            <p class="text-muted mb-4">
                                Thank you for registering your company with
                                <span class="fw-semibold text-primary">Vivasvanna Exports.</span><br>
                                Your account has been created successfully and is now ready to use.
                            </p>
                            @endif

                            {{-- Buttons --}}
                            <a href="https://portal.vivasvannaexports.com/client/login" class="btn btn-success px-5 py-2 fw-semibold">
                                <i class="fa fa-tachometer-alt me-2"></i>
                                Go to Dashboard
                            </a>

                            {{-- Redirecting Message --}}
                            <p class="text-muted mt-3">
                                <i class="fa fa-hourglass-half text-warning me-2"></i>
                                Please wait... Redirecting to dashboard in
                                <span id="countdown">15</span> seconds.
                            </p>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    let seconds = 15;
                                    let countdownEl = document.getElementById("countdown");

                                    let timer = setInterval(function() {
                                        seconds--;
                                        countdownEl.textContent = seconds;

                                        if (seconds <= 0) {
                                            clearInterval(timer);
                                            window.location.href = "https://portal.vivasvannaexports.com/client/login";
                                        }
                                    }, 1000);
                                });
                            </script>
                            @else
                            <div class="mb-4">
                                <i class="fa fa-times-circle text-danger" style="font-size:80px;"></i>
                            </div>

                            {{-- Heading --}}
                            <h2 class="fw-bold text-dark mb-3">Invalid Link</h2>

                            {{-- Message --}}
                            <p>
                                The registration link you used for
                                <span class="fw-semibold text-primary">Vivasvanna Exports</span> is
                                <span class="fw-semibold text-danger">invalid</span>.<br>
                                Please request a new invitation link or contact our support team for assistance.
                            </p>
                            @endif

                            {{-- Support Info --}}
                            <div class="mt-4">
                                <p class="mb-1">
                                    <i class="fa fa-phone-alt text-primary me-2"></i>
                                    Support: <a href="tel:+919876543210">+91 98765 43210</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fa fa-envelope text-primary me-2"></i>
                                    Email: <a href="mailto:info@ratnamaniindustries.com">info@ratnamaniindustries.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection