@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

<style>
	h2{text-align: center;}
	.emPos{margin-left: .5em}
	
	#typeContest{text-align: center;font-size: 16px;}
	.title{text-align: center;font-size: 16px;}

	/*tr,td{border:.5px solid red;padding: 2em}*/

	.add_story{cursor: move;}
	.iconFaMove{display: none;}
	.active{display: inline;}

	@media screen and (min-width: 1100px) {
		.modal-content {
			width: 800px;

		}
	}

</style>

<section id="widget-grid" class="" ng-app="App" ng-controller="AppCtrl as vm">
	<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false">
		<header>
			<span class="widget-icon"> <i class="fa fa-bank"></i> </span>
			<h2>Tiendas</h2>
		</header>
		<div>
			<div class="widget-body no-padding">
				<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
			        <thead>
			        	<tr>
			        		<!-- <th colspan="9">{{ HTML::link('premios/nvatienda',' +',array('class' => 'btn btn-info fa fa-gift fa-lg pull-right')) }}</th> -->
			        		<th colspan="9"> <a class="btn btn-info fa fa-gift fa-lg pull-right" data-toggle="modal" data-target="#modalRds" ng-click="vm.NewQuestion()"> +</a></th>
			        	</tr>								
			        	<tr>
		                    <th data-class="expand">Tienda</th>
		                    <th data-class="expand">Nombre de Puntos</th>
		                    <th data-hide="phone">Premios</th>
		                    <th data-hide="phone">Editar</th>
		                    <th data-hide="phone,tablet">Eliminar</th>
			            </tr>
			        </thead>
	        		<tbody>
			            @foreach ($tiendas as $tienda)
			            <tr>
			                <td>{{$tienda->sitio}}</td>
			                <td>{{$tienda->nombre_puntos}}</td>
			                <td>{{$tienda->premios}}</td>
			                <td>
			                	<a class="btn btn-warning btn-xs fa fa-edit" data-toggle="modal" data-target="#modalRds" ng-click="vm.EditPremios('{{$tienda->sitio}}')"></a>
				            	{{-- HTML::link('user/editienda/'.$tienda->sitio,'',array('class' => 'btn btn-warning btn-xs fa fa-edit')) --}}
				            </td>
				            <td>
				                {{ HTML::link('user/deletetienda/'.$tienda->sitio,'',array('class' => 'btn btn-danger btn-xs delete fa fa-times','onclick' => "return message();")) }}
				            </td>
				           
			            </tr>
			            @endforeach
			        </tbody>
					
				</table>

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
	                <h4 class="modal-title" id="myModalLabel">Premios</h4>
	            </div>
	            <div class="modal-body" >
		            @include('premios/premios')
	            </div>
	        </div>
	    </div>
	</div>	
</section>	


@stop




@section('scripts')
	@parent

	<!-- PAGE RELATED PLUGIN(S) -->
	<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
	<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
	{{ HTML::script("js/plugin/dropzone/dropzone.min.js") }}

	<script type="text/javascript">
		$(document).ready(function() {
			
			pageSetUp();
			
			/* BASIC ;*/
				
			var responsiveHelper_datatable_fixed_column = undefined;
				
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};
	
			/* END BASIC */
			
			/* COLUMN FILTER  */
		    var otable = $('#datatable_fixed_column').DataTable({
		    	//"bFilter": false,
		    	//"bInfo": false,
		    	//"bLengthChange": false
		    	//"bAutoWidth": false,
		    	//"bPaginate": false,
		    	//"bStateSave": true // saves sort state using localStorage
				// "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
				// 		"t"+
				// 		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_fixed_column) {
						responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_fixed_column.respond();
				}		
			
		    });
		    
		    // Apply the filter
		    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
		    	
		        otable
		            .column( $(this).parent().index()+':visible' )
		            .search( this.value )
		            .draw();
		            
		    } );
		    /* END COLUMN FILTER */   
		})


		function message() {

	        var lang = $("#language-combo").val();

	        if (lang == 'es') {
	            var msg ='¿Está seguro de que desea eliminar la tienda?';
	        }
	        if (lang == 'en') {
	            var msg = 'Are you sure you want to delete the store?';
	        }
	        if(!lang){
	        	var msg = '¿Está seguro de que desea eliminar la tienda?';
	        }

	        var msgs = confirm(msg);

	        if (msgs == false) {
	            return false;
	        }
	    }
	</script>

	<script type="text/javascript">

		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone("#my-dropzone-premios", {
			//maxFiles: 5,
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
				    								.append($("<section>").addClass('col col-3')
				    									.append($("<label>").addClass('input').append($("<input>",{type:'hidden',name:'premioImg['+responseText+'][]'}).addClass('input-sm')))
				    									.append($("<label>",{text:'Nombre'}).addClass('label'))
				    									.append($("<label>").addClass('input').append($("<input>",{type:'text',name:'premioImg['+responseText+'][]',placeholder:'Escribe el nombre',required:true}).addClass('input-sm'))))
				    								.append($("<section>").addClass('col col-3')
				    									.append($("<label>",{text:'Descripción'}).addClass('label'))
				    									.append($("<label>").addClass('input').append($("<input>",{type:'text',name:'premioImg['+responseText+'][]',placeholder:'Escribe la descripción',required:true}).addClass('input-sm'))))
				    								.append($("<section>").addClass('col col-2')
				    									.append($("<label>",{text:'Valor'}).addClass('label'))
				    									.append($("<label>").addClass('input').append($("<input>",{type:'number',name:'valor[]',value:1,min:'1'}).addClass('input-sm'))))
				    								.append($("<section>").addClass('col col-2')
				    									.append($("<label>",{text:'Cantidad'}).addClass('label'))
				    									.append($("<label>").addClass('input').append($("<input>",{type:'number',name:'cantidad[]',value:1,min:'1'}).addClass('input-sm'))))));
			    	}
			    });
			    this.on("maxfilesexceeded", function(file){
	       				alert("Se exedio el limite de imagenes para la pregunta");
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
		  .controller('AppCtrl', premiosController);

	function premiosController($http){

				var scope = this;
				items = {};
		    	items.data = [];
				opQuestions = [];




	    scope.NewQuestion = function(){
	    		scope.tienda = "";
		    	scope.puntos = "";
		    	scope.infoPremios=[];
		    	$("input[name=tienda]").prop('readonly', false);
	    }

	    // scope.deleteQuestion = function(id){

	    // 	var http = $http({method:'GET',url:'/question/delete-question/'+id});

		   //  		http.success(function(data){
		   //  			window.location.reload();
		   //  		});
		   //  		http.error(function(data){
		   //  			alert("error")
		   //  		});
	    // }

	    // scope.checkedRadio = function(option){    	
	    // 	(option == 'Imagen') ? scope.radioRequest = true : scope.radioRequest = '';

	    // }

	    scope.EditPremios = function(sitio){
	    		var http = $http({method:'GET',url:'/premios/show-premios/'+sitio});
		    		http.success(function(data){
		    			scope.tienda = data.tienda;
		    			scope.puntos = data.puntos;
		    			if (data.allPremios) {
		    				scope.infoPremios = data.allPremios;
		    			}
		    			$("input[name=tienda]").attr('readonly', true);//attr('disabled', 'disabled');
		    		});
		    		http.error(function(data){
		    			alert("error")
		    		});
	    }

	    scope.deleteCatAct = function(index){

	    	scope.infoPremios.splice(index,1);
	    }


}

	</script>

@stop