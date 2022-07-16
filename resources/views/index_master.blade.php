<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        
        <title>ReWright</title>
        <!--Font/Icon-->
        <!--link rel = "stylesheet" type = "text/css" href="http://fonts.googleapis.com/icon?family=Material+Icons"/-->
        
        <link rel = "stylesheet" type = "text/css" href="{{ URL::asset('css/materialize-fonts.min.css') }}"/><!--local copy-->
        
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/materialize.min.css') }}" media="screen,projection"/>
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/functions.css') }}"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type = "text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"/></script>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper">
                <img src="https://rewright.herokuapp.com/profile/image/get/t/" alt='notavailable' class='profiles circle'/>
                <a href="#" class="brand-logo">ReWright</a>
            </div>
        </nav>
        @yield('content')
        
        <script type = "text/javascript" src = "{{ URL::asset('js/materialize.min.js') }}"/></script>
        <script type = "text/javascript" src = "{{ URL::asset('js/index_functions.js') }}"/></script>
        @yield('errors')
    </body>
</html>