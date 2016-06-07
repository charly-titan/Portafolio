@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
@if ($user = Sentry::getUser())

					<!-- START ROW -->
					<div class="row">
						<!-- NEW COL START -->
						<article class="col-sm-12 col-md-12 col-lg-12">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>Listado de Servicios para versus</h2>
				
								</header>
				
								<!-- widget div-->
								<div>
									<!-- widget content -->
									<div class="widget-body form-horizontal">
											<fieldset>			

												<div class="form-group">
													<section class="col-md-8">
														<label class="col-md-2 control-label" for="select-1">Servicios</label>
														<div class="col-md-10">


														@if(isset($services))
															<select class="select2"  id='option_service'>
																<option></option>
																@foreach($services as $service)
																	<option value="{{$service['id']}}">{{$service['name_service']}}</option>
																@endforeach
															</select>
														@endif
									
									
														</div>
													</section>
													<section class="col-md-2" id='active_service'></section>
													<section class="col-md-2" id='save_service_versus'></section>
													
												</div>

											</fieldset>
									</div>
									<!-- end widget content -->
								</div>
								<!-- end widget div -->



							</div>

							<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Versus configurados</h2>
				
								</header>
				
								<!-- widget div-->
								<div>
									<div class="widget-body no-padding">
												<table id="dt_basic" class="table table-hover" width="100%">
												<thead>			                
													<tr>
														<th >ID</th>
														<th >{{Lang::get('servicesTwitter.name')}}</th>
														<th>{{Lang::get('servicesTwitter.status')}}</th>
														<th>{{Lang::get('servicesTwitter.last_update')}}</th>
													</tr>
												</thead>
												<tbody id='listVersus'>

												@if($versus_configured)
													@foreach($versus_configured as $versus)
														<tr>
															<td>{{$versus['id_service']}}</td>
															<td><a style="cursor: pointer" class='myModal' data-toggle="modal" data-target="#myModal" id="{{$versus['id_service']}}">{{$versus['name_service']}}</a></td>
															<td>
																<label class='checkbox-inline'>
																	{{ Form::checkbox('versusStatus', 1, $versus['status'], ['class' => 'checkbox style-0 chkStatus','id'=>$versus['id']]) }}
																	<span id='status-type-service'>{{ $versus['status'] ? 'Desactivar' : 'Activar';}}</span>
																</label>
															</td>
															<td></td>
														</tr>
													@endforeach
												@endif

												</tbody>
											</table>
									</div>
								</div>
							</div>

						</article>

					</div>



				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title" id="myModalLabel"></h4>
							</div>
							<div class="modal-body" >

								<table class="table table-bordered">
									<thead>
										<tr>
											<th style="width:50%">Hastags</th>
											<th style="width:50%">Tweets</th>
										</tr>
									</thead>
										<tbody id='modalVersus'></tbody>
									</table>
						
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			

@endif				
@stop

@section('scripts')
    @parent
	<script src="https://cdn.firebase.com/js/client/2.4.0/firebase.js"></script>
	
	<script src="/js/plugin/select2/select2.min.js"></script>
	<script src="/js/notification/SmartNotification.min.js"></script>


	<!-- PAGE RELATED PLUGIN(S) -->
		<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script src="/js/twitter_versus.js"></script>

@stop