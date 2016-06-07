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

	#upimg{max-width: 650px;}
	.checkbox {padding: 1em;}
	#imgDemo{display: none;}
	
@if(isset($info->properties['colorFont']))
    input[type="submit"].btn-confirmar{background: {{$info->properties['colorHeader']}}!important;}
@endif
</style>

@section('content')

	<article class="left-container" id='upimg'>
	   <div class="main-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>
            <h3>{{isset($contentText->textPhrase)?$contentText->textPhrase:'Sube tu foto para partipar'}}</h3>
        	<div class="iu-texto">
            <div id='demo'>
                <h3 class="resumen"> </h3>
                 	{{Form::open(array('url'=>'canal-5/'.$short_name.'/uploadimg','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                    {{Form::close()}}
            </div>
            <div id='upimg'> 
            	{{Form::open(array('url'=>'canal-5/'.$short_name.'/save-foto','method'=>'POST'))}}
            		<div class="form-box">
                        {{Form::label('nameImage','Nombre')}}
                        <span class="span"></span>
                        {{Form::text('nameImage',"", array('placeholder'=>'Escribe un nombre para tu foto','data-requiere'=>'true','data-format'=>'text','data-null'=>Lang::get('promociones.formNameMsgNull'),'id'=>'nameImage'))}}
                    </div>
            		{{Form::hidden('urlImage',"", array('id'=>'urlImage'))}}
            		<div class="form-box-100">    
                    	{{Form::submit('Guardar',array('id'=>'botonGuardar','class'=>'btn-confirmar','name'=>'guardar'))}}
                	</div>
                {{Form::close()}}  
            {{-- html_entity_decode( HTML::image("", "",['id'=>'imgDemo']) )  --}}

            </div>
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
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Coloca la foto aqu&iacute; <span class="font-xs">para subirla</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (O haz Click)</h4></span>',
				dictResponseError: 'Error al subir la foto!',
			  init: function() {
			    this.on("success", function(file, responseText) {
			    		/*$("#demo,#checkbokImg").hide();
			    		$('#imgDemo').attr('src',responseText);
			    		$("#imgDemo").show();*/
			    		$("#urlImage").val(responseText);
			    		//console.log(responseText)
			      		
			    });
			    this.on("maxfilesexceeded", function(file){
	        		alert("Se permite solo una imagen");
	        		this.removeFile(file);
	    		});
			    this.on("removedfile", function(file){
	        			$("#urlImage").val("");
	        				 
	    		});
			  }
			};

		$(document).ready(function () {
		    
		    $("#botonGuardar").click(function (){
		        if( $("#urlImage").val() == "" ){
		            alert("No hay imagen para guardar");
		            return false;
		        }
				if( $("#nameImage").val() == "" ){
		            alert("Escribe un nombre");
		            return false;
		        }
		    });
		    
		});
			
    	</script>

 @stop
