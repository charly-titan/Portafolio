<style>
	.inputStyle{
		outline:none;
		background-color:transparent;
		border:none;
		width: 100%;
	}
	.error{color: red;font-size: 10px}
	.dropzone{min-height: 150px;}
    .dropzone .dz-preview{font-size: 10px;} 
        img {max-width: 100%;max-height: 100%;}
        @media all and (max-width: 1000px){
            img{
            width:800px;
            height: 250px;
            }
        }
    .imgEditDiv{width: 50%;}
    .imgTdStyle{width: 15%;}
    .imgDivStyle{width: 150px;}
    #typeContest,#myModalLabel {text-transform:capitalize;}

.dropzone .dz-preview .dz-details,
.dropzone-previews .dz-preview .dz-details {
  width: 80px; /*******/
  height: 100px; /*******/
  position: relative;
  background: #ebebeb;
  padding: 0px;
  margin-bottom: 0px;
}
#styleImgQuestion{padding-left: 20em}
.jarviswidget-ctrls,.widget-toolbar{display: none;}
</style>

<div class="row">
	<article class="col-sm-12 col-md-12 col-lg-12" >
		<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
				<h2 id='typeContest'>Tienda de Premios</h2>
			</header>

			<div>
				<div class=" no-padding">

					{{Form::open(array('url'=>'/premios/premios','method'=>'POST','name'=>'savePremios','class'=>'smart-form'))}}
				
					<fieldset>
						<div class="row">

							<section class="col col-4">
								<label class="label">Tienda</label>
								<label class="input">
									{{Form::text('tienda','',['class'=>'input-sm','ng-model'=>'vm.tienda','required','placeholder'=>'Escribe el nombre de la tienda'])}}
									<input type="hidden" class="input-sm" value='@{{vm.tienda}}' name='tienda'>
								</label>
								<span class='error' ng-show='!savePremios.$pristine && savePremios.puntos.$error.required'>Requiere escribir el nombre de la tienda</span>
							</section>
							<section class="col col-4">
								<label class="label">Nombre de los puntos</label>
								<label class="input">
									{{Form::text('puntos','',['class'=>'input-sm','ng-model'=>'vm.puntos','required','placeholder'=>'Escribe el nombre de los puntos'])}}
									<input type="hidden" class="input-sm" value='@{{vm.puntos}}' name='puntos'>
								</label>
								<span class='error' ng-show='!savePremios.$pristine && savePremios.puntos.$error.required'>Requiere escribir el nombre de los puntos</span>
							</section>
						</div>
					
						<!-- CARGA DE OPCIONES DE IMAGEN -->
						<div class="row">
							<label class="label"></label>
								<div class="well" >
										<table class="table table-striped table-forum imgEdit">
											<thead>
											<tr>
												<th colspan="3">Premios</th>
											</tr>
											</thead>
											<tbody id="table_body2" >
												<tr ng-repeat="optPremio in vm.infoPremios">	
													<td class='add_story text-center' style="width: 30px;">
														<i class="fa fa-th fa-2x text-muted iconFaMove"></i><span>@{{$index+1}}</span> 
													</td>
													<td class='imgTdStyle'>
														<div>
															<img src="@{{optPremio.img}}" class='imgDivStyle img-responsive'>
														</div>
													</td>
													<td >
														<section class='col col-3'>
															<input type="hidden" class="input-sm" value='@{{optPremio.id}}' name='premioImg[@{{optPremio.img}}][]'>
															<label for="" class='label'>Nombre</label>
															<label for="" class="input">
																<input type="text" class="input-sm" value='@{{optPremio.name}}' name='premioImg[@{{optPremio.img}}][]' placeholder='Escribe el nombre' required='required'>
															</label>
														</section>
														<section class='col col-3'>
															<label for="" class='label'>Descripción</label>
															<label for="" class="input">
																<input type="text" class="input-sm" value='@{{optPremio.desc}}' name='premioImg[@{{optPremio.img}}][]' placeholder='Escribe su descripción' required='required'>
															</label>
														</section>
														<section class='col col-2'>
															<label for="" class='label'>Valor</label>
															<label for="" class="input">
																<input type="number" class="input-sm" value='@{{optPremio.valor}}' name='valor[]' min='1'>
															</label>
														</section>
														<section class='col col-2'>
															<label for="" class='label'>Cantidad</label>
															<label for="" class="input">
																<input type="number" class="input-sm" value='@{{optPremio.canti}}' name='cantidad[]' min='1'>
															</label>
														</section>
														<section class="col col-1">
														<br>
															<em class="pull-right badge bg-color-red padding-5" rel="tooltip" title="" data-placement="left" data-original-title="Warning Icon Text"><a class="fa fa-trash-o  fa-lg txt-color-white" ng-click="vm.deleteCatAct($index)"></a></em>
														</section>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
						</div>


									
					{{Form::close()}}

						
						

	                   <div class="row">
							<br>
							<section>
								{{Form::button('Agregar premio',array('class'=>'btn btn-xs btn-primary pull-right','ng-click'=>"showRw = !showRw"))}}
							</section>
						</div>



						<section ng-show="showRw">
							<br>
	                        <label class="label">Agregar imagen al premio</label>
	                        <div class="widget-body">
	                            {{Form::open(array('url'=>'premios/img-premios','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone-premios','file'=>true))}}
	                            {{Form::close()}}
	                        </div>
	                    </section>
						
						<section>
							<div class="form-actions">
								<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
		                            {{Lang::get('contest.cancel')}}
		                         </button>

									{{Form::button('Guardar',array('class'=>'btn btn-sm btn-primary','onclick'=>'savePremios.submit()','ng-disabled'=>'!savePremios.$valid'))}}
				                
				            </div>
						</section>

					</fieldset>
				</div>

			</div>
		</div>			
	</article>


</div>

