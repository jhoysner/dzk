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
    <title>{{ config('app.name', '') }}</title>

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
</head>
<body>
<!-- start Header Area -->

    @include('layouts.header')

<!-- End Header Area -->

    <!-- Start hero-section -->
    @include('layouts.section_star_hero2')
    <!-- End hero-section -->

    <!-- Start featured-item-section -->
    @include('layouts.section_featured_item')
    <!-- End featured-item-section -->

    <!-- Start latest-item-section -->
    @include('layouts.section_latest_item')
    <!-- End latest-item-section -->

    <!-- Start free-item-section -->
    @include('layouts.section_free_item')
    <!-- End free-item-section -->

    <!-- Start team-section -->
    @include('layouts.section_team')
    <!-- End team-section -->

    <!-- Start cta-section -->
    @include('layouts.section_cta')
    <!-- End cta-section -->

    <!-- Start counter-section -->
    @include('layouts.section_counter')
    <!-- End counter-section -->

    <!-- start footer Area -->
    @include('layouts.footer')
    <!-- End footer Area -->
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
</body>

</html>
