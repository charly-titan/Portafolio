@extends(Config::get( 'app.main_template' ).'.main')

<style>
	
        .prueba{
        	border: 2px solid red;
        }
		.dropzone{min-height: 200px;}
    	#demo .dropzone .dz-preview{font-size: 12px;} 
    	img {max-width: 100%;max-height: 100%;}
        @media all and (max-width: 1000px){
            img{
            width:800px;
            height: 250px;
            }
        }

	#demo1{max-width: 650px;}
	.checkbox {padding: 1em;}
	#demo,#imgDemo{display: none;}

</style>

@section('content')

	<article class="left-container" id='demo1'>
	       <div class="main-form" id='checkbokImg'>
            <h2>Carga tu Foto</h2>
                {{Form::open(array('url'=>'#','id'=>'contact-form-confirm','method' => 'post'))}}
                    <div class="form-box-100 check">
                        <div class="checkbox">
                        {{Form::checkbox('condiciones', '',false,array('class'=>'checkConditions', 'id'=>'condiciones','data-requiere'=>'true','data-format'=>'bases','data-null'=>Lang::get('promociones.formBaseCondMsgNull')))}}Acepto las 
                        {{ HTML::link('/canal5/'.$short_name.'/bases-concurso', Lang::get('promociones.formBaseCond'),array("target"=>"_blank")) }}
                        <p class="span1"></p></div>
                        <div class="checkbox">
                        {{Form::checkbox('aviso', '',false,array('class'=>'checkConditions','id'=>'aviso','data-requiere'=>'true','data-format'=>'privacidad','data-null'=>Lang::get('promociones.formAvsPrivMsgNull')))}}Acepto
                        {{ HTML::link('/canal5/'.$short_name.'/aviso-privacidad', Lang::get('promociones.formAvsPriv'),array("target"=>"_blank")) }}
                        <p class="span2"></p></div>
                    </div>
            {{Form::close()}}
        </div>
        <div class="iu-texto">
            <div id='demo'>
                <h3 class="resumen"> </h3>
                 	{{Form::open(array('url'=>'/canal5/rapidos-y-furiosos/uploadimg','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                    {{Form::close()}}
            </div>
            <div id='demo1'> 

            {{ html_entity_decode( HTML::image("", "",['id'=>'imgDemo']) )  }}

            </div>
        </div>
    </article>
   	
@stop


@section('scripts')
    @parent
    	{{ HTML::style('css/bootstrap.min.css') }}
    	{{ HTML::style('css/smartadmin-production-plugins.min.css') }}


    	{{ HTML::style('css/smartadmin-rtl.min.css') }}


    	{{ HTML::script("js/dropzone/dropzone.min.js") }}
    	                      

    	<script>

    	 /************** DropZone *******************/
			
			Dropzone.options.myDropzone = {
				maxFiles: 1,
				paramName: "file",
				addRemoveLinks : true,
				//maxFilesize: 500,
				acceptedFiles: ".jpg, .jpeg, .gif, .png",
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
				dictResponseError: 'Error uploading file!',
			  init: function() {
			    this.on("success", function(file, responseText) {

			    		$("#demo,#checkbokImg").hide();
			    		$('#imgDemo').attr('src',responseText);
			    		$("#imgDemo").show();
			    		console.log(responseText)
			      		
			    });
			    this.on("maxfilesexceeded", function(file){
	        				alert("Se permite solo una imagen");
	        				 this.removeFile(file);
	    			});
			  }
			};

			$(function(){

					document.getElementById('condiciones').onclick = function() {
					   if (this.checked) {
					      	if ($("#aviso").is(':checked')) {
						           $("#demo").show();
						    }
					   }else{
						    	$("#demo").hide();
						}
					}

					document.getElementById('aviso').onclick = function() {
					   if (this.checked) {
					     	if ($("#condiciones").is(':checked')) {
						        $("#demo").show();
						    }
					   }else{
					   	$("#demo").hide();
					   }

					}

					


			}); 

    	</script>

 @stop
