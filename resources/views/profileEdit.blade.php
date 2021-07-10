<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    	<meta name="csrf-token" content="{{ csrf_token() }}" />
    	<meta name="authToken" content="{{ $authToken }}">
        <title>ReWrighT</title>
        <!--Font/Icon-->
        <!--link rel = "stylesheet" type = "text/css" href="http://fonts.googleapis.com/icon?family=Material+Icons"/-->
        
        <link rel = "stylesheet" type = "text/css" href="{{ URL::asset('css/materialize-fonts.min.css') }}"/><!--local copy-->
        <!--Local-->
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/materialize.min.css') }}" media="screen,projection"/>
        <link rel = "stylesheet" type = "text/css" href = "{{ URL::asset('css/functions.css') }}"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
    </head>
    <body>
        <!--Local-->
        <script type = "text/javascript" src = "{{ URL::asset('js/jquery-2.1.1.min.js') }}"/></script><!--local copy-->
        <script type = "text/javascript" src = "{{ URL::asset('js/materialize.js') }}"/></script>
		<header>	
			<nav class="top-nav grey darken-4">
				<div class="container">
					<div class="nav-wrapper">
						<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">dashboard</i></a>			
						<ul class="right hide-on-med-and-down">
							<li><a href="{!! route('logout') !!}">logout</a></li>
						</ul>
					</div>
				</div>
			</nav>
			
			<ul id="slide-out" class="sidenav">
				<li class="no-padding">																		{{-- Profile --}}
					<ul id="profileMenu" class="collapsible">
						<li>
							<div class="collapsible-header"><i class="material-icons left">perm_identity</i>{{ Auth::user()->username }}</div>
							<div class="collapsible-body">
								<ul>
									<li><a href="{!! route('logout') !!}"><i class="material-icons">exit_to_app</i></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</header>
		<main>
		{!! Form::open(['route'=>'postEditProfile','id'=>'postEditProfile','files'=>'true']) !!}
		<div class = "container">
			<div class = "row">
				<div class="col s12 m9 l7 offset-l3">
					<div id="div_pdetails" class="section scrollspy">
						<div class = "row">
							<div class="col l6 m6 s12">
								<input type="text" id="email" name="email" value = "{{ $user_info['email'] }}" disabled="disabled">
								{!! Form::hidden('h_email',$user_info['email'],['id'=>'h_email']) !!}
								<label for="email">E-mail</label>
							</div>
							<div class="col l6 m6 s12">
								<input type="text" id="code" name="code" value = "{{ $user_info['code'] }}" disabled="disabled">
								{!! Form::hidden('h_code',$user_info['code'],['id'=>'h_code']) !!}
								<label for="code">Activation code</label>
							</div>
						</div>
						<div class = "row">
							<div class="col l3 m3">
								<input type="text" id="fname" name="fname" value = "{{ $user_info['fname'] }}">
								<label for="fname">First Name</label>
							</div>
							<div class="col l3 m3">
								<input type="text" id="mname" name="mname" value = "{{ $user_info['mname'] }}">
								<label for="mname">Middle Name</label>
							</div>
							<div class="col l3 m3">
								<input type="text" id="lname" name="lname" value = "{{ $user_info['lname'] }}">
								<label for="lname">Last Name</label>
							</div>
							<div class="col l3 m3">
								<input type="text" id="suffix_name" name="suffix_name" value = "{{ $user_info['sname'] }}">
								<label for="suffix_name">Suffix</label>
							</div>
						</div>
						<div class="col s12 m6 l6">
							<label for="sex">Gender:</label>
							<select id="sex" name="sex" value = "{{ $user_info['sex'] }}">
								@if(is_null($user_info['sex']))
									<option disabled selected></option>
								@else
									<option disabled></option>
								@endif
								@if($user_info['sex'] === 'MALE')
									<option value='MALE' selected>Male</option>
								@else
									<option value='MALE'>Male</option>
								@endif
								@if($user_info['sex'] === 'FEMALE')
									<option value='FEMALE' selected>FEMALE</option>
								@else
									<option value='FEMALE'>FEMALE</option>
								@endif
							</select>
						</div>
						<div class = "row">
							<div class="col l12 m12 s12">
								<input type="text" id="perm_address" name="perm_address" value = "{{ $user_info['p_add'] }}">
								<label for="perm_address">Perm. Address</label>
							</div>
						</div>
						<div class = "row">
							<div class="col l12 m12 s12">
								<input type="text" id="tempo_address" name="tempo_address" value = "{{ $user_info['t_add'] }}">
								<label for="tempo_address">Temp. Address</label>
							</div>
						</div>
						<div class = "row">
							<div class="col l12 m12 s12">
								<input type="text" id="office_address" name="office_address" value = "{{ $user_info['o_add'] }}">
								<label for="office_address">Office Address</label>
							</div>
						</div>		
					</div>

					<div id="div_mdetails" class="section scrollspy">
						
					</div>
				</div>
				<div class="col hide-on-small-only m3 l2">
					<div class="tabs-wrapper pinned">
						<div style="height:1px;">
							<ul class="section table-of-contents">
								<li><a href="#div_pdetails">Personal Information</a></li>
								<!--li><a href="#div_mdetails">Medical Information</a></li-->
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<a href="#post" class="right modal-action modal-close waves-effect waves-green btn-flat" onclick="simpleSave('postEditProfile');">Update
						<i class="large material-icons right">send</i>
					</a>
				</div>
			</div>
		</div>

		{!! Form::close() !!}
		</main>
		<footer class="page-footer grey darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="blue-text text-darken-1">ReWrighT: Hand and Wrist rehabilitation system</h5>
                <p class="blue-text text-darken-4">Made with Laravel</p>
                <p class="blue-text text-darken-4">Made with LeapJS PlayBack</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="blue-text text-darken-1">Links</h5>
                <ul>
                  <li><a class="blue-text text-darken-4" href="https://github.com/leapmotion/leapjs-playback">LeapJS Playback</a></li>
                  <li><a class="blue-text text-darken-4" href="https://laravel.com/">Laravel</a></li>
                  <li><a class="blue-text text-darken-4" href="https://github.com/gborjal">Gabriel Luis Borjal</a></li>
                  <li><a class="blue-text text-darken-4" href="#!">Ralph Deloria</a></li>
                  <li><a class="blue-text text-darken-4" href="#!">Rheyvin Demerey</a></li>
                  <li><a class="blue-text text-darken-4" href="#!">Dave Kristian Au</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container blue-text text-darken-1">
            © 2021 ReWrighT: Hand and Wrist rehabilitation system
            <!--a class="grey-text text-lighten-4 right" href="#!">More Links</a-->
            </div>
          </div>
        </footer>
		<script type = "text/javascript" src = "{{ URL::asset('js/api.js') }}"/></script>
		<script type="text/javascript">
			function simpleSave(fId){
				ajaxSubmitPostings(fId,new FormData(fId));
			}
		</script>
        
  </body>
</html>

