@extends(Config::get( 'app.main_template' ).'.main')

@section('content')



		<div class="col-sm-6">
			<div class="well well-sm">
				
				<div class="jarviswidget" id="wid-id-11" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">

					<header>
						<h2><i class="fa fa-rss text-success"></i> Notificaciones</h2>			
							<ul id="widget-tab-1" class="nav nav-tabs pull-right">

								<li >
									<a data-toggle="tab" href="#hr1"> <i class="fa fa-lg fa-user"></i> <span class="hidden-mobile hidden-tablet"> Usuario </span> </a>
								</li>

								<li class="active">
									<a data-toggle="tab" href="#hr2"> <i class="fa fa-lg fa-group"></i> <span class="hidden-mobile hidden-tablet"> Grupos </span></a>
								</li>

							</ul>			
					</header>

					<div>
						<div class="widget-body no-padding">
										
							<div class="tab-content padding-10">

								<div class="tab-pane fade  form-horizontal" id="hr1">
										
									<div class="form-group">
										<label class="col-md-2 control-label" for="select-1">Usuarios</label>
										<div class="col-md-10">
					
											<select class="select2"  id='option_user'>
											 	<option></option>
												@foreach($users as $user)
													<option value="{{$user->id}}">{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}</option>
												@endforeach
											</select>
					
										</div>
									</div>

								
									<div class="form-group" id='dvMsgUser'></div>

									<div class="form-actions" id='btnSendUser'></div>
									

								</div>
												
								<div class="tab-pane fade in active form-horizontal" id="hr2">

									<div class="form-group" >
										<label class="col-md-2 control-label" for="select-1">Grupos</label>
										<div class="col-sm-8">
					
											<select class="select2" id='option_group'>
												<option value="">Selecciona un grupo....</option>
											</select>
					
										</div>
										{{--@if($userPermission["view"])--}}
											<div class="col-sm-2">
												<button class='btn btn-primary' id='btnAddGroup'><i class="fa fa-plus"></i> <i class="fa fa-group"></i></button>
											</div>
										{{--@endif--}}
									</div>

									<div class="form-group" id="user_group">
										<label class="col-md-2 control-label" for="select-1">Usuarios</label>
										<div class="col-md-10">
					
											<select multiple class="select2" id='listUsers'>
												@foreach($users as $user)
													<option value="{{$user->id}}">{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}</option>
												@endforeach
											</select>
					
										</div>

									</div>

									<div class="form-group" id='dvMsgGroup'></div>

									<div class="form-actions" id='btnSendGroup'></div>
				


									


												
								</div>

							</div>
										
						</div>
					</div>		
				</div>
			</div>
		</div>

		<div class="col-sm-4" id='addGroup'>

					<section id="widget-grid" class="">
						<div class="row">
							<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							
								<div class="jarviswidget" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" id="wid-id-0">

									<header>
										<span class="widget-icon"> <i class="fa fa-comments"></i> </span>
										<h2>Grupos de Telegram </h2>				
										
									</header>
					
									<div class="widget-body">

									    <form>
									        <div class="form-group">
									            <label for="code-beca" class="control-label">Nombre del grupo a agregar:</label>
									            <input type="text" class="form-control" id="name-group">
									        </div>
									        <div class="form-group">
									            <label for="code-beca" class="control-label">Usuarios:</label>
									            <select multiple class="select2" id='userGroup'>
													@foreach($users as $user)
														<option value="{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}">{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}</option>
													@endforeach
												</select>
									        </div>
									    </form>

									    <div class="modal-footer">
									        <button type="button"  class="btn btn-xs btn-default" id='closeAddGroup'>Cerrar</button>
									        <button type="button" class="btn btn-xs btn-primary" id='saveGroup'>Guardar</button>
									    </div>

									</div>
								
								</div>
							</article>
						</div>
					</section>
		</div>

		<div class="col-sm-12">

					<section id="widget-grid">
						<div class="row">
							<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="jarviswidget" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" id="wid-id-0">

									<header>
										<span class="widget-icon"> <i class="fa fa-comments"></i> </span>
										<h2>Estatus mensajes</h2>				
										
									</header>
									<div class="widget-body">
										<table class="table table-striped" id=''>
											<thead> 
												<tr> 
													<th>Nombre</th> 
													<th>Mensaje</th> 
													<th>Status</th> 
												</tr> 
											</thead>
											<tbody id='statusMsg'>
												
											</tbody>
										</table>
										
									</div>
								</div>
							</article>
						</div>
					</section>
		</div>
@stop

@section('scripts')
    @parent
	<script src="https://cdn.firebase.com/js/client/2.4.0/firebase.js"></script>
	<script src="/js/plugin/select2/select2.min.js"></script>
	<script src="js/notification/SmartNotification.min.js"></script>

	<script src="/js/notificaciones_telegram.js"></script>
    
    <script>

		$(".select2-hidden-accessible").remove();
		$("#addGroup,#user_group").hide();

	</script>

@stop