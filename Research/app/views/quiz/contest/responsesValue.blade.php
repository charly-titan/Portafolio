@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('content')

<style>	
.valueOption{width: 50px;text-align: center;}
.table{font-size: 12px}
#msg{display: none;}
</style>

<div class="row">

	<article class="col-sm-12 col-md-12 col-lg-10 sortable-grid ui-sortable">

		<div class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-2" data-widget-editbutton="false" role="widget">

			<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>

			<div role="content">

				<div class="widget-body no-padding">
										
					<div class="alert alert-info no-margin fade in">
						<i class="fa-fw fa fa-info"></i>
						Valor de las respuestas
					</div>

					{{Form::open(array('url'=>'/question/responses-value/'.$questions[0]->contest_id,'method'=>'POST','name'=>'save','class'=>'smart-form','id'=>'formSubmit'))}}
						<div class="table-responsive">					
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Pregunta</th>
										<th>Opciones</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody>

									@for ($i=0; $i < count($questions) ; $i++)
										<tr>
											<td>{{$questions[$i]->order+1}}</td>
											<td colspan="3">{{$questions[$i]->questionText}}</td>

											@if($questions[$i]->questionType == 'text' || $questions[$i]->questionType == 'abierta')
												
												@for ($j=0; $j <count($questions[$i]->answers) ; $j++)
													<tr>
														<td colspan="2"></td>
														<td>{{$questions[$i]->answers[$j]['text']}}</td>
														<td>
															{{Form::input('number', 'inputname','',['class'=>'valueOption','min'=>0,'onkeypress'=>'return validarNro(event)','readonly'=>'readonly'])}}

															{{$errors->first('valueOption','<span class="error">:message</span>')}}
														</td>
														
													</tr>
												@endfor

											@else

												@for ($j=0; $j <count($questions[$i]->answers) ; $j++)
													
													<tr>
													  	<td colspan="2"></td>
													  	<td>{{$questions[$i]->answers[$j]['text']}}</td>
													  	<td>
													  		{{Form::input('number',"valueOption[".$questions[$i]->id."][".$questions[$i]->answers[$j]['id_option']."]",($questions[$i]->answers[$j]['value'])?$questions[$i]->answers[$j]['value']:0,['class'=>'valueOption','min'=>0,'onkeypress'=>'return validarNro(event)',isset($questions[$i]->statusRatePDF)?'readonly':''] )}}
													  		{{$errors->first('valueOption','<span class="error">:message</span>')}}
													  	</td>
													</tr>

												@endfor

											@endif
										</tr>
									@endfor	
								</tbody>
							</table>			
						</div>


				
					{{Form::close()}}

					<div class="dt-toolbar-footer">
						<div class="col-xs-12 col-sm-12">
							@if($questions[0]->statusRatePDF)

								{{ HTML::linkAction('ContestController@getIndex', 'Cerrar',null,array('class'=>'btn btn-primary pull-right')) }}

							@else

								<button onclick="save.submit();Msg()" id='btnUpdate' class ='btn btn-primary pull-right'>Guardar</button>
								{{ HTML::linkAction('ContestController@getIndex', 'Cancelar',null,array('class'=>'btn btn-default pull-right','id'=>'btnCancel')) }}		

								<a href="javascript:void(0);" id='msg' class="btn bg-color-blue txt-color-white pull-right">Actuailzando  <i class="fa  fa-spinner fa-spin"></i></a>
											
							@endif
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</article>
</div>

@stop


@section('scripts')
	@parent

	<script>

		function validarNro(e) {
	        var key;
	        if(window.event) // IE
	            {
	            key = e.keyCode;
	            }
	        else if(e.which) // Netscape/Firefox/Opera
	            {
	            key = e.which;
	            }

	        if (key < 48 || key > 57)
	            {
	            if(key == 46 || key == 8) // Detectar . (punto) y backspace (retroceso)
	                { return true; }
	            else 
	                { return false; }
	            }
	        return true;
	    }

	    function Msg(){
	    	$("#btnUpdate,#btnCancel").remove();
	    	$("#msg").show();
	    }


	</script>

	 
@stop