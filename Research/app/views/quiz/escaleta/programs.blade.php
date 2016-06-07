@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
	<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">
								<!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"
				
								-->
								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Escaleta </h2>
				
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
										
										<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">
											<thead>
												<tr>
													
													<th data-class="expand">Nombre del programa</th>
													<th>Días de transmision</th>
													<th data-hide="phone">Company</th>
													<th data-hide="phone,tablet">Zip</th>
													<th data-hide="phone,tablet">City</th>
													<th data-hide="phone,tablet">Date</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($programs as $program)
													<tr>
														<td><a href="/escaleta/{{$program['id']}}/edit">{{ $program["program_name"] }}</a></td>
														<td>1-342-463-8341</td>
														<td>Et Rutrum Non Associates</td>
														<td>35728</td>
														<td>Fogo</td>
														<td>03/04/14</td>
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

@stop