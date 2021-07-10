@extends('masterAdmin')

@section('content')

	<div id='top'></div>
	<header>	
		<nav class="top-nav grey darken-4">
			<div class="container">
				<div class="nav-wrapper">
					<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">dashboard</i></a>			
					<ul class="right hide-on-med-and-down">
						<li><a href="{!! route('logoutAdmin') !!}">logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<ul id="nav-desktop" class="sidenav sidenav-fixed">
			<li class="no-padding">
				<a href="#!" id='db_manage'>
					<i class="material-icons left">work</i>Manage 				{{-- Manage --}}
				</a>
			</li>										
			<li class="no-padding" id='db_profile'>
				<a href="#m_personal" class="modal-trigger">
					<i class="material-icons left">face</i> Profile	{{-- Profile --}}
				</a>
			</li>	
		</ul>
		<ul id="slide-out" class="sidenav">
			<li class="no-padding">																		{{-- Manage --}}
				<ul id="manageMenu" class="collapsible">
					<li>
						<div class="collapsible-header"><i class="material-icons left">work</i>Manage</div>
						<div class="collapsible-body">
							<ul>
								<li class="blue-text text-darken-4"><a href = "#!" onclick = "$('ul.tabs').tabs('select', 'manageUser');">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspUser</a></li>
								<li class="blue-text text-darken-4"><a href = "#!" onclick = "$('ul.tabs').tabs('select', 'managePG');">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPatient Group</a></li>
								<li class="blue-text text-darken-4"><a href = "#!" onclick = "$('ul.tabs').tabs('select', 'manageDiscussion');">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDiscussions</a></li>
								<li class="blue-text text-darken-4"><a href = "#!" onclick = "$('ul.tabs').tabs('select', 'manageTask');">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTasks</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
			<li class="no-padding">																		{{-- Profile --}}
				<ul id="profileMenu" class="collapsible">
					<li>
						<div class="collapsible-header"><i class="material-icons left">perm_identity</i>{{ Auth::user()->username }}</div>
						<div class="collapsible-body">
							<ul>
								<li><a href="#m_personal" class="modal-trigger">Profile</a></li>
								<li><a href="{!! route('logoutAdmin') !!}"><i class="material-icons">exit_to_app</i></a></li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</header>
	<main>
		<!-- General Body -->
		<div id="genContent" style="min-height:520px; ">
			<div class="row">
				<div class="col s12 m12 l12">
					<div class="row">
						<div class="col s12 m12 l7 offset-l3">
							<div class="row">
								<div id = "manage">
									<div class="col s12 hide-on-med-and-down">
										<ul class="tabs" id = "menu_tabs">
											<li class="tab col s3"><a class="active" href="#manageUser">User</a></li>
											<li class="tab col s3"><a href="#managePG">Patient group</a></li>
											<li class="tab col s3"><a href="#manageDiscussion">Discussions</a></li>
											<li class="tab col s3"><a href="#manageTask">Tasks</a></li>
										</ul>
									</div>
								</div>
								<div id = "manageUser">
									<nav class = "hide-on-large-only light-blue darken-4">
										<div class="nav-wrapper">
											<div class="col s12">
												<a href="#!" class="breadcrumb">Users</a>
											</div>
										</div>
									</nav>
									<div class="col s12">
										<ul class = "pagination">
											<li class = "light-blue darken-4 active" id = "li_c_user"><a id = "a_c_user" href="#!">Create</a></li>
											<li id = "li_activation"><a id = "a_activation" href="#!">Activation Code</a></li>
										</ul>
										
									</div>
									<div id="createUser" class="col s12">
										{!! Form::open(['route'=>'registerByAdmin','id'=>'f_reg']) !!}
										{!! csrf_field() !!}
											
											{!! Form::email('email',null,['class'=>'form-control']) !!}
											<label for="email">Email</label>
											<div class="input-field col s12">
												<select name='user_types'>		{{-- get this from db next time for scalability--}}
													<option value="" disabled selected>Choose your option</option>
													<option value="1">Physician</option>
													<option value="2">Patient</option>
												</select>
												<label>Type:</label>
											</div>
											<br/><br/>
											
										{!! Form::close() !!}<button id="sub" class="btn waves-effect light-blue darken-3" onclick="submitRegForm()">Create Account
												<i class="material-icons right">done</i>
											</button>
										<div id = "code" class="input-field col s12">

										</div>
									</div>
									<div id="getActivationCode" class="col s12" style = "display:none;">
										{!! Form::open(['route'=>'getActivationCode','id'=>'f_activation']) !!}
										{!! csrf_field() !!}
											
											{!! Form::email('email',null,['class'=>'form-control']) !!}
											<label for="email">Email</label>
											<br/><br/>
											
										{!! Form::close() !!}<button id="sub" class="btn waves-effect light-blue darken-3" onclick="submitActivationForm()">Get Code
												<i class="material-icons right">done</i>
											</button>
										<div class="input-field col s12">
											<ul class = "collection" id = "codeActivation"></ul>
										</div>
									</div>
								</div>
								<div id = "managePG">
									<div class="col s12">
										<nav class = "hide-on-large-only light-blue darken-3">
											<div class="nav-wrapper">
												<div class="col s12">
													<a href="#!" class="breadcrumb">Patient Group</a>
												</div>
											</div>
										</nav>
									</div>
									<div id="test1" class="col s12">
											<div class="search-wrapper card">
											{!! Form::open(['route'=>'getPatientGroup','id'=>'f_getPatientGroup']) !!}
											{!! csrf_field() !!}
												<div class="input-field">
													<input type="search" id="search" name = "search" class = "btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="Physician email/name or Group ID" required = "required" onkeyup="searchPatientGroup();" />
													<label for="search"><i class="material-icons">search</i></label>
													<i class="material-icons">close</i>
												</div>
											{!! Form::close() !!}
											</div>
										
										<div class="input-field col s12">
											<ul class = "collection" id = "patientGroups"></ul>
										</div>
									</div>
								</div>
								<div id = "manageDiscussion">
									<div class="col s12">
										<nav class = "hide-on-large-only light-blue darken-3">
											<div class="nav-wrapper">
												<div class="col s12">
													<a href="#!" class="breadcrumb">Discussions</a>
												</div>
											</div>
										</nav>
									</div>
									<div id="test1" class="col s12">Test 1</div>
								</div>
								<div id = "manageTask">
									<div class="col s12">
										<nav class = "hide-on-large-only light-blue darken-3">
											<div class="nav-wrapper">
												<div class="col s12">
													<a href="#!" class="breadcrumb">Tasks</a>
												</div>
											</div>
										</nav>
									</div>
									<div id="test1" class="col s12">Test 1</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End of General Body -->
		<!-- Modals -->
		
		<div id="m_personal" class="modal modal-fixed-footer">
			
			{!! Form::open() !!}
			<div class="modal-content">
				<h4>Profile</h4>
				<div class="row">
					<div class="col s12 m12 l12">
						{!! Form::text('username',Auth::user()->username) !!}
						<label for="username">Username</label>
					</div>
					
					
					@if( isset(Auth::user()->userInformation) )
						<div class="col s12 m3 l3">
							{!! Form::text('first_name',Auth::user()->userInformation->first_name) !!}
							<label for="first_name">First</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('middle_name',Auth::user()->userInformation->middle_name) !!}
							<label for="middle_name">Middle</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('last_name',Auth::user()->userInformation->last_name) !!}
							<label for="last_name">Last</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('suffix_name',Auth::user()->userInformation->suffix_name) !!}
							<label for="suffix_name">Suffix</label>
						</div>
						<div class="col s12 m3 l3">
							<label>Gender:</label>
							<select name="sex">
								@if( Auth::user()->userInformation->sex === 'MALE')
									<option value="MALE" selected>Male</option> 
								@else
									<option value="MALE">Male</option> 
								@endif
								@if( Auth::user()->userInformation->sex === 'FEMALE')
									<option value="FEMALE" selected>Female</option>
								@else
									<option value="FEMALE" >Female</option> 
								@endif
							</select>
						</div>
						<div class="col s12 m12 l12">
							{!! Form::text('perm_address',Auth::user()->userInformation->perm_address) !!}
							<label for="perm_address">Permanent Address</label>
						</div>
						<div class="col s12 m12 l12">
							{!! Form::text('tempo_address',Auth::user()->userInformation->tempo_address) !!}
							<label for="tempo_address">Temporary Address</label>
						</div>
						@if(Auth::user()->user_type === '1')
						<div class="col s12 m12 l12">
							{!! Form::text('office_address',Auth::user()->userInformation->office_address) !!}
							<label for="office_address">Office Address</label>
						</div>
						@endif
					@else
						<div class="col s12 m3 l3">
							{!! Form::text('first_name') !!}
							<label for="first_name">First</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('middle_name') !!}
							<label for="middle_name">Middle</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('last_name') !!}
							<label for="last_name">Last</label>
						</div>
						<div class="col s12 m3 l3">
							{!! Form::text('suffix_name') !!}
							<label for="suffix_name">Suffix</label>
						</div>
						<div class="col s12 m3 l3">
							<label>Gender:</label>
							<select name="sex">
								<option value="MALE">Male</option>
								<option value="FEMALE" >Female</option> 
							</select>
						</div>
						<div class="col s12 m12 l12">
							{!! Form::text('perm_address') !!}
							<label for="perm_address">Permanent Address</label>
						</div>
						<div class="col s12 m12 l12">
							{!! Form::text('tempo_address') !!}
							<label for="tempo_address">Temporary Address</label>
						</div>
						<div class="col s12 m12 l12">
							{!! Form::text('office_address') !!}
							<label for="office_address">Office Address</label>
						</div>
					@endif
				</div>

				<div id="div_extra_dtls"></div>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="">Save</a>
			</div>
			{!! Form::close() !!}
		</div>
		
		<!-- End of modals -->
	</main>
    
@stop