<?php $page_id="extr-page"; ?>
@extends(Config::get( 'app.main_template' ).'.main')

@section('aside_left')
@stop



@section('css')
@parent
<!-- page related CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/lockscreen.min.css">
@stop

@section('content')



	<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button-->
								<h4 class="modal-title" id="myModalLabel">{{Lang::get("users.twostepverification_title")}}</h4>
							</div>
							<div class="modal-body">
				
								<!-- widget content -->
									<div class="widget-body fuelux">
				
										<div class="wizard">
											<ul class="steps">
												<li data-target="#step1" class="active">
													<span class="badge badge-info">1</span>{{Lang::get("users.twostepverification_step1")}}<span class="chevron"></span>
												</li>
												<li data-target="#step2">
													<span class="badge">2</span>{{Lang::get("users.twostepverification_step2")}}<span class="chevron"></span>
												</li>
												<li data-target="#step3">
													<span class="badge">3</span>{{Lang::get("users.twostepverification_step3")}}<span class="chevron"></span>
												</li>
												
											</ul>
											<div class="actions">
												<button type="button" class="btn btn-sm btn-primary btn-prev">
													<i class="fa fa-arrow-left"></i>Prev
												</button>
												<button type="button" class="btn btn-sm btn-success btn-next" data-last="Finish">
													Next<i class="fa fa-arrow-right"></i>
												</button>
											</div>
										</div>
										<div class="step-content">
											
				
												<div class="step-pane active" id="step1">
													<h3><strong>{{Lang::get("users.twostepverification_step1")}}</strong> - {{Lang::get("users.twostepverification_step1_title")}}</h3>
				




							<div class="row">
								<div class="col-md-4">
									<a href="https://support.google.com/accounts/answer/1066447?hl=es" target="_blank"><img src="/img/reference/google_auth_install.png" class="img-responsive" alt="img"></a>
									<ul class="list-inline padding-10">
										<li>
											<a href="https://support.google.com/accounts/answer/1066447?hl=es" target="_blank"> Ver tutorial </a>
										</li>
									</ul>
								</div>
								<div class="col-md-8 padding-left-0">

									<p>
										{{Lang::get("users.twostepverification_step1_txt")}}
									</p>
									<div class="text-center">
														<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" class="btn btn-primary btn-circle btn-xl" target="_blank"><i class="fa fa-android"></i></a>

														<a href="http://itunes.apple.com/us/app/google-authenticator/id388497605" class="btn btn-primary btn-circle btn-xl" target="_blank"><i class="fa fa-apple"></i></a>

														<a href="http://apps.microsoft.com/windows/en-us/app/google-authenticator/7ea6de74-dddb-47df-92cb-40afac4d38bb" target="_blank" class="btn btn-primary btn-circle btn-xl"><i class="fa fa-windows"></i></a>

									</div>
								</div>
							</div>

													

													
				
												</div>
				
												<div class="step-pane" id="step2">
													<h3><strong>{{Lang::get("users.twostepverification_step2")}} </strong> - {{Lang::get("users.twostepverification_step2_title")}}</h3>
													


							<div class="row">
								<div class="col-md-5">
									{{ HTML::image($google2fa_url) }}
									
								</div>
								<div class="col-md-7 padding-left-0">

									<p>
										{{Lang::get("users.twostepverification_step2_txt")}}
									</p>
									
								</div>
							</div>

				
													
				
												</div>
				
												<div class="step-pane" id="step3">

													{{Form::open(array('url' => '/user/googleauth', 'id'=>'googleAuth', 'method' => 'post'))}}
													<h3><strong>{{Lang::get("users.twostepverification_step3")}}  </strong> - {{Lang::get("users.twostepverification_step3_title")}}</h3>

													<div>											
														<div>
															<h1>{{Session::get('user.firstname')}} {{Session::get('user.lastname')}} <small><i class="fa fa-lock text-muted"></i> &nbsp;{{Lang::get("users.locked_user")}}</small></h1>
															<p class="text-muted">
																{{Lang::get("users.locked")}}
															</p>

															<div class="input-group {{($errors->any())?'has-error':''}}">
																<input class="form-control " type="text" name="auth2step" placeholder="{{Lang::get('users.locked_placeholder')}}" maxlength="7">
																<div class="input-group-btn">
																	<button class="btn btn-primary" type="submit">
																		<i class="fa fa-key"></i>
																	</button>
																</div>
															</div>
															@if($errors->any())
															<p class="no-margin margin-top-5 alert alert-danger fade in">


																<!--
																{{ ($error_tries_num= (Session::has('user.autherror'))?intval(Session::get('user.autherror')):0);}}
																-->
																{{Lang::get("users.locked_error",array('error_tries'=>  ( intval(Config::get('app.error_tries')) - $error_tries_num ))) }}
															</p>
															@endif
														</div>

													</div>
													<p class="font-xs margin-top-5">
														

													</p>
												{{ Form::close() }}
												</div> <!-- step 3 -->
				
												
				
											
										</div>
				
									</div>
									<!-- end widget content -->
				
							</div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->



@stop

@section('scripts')
@parent
<!-- PAGE RELATED PLUGIN(S) -->
		<script src="/js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
		<script src="/js/plugin/fuelux/wizard/wizard.min.js"></script>
		

		<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();
			
			
	
			
			  
		
			// fuelux wizard
			  var wizard = $('.wizard').wizard();
			  
			  wizard.on('finished', function (e, data) {
			    $("#googleAuth").submit();
			    //console.log("submitted!");
			    $.smallBox({
			      title: "Congratulations! Your form was submitted",
			      content: "<i class='fa fa-clock-o'></i> <i>1 seconds ago...</i>",
			      color: "#5F895F",
			      iconSmall: "fa fa-check bounce animated",
			      timeout: 4000
			    });
			    
			  });

		

		$('#myModal').modal('show');
		});

		@if($errors->any())
			$('.wizard').wizard('selectedItem', {
			    step: 3
			  });
		@endif

		</script>
@stop