@extends('index_master')

@section('content')
	
	<div class="parallax-container">
		<div class="parallax"><img src="{{ route('image','brandBackdropLarge.png') }}"></div>
	</div>
	<div class="section white">
		<div class="row container">
			<div class="col s12 m12 l8">
				<h3>Try out our demo!</h3>
				<blockquote>
					Login as a demo Physician or as a Patient!<br/> <br/>
					Or, just login!
				</blockquote>
			</div>
			<div id="f" class="col s12 m12 l4 card medium">
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
		<div class="parallax"><img src="{{ route('image','highlight_1.png') }}"/></div>
	</div>
	<div class="section" style="background-color:#DFDFDD">
		<div class="row container">
			<div class="col s12 l7">
				<h3>Record EXERCISES!</h3>
				<blockquote>Create and record PERSONALIZED Exercises for your Patients!</blockquote>
				<blockquote>
					Follow your Physician's recommendation!<br/>
					Review your how your patient follows the exercises and PLAYBACK
				</blockquote>
			</div>
			<div class="col s12 m3 l5">
				<img class="materialboxed responsive-img" src="{{ route('image','feature_1.png') }}"/>
			</div>
		</div>
		<div class="row container">
			<div class="col s12 l7">
				<h3>Personalize TASKS</h3>
				<blockquote>Create tasks specific or generalized to your Patients!</blockquote>
				<blockquote>
					Have the ability to assign tasks for different or similar cases of patients!
				</blockquote>
			</div>
			<div class="col s12 l5">
				<img class="materialboxed responsive-img" src="{{ route('image','feature_2.png') }}"/>
			</div>
		</div>
	</div>
	<div class="parallax-container">
		<div class="parallax"><img src="{{ route('image','highlight_2.png') }}"/></div>
	</div>
	<div  class="section" style="background-color:#DFDFDD">
		<div class="row container">
			<div class="col s12 l5">
				<img class="materialboxed responsive-img" src="{{ route('image','feature_3.png') }}"/>
			</div>
			<div class="col s12 l7">
				<h3>Remotely monitor Patient Exercise!</h3>
				<blockquote>Review, grade, and take notes of patient performances!</blockquote>
			</div>
		</div>
	</div>
	<div class="parallax-container">
		<div class="parallax"><img src="{{ route('image','highlight_3.png') }}"/></div>
	</div>
	<div class="section" style="background-color:#DFDFDD">
		<div class="row container">
			<div class="col s12 l7">
				<h3>Create Discussion Threads!</h3>
				<blockquote>
					Create articles for your patients to read and react! <br/>
					Be it for a single patient or a group of patients.
				</blockquote>
			</div>
			<div class="col s12 l5">
				<img class="materialboxed responsive-img" src="{{ route('image','feature_4.png') }}"/>
			</div>
		</div>
		<div class="row container">
			<div class="col s12 l7">
				<h3>Interact through THREADS!</h3>
				<blockquote>Reply queries trough the thread's comments section</blockquote>
			</div>
			<div class="col s12 l5">
				<img class="materialboxed responsive-img" src="{{ route('image','feature_5.png') }}"/>
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
