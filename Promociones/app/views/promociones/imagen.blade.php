@extends(Config::get( 'app.main_template' ).'.main')

<style>
	
        .prueba{
        	border: 2px solid red;
        }
		.dropzone{min-height: 200px;}
    	#demo .dropzone .dz-preview{font-size: 12px;} 

</style>
@section('content')
	<article class="left-container">
        <div class="iu-texto">
            <div id='demo'>
                <h2 class="title"></h2>
                <h3 class="resumen"> </h3>
                 	{{Form::open(array('url'=>'/canal5/rapidos-y-furiosos/uploadimg','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                    {{Form::close()}}
            </div>
        </div>
    </article>

@stop

@section('scripts')
    @parent
    	{{ HTML::script("js/dropzone/dropzone.min.js") }}

    	<script>

    	 /************** DropZone *******************/

			
			Dropzone.options.myDropzone = {
				maxFiles: 1,
				paramName: "file",
				addRemoveLinks : true,
				maxFilesize: 10,
				acceptedFiles: ".jpg, .jpeg, .gif, .png",
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
				dictResponseError: 'Error uploading file!',
			  init: function() {
			    this.on("success", function(file, responseText) {
			    		console.log(responseText)
			      		
			    });
			  }
			};
    	</script>

 @stop