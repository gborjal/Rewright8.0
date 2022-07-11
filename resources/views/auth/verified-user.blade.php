@extends('index_master')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col s12 m6 l6 offset-m3 offset-l3">
				<div id="f" class="card-panel medium teal">
					<span class="white-text">
						E-mail verified!<br/>
						<a href="{!! route('login') !!}">Go to Login page</a>
			        </span>	
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
