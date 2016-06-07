@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('content')

<style>
	td.btnAlign{text-align: center;}
</style>

<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2>{{Lang::get('contest.listContest')}}</h2> 
				@if ($user = Sentry::getUser())
				@endif
				@if ($user->hasAccess('promo.create'))
				<a class="btn btn-warning btn-xs pull-right" href="/contest/create">{{Lang::get('contest.createContest')}}</a>
				@endif
			</header>
			<div>
			<div class="widget-body no-padding">	

				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
					<thead>			                
						<tr>
							<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.name')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-cubes txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.typeContest')}} </th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.startDate')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.endDate')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.activationDate')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-pencil txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.contestUpdate')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-file-excel-o txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.generateCSV')}}</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw fa-edit txt-color-blue hidden-md hidden-sm hidden-xs"></i> {{Lang::get('contest.reviewAnswers')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($dataContest as $key => $value)
						<tr>
							<td>{{$value->short_name}}</td>
							<td>{{$value->contest_type}}</td>
							<td>{{$value->start_date}}</td>
							<td>{{$value->end_date}}</td>
							<td>{{$value->activation_date}}</td>
							<td class='btnAlign'>
								{{ HTML::linkAction('ContestController@getContestdetails', '', $value->id_contest,array('class'=>'btn btn-warning fa fa-edit')) }}
							</td>
							<td class='btnAlign'>	
								{{ HTML::linkAction('ContestController@getReportCsv', '', $value->id_contest,array('class'=>'btn bg-color-pinkDark txt-color-white fa fa-file-text-o')) }}
								@if ($user->hasAccess('info.download') && (($value->contest_type == 'Frase') or ($value->contest_type == 'frase')))
									{{ HTML::linkAction('ContestController@getReportPdf', '', $value->id_contest,array('class'=>'btn bg-color-redLight txt-color-white fa  fa-file-pdf-o')) }}
								@endif
								@if ($user->hasAccess('info.download') && ($value->contest_type == 'versus'))
									{{ HTML::linkAction('ContestController@getReportPdfVersus', '', $value->id_contest,array('class'=>'btn bg-color-redLight txt-color-white fa  fa-file-pdf-o')) }}
								@endif
								@if ($user->hasAccess('info.download') && ($value->contest_type == 'video'))
									{{HTML::linkAction('QuestionController@getPdfContestVideo', '', $value->id_contest,array('class'=>'btn bg-color-redLight txt-color-white fa  fa-file-pdf-o'))}}
								@endif
								@if($value->channel == 'television')
									{{HTML::linkAction('QuestionController@getPdfContestTelevision', '', $value->id_contest,array('class'=>'btn bg-color-redLight txt-color-white fa  fa-file-pdf-o'))}}								
								@endif	
								
							</td>
							<td>
								@if($value->contest_type == 'quiz')
									@if( strtotime($value->end_date) < strtotime(date('Y/m/d h:i A')) )

										{{ HTML::linkAction('QuestionController@getResponsesValue', '', $value->id_contest,array('class'=>'btn btn-warning fa fa-edit')) }}

										@if($value->statusPDF)
												{{HTML::linkAction('QuestionController@getPdfContestPoints', '', $value->id_contest,array('class'=>'btn bg-color-redLight txt-color-white fa  fa-file-pdf-o'))}}
										@endif
									@endif
							
								@endif
								@if($value->contest_type == 'foto')
									{{HTML::linkAction('FotosController@getOption', '', $value->id_contest,array('class'=>'btn btn-info fa fa-check-square-o', 'alt'=>'Aprobar fotos'))}}
								@endif
								@if($value->contest_type == 'video')
									{{HTML::linkAction('VideosController@getAprobarVideos', '', $value->id_contest,array('class'=>'btn btn-info fa fa-check-square-o'))}}
								@endif
								
							</td>
							
						</tr>					
							
						@endforeach
								{{--@if (Session::has('msgCsv'))
   									<div class="alert alert-info">{{ Session::get('msgCsv') }}</div>
								@endif--}}
					</tbody>
				</table>

			</div>
		</div>
	</div>
</article>
	</div>
@stop


@section('scripts')
    @parent

 {{ HTML::script("js/plugin/jquery-touch/jquery.ui.touch-punch.min.js") }}


    {{ HTML::script("js/plugin/datatables/jquery.dataTables.min.js") }}
    {{ HTML::script("js/plugin/datatables/dataTables.colVis.min.js") }}
    {{ HTML::script("js/plugin/datatables/dataTables.tableTools.min.js") }}
    {{ HTML::script("js/plugin/datatables/dataTables.bootstrap.min.js") }}
    {{ HTML::script("js/plugin/datatable-responsive/datatables.responsive.min.js") }}

    <script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();

	
			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
	
				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});
	
			/* END BASIC */
			
			/* COLUMN FILTER  */
		    var otable = $('#datatable_fixed_column').DataTable({
		    	//"bFilter": false,
		    	//"bInfo": false,
		    	//"bLengthChange": false
		    	//"bAutoWidth": false,
		    	//"bPaginate": false,
		    	//"bStateSave": true // saves sort state using localStorage
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_fixed_column) {
						responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_fixed_column.respond();
				}		
			
		    });
		    
		    // custom toolbar
		    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
		    	   
		    // Apply the filter
		    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
		    	
		        otable
		            .column( $(this).parent().index()+':visible' )
		            .search( this.value )
		            .draw();
		            
		    } );
		    /* END COLUMN FILTER */   
	    
			/* COLUMN SHOW - HIDE */
			$('#datatable_col_reorder').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"autoWidth" : true,
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
	
			/* TABLETOOLS */
			$('#datatable_tabletools').dataTable({
				
				// Tabletools options: 
				//   https://datatables.net/extensions/tabletools/button_options
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
		        "oTableTools": {
		        	 "aButtons": [
		             "copy",
		             "csv",
		             "xls",
		                {
		                    "sExtends": "pdf",
		                    "sTitle": "SmartAdmin_PDF",
		                    "sPdfMessage": "SmartAdmin PDF Export",
		                    "sPdfSize": "letter"
		                },
		             	{
	                    	"sExtends": "print",
	                    	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
	                	}
		             ],
		            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
		        },
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_tabletools) {
						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_tabletools.respond();
				}
			});
			
			/* END TABLETOOLS */
		
		})

		</script>



@stop