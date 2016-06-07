@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
       <div class="iu-texto">
           <div>

               <h2 class="title">{{isset($info->properties['titleWaiting'])?$info->properties['titleWaiting']:''}}</h2>
               <h3 class="resumen">{{isset($contentText->textWaiting)?$contentText->textWaiting:''}}</h3>
           </div>
           <div class="btn-text">
                    {{ HTML::link(isset($info->properties['urlWaiting'])?$info->properties['urlWaiting']:'', isset($info->properties['nameUrlWaiting'])?$info->properties['nameUrlWaiting']:'') }}
           </div>
       </div>
    </article>
   	
@stop