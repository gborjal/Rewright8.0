@extends('index_master')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col s12 m6 l6 offset-m3 offset-l3">
				<div id="f" class="card medium">
					<ul class="tabs">
						<li class="tab col s3"><a class="blue-text text-accent-4" href="#div_login" onclick="changeRegCard(0);">Login</a></li>
						<div class="indicator blue darken-4" style="z-index:1"></div>
					</ul>
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
					</div>
					<a href="register" data-link="{{ route('register') }}">
						<i class="material-icons left">person_add</i>Register as Physician {
					</a>
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
							displayLength:5000, 
							classes:'blue darken-4'
						});
			
			@endforeach
		</script>
	@endif
	@if(Session::get('error'))
		<script type="text/javascript">
			var toastContent = "<span>{{ Session::get('error') }}</span>";
			M.toast({ 	html:toastContent,
						displayLength:5000, 
						classes:'blue darken-4'
					});
		</script>
	@endif
@stop
