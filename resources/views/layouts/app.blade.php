<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ __('SIMPEG INDAG') }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="{{ asset('/upload/logo/logo.png') }}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/bootstrap/dist/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/font-awesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-component/Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/core-admin/core-dist/css/AdminLTE.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link href="https://fonts.googleapis.com/css?family=Anton|Permanent+Marker|Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet"> 
        <style type="text/css">
            .fontQuicksand{
                font-family: 'Quicksand', sans-serif;
            }

            .fontPoppins{
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>
    <body class="hold-transition login-page fontPoppins"  style="background-image: url(upload/background/login.jpg);background-size: cover;background-position: center;">
         @yield('content')
        <script src="{{ asset('/assets/core-admin/core-component/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('/assets/core-admin/core-component/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>

