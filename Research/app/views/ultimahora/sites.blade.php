@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')

@endsection
@section('content')

<div id="wrapper">
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<h1 ><i class="fa fa-list-alt"></i> Sitios </h1>
				</div>
				<button class="btn btn-primary pull-right" id="mybtnmodal" data-toggle="modal" data-target="#myModal" onclick="limpiarSites()">
					Agregar
				</button>
				<div class="row">
					<article class="col-md-12">
						<div class="jarviswidget jarviswidget-color-blueDark" >
							<header role="heading">
								<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
								<h2>Sitios </h2>
								<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
							</header>
							<div role="content">
								<div class="jarviswidget-editbox"></div>
								<div class="widget-body no-padding">
									@if(Session::has('message'))
									<div class="alert alert-success" data-dismiss="alert">
										<a class="close" data-dismiss="alert" href="#">×</a>
										<ul>
											<li>{{ Session::get('message') }}</li>
										</ul>
									</div>
									@endif
									<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th class="text-center">ID</th>
												<th class="text-center">Abrev</th>
												<th class="text-center">Sitio</th>
												<th class="text-center">Accion</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($sites_uh as $site)
											<tr>
												<th >{{$site->id}}</th>
												<th >{{$site->abrev}}</th>
												<th >{{$site->site}}</th>
												<th class="text-center">
													<button id="{{$site->id}}" class="btn btn-warning" onclick="postSiteDelete(this.id)"><i class="fa fa-trash-o"></i></button>
													<button id="{{$site->id}}" class="btn btn-primary" onclick="postSiteEdit(this.id)"><i class="fa fa-edit"></i></button>
												</th>
											</tr>
											@endforeach
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
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Nuevo sitio</h4>
							</div>
							<div class="modal-body">
								{{ Form::open(['url' => '/ultima-hora/sites', 'method' => 'POST', 'class' => 'smart-form', 'id' => 'myform']) }}
								<fieldset>
									<section>
										<input type="hidden" id="site_id" name="site_id" >
										<label class="label">Aberv <small> (sin espacios)</small></label>
										<label class="input ">
											<input type="text" id="abrev" name="abrev" >
										</label>
										<label class="label">Nombre Sitio</label>
										<label class="input ">
											<input type="text" id="site" name="site" >
										</label>
									</section>
								</fieldset>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Enviar</button>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
				<!-- modal -->
			</div>
		</div>
	</div>
</div>
@endsection
@section("scripts")
@parent
<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="{{ asset('js/notification/SmartNotification.min.js')}}"></script>
<script src="{{asset('js/ultima-hora.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dt_basic').dataTable({});
	});

</script>
@endsection
