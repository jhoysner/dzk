<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es')}}" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.png">
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
    <script> window.Laravel = {!! 
        json_encode([
            'csrfToken' => csrf_token(),
            //'userId' => Auth::user()->id,
            //'roles' => Auth::user()->getRoleNames(),
            //'permissions' => Auth::user()->permissions()->pluck('name')->toArray(),
        ]) !!};</script>

    <!-- Site Title -->
    <title>{{ config('app.name', '') }}</title>

    <link href="{{ asset ('css/fonts-googleapis.css') }}" rel="stylesheet">
    <!-- ===========================================
				CSS
		============================================= -->
    <link rel="stylesheet" href="{{ asset('/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body>

	<div id="app">
		<main-dashboard></main-dashboard>
	</div>

    <script src="{{ asset('/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('/js/popper.min.js') }}"></script>
    <script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/easing.min.js') }}"></script>
    <script src="{{ asset('/js/superfish.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/js/Chart.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v3&key=AIzaSyBnSDDT8mnv1_cDX_iZmaEaYy6qp63be1E"></script>-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARjJet0cEb9j1zlP0rFo1sW7jRN0s8f_4">
    </script>
    <script src="{{ asset('/js/Google.js') }}"></script>

</body>

</html>
