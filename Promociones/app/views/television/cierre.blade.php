@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
	<article class="left-container">
        <div class="iu-texto">
            <div>
                <h2 class="title">{{isset($info->properties['titleClosure'])?$info->properties['titleClosure']:''}}</h2>
                <h3 class="resumen"> {{isset($contentText->textClosure)?$contentText->textClosure:''}}</h3>
            </div>
            <div class="btn-text">
                    {{ HTML::link(isset($info->properties['urlClosure'])?$info->properties['urlClosure']:'', isset($info->properties['nameUrlClosure'])?$info->properties['nameUrlClosure']:'') }}
            </div>
        </div>
    </article>
   	
@stop