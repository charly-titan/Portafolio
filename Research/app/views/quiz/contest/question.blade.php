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
				<h2 id='typeContest'>{{isset($typeQuestion)?$typeQuestion:''}}</h2>
			</header>

			<div>
				<div class=" no-padding">

					    <section ng-show="goImg">
							<br>
	                        <label class="label">Agregar Imagen</label>
	                        <div class="widget-body">
	                            {{Form::open(array('url'=>'question/img-quiz','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone-all-quiz','file'=>true))}}
	                            {{Form::close()}}
	                        </div>
	                    </section>

					{{Form::open(array('url'=>'/question/quiz','method'=>'POST','name'=>'saveQuestion','class'=>'smart-form'))}}
				
					<fieldset>
						<div class="row">

							<section class='col col-lg-12' ng-show="vm.typeContest != 'versus'" ng-click="goImg = !goImg" >
								<button class='btn btn-info btn-xs pull-right' type='button'>Agregar imagen</button>
							</section>

							<section class="col col-6">
								{{Form::label(Lang::get('contest.question'),'',['class'=>'label'])}}
								<label class="input">
									{{Form::text('question','',['class'=>'input-sm','ng-model'=>'vm.question.questionText','required'])}}
								</label>
								<span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.question.$error.required'>Requiere escribir la pregunta</span>
							</section>
							<section class="col col-3" ng-show="vm.typeContest != 'versus'">			
								{{Form::label(Lang::get('contest.questionType'),'',['class'=>'label'])}}
								<label class="select">
									<select   ng-options="option.name for option in vm.typeOption track by option.value" ng-model="vm.selectedOption" name='typeQuestion' ng-change='vm.checkedRadio(vm.selectedOption.name)' required></select>
									<i></i> </label><span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.typeQuestion.$error.required'>Debe seleccionar una opcion</span>
							</section>
							<section class="col col-3" ng-show="vm.selectedOption.name == 'Checkbox'" >
								{{Form::label(Lang::get('contest.maxElemntsSel'),'',['class'=>'label'])}}
								<label class="select" >
										{{ Form::select('maxElemntsSel', array('' => '')+range(1,10),'',['ng-model'=>'vm.selectMaxElem',]) }}
									<i></i> </label>
							</section>
						</div>
					
						<div class="row">
							<section class="col col-3">
								<label class="label">{{Lang::get('contest.helpText')}}</label>
								<label class="input">
									{{Form::text('helpText','',['class'=>'input-sm','ng-model'=>'vm.question.helpText','required'])}}
								</label>
								<span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.helpText.$error.required'>Escribir texto de ayuda</span>
							</section>
							<section class="col col-3">
								<label class="label">{{Lang::get('contest.errorText')}}</label>
								<label class="input">
									{{Form::text('errorText','',['class'=>'input-sm','ng-model'=>'vm.question.errorText','required'])}}
								</label>
								<span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.errorText.$error.required'>Requiere escribir el error</span>
							</section>
							<section class='col col-3'>
								<label class="label">{{Lang::get('contest.placeholder')}}</label>
								<label class="input">
									{{Form::text('placeholder','',['class'=>'input-sm','ng-model'=>'vm.question.placeholder','required'])}}
								</label>
								<span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.placeholder.$error.required'>Requiere escribir el placeholder</span>
							</section>
							<section class='col col-3' ng-show="vm.selectedOption.name != 'Imagen'">
								<label class="label">{{Lang::get('contest.required')}}</label>
								<div class="inline-group">
									<label class="radio">
										<input name="required" value='1' type="radio" ng-model='vm.radioRequest' required>
										<i></i>Si</label>
									<label class="radio">
										<input name="required" value='0' type="radio" ng-model='vm.radioRequest' required>
										<i></i>No</label>
								</div>
								<span class='error' ng-show='!saveQuestion.$pristine && saveQuestion.required.$error.required'>Requiereal menos una opcion</span>
							</section>
						</div>


							
							<!-- CARGA DE IMAGEN UNICA DE PREGUNTA-->
							<section>
								<div class="row" ng-show="goImg || vm.imgQuestions!=''">
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
							</section>
							


						<!--div ng-show="vm.selectedOption.name != null && vm.selectedOption.name != 'Imagen' && vm.selectedOption.name != 'Abierta' && vm.selectedOption.name != 'Text'" -->
						<div ng-show="vm.selectedOption.name != null && vm.selectedOption.name != 'Imagen' && vm.selectedOption.name != 'Abierta' && vm.selectedOption.name != 'Text' && vm.selectedOption.name != 'Foto'" >
							{{--Lang::get('contest.addOptions')--}}
							<div class="row" >
								<section class="col col-8">
									<label class="label">Agregar Opciones</label>
									{{Form::label('','',['class'=>'label'])}}
									<label class="input">
										{{Form::text('','',['class'=>'input-sm','ng-model'=>'vm.newOption'])}}
									</label>
								</section>

								<section class="col col-3">
									<label class="label" style='color:white'>.</label>
									{{Form::label('','',['class'=>'label'])}}
										<button  type='button' class="btn btn-success btn-sm" id='' ng-click='vm.addOption()' >
											<i class="fa fa-plus"></i> {{Lang::get('contest.add')}}
										</button>
								</section>
							</div>

							<div class="row" ng-show="vm.items.data!=null">
								<section class="col col-10">
									
									<div class="well">
										<table class="table table-striped table-forum">
											<thead>
												<tr>
													<th colspan="2" class='text-center'>Opciones</th>
													<th class="text-center hidden-xs hidden-sm" style="width: 100px;"></th>

												</tr>
											</thead>
											<tbody id="table_body2" >
												<tr ng-repeat="item in vm.items.data">	
													<td class='add_story text-center' style="width: 40px;">
														<i class="fa fa-th fa-2x text-muted iconFaMove"></i><span>@{{$index+1}}</span> 
													</td>
													<td>
														<input type="text" value='@{{item.title}}' name='optionsQuestion[]' class='inputStyle' readonly="readonly">	
													</td>
													<td>
														<em class="pull-right badge bg-color-red padding-5" rel="tooltip" title="" data-placement="left" data-original-title="Warning Icon Text"><a class="fa fa-trash-o  fa-lg txt-color-white" ng-click="vm.deleteItem($index)"></a></em>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</section>
							</div>
						</div>

						<!-- CARGA DE OPCIONES DE IMAGEN -->
						<div class="row" ng-show="vm.selectedOption.name == 'Imagen'">
							<label class="label"></label>
								<div class="well" >
										<table class="table table-striped table-forum imgEdit">
											<thead>
											<tr>
												<th colspan="3">Opciones</th>
											</tr>
											</thead>
											<tbody id="table_body2" >
												<tr ng-repeat="optionQuestion in vm.optionsQuestionImg">	
													<td class='add_story text-center' style="width: 40px;">
														<i class="fa fa-th fa-2x text-muted iconFaMove"></i><span>@{{$index+1}}</span> 
													</td>
													<td class='imgTdStyle'>
														<div>
															<img src="@{{optionQuestion.img}}" class='imgDivStyle img-responsive'>
														</div>
													</td>
													<td >
														<section class='col col-5'>
															<label for="" class='label'>Titulo</label>
															<label for="" class="input">
																<input type="text" class="input-sm" value='@{{optionQuestion.text}}' name='titleImg[@{{optionQuestion.img}}][]' >
															</label>
														</section>
														<section class='col col-5'>
															<label for="" class='label'>Descripcion</label>
															<label class="textarea textarea-expandable">
																<textarea name="description[]" class="custom-scroll"></textarea>
															</label>
														</section>
														<section class="col col-2">
														<br>
															<em class="pull-right badge bg-color-red padding-5" rel="tooltip" title="" data-placement="left" data-original-title="Warning Icon Text"><a class="fa fa-trash-o  fa-lg txt-color-white" ng-click="vm.deleteItemAct($index)"></a></em>
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
								{{Form::button('Agregar otras imagenes',array('class'=>'btn btn-xs btn-primary pull-right','ng-click'=>"show = !show"))}}
							</section>
						</div>



						<section ng-show="show">
							<br>
	                        <label class="label">Agregar opciones de imagen</label>
	                        <div class="widget-body">
	                            {{Form::open(array('url'=>'question/img-quiz','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone-quiz','file'=>true))}}
	                            {{Form::close()}}
	                        </div>
	                    </section>
						
						<section>
							<div class="form-actions">
								<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
		                            {{Lang::get('contest.cancel')}}
		                         </button>

									{{Form::button('Guardar',array('class'=>'btn btn-sm btn-primary','onclick'=>'saveQuestion.submit()','ng-disabled'=>'!saveQuestion.$valid'))}}
				                
				            </div>
						</section>

					</fieldset>
				</div>

			</div>
		</div>			
	</article>


</div>