@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="iu-texto gracias">
            <div>
                <h2 class="title">{{isset($info->properties['titleThanks'])?$info->properties['titleThanks']:''}}</h2>
                <h3 class="resumen">{{isset($contentText->textThanks)?$contentText->textThanks:''}}</h3>
            </div>
            <div class="btn-text">
                    {{ HTML::link(isset($info->properties['urlThanks'])?$info->properties['urlThanks']:'', isset($info->properties['nameUrlThanks'])?$info->properties['nameUrlThanks']:'') }}
            </div>
        </div>
        <br>
    </article>
   	
@stop