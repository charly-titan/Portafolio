<?php $page_id="extr-page"; ?>
@extends(Config::get( 'app.main_template' ).'.main')

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
						{{Form::open(array('method'=>'POST','url'=>'user/changepass/'.$idUser,'id'=>'login-form','class'=>'smart-form client-form'))}}
							<form action="index.html" id="login-form" class="smart-form client-form">
								<header>
									<div class="jarviswidget-ctrls" role="menu"> 
										<a href="user/login" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
									</div>
									{{Lang::get('users.password_placeholder')}}
								</header>

								<fieldset>
									
									<section>
										<label class="label">{{Lang::get('users.password')}}</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											{{Form::password('password')}}
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{Lang::get('users.password_placeholder')}}</b> </label>{{ $errors->first('password') }}
									</section>
									<section>
										<label class="label">{{Lang::get('users.repeat_password')}}</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											{{Form::password('password_repeat')}}
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{Lang::get('users.password_placeholder')}}</b> </label>{{ $errors->first('password_repeat') }}
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										{{Lang::get('users.send')}}
									</button>
								</footer>
							</form>

						</div>
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
						}
					},

					// Messages for form validation
					messages : {
						email : {
							required : 'Please enter your email address',
							email : 'Please enter a VALID email address'
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



