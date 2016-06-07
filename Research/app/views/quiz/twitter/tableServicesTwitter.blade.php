@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

<style>
	#fileConfigured{
		overflow:hidden;
	}
</style>
@if ($user = Sentry::getUser())
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>{{Lang::get('servicesTwitter.service_set')}} </h2>
				
								</header>
				
								<!-- widget div-->
								<div>
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
										@if ($user->hasAccess('twitter.create'))
										{{ HTML::linkAction('SocialHubController@getNewService', Lang::get('servicesTwitter.add_new_service'), '',array('class'=>'btn btn-primary pull-right')) }}
										@endif
										<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">
											<thead>
												<tr>
													<th data-hide="phone">ID</th>
													<th data-class="expand">{{Lang::get('servicesTwitter.name')}}</th>
													<th>{{Lang::get('servicesTwitter.status')}}</th>
													<th data-hide="phone">{{Lang::get('servicesTwitter.last_update')}}</th>
													
													<th data-hide="phone,tablet">{{Lang::get('servicesTwitter.edit')}}</th>

												</tr>
											</thead>
											<tbody>

												@foreach ($services as $service)
													<tr>
														<td >{{ $service['id'] }}</td>
														<td>{{ $service['name_service'] }}</td>
														@if($service['status-service'] == 1)
															<td>
																<div class="checkbox">
																	<label>
																  		{{Form::checkbox('name', 'value',true,['class'=>"checkbox style-0 statuService",'id'=>$service['id']])}}
																  		<span>Desactivar</span>
																	</label>
																</div>
															</td>
														@else
															<td>
																<div class="checkbox">
																	<label>
																  		{{Form::checkbox('name', 'value',false,['class'=>"checkbox style-0 statuService",'id'=>$service['id']])}}
																  		<span>Activar</span>
																	</label>
																</div>
															</td>
														@endif
														@if(isset($service['last_update']))
															<td>{{$service['last_update']}}</td>
														@else
															<td>-----------------------------</td>
														@endif
														
														<td>
															
															{{ HTML::linkAction('SocialHubController@getEditService', '', $service['id'],array('class'=>'btn btn-warning fa fa-edit')) }}
															
														</td>
													</tr>
												@endforeach

											</tbody>
										</table>
									
									</div>
									<!-- end widget content -->
				
								</div>
								<!-- end widget div -->
				
							</div>
							<!-- end widget -->
@endif				
@stop

@section('scripts')
    @parent
    	<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
    	<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
    	<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>


<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
//		$(document).ready(function() {
			pageSetUp();
			
				var responsiveHelper_datatable_col_reorder = undefined;

				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
	    
			/* COLUMN SHOW - HIDE */
			$('#datatable_col_reorder').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"autoWidth" : true,
				"order": [[ 1, "asc" ]],
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_col_reorder) {
						responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_col_reorder.respond();
				}

			});
			
			/* END COLUMN SHOW - HIDE */

			$(".statuService").on('change',function(){
				
				var statuService = $(this),
					desactivar = 'Desactivar',
					activar = 'Activar',
					status = 0;

				if ( $("#"+statuService.attr('id')).is(':checked') ){
					status = 1;
					$(this).parent().find('span').text(desactivar)
				}else{
					status = 0;
					$(this).parent().find('span').text(activar)
				}

				url = window.location.pathname;

				( url.substr(-1)!='/')? change_status = "/change-status" : change_status = "change-status";

				$.ajax({
					url: window.location.pathname+change_status,
					type: 'GET',
					data: {status:status,id:statuService.attr('id')},
					dataType: 'JSON',
					success: function(data){
						//console.log(data)
					}
				});


			});

			$(".dt-toolbar>div:eq(1)").append($("<button>",{id:'btnBackup'}).addClass('btn btn-labeled btn-danger pull-right').append($("<span>").addClass("btn-label").append($("<i>").addClass('fa fa-save'))).append($("<span>",{text:'Backup'})));
			
			$("#btnBackup").on("click",function(){

				$(this).removeClass('btn-danger').addClass('btn-warning').find('i').removeClass('fa-save').addClass("fa-gear fa-spin");

				$.get( "/social-hub/backup", function( data ) {
					alert("Se ha respaldado correctamente")
					$('#btnBackup').removeClass('btn-warning').addClass(' btn-danger').find('i').removeClass('fa-gear fa-spin').addClass("fa-save");

				});
			});

		
//		})

		</script>


@stop