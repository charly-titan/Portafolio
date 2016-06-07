<?php $page_id="extr-page"; ?>
@extends(Config::get( 'app.main_template' ).'.main')
<style>
	.error{color: red;}
</style>
@section('content')
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
						<h1 class="txt-color-red login-header-big">{{Lang::get('research.app_name')}}</h1>
						<div class="hero">

							<div class="pull-left login-desc-box-l">
								<h4 class="paragraph-header">{{Lang::get('research.app_description')}}</h4>
								
							</div>
							
							<img src="/img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">{{Lang::get('research.app_feature01_title')}}</h5>
								<p>
									{{Lang::get('research.app_feature01')}}
								</p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">{{Lang::get('research.app_feature02_title')}}</h5>
								<p>
									{{Lang::get('research.app_feature02')}}
								</p>
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
						<div class="well no-padding">
						{{Form::open(array('method'=>'POST','url'=>'user/login','id'=>'login-form','class'=>'smart-form client-form'))}}
							<form action="index.html" id="login-form" class="smart-form client-form">
								<header>
									{{Lang::get('users.sign_in')}}
								</header>

								<fieldset>
										

										@if($errors->first('msg'))
											<div class="alert alert-danger fade in">
												<button class="close" data-dismiss="alert">
													×
												</button>
												<i class="fa-fw fa fa-times"></i>
												<strong>Error! </strong>{{ $errors->first('msg') }}
											</div>
										@endif
									<section>
										<label class="label">{{Lang::get('users.email')}}</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											{{Form::text('email')}}
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> {{Lang::get('users.email_placeholder')}}</b></label> <span class="error">{{ $errors->first('email') }}</span>
									</section>

									<section>
										<label class="label">{{Lang::get('users.password')}}</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											{{Form::password('password')}}
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{Lang::get('users.password_placeholder')}}</b> </label> <span class="error">{{ $errors->first('password') }}</span>
										<div class="note">
											{{ HTML::linkAction('UsersController@getForgotpassword',Lang::get('users.forgot_password')) }}
										</div>
									</section>

									<section>
										<label class="checkbox">
												{{Form::checkbox('remember','',true)}}
											<i></i>{{Lang::get('users.stay_signed')}}</label>
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										{{Lang::get('users.signin')}}
									</button>
								</footer>
							</form>

						</div>
						
						<h5 class="text-center"> {{Lang::get('users.signin_using')}}</h5>
															
						<center>
							<a href="/social" class="btn btn-danger btn-sm">{{Lang::get('users.google_signin')}}</a>
						</center>

					</div>
				</div>
@stop

@section('css')
	@parent
	<style>
		#extr-page #header{overflow:visible;}
	</style>
@stop

@section('content')
	@parent
		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						email : {
							required : true,
							email : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						email : {
							required : 'Please enter your email address',
							email : 'Please enter a VALID email address'
						},
						password : {
							required : 'Please enter your password'
						}
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>
@stop	