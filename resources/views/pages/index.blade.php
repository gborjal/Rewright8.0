@extends('index_master')

@section('content')
	
	<div class="parallax-container">
		<div class="parallax"><img src="{{ route('image','brandBackdropLarge.png') }}"></div>
	</div>
	<div class="section white">
		<div class="row container">
			<div class="col s12 m12 l9">
				<h3>Try out our demo!</h3>
				<blockquote>
					Login as a demo Physician or as a Patient!
				</blockquote>
				<blockquote>Or, just login!</blockquote>
			</div>
			<div id="f" class="col s12 m12 l3 card medium">
				<div id="div_login" class="col s12">
					<br/>
					{!! Form::open(['route'=>'login','method'=>'POST']) !!}
						
    					<div class="input-field">
							{!! Form::text('login_id',null,['placeholder'=>'username or email','class'=>'validate']) !!}
							<label for="login_id">Username/Email</label>
						</div>
					
    					<div class="input-field">
							{!! Form::password('password',null,['placeholder'=>'password','type'=>'password','class'=>'validate']) !!}
							<label for="password">Password</label>
						</div>
						
						<p>
							<label>
								<input type="checkbox" id="remember" name="remember"/>
								<span>Remember me</span>
							</label>
						</p>	
						<button class="btn waves-effect blue darken-4" type="submit" formmethod="post">Login
						    <i class="large material-icons right">send</i>
		  				</button>
					{!! Form::close() !!}
					<ul class="collection">
						<!--li class="collection-item">
							<a href="register" data-link="{{ route('register') }}">
								<i class="material-icons left">person_add</i>Register as Physician 
							</a>
						</li-->
						<li class="collection-item">
							<a href="login_demo_phy" data-link="{{ route('login_demo_phy') }}">
								<i class="material-icons left">play_circle_outline</i>Demo as Physician 
							</a>
						</li>
						<li class="collection-item">
							<a href="login_demo_patient" data-link="{{ route('login_demo_patient') }}">
								<i class="material-icons left">play_circle_outline</i>Demo as Patient 
							</a>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
	<div class="parallax-container">
		<div class="parallax"><img src="{{ route('image','brandBackdropLarge.png') }}"></div>
	</div>
	<div class="section white">
		<div class="row container">
			<div class="col s12 m9 l9">

			</div>
		</div>
	</div>

@stop
@section('errors')
	@if($errors->any())
		<script type="text/javascript">
			@foreach($errors->all() as $error)

			
				var toastContent = "<span>{{ $error }}</span>";
				M.toast({ 	html:toastContent,
							displayLength:10000, 
							classes:'blue darken-4'
						});
			
			@endforeach
		</script>
	@endif
	@if(Session::get('error'))
		<script type="text/javascript">
			var toastContent = "<span>{{ Session::get('error') }}</span>";
			M.toast({ 	html:toastContent,
						displayLength:10000, 
						classes:'blue darken-4'
					});
		</script>
	@endif
@stop
