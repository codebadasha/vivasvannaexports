<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Vivasvanna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.guest.partials.header_link')
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <x-guest-topnavigation />

        <div class="main-content mx-5">
            @yield('content')
            <x-guest-footer />
        </div>
    </div>
    <div class="rightbar-overlay"></div>
    @include('components.guest.partials.footer_link')
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