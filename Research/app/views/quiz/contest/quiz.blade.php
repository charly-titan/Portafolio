@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

<style>
	h2{text-align: center;}
	.emPos{margin-left: .5em}
	.modal-content{width: 800px;}
	#typeContest{text-align: center;font-size: 16px;}
	.title{text-align: center;font-size: 16px;}

	tr,td{border:.5px solid red;padding: 2em}

	.add_story{cursor: move;}
	.iconFaMove{display: none;}
	.active{display: inline;}

</style>
<br><br>
@if ($userPermission["view"])
                              
<div class="tab-pane active">

    <section id="widget-grid" class="" ng-app="App" ng-controller="AppCtrl as vm">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="well">
                                <p id='typeContest'><strong>{{strtoupper(isset($typeQuestion)?$typeQuestion:'')}}</strong></p>
                            <div class="btn-toolbar">

	                            @if($questionAnswer)
	                            	
	                            	@if(isset($questionAnswer->contest_type)?$questionAnswer->contest_type:'' == 'versus')
			                            
			                            <div class="col-md-12 padding-left-0">
												<h3 class="margin-top-0">{{$questionAnswer->questionText}}<br></h3>

												<div class="bootstrap-duallistbox-container row"> 
															@foreach ($questionAnswer->optionsQuestion as $value)

																<div class="box2 col-md-2" >  
			                                     					<div class="col-md-12">
																		<img src="{{$value['img']}}" class="img-responsive" alt="img">
																			<ul class="list-inline padding-10">
																				<li>
																					<a href="#"> {{$value['text']}}</a>
																				</li>
																			</ul>
																	</div>
			                            						</div>
										
															@endforeach
												</div> 
											@if ($userPermission["update"])	
												<a class="btn btn-warning  pull-right" data-toggle="modal" data-target="#myModal" ng-click="vm.EditQuestion({{$questionAnswer->id}})"> Editar </a>
												<a class="btn btn-default  pull-left" data-toggle="modal" data-target="#modalRds" ng-click="vm.EditRewards({{$questionAnswer->id}})"> Recompensas </a>
											@endif
										</div>

									@else
										{{Form::open(array('url'=>'/question/position-question','method'=>'POST','class'=>'smart-form','name'=>'save','files' => true))}}
											

												<section>
													<div class="well">
														<table class="table table-striped table-forum">
															<thead>
																<tr>
																	<th colspan="2" class='text-center'>Preguntas</th>
																	<th class="text-center hidden-xs hidden-sm" style="width: 100px;">
																		@if ($userPermission["update"])
																			<button type='button' data-toggle="modal" data-target="#myModal" class='btn btn-warning btn-xs pull-right' ng-click='vm.NewQuestion()'>Agregar pregunta</button>
																		@endif
																	</th>

																</tr>
															</thead>
															<tbody id="table_body">

																@for ($i=0; $i < count($questionAnswer); $i++)
																	<tr>	
																		<td class='add_story text-center' style="width: 40px;"><i class="fa fa-th fa-2x text-muted iconFaMove"></i><span>{{$i+1}}</span> </td>
																		<td class='something_1'>
																			{{Form::text('positionQuestion['.$questionAnswer[$i]->id.']',$questionAnswer[$i]->questionText,['class'=>'inputStyle','readonly'=>'readonly'])}}
																		</td>
																		<td>
																			@if ($userPermission["update"])	
																							<em class="something_1 pull-right badge bg-color-red padding-5 emPos" rel="tooltip" title="" data-placement="left" data-original-title="Delete Question"><a class="fa fa-trash-o  fa-lg txt-color-white" ng-click="vm.deleteQuestion({{$questionAnswer[$i]->id}})"></a></em>
																							<em class=" something_1 pull-right badge bg-color-blue padding-5 emPos" rel="tooltip" title="" data-placement="left" data-original-title="Edit Question"><a class="fa fa-edit  fa-lg txt-color-white" data-toggle="modal" data-target="#myModal" ng-click="vm.EditQuestion({{$questionAnswer[$i]->id}})"></a></em>
																			@endif
																		</td>
																	</tr>
																@endfor

																@if ($userPermission["update"])
																	<tr>
																		<td colspan="2"></td>
																		<td>
																			<button type='button' class='btn btn-info btn-xs' onclick="save.submit();">Guardar Posicion</button>
																		</td>
																	</tr>
																@endif
															</tbody>
														</table>
													</div>
												</section>

										{{Form::close()}}		

									@endif
	                            @else

	                            	@if(($typeQuestion == 'frase') or ($typeQuestion == 'foto'))
										<div><h2>{{Lang::get('contest.msgFrase')}}</h2></div>
	                            	@else
		                            	<div id='btnAdd'>
											<button data-toggle="modal" data-target="#myModal" class='btn btn-success' ng-click='vm.NewQuestion()'>
												Agregar Pregunta para {{isset($typeQuestion)?$typeQuestion:''}}
											</button>
										</div>
	                            	@endif


									

								@endif

										<br>

										<!-- Modal -->
							                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							                    <div class="modal-dialog">
							                        <div class="modal-content">
							                            <div class="modal-header">
							                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							                                    &times;
							                                </button>
							                                <h4 class="modal-title" id="myModalLabel">{{strtoupper(isset($typeQuestion)?$typeQuestion:'')}}</h4>
							                            </div>
							                           
							                                <!--  Cuerpo modal -->
							                                <div class="modal-body" >
									                                @include(Config::get( 'app.main_template' ).'/contest/question')
							                                </div>
							                        </div>
							                    </div>
							                </div>	

							            <!-- Modal -->
							                <div class="modal fade" id="modalRds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							                    <div class="modal-dialog">
							                        <div class="modal-content">
							                            <div class="modal-header">
							                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							                                    &times;
							                                </button>
							                                <h4 class="modal-title" id="myModalLabel">{{strtoupper(isset($typeQuestion)?$typeQuestion:'')}}</h4>
							                            </div>
							                           
							                                <!--  Cuerpo modal -->
							                                <div class="modal-body" >
									                                @include(Config::get( 'app.main_template' ).'/contest/rewards')
							                                </div>
							                        </div>
							                    </div>
							                </div>	




										</div>
									</div>	

                            </div>   
                        </div>
                    </div>
                </div>
    </section>

    <div class="form-actions">

				{{ HTML::linkAction('ContestController@getText', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
				{{ HTML::linkAction('ContestController@getIndex', Lang::get('contest.close'),null,array('class'=>'btn btn-primary pull-right')) }}
	</div>
</div>

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getText', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
				{{ HTML::linkAction('ContestController@getIndex', Lang::get('contest.close'),null,array('class'=>'btn btn-primary pull-right')) }}
        </div>
    </div>

@endif


@stop



@section("scripts")
	@parent

	<script type="text/javascript">
			// DO NOT REMOVE : GLOBAL FUNCTIONS!
			
			$(function () {

			    $("#table_body,#table_body2").sortable({
			        helper: fixHelper,
			        axis: "y"
			    }).disableSelection();
			    $('#table_body td,#table_body2 td').not('.add_story').mousedown(function(event){
			        event.stopImmediatePropagation();
			    });


			var fixHelper = function (e, ui) {
			    ui.children().each(function () {
			        $(this).width($(this).width());
			    });

			    return ui;
			};


			$(".add_story").mouseover(function(){
				$(this).children("span").css('color','white');
				$(this).children("i").css('color','#C0C0C0').addClass('active');
			})
			.mouseout(function() {
				$(this).children("span").css('color','black');
				$(this).children("i").removeClass('active');
			});



			    Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("#my-dropzone-quiz", {
				 	maxFiles: 50,
					maxFilesize: 10,
					paramName: "file",
					addRemoveLinks : true,
					//previewsContainer: '#dropzonePreview',
					acceptedFiles: ".jpg, .jpeg, .gif, .png",
					dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Images <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
					dictResponseError: 'Error uploading file!',
				  init: function() {
				    this.on("success", function(file, responseText) {
				    
				    	var name = file.name.split(".");

				    	if(file){

					    	$(".imgEdit").append($("<tr>",{id:name[0]})
					    					.append($("<td>").addClass('add_story text-center').append($("<i>").addClass('fa fa-th fa-2x text-muted iconFaMove').append($("<span>").addClass('ng-binding'))))
					    					.append($("<td>").addClass('imgTdStyle')
					    						.append($("<div>")
					    								.append($("<img>").addClass('imgDivStyle img-responsive').attr("src",responseText))))
					    					.append($("<td>")
					    								.append($("<section>").addClass('col col-6')
					    									.append($("<label>",{text:'Titulo'}).addClass('label'))
					    									.append($("<label>").addClass('input').append($("<input>",{type:'text',name:'titleImg['+responseText+'][]'}).addClass('input-sm'))))
					    								.append($("<section>").addClass('col col-6')
					    									.append($("<label>",{text:'Descripción'}).addClass('label'))
					    									.append($("<label>").addClass('textarea textarea-expandable').append($("<textarea>",{name:'description[]'}).addClass('custom-scroll'))))));
				    	}

				    	
				      		
				    });
				    this.on("maxfilesexceeded", function(file){
	        				alert("Rebasaste el limite de imagenes para la pregunta");
	        				 this.removeFile(file);
	    			});
	    			this.on('removedfile',function(file){
						var name = file.name.split(".");
						$("#"+name[0]).remove();  
	    			});
				  }
				});

		/********************************************************************************************************************/

		 Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("#my-dropzone-all-quiz", {
				 	maxFiles: 1,
					maxFilesize: 10,
					paramName: "file",
					addRemoveLinks : true,
					//previewsContainer: '#dropzonePreview',
					acceptedFiles: ".jpg, .jpeg, .gif, .png",
					dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Images <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
					dictResponseError: 'Error uploading file!',
				  init: function() {
				    this.on("success", function(file, responseText) {
				    
				    	var name = file.name.split(".");

				    	if(file){


				    		$(".addTitleImg").append($("<tr>").append($('<th>',{text:'Imagen de la pregunta','colspan':3})));

					    	$(".imgEditQuestion").append($("<tr>",{id:name[0]})
					    					.append($("<td>",{'colspan':3}).addClass('imgTdStyle')
					    						.append($("<div>")
					    								.append($("<img>").addClass('imgDivStyle img-responsive').attr("src",responseText)))));
					    	$("#imgQuestion").val(responseText);
				    	}

				    	
				      		
				    });
				    this.on("maxfilesexceeded", function(file){
	        				alert("Rebasaste el limite de imagenes para la pregunta");
	        				 this.removeFile(file);
	    			});
	    			this.on('removedfile',function(file){
						var name = file.name.split(".");
						$("#"+name[0]).remove();  
						$(".addTitleImg").children().remove();
	    			});
				  }
				});




			});

	/************************************************************************************/

	Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("#my-dropzone-rewards", {
				 	maxFiles: 5,
					maxFilesize: 10,
					paramName: "file",
					addRemoveLinks : true,
					//previewsContainer: '#dropzonePreview',
					acceptedFiles: ".jpg, .jpeg, .gif, .png",
					dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Images <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
					dictResponseError: 'Error uploading file!',
				  init: function() {
				    this.on("success", function(file, responseText) {
				    
				    	var name = file.name.split(".");

				    	if(file){

					    	$(".imgEditRw").append($("<tr>",{id:name[0]})
					    						.append($("<td>").addClass('add_story text-center').append($("<i>").addClass('fa fa-th fa-2x text-muted iconFaMove').append($("<span>").addClass('ng-binding'))))
						    					.append($("<td>").addClass('imgTdStyle')
					    						.append($("<div>")
					    								.append($("<img>").addClass('imgDivStyle img-responsive').attr("src",responseText))))
					    					.append($("<td>")
					    								.append($("<section>").addClass('col col-5')
					    									.append($("<label>",{text:'Categoria'}).addClass('label'))
					    									.append($("<label>").addClass('input').append($("<input>",{type:'text',name:'categoryImg['+responseText+'][]',placeholder:'Palomita Natural',required:true}).addClass('input-sm'))))
					    								.append($("<section>").addClass('col col-3')
					    									.append($("<label>",{text:'Puntos Min'}).addClass('label'))
					    									.append($("<label>").addClass('input').append($("<input>",{type:'number',name:'rangeIni[]',value:1,min:'1'}).addClass('input-sm'))))
					    								.append($("<section>").addClass('col col-3')
					    									.append($("<label>",{text:'Puntos Max'}).addClass('label'))
					    									.append($("<label>").addClass('input').append($("<input>",{type:'number',name:'rangeFin[]',value:150,min:'1'}).addClass('input-sm'))))));
				    	}

				    	
				      		
				    });
				    this.on("maxfilesexceeded", function(file){
	        				alert("Rebasaste el limite de imagenes para la pregunta");
	        				 this.removeFile(file);
	    			});
	    			this.on('removedfile',function(file){
						var name = file.name.split(".");
						$("#"+name[0]).remove();  
	    			});
				  }
				});


	</script>

	<script>
		angular
		  .module('App', [])
		  .controller('AppCtrl', questionController);

function questionController($http){

				var scope = this;
				items = {};
		    	items.data = [];
				opQuestions = [];

/***************************************/
			scope.typeOption = [
								{ id: 1,value: 'checkbox',name: 'Checkbox'}, 
								{ id: 2,value: 'radio',name: 'Radio'},
								{ id: 3,value: 'select',name: 'Select'},
								{ id: 4,value: 'imagen',name: 'Imagen'},
								{ id: 5,value: 'abierta',name: 'Abierta'},
								{ id: 6,value: 'text',name: 'Text'},
								{ id: 7,value: 'foto',name: 'Foto'}
								]; 


		scope.addOption = function (index) {

        	if(scope.newOption){

        		scope.items = items;
		        items.data.push({
		            id: scope.items.data.length + 1,
		            title: scope.newOption
		        });

		        opQuestions.push(scope.newOption);
		        scope.optionsRes = opQuestions;
		        scope.newOption = null;
        	}
        	

	    }

	    scope.deleteItem = function (index) {
	        items.data.splice(index, 1);
	        opQuestions.splice(index,1);
	        scope.optionsRes = opQuestions;
	    }

	    scope.deleteItemAct = function(index){

	    	scope.optionsQuestionImg.splice(index,1);
	    }


	    scope.EditQuestion = function(id){
	    	
	    	var http = $http({method:'GET',url:'/question/edit-question/'+id});


		    http.success(function(data){

		    	items.data = [];
		    	scope.question = '';
		    	scope.selectMaxElem='';
		    	scope.optionsQuestion='';
		    	scope.selectedOption='';
		    	scope.radioRequest='';
		    	scope.optionsQuestionImg='';
		    	scope.imgQuestions = '';

		            scope.question = data;
		            scope.typeContest = data.contest_type;
		            scope.selectMaxElem = data.numElemetMaxSel-1;
		            //scope.optionsQuestion = data.optionsQuestion;
		            scope.radioRequest = parseInt(data.request);
		            scope.imgQuestions = data.img;

		    	

		        /*************************************************/

		    	scope.items = items;

		    	(data.contest_type!='versus')?scope.optionsQuestion = data.optionsQuestion:scope.optionsQuestionImg = data.optionsQuestion;

		    	if(data.questionType == 'imagen'){scope.optionsQuestionImg = data.optionsQuestion}

		    	for (var i = 0; i < scope.optionsQuestion.length; i++) {
		    		
					if(data.questionType!= 'imagen'){
						items.data.push({
				            id: scope.items.data.length + 1,
				            title: scope.optionsQuestion[i].text
			        	});
					}
		    	};

		    
		    	/*************************************************/


		        angular.forEach(scope.typeOption, function(value, key) {

		            if(value.value == data.questionType){
		             scope.selectedOption = scope.typeOption[key];
		            }
					        
				});

		    });

		    http.error(function(data){
		        alert("errors")
		    });
	    }


	    scope.NewQuestion = function(){

		    	var http = $http({method:'GET',url:'/question/type-contest'});

		    		http.success(function(data){

		    			scope.typeContest = data.typeContest;

		    			if(scope.typeContest!="versus"){

		    				items.data = [];
					    	scope.question = '';
					    	scope.selectMaxElem='';
					    	scope.optionsQuestion='';
					    	scope.selectedOption='';
					    	scope.radioRequest='';
					    	scope.optionsQuestionImg='';
					    	scope.imgQuestions = '';

		    			}else{

		    				scope.selectedOption = scope.typeOption[3];
		    				scope.radioRequest = true;
		    			}
		    		});
		    		http.error(function(data){
		    			alert("error")
		    		});
	    }

	    scope.deleteQuestion = function(id){

	    	var http = $http({method:'GET',url:'/question/delete-question/'+id});

		    		http.success(function(data){
		    			window.location.reload();
		    		});
		    		http.error(function(data){
		    			alert("error")
		    		});
	    }

	    scope.checkedRadio = function(option){    	
	    	(option == 'Imagen') ? scope.radioRequest = true : scope.radioRequest = '';

	    }

	    scope.EditRewards = function(){

		    	var http = $http({method:'GET',url:'/rewards/show-rewards'});
		    		http.success(function(data){
		    			scope.typeContest = data.typeContest;
		    			if (data.infoPoint) {
		    				scope.point = data.infoPoint.id;
		    				scope.puntos = data.infoPoint.name;
		    				scope.infoCategories = JSON.parse(data.infoPoint.categories);
		    			}
		    			if(data.infoRewards){
		    				scope.givenPoints = data.infoRewards.given_points;
		    				scope.sharePoints = data.infoRewards.share_points;
		    			}
		    			scope.selectedOption = scope.typeOption[3];
		    			scope.imgQuestions = '';
		    			
		    		});
		    		http.error(function(data){
		    			alert("error")
		    		});
	    }

	    scope.deleteCatAct = function(index){

	    	scope.infoCategories.splice(index,1);
	    }


}

	</script>

@stop


