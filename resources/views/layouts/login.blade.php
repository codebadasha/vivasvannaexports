<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | Vivasvanna</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('images/logo-vis-150x150.png') }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/developer.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/password_generation.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    </head>

    <body>
        @yield('content')
        <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/validation.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script type="text/javascript">
            @if(Session::has('messages'))
                $(document).ready(function() {
                    @foreach(Session::get('messages') AS $msg) 
                        toastr['{{ $msg["type"] }}']('{{$msg["message"]}}');
                    @endforeach
                });
            @endif
            
            @if (count($errors) > 0) 
                $(document).ready(function() {
                    @foreach($errors->all() AS $error)
                        toastr['error']('{{$error}}');
                    @endforeach     
                });
            @endif
        </script>
    </body>
</html>
