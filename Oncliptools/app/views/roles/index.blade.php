@extends('vcms.main')

<style type="text/css">

	#colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

	i {padding-right: .5em;}

</style>

@section('content')

 {{App::setLocale(Session::get('locale'))}}
<div class="row">
		@section('titulo')
			{{Lang::get('roles.title_index')}}
		@stop
    
		<section class="widget">
	                <ol class="breadcrumb">
	                    <li><i class="fa fa-sitemap fa-lg" class="active"></i>{{Lang::get('roles.title_home')}}</li>
	                </ol>
	    </section>
			<div id='col_md' class='col-md-9 col-md-offset-1'>
				<section class='widget'>
					<header>
			            <h4><i class="fa fa-list fa-lg"></i>{{Lang::get('roles.title_home')}}
			            		<button class="btn btn-warning btn-sm" id='creaSite' data-toggle="button" style='float: right'>
									<i class="fa fa-list-ul"><i class="fa fa-plus"></i></i><span class='hidden-xs dropdown'>{{Lang::get('roles.add_site')}}</span>
								</button>
			           </h4>
			        </header>
					
					<div class='body'>
								<table class="table table-striped">

									<thead>
										<tr>
											<th>{{Lang::get('roles.name')}}</th>
										</tr>
									</thead>

									<tbody>
										@foreach($sites as $val)
											<tr>
												<td>{{link_to('roles/rolnew/' . $val->name .'/'. $val->id_site ,$val->name)}}</td>
												<td>{{ Form::open(array('url' => 'roles/deletesite/' . $val->id_site, 'class' => 'pull-right','id' => 'deletesite')) }}
														{{ Form::hidden('_method', 'GET') }}
														<button type="" class='btn btn-danger btn-sm' onclick="return message()">
															<i class='fa fa-trash-o fa-lg'></i><span class='hidden-xs dropdown'>{{Lang::get('roles.del_site')}}</span>
														</button>
													{{ Form::close() }}

												</td>
											</tr>
										@endforeach
										
									</tbody>
								</table>
					</div>
					
				</section>
				
			</div>

					<!-- CreateSite -->
			<div class="col-md-4" id='colCreateSite'>
				<section class="widget">
						<header>
					        <h4><i class="fa fa-list-ul"><i class="fa fa-plus"></i></i>{{Lang::get('roles.create_site')}}</h4>
					    </header>

					    <div class='body'>
					    	{{ Form::open(array('url' => 'roles/crearsite','id'=>'crearsite')) }}

								<div class="control-group">
									{{ Form::label('name', Lang::get('roles.name_site')) }}
		                            <div class="controls form-group">
		                                <div class="input-group col-sm-10">
		                                  {{ Form::text('name', Input::old('name'), array('class' => 'form-control','placeholder' => Lang::get('roles.name_site')) ) }}
		                                </div>
		                                <div class="controls form-group" style='padding: .5em;' id='errorName'>
		                                	<span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                        </div>
		                            </div>
	                    	    </div>
	                    	    <div class="control-group">
									{{ Form::label('domain', Lang::get('roles.domain_site')) }}
		                            <div class="controls form-group">
		                                <div class="input-group col-sm-10">
		                                  {{ Form::text('domain', Input::old('name'), array('class' => 'form-control','placeholder' => Lang::get('roles.domain_site')) ) }}
		                                </div>
		                                <div class="controls form-group" style='padding: .5em;' id='errorDominio'>
		                                	<span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                        </div>
		                            </div>
	                    	    </div>

								<div class="form-actions" style='text-align:center'>
									{{ Form::button(Lang::get('roles.btn_Savesite'), array('class' => 'btn btn-success btn-sm','onclick'=>'valInput()')) }}
									<a class='btn btn-primary btn-sm' id='cancelIndx'>{{Lang::get('roles.btn_Cancel')}}</a>
								</div>
							{{ Form::close() }}
					    </div>


							
				</section>
			</div><!-- FIN create **************************** -->
</div>

@stop


@section('scripts')
 @parent

 	{{ HTML::script('js/roles.js') }}
 	<script type="text/javascript" >

			function message(){

				var lang = $("#language-combo").val();

				if(lang == 'es'){var msg = '¿Está seguro de que lo desea eliminar?'}
				if(lang ==  'en'){var msg = 'Are you sure you want to delete?'}

				var msgs = confirm(msg);

				if(msgs == false){return false;}
			}

			function valInput(){
				
				var name = $('#name').val();
				var domain = $('#domain').val();

				if(name == '' && domain == ''){
					$('#errorDominio,#errorName').show();
				}else if(name == ''){
					$('#errorDominio').hide();
					$('#errorName').show();
				}else if(domain == ''){
					$('#errorName').hide();
					$('#errorDominio').show();
				}

				if(name != '' && domain !=''){
					$("#crearsite").submit();
				}

			}
</script>



@stop