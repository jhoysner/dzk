<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <h2>Estimado usuario {{ $firstname}} {{$lastname}}</h2>

            <p>Por favor haga click en el siguiente link para desbloquear su cuenta:
            <a href="{{ url('/account/verify/' . $access_token)}}"><strong>Desbloquear Cuenta</strong></a></p>
        </div>
    </body>
</html>
