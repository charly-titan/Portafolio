@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

@if ($userPermission["view"])
	<!-- widget grid -->

<section id="widget-grid" class="">
<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Usuarios</h2>
				
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
				
										<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
					
									        <thead>
									        	<tr>
									        		<th colspan="7">{{ HTML::link('user/telegram','',array('class' => 'btn btn-info fa fa-send fa-lg pull-right')) }}</th>
									        		<th colspan="9">{{ HTML::link('user/formaccount',' +',array('class' => 'btn btn-info fa fa-user fa-lg pull-right')) }}</th>
									        	</tr>

												<tr>
													<th class="hasinput" style="width:12%">
														<input type="text" class="form-control" placeholder="{{Lang::get('users.name')}}" />
													</th>
													<th class="hasinput" style="width:12%">
														<input class="form-control" placeholder="{{Lang::get('users.last_name')}}" type="text">	
													</th>
													<th class="hasinput" style="width:12%"></th>
													<th class="hasinput" style="width:12%"></th>
													<th class="hasinput" style="width:12%"></th>
													<th class="hasinput" style="width:12%">
														<input type="text" class="form-control" placeholder="{{Lang::get('users.roles')}}" />
													</th>
													@if ($userPermission["create"])
										            	<th class="hasinput" style="width:3%"></th>
										            @endif
										            @if ( $userPermission["delete"])
										            	<th class="hasinput" style="width:3%"></th>
										            @endif
												</tr>
									            <tr>
								                    <th data-class="expand">{{Lang::get('users.name')}}</th>
								                    <th>{{Lang::get('users.last_name')}}</th>
								                    <th data-hide="phone">{{Lang::get('users.last_login')}}</th>
								                    <th data-hide="phone">{{Lang::get('users.created_at')}}</th>
								                    <th data-hide="phone,tablet">{{Lang::get('users.updated_at')}}</th>
								                    <th data-hide="phone,tablet">{{Lang::get('users.roles')}}</th>
								                    
								                    @if ( $userPermission["update"] )
										            	<th></th>
										            @endif
										             @if ( $userPermission["delete"] )
										            	<th></th>
										            @endif

									            </tr>
									        </thead>
				
									        <tbody>
									            @foreach ($users as $user)
									            <tr>
									                <td>{{Crypt::decrypt($user->first_name)}}</td>
									                <td>{{Crypt::decrypt($user->last_name)}}</td>
									                <td>{{$user->last_login}}</td>
									                <td>{{$user->created_at}}</td>
									                <td>{{$user->updated_at}}</td>
									                <td class="txt-color-blueLight"><small>{{$user->roles}}</small></td>

									                @if ($userPermission["update"]) 
										                <td>
										                	{{ HTML::link('user/editprofile/'.$user->id,'',array('class' => 'btn btn-warning btn-xs fa fa-edit')) }}
										                </td>
										            @endif	
										            @if ($userPermission["delete"]) 
										                <td>
										                	{{ HTML::link('user/deleteprofile/'.$user->id,'',array('class' => 'btn btn-danger btn-xs delete fa fa-times','onclick' => "return message();")) }}
										                </td>
										            @endif	
	
										           
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
					
</section>	

@endif

@stop




@section('scripts')
	@parent

	<!-- PAGE RELATED PLUGIN(S) -->
		<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
$(document).ready(function() {
			
			pageSetUp();
			
			/* // DOM Position key index //
		
			l - Length changing (dropdown)
			f - Filtering input (search)
			t - The Table! (datatable)
			i - Information (records)
			p - Pagination (paging)
			r - pRocessing 
			< and > - div elements
			<"#id" and > - div with an id
			<"class" and > - div with a class
			<"#id.class" and > - div with an id and class
			
			Also see: http://legacy.datatables.net/usage/features
			*/	
	
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


	function message() {

        var lang = $("#language-combo").val();

        if (lang == 'es') {
            var msg = '¿Está seguro de que desea desactivar al Usuario?';
        }
        if (lang == 'en') {
            var msg = 'Are you sure you want to disable the user?';
        }
        if(!lang){
        	var msg = '¿Está seguro de que desea desactivar al Usuario?';
        }

        var msgs = confirm(msg);

        if (msgs == false) {
            return false;
        }
    }


		</script>
@stop