@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
       	<div class="iu-texto">
           	<div>
               	<h2 class="title">{{isset($info->properties['titlePrevious'])?$info->properties['titlePrevious']:''}}</h2>
               	<p class="parrafo">{{isset($contentText->textPrevious)?$contentText->textPrevious:''}}</p>
           	</div>
           	<div class="btn-text">
                    {{ HTML::link(isset($info->properties['urlPrevious'])?$info->properties['urlPrevious']:'', isset($info->properties['nameUrlPrevious'])?$info->properties['nameUrlPrevious']:'') }}
           </div>
       	</div>
   	</article>
   	
@stop