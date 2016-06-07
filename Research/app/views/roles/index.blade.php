@extends(Config::get( 'app.main_template' ).'.main')

<style type="text/css">

	#colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

	i {padding-right: .5em;}

</style>
<input type="hidden" value="{{Config::get('app.locale')}}" id='language-combo'>
@section('content')

<!-- RIBBON -->
<div id="ribbon">
	<ol class="breadcrumb">
	    <li><i class="fa fa-sitemap fa-lg" class="active"></i>{{Lang::get('roles.title_home')}}</li>
	</ol>
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

	<article class="col-sm-6 col-md-12 col-lg-12 sortable-grid ui-sortable" id='col_md'>
		<div class="well well-sm well-light" >
			<p class="alert alert-info">
				<i class="fa fa-list"></i><strong>Sitios</strong>
				<button class="btn btn-labeled btn-warning pull-right" id='creaSite' data-toggle="button">
				 <span class="btn-label">
				  <i class="fa fa-plus"></i>
				 </span>{{Lang::get('roles.add_site')}}
				</button>
				<!--button class="btn btn-warning btn-xs pull-right" id='creaSite' data-toggle="button">
						<i class="fa fa-plus"></i></i> <span class='hidden-xs dropdown'>{{Lang::get('roles.add_site')}}</span>
				</button-->
			</p>

			

			<div role="content">
				
				<div class="widget-body">

					<div class="table-responsive">
										
						<table class="table table-hover smart-form" style="font-size: 13px;">
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
												<!--button type="" class='btn btn-danger btn-xs' onclick="return message()">
													<i class='fa fa-trash-o'></i>
												</button-->
												<button class="btn btn-labeled btn-danger btn-xs" onclick="return message()"> <span class="btn-label"><i class="glyphicon glyphicon-trash"></i></span>Eliminar</button>

											{{ Form::close() }}
										</td>
									</tr>
								@endforeach							
							</tbody>
						</table>					
					</div>
				</div>
			</div>
		</div>
	</article>


<article class="col-sm-12 col-md-12 col-lg-4 sortable-grid ui-sortable" id='colCreateSite'>
	
	<div class="well well-sm well-light">
	
	<p class="alert alert-info">
		<i class="fa fa-plus"></i></i><strong>{{Lang::get('roles.create_site')}}</strong> 
	</p>
				<section class="widget">

					    <div class='body'>
					    	{{ Form::open(array('url' => 'roles/crearsite','id'=>'crearsite')) }}

								<div class="control-group">
									{{ Form::label('name', Lang::get('roles.name_site')) }}
		                            <div class="controls form-group">
		                                  {{ Form::text('name', Input::old('name'), array('class' => 'form-control input-xs','placeholder' => Lang::get('roles.name_site')) ) }}
		                                <div class="controls form-group" style='padding: .5em;' id='errorName'>
		                                	<span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                        </div>
		                            </div>
	                    	    </div>
	                    	    <div class="control-group">
									{{ Form::label('domain', Lang::get('roles.domain_site')) }}
		                            <div class="controls form-group">
		                                  {{ Form::text('domain', Input::old('name'), array('class' => 'form-control input-xs','placeholder' => Lang::get('roles.domain_site')) ) }}
		                                <div class="controls form-group" style='padding: .5em;' id='errorDominio'>
		                                	<span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                        </div>
		                            </div>
	                    	    </div>

								<div  style='text-align:center'>
									<button  type='button'class="btn btn-labeled btn-success" onclick='valInput()'> <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>{{Lang::get('roles.btn_Savesite')}}</button>
									<a href="javascript:void(0);" class="btn btn-labeled btn-danger" id='cancelIndx'> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>{{Lang::get('roles.btn_Cancel')}}</a>
								</div>
							{{ Form::close() }}
					    </div>

				</section>

</div>	
</article>

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