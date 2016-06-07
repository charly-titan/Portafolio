@extends(Config::get( 'app.main_template' ).'.main')

<style>
	
        
	#upimg{max-width: 550px;}
	.checkbox {padding: 1em;}
	.iu-texto {
	  width: 100% !important
	}
	.c5-wapper .wrapper-container .container .left-container {
	  width: 550px !important
	}
	@if(isset($info->properties['colorFont']))
        .iu-texto .btn-text a{color:{{$info->properties['colorFont']}}!important; }
        @endif
</style>

@section('content')

	<article class="left-container" >
	   <div class="iu-texto gracias">
            <h2 class="title">{{isset($info->properties['titleThanks'])?$info->properties['titleThanks']:''}}</h2>
			
            
        </div>
        <div class="col-md-12 col-sm-8">
			<div class="service-item">
	            	{{ html_entity_decode( HTML::image($photo->foto_url, "",['id'=>'imgDemo', 'class'=>'img-responsive']) )  }}
	            	<div class="iu-texto">
	            		@if ($photo->status=="pending")
		                	<h4 class="resumen"> Foto en revisi&oacute;n</h4>
		                @else
		                	<h4 class="resumen"> Tu foto esta aprobada ¡Ya puedes verla!</h4>
		                @endif
	            		<!--h4>{{$photo->foto_name}}</h4-->
	               	</div>
            	</div>
            </div>
        
		<br>
		<div class="iu-texto ">
			<!--p>Esta es la url donde tus amigos podr&aacute;n votar ¡Comp&aacute;rtela!</p-->
			<div class="iu-texto">
        		<h3 class="resumen">{{isset($contentText->textThanks)?$contentText->textThanks:''}}</h3>

            </div>
			<div class="btn-text">
				{{ HTML::link(isset($info->properties['urlThanks'])?$info->properties['urlThanks']:'', isset($info->properties['nameUrlThanks'])?$info->properties['nameUrlThanks']:'') }}				
	            {{-- HTML::link($photo->voto_url, 'Vota por tu foto aqu&iacute;', array( 'target'=>'blank','class'=>'link-vota')) --}}
	        </div>
        </div>       
               
    </article>
   	
@stop


@section('scripts')
    @parent
    	<!-- Bootstrap CSS -->
		<link href="/fasi/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="/fasi/css/font-awesome.min.css" rel="stylesheet">	
		<!-- Pretty Photo CSS -->
		<link href="/fasi/css/prettyPhoto.css" rel="stylesheet">

    	

 @stop
