@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<link rel="stylesheet" href="{{ asset('css/ultima-hora.css')}}">
@endsection
@section('content')
<div id="wrapper">
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<h1 >
						<i class="fa fa-list-alt">
						</i> Listado
					</h1>
				</div>
				<button class="btn btn-primary pull-right" id="mybtnmodal" data-toggle="modal" data-target="#myModal" onclick="limpiarUsers()">
					Agregar
				</button>
				<div class="row">
					<article class="col-md-12">
						<div class="jarviswidget jarviswidget-color-blueDark" >
							<header role="heading">
								<span class="widget-icon"> <i class="fa fa-edit">
								</i> </span>
								<h2>User </h2>
								<span class="jarviswidget-loader">
									<i class="fa fa-refresh fa-spin">
									</i>
								</span>
							</header>
							<div role="content">
								<div class="jarviswidget-editbox">
								</div>
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
												<th class="text-center">Email</th>
												<th class="text-center">Sitios</th>
												<th class="text-center">Accion</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($datos as $user_uh)
											<tr>
												<th >
													{{$user_uh['user_id']}}
												</th>
												<th >{{$user_uh['email']}}</th>
												<th >
													@if ($user_uh['sites'] == "")
													<ul class="list-unstyled" >
														<li>"Sin sitios"</li>
													</ul>
													@else
													@foreach ($user_uh['sites'] as $usersite)
													<ul class="list-unstyled" >
														<li>{{$usersite->site}}</li>
													</ul>
													@endforeach
													@endif
												</th>
												<th class="text-center">
													<button id="{{$user_uh['user_id']}}" class="btn btn-warning" onclick="postUserDelete(this.id)"><i class="fa fa-trash-o"></i></button>
													<button id="{{$user_uh['email']}}" class="btn btn-primary" onclick="postUserEdit(this.id)"><i class="fa fa-edit"></i></button>
													<a href="{!! route('actividades.delete', [$mzActividades->id]) !!}" onclick="return confirm('Quieres eliminar esta activid
													ad?')">
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
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									<h4 class="modal-title" id="myModalLabel">Permisos</h4>
								</div>
								<div class="modal-body">
									{{ Form::open(['url' => '/ultima-hora/users', 'method' => 'POST', 'class' => 'smart-form', 'id' => 'myform']) }}
									<input type="hidden" name="user_id" id="user_id">
									<fieldset>
										<section>
											<div class="input-group">
												<div class="col-md-11">
													<div class="input-group-btn">
														<label class="label">Email</label>
														<select id="combobox" class="form-control input-group-addon">
															<option value="">Selecciona</option>
															@foreach ($users as $user)
															<option value="{{$user->id}}">{{$user->email}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
											<label class="label">nombre</label>
											<label class="input ">
												<input type="text" id="first_name" name="first_name" >
											</label>
											<label class="label">apellido</label>
											<label class="input ">
												<input type="text" id="last_name" name="last_name" >
											</label>
										</section>
									</fieldset>
									<fieldset>
										<section>
											<label class="label">Sitios Permitidos</label>
											<label class="checkbox ">
												<input id="selecctall" type="checkbox">
												<i>
												</i>
												<strong>Todos</strong>
											</label>
											<div class="inline-group">
												@foreach ($sites as $site)
												<label class="checkbox ">
													<input type="checkbox" name="sites[]" class="checkbox1" value='{{$site->id}}' id='{{$site->abrev}}'>
													<i></i>{{$site->site}}
												</label>
												@endforeach
											</div>
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
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
	<script src="{{asset('js/notification/SmartNotification.min.js')}}"></script>
	<script src="{{asset('js/ultima-hora.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#dt_basic').dataTable({});
			autocompletar();
			pingClick();
		});
</script>
@if(count($errors->all())>0)
<?php
$numbererrors = count($errors->all());
if ($numbererrors == 2) {
    $mensaje = "message_site_user";
} else {
    if ($errors->get('user_id')) {
        $user_iderrors = $errors->get('user_id');
        $mensaje = "message_user";
    }
    if ($errors->get('sites')) {
        $siteserrors = $errors->get('sites');
        $mensaje = "message_site";
    }
}
?>
<script>
	var message_alert = <?php
echo json_encode($mensaje); ?>;
</script>
<?php
if (Session::get('miuser') != "") {
    $email = Session::get('miuser.email');
    ?>
	<script>
		var email = <?php
echo json_encode($email); ?>;
	</script>
	<?php
}
?>
<script>
	if (message_alert == 'message_site'){
		message_site();
	}
	if (message_alert == 'message_user'){
		message_user();
	}
	if (message_alert == 'message_site_user'){
		message_site_user();
	}
	$("#myModal").modal();
		if (typeof email != "undefined"){
		createFunction(email);
	}
</script>
@endif
@endsection
