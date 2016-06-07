<?php $page_id="lock-page"; ?>
@extends(Config::get( 'app.main_template' ).'.main')

@section('aside_left')
@stop

@section('head')
@stop

@section('css')
@parent
<!-- page related CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="/css/lockscreen.min.css">
@stop

@section('content')
			<!--form class="lockscreen animated flipInY" action="index.html"-->
				{{Form::open(array('url' => '/user/googleauth', 'id'=>'googleAuth', "class"=>"lockscreen animated flipInY", 'method' => 'post'))}}
				<div class="logo">
					<h1 class="semi-bold"><img src="/img/logo-o.png" alt="" /> {{Lang::get('research.app_name')}}</h1>
				</div>
				<div>
					
					<img src="http://www.gravatar.com/avatar/{{Session::get('user.gravatar')}}" alt="me" width="120" height="120" />
					<div>
						<h1><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i>{{Session::get('user.firstname')}} {{Session::get('user.lastname')}} <small><i class="fa fa-lock text-muted"></i> &nbsp;{{Lang::get("users.locked_user")}}</small></h1>
						<p class="text-muted">
							{{Lang::get("users.locked")}}
						</p>

						<div class="input-group">
							<input class="form-control" name="auth2step" maxlength="7" type="text" placeholder="{{Lang::get('users.locked_placeholder')}}">
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">
									<i class="fa fa-key"></i>
								</button>
							</div>
						</div>
						@if($errors->any())
						<!--
																{{ ($error_tries_num= (Session::has('user.autherror'))?intval(Session::get('user.autherror')):0);}}
																-->
						<p class="no-margin margin-top-5 alert alert-danger fade in">
							{{Lang::get("users.locked_error",array('error_tries'=>  ( intval(Config::get('app.error_tries')) - $error_tries_num ))) }}
						</p>
						@endif
					</div>

				</div>
				<p class="font-xs margin-top-5">
					

				</p>
			{{ Form::close() }}
@stop