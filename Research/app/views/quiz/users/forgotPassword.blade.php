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
						{{Form::open(array('method'=>'POST','url'=>'user/forgotpassword','id'=>'login-form','class'=>'smart-form client-form'))}}
							<form action="index.html" id="login-form" class="smart-form client-form">
								<header>
								<div class="jarviswidget-ctrls" role="menu"> 
									<a href="user/login" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
								</div>
									{{Lang::get('users.email_placeholder')}}
								</header>

								<fieldset>
									
									<section>
										<label class="label">{{Lang::get('users.email')}}</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											{{Form::text('email')}}
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> {{Lang::get('users.email_placeholder')}}</b></label><span class="error">{{ $errors->first('email') }}</span>
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										{{Lang::get('users.email_request')}}
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


@section('scripts')
 @parent

    @if(Session::has('msg')) 
       <script type="text/javascript">

            window.onload = function() {

                var leng = navigator.language || navigator.userLanguage; 

                if(leng == 'es'){msg = "Debes esperar al menos 5 minutos para volver a solicitar la contraseña"}
                else{msg = "You must wait at least 5 minutes to re-request the password"}

                alert(msg)
            	window.location.href = "user/login";
            }
          </script>    
    @endif
    @if(Session::has('msgAviso')) 
          <script type="text/javascript">

           window.onload = function() {

                var leng = navigator.language || navigator.userLanguage; 

                if(leng == 'es'){msgAviso = "Ya solicitaste cambio de contraseña favor de checar tu correo"}
                else{msgAviso = "Because you've requested password change please check your email"}

                alert(msgAviso)
                window.location.href = "user/login";
            }
          </script>      
    @endif


    @if(Session::has('msgEnviado')) 
          <script type="text/javascript">

            window.onload = function() {

                var leng = navigator.language || navigator.userLanguage; 

                if(leng == 'es'){msgEnviado = "Se te han enviado instrucciones para cambiar la contraseña en tu correo";}
                else{msgEnviado = "Instructions sent to you to change your password in your email";}

                alert(msgEnviado)
                window.location.href = "user/login";
            }

            
          </script>      
    @endif
    @if(Session::has('msgError')) 
          <script type="text/javascript">

             window.onload = function() {

                var leng = navigator.language || navigator.userLanguage; 

                if(leng == 'es'){msgError = "No se encuentra el usuario";}
                else{msgError = "User can not be found";}

                alert(msgError)
            }

          </script>      
    @endif

@stop
