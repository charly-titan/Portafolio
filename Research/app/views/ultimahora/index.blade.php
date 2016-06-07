@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<link rel="stylesheet" href="{{ asset('css/ultima-hora.css')}}">
@endsection
@section('content')
<?php $mxm_email = (Session::get('user.email'));
$mxm_user = (Session::get('user.firstname') . " " . Session::get('user.lastname'));
?>
<div id="wrapper">
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<h1 ><i class="fa fa-list-alt"></i> Min X Min </h1>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-inline">
					<div class="input-group">
						<div class="input-group-addon">Sitio</div>
						<select class="form-control" name="mxm_cat" id="mxm_cat">
							<option value="0" disabled="">Seleccione:</option>
							@foreach ($sites_user as $site)
							<option value="{{$site->abrev}}">{{$site->site}}</option>
							@endforeach
						</select>
					</div>
					<button class="btn btn-primary" id="mybtnmodal" data-toggle="modal" data-target="#myModal" onclick="limpiarUh()">
						Publicar
					</button>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title" id="myModalLabel">Publicar</h4>
							</div>
							<div class="modal-body">
								{{ Form::open(['url' => 'http://node-write.sinpk2.com:9000/api/upload', 'method' => 'POST', 'name' => '', 'class' => 'smart-form dropzone dropnull', 'id' => 'dropzone', 'enctype' => 'multipart/form-data']) }}
								<fieldset>
									<section>
										<input type="hidden" name="user_id" value="{{$mxm_email}}">
										<input type="hidden" name="mxm_user" value="{{$mxm_user}}">
									</section>
									<section>
										<label class="label">Sitio : </label>
										<select class="form-control" name="sitio" id="mxm_categoria" disabled="">
											@foreach ($sites_user as $site)
											<option value="{{$site->abrev}}">{{$site->site}}</option>
											@endforeach
										</select>
									</section>
									<section>
										<label class="label">Titulo</label>
										<label class="input">
											<input type="text" name="title" id="mxm_titulo">
										</label>
									</section>
									<section>
										<label class="label">Balazo</label>
										<label class="textarea textarea-resizable">
											<textarea rows="3" name="text" class="custom-scroll" id="mxm_texto"></textarea>
										</label>
									</section>
									<section>
										<label class="label">URL</label>
										<label class="input">
											<input type="url" name="url" id="mxm_url">
										</label>
									</section>
									<section>
										<div id="dropzonePreview" class="dropzonePreview">
											<span class="text-center">
												<span class="font-lg visible-xs-block visible-sm-block visible-lg-block">
													<span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop Zone</span>
												</span>
											</span>
										</div>
									</section>
								</fieldset>
							</div>
							<div class="modal-footer">
								<input type="button"  name="btn" id="clear-dropzone" class="btn btn-default" value="Borrar"></input>
								<input type="hidden" name="###" id='eliminar' class="btn btn-warning" onclick="mxm_delete(name);" value="Eliminar"> </input>
								<input type="submit" name="btn" id="uploaden" class="btn btn-primary" value="Guardar"></input>
							</div>
							{{ Form::close() }}
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div id="Listado" class="listado" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("scripts")
@parent
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.0-beta3/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.0-beta3/JSXTransformer.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.5/socket.io.min.js"></script>
<script src="{{asset('js/ultima-hora.jsx')}}" type="text/jsx" ></script>
<script src="{{asset('js/ultima-hora.js')}}"></script>
<script src="{{ asset('js/plugin/dropzone/dropzone.min.js')}}"></script>
<script src="{{ asset('js/notification/SmartNotification.min.js')}}"></script>
<script type="text/jsx">
	React.render(React.createElement(SimpleFilterableList, null),
	             document.getElementById("Listado"))
</script>
<script type="text/javascript">
	$( document ).ready(function() {
		validacion();
		mydropzone();
	});
</script>
@endsection
