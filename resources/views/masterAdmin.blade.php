<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="authToken" content="{{ $authToken }}">
        <title>ReWrighT</title>
        <!--Font/Icon-->
        <!--link rel = "stylesheet" type = "text/css" href="http://fonts.googleapis.com/icon?family=Material+Icons"/-->
        <link rel = "stylesheet" type = "text/css" href="{{ URL::asset('css/materialize-fonts.min.css') }}"/>
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/materialize.min.css') }}" media="screen,projection"/>
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/functions.css') }}"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type = "text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"/></script>
    </head>
    <body>
        
        @yield('content')
        
        <script type = "text/javascript" src = "{{ URL::asset('js/api.js') }}"/></script>
        <script type = "text/javascript" src = "{{ URL::asset('js/functionsAdmin.js') }}"/></script>
        <footer class="page-footer grey darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="light-blue-text text-darken-1">ReWrighT: Hand and Wrist rehabilitation system</h5>
                <p class="light-blue-text text-darken-2">Made with Laravel</p>
                <p class="light-blue-text text-darken-2">Made with LeapJS PlayBack</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="light-blue-text text-darken-1">Links</h5>
                <ul>
                  <li><a class="light-blue-text text-darken-2" href="https://github.com/leapmotion/leapjs-playback">LeapJS Playback</a></li>
                  <li><a class="light-blue-text text-darken-2" href="https://laravel.com/">Laravel</a></li>
                  <li><a class="light-blue-text text-darken-2" href="https://github.com/gborjal">Gabriel Luis Borjal</a></li>
                  <li><a class="light-blue-text text-darken-2" href="#!">Ralph Deloria</a></li>
                  <li><a class="light-blue-text text-darken-2" href="#!">Rheyvin Demerey</a></li>
                  <li><a class="light-blue-text text-darken-2" href="#!">Dave Kristian Au</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container light-blue-text text-darken-1">
            © 2021 ReWrighT: Hand and Wrist rehabilitation system
            <!--a class="grey-text text-lighten-4 right" href="#!">More Links</a-->
            </div>
          </div>
        </footer>
        
        <script type = "text/javascript" src = "{{ URL::asset('js/materialize.js') }}"/></script>
        
        <!--    
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type = "text/javascript" src = "{{ URL::asset('js/materialize.min.js') }}"/></script>    
        -->
    </body>
</html>

