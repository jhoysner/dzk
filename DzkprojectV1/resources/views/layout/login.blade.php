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

    <script> window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};</script>

    <!-- Site Title -->
    <title>Login - Inicio de Sesión</title>

    <link href="css/fonts-googleapis.css" rel="stylesheet">
    <!-- ===========================================
				CSS
	============================================= -->
    <link rel="stylesheet" href="css/simple-line-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/main.css">
    
    <!-- INCLUIR CSS ADICIONALES -->
    
</head>
<body>

    <div id="app">
        @yield('content')
    </div>
    
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/easing.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/main.js"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    
    
    <!--SCRIPTS PERSONALIZADOS DE LOS MODULOS  -->
    
</body>

</html>
