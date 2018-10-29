<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es')}}" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <!-- Author Meta -->
    <meta name="author" content="codethemes">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script> window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};</script>

    <!-- Site Title -->
    <title>{{ config('app.name', '') }}</title>

    <link href="css/fonts-googleapis.css" rel="stylesheet">
    <!-- ===========================================
				CSS
	============================================= -->
    <link rel="stylesheet" href="{{asset('css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    
    <!-- INCLUIR CSS ADICIONALES -->
    
    @yield('customcss')
    
</head>
<body>
    @include('layout.header')

    <div id="app">
        @yield('content')
    </div>
     @include('layout.footer')

    <script src="{{asset('js/vendor/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/easing.min.js')}}"></script>
    <script src="{{asset('js/superfish.min.js')}}"></script>
    <script src="{{asset('js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v3&key=AIzaSyBnSDDT8mnv1_cDX_iZmaEaYy6qp63be1E"></script>
    <!--<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARjJet0cEb9j1zlP0rFo1sW7jRN0s8f_4&callback=initMap">
    </script>-->
    
    
    <!--SCRIPTS PERSONALIZADOS DE LOS MODULOS  -->
    @yield('customjs')
	    
</body>

</html>
