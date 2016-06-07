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
</style>

<div class="row">
	<article class="col-sm-12 col-md-12 col-lg-12" >
		<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
				<h2 id='typeContest'>Modulo de Recompensas</h2>
			</header>

			<div>
				<div class=" no-padding">

					    <!--section ng-show="goImg">
							<br>
	                        <label class="label">Agregar Imagen</label>
	                        <div class="widget-body">
	                            {{Form::open(array('url'=>'question/img-quiz','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone-all-quiz','file'=>true))}}
	                            {{Form::close()}}
	                        </div>
	                    </section-->

					{{Form::open(array('url'=>'/rewards/reward','method'=>'POST','name'=>'saveRewards','class'=>'smart-form'))}}
				
					<fieldset>
						<div class="row">

							<!--section class='col col-lg-12' ng-show="vm.typeContest == 'versus'" ng-click="goImg = !goImg" >
								<button class='btn btn-info btn-xs pull-right' type='button'>Agregar imagen</button>
							</section-->

							<section class="col col-4">
								<label class="label">Nombre de los puntos</label>
								<label class="input">
									{{Form::text('puntos','',['class'=>'input-sm','ng-model'=>'vm.puntos','required','placeholder'=>'Palomitas'])}}
									<input type="hidden" class="input-sm" value='@{{vm.point}}' name='point'>
								</label>
								<span class='error' ng-show='!saveRewards.$pristine && saveRewards.puntos.$error.required'>Requiere escribir el nombre</span>
							</section>
							<section class="col col-3">
								<label class="label">Puntos por participar</label>
								<label class="input col-6">
									{{--Form::number('givenPoints','1',['class'=>'input-sm','ng-model'=>'vm.givenPoints','required','min'=>'1'])--}}
									<input type="number" class="input-sm"  name='givenPoints' value='@{{vm.givenPoints}}' ng-model='vm.givenPoints' min='1' required='required'>
								</label>
								<span class='error' ng-show='!saveRewards.$pristine && saveRewards.givenPoints.$error.required'>Requiere escribir numero de puntos</span>
							</section>
							<section class="col col-3">
								<label class="label">Puntos por compartir</label>
								<label class="input col-6">
									<input type="number" class="input-sm"  name='sharePoints' value='@{{vm.sharePoints}}' ng-model='vm.sharePoints' min='1' required='required'>
								</label>
								<span class='error' ng-show='!saveRewards.$pristine && saveRewards.sharePoints.$error.required'>Requiere escribir numero de puntos</span>
							</section>
						</div>
					

							
							<!-- CARGA DE IMAGEN UNICA DE PREGUNTA-->
							<!--section>
								<div class="row" ng-show="goImg">
								<label class="label"></label>
									<div class="well">
											<table class="table table-striped table-forum imgEditQuestion">
												<thead class='addTitleImg'>
												</thead>
												<tbody id="table_body2" >
													<tr>	
														<td class='imgQuestionTdStyle'>
															<div id='styleImgQuestion'>
																<img src="@{{vm.imgQuestions}}"  class='imgDivStyle img-responsive'>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<input type="hidden" name='imgQuestion' id='imgQuestion'>
							</div>
							</section-->
							


						
						<!-- CARGA DE OPCIONES DE IMAGEN -->
						<div class="row" ng-show="vm.selectedOption.name == 'Imagen'">
							<label class="label"></label>
								<div class="well" >
										<table class="table table-striped table-forum imgEditRw">
											<thead>
											<tr>
												<th colspan="3">Categorias de @{{vm.puntos}}</th>
											</tr>
											</thead>
											<tbody id="table_body2" >
												<tr ng-repeat="optCategory in vm.infoCategories">	
													<td class='add_story text-center' style="width: 30px;">
														<i class="fa fa-th fa-2x text-muted iconFaMove"></i><span>@{{$index+1}}</span> 
													</td>
													<td class='imgTdStyle'>
														<div>
															<img src="@{{optCategory.img}}" class='imgDivStyle img-responsive'>
														</div>
													</td>
													<td >
														<section class='col col-5'>
															<label for="" class='label'>Categoria</label>
															<label for="" class="input">
																<input type="text" class="input-sm" value='@{{optCategory.name}}' name='categoryImg[@{{optCategory.img}}][]' placeholder='Palomita Natural' required='required'>
															</label>
														</section>
														<section class='col col-3'>
															<label for="" class='label'>Puntos Min</label>
															<label for="" class="input">
																<input type="number" class="input-sm" value='@{{optCategory.range_ini}}' name='rangeIni[]' min='1'>
															</label>
														</section>
														<section class='col col-3'>
															<label for="" class='label'>Puntos Max</label>
															<label for="" class="input">
																<input type="number" class="input-sm" value='@{{optCategory.range_fin}}' name='rangeFin[]' min='1'>
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

						
						

	                   <div class="row" ng-show="vm.selectedOption.name == 'Imagen'">
							<br>
							<section>
								{{Form::button('Agregar categoria',array('class'=>'btn btn-xs btn-primary pull-right','ng-click'=>"showRw = !showRw"))}}
							</section>
						</div>



						<section ng-show="showRw">
							<br>
	                        <label class="label">Agregar imagen a la categoria</label>
	                        <div class="widget-body">
	                            {{Form::open(array('url'=>'rewards/img-rewards','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone-rewards','file'=>true))}}
	                            {{Form::close()}}
	                        </div>
	                    </section>
						
						<section>
							<div class="form-actions">
								<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
		                            {{Lang::get('contest.cancel')}}
		                         </button>

									{{Form::button('Guardar',array('class'=>'btn btn-sm btn-primary','onclick'=>'saveRewards.submit()','ng-disabled'=>'!saveRewards.$valid'))}}
				                
				            </div>
						</section>

					</fieldset>
				</div>

			</div>
		</div>			
	</article>


</div>