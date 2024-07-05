@extends('index_master')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col s12 m12 l6">
				<div class="col s12" style="z-index: -1;">
					<img class="responsive-img" src="{{ route('image','brandBackdropLarge.png') }}"/>
				</div>
				<div id="f" class="col s12 m6 l6 offset-m3 offset-l3 card medium">
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
