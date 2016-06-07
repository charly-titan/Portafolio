@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

    <article class="left-container">
        <div class="iu-texto">
            <div class="terminos-condiciones">
                <h2 class="title">{{isset($info->properties['titleMechanical'])?$info->properties['titleMechanical']:''}}</h2>
                
                <div>{{isset($contentText->textMechanical)?$contentText->textMechanical:''}}</div>
            </div>
	        <div class="registro">
	            <h2 class="title">{{Lang::get('promociones.registroTitle')}}</h2>
	            <h4 class="resumen_login">
	            <b>{{Lang::get('promociones.registroLogin')}}</b>&nbsp;{{Lang::get('promociones.registroLogin2')}}</h4>
	            <ul class="redes">
	                <li class="twitter">
	                    <a href="/social/Twitter" title="Twitter">
	                        <i class="c5-twitter"></i>
	                    </a>
	                </li>
	                <li class="facebook">
	                    <a href="/social/Facebook" title="Facebook">
	                        <i class="c5-facebook"></i>
	                    </a>
	                </li>
	                <li class="google">
	                    <a href="/social/Google" title="google">
	                        <i class="c5-plus"></i>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</article>

	  
@stop



