@extends('index_master')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col s12 m6 l6 offset-m3 offset-l3">
				<div id="f" class="card medium">
					<ul class="tabs">
						<li class="tab col s3"><a class="blue-text text-accent-4" href="#div_login" onclick="changeRegCard(0);">Register</a></li>
						<div class="indicator blue darken-4" style="z-index:1"></div>
					</ul>
					<div id="div_login" class="col s12">
						<br/>
						{!! Form::open(['route'=>'registerByNormal','method'=>'POST']) !!}
							
        					<div class="input-field">
								{!! Form::text('email',null,['placeholder'=>'username or email','class'=>'validate']) !!}
								<label for="email">Username/Email</label>
							</div>
							<div class="input-field">
								{!! Form::password('r_password',['id'=>'r_password1','class'=>'form-control password', 'onchange'=>'chk_pword()']) !!}
								<label id="label_pword" for="r_password">Password</label>
							</div>
							<div class="input-field">
								<label id="label_pword" for="r_password">Password</label>
								{!! Form::password('r_password',['id'=>'r_password2','class'=>'form-control password', 'placeholder' =>'Re-type password', 'onchange'=>'chk_pword()','onkeypress'=>'chk_pword()']) !!}
							</div>
							{!! Form::hidden('password','null',['id'=>'password']) !!}	
							<button class="btn waves-effect blue darken-4" type="submit" formmethod="post">Register
							    <i class="large material-icons right">send</i>
			  				</button>
						{!! Form::close() !!}
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
			function chk_pword()
			{
				var p1 = document.getElementById('r_password1');
				var p2 = document.getElementById('r_password2');

				if(!(p1.value === p2.value))
				{
					document.getElementById('label_pword').innerHTML = '<h6><b>Passwords MUST match!</b></h6>';
					document.getElementById('label_pword').style.color = 'green';
					document.getElementById('sub').disabled=true;
					return false;
				}else
				{
					document.getElementById('label_pword').innerHTML = 'Passwords match!';
					document.getElementById('label_pword').style.color = '#B71C1C';
					document.getElementById('password').value = document.getElementById('r_password2').value;
					document.getElementById('sub').disabled=false;
					return true;
				}
			}
		</script>
	@endif
@stop
