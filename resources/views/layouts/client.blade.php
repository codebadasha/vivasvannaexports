<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Vivasvanna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.client.partials.header_link')
    <style>
.account-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.overlay-card {
    background: #fff;
    padding: 50px;
    border-radius: 12px;
    width: 500px;
    max-width: 90%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
}
</style>

</head>

<body data-sidebar="dark">
    @php
    $client = Auth::guard('client')->user();
    @endphp

    @if($client && ($client->is_active == 0 || $client->is_verify == 0))

        @php
            if($client->is_verify == 0){
                $title = "Account Verification Pending";
                $icon = "fa-clock";
                $color = "warning";
                $message = "Your company account with Vivasvanna Exports is pending verification. Please wait while our team reviews your details.";
            }else{
                $title = "Account Deactivated";
                $icon = "fa-ban";
                $color = "danger";
                $message = "Your company account with Vivasvanna Exports has been deactivated. Please contact our support team to reactivate your account.";
            }
        @endphp

        <div class="account-overlay">
            <div class="overlay-card text-center">
                <i class="fa {{ $icon }} text-{{ $color }} mb-4" style="font-size:70px;"></i>
                <h3 class="fw-bold mb-3">{{ $title }}</h3>
                <p class="text-muted mb-4">
                    {{ $message }}
                </p>

                <div class="mt-4">
                    <p class="mb-1">
                        <i class="fa fa-phone-alt text-primary me-2"></i>
                        Support: <a href="tel:+919876543210">+91 98765 43210</a>
                    </p>
                    <p class="mb-0">
                        <i class="fa fa-envelope text-primary me-2"></i>
                        Email: <a href="mailto:info@ratnamaniindustries.com">
                            info@ratnamaniindustries.com
                        </a>
                    </p>
                </div>

                <a href="{{ route('client.logout') }}" class="btn btn-dark mt-3">
                    Logout
                </a>
            </div>
        </div>

    @endif
    <div id="layout-wrapper">
        <x-client-topnavigation />

        <x-client-sidebar />
        <div class="main-content">
            @yield('content')
            <x-client-footer />
            @include('components.client.partials.modal')

        </div>
    </div>
    <div class="rightbar-overlay"></div>
    @include('components.client.partials.footer_link')
    @yield('js')
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "timeOut": "5000"
        };
    </script>
    <script type="text/javascript">
        @if(Session::has('messages'))
        $(document).ready(function() {
            @foreach(Session::get('messages') AS $msg)
            toastr['{{ $msg["type"] }}'](
                '{{ $msg["message"] }}',
                {!! isset($msg["title"]) ? "'".$msg["title"]."'" : "null" !!}
            );
            @endforeach
        });
        @endif

        @if(count($errors) > 0)
        $(document).ready(function() {
            @foreach($errors->all() AS $error)
            toastr['error']('{{$error}}');
            @endforeach
        });
        @endif
    </script>

</body>

</html>