@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

    <article class="left-container">
        <div class="iu-texto">
            <div class="terminos-condiciones">
                <h2 class="title">{{Lang::get('promociones.titleContainer')}}</h2>
                <h4 class="resumen_login">{{Lang::get('promociones.resumen_login')}}</h4>
                <h5 class="encabezado">{{Lang::get('promociones.encabezado')}}</h5>
                <ul class="mecanica">
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip1')}}
                        <strong>{{Lang::get('promociones.loginMsgLip1S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip2')}}
                        <strong>{{Lang::get('promociones.loginMsgLip2S')}}</strong>y 
                        <strong>{{Lang::get('promociones.loginMsgLip2S1')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip3')}}
                        <strong>{{Lang::get('promociones.loginMsgLip3S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip4')}}</p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip5')}} 
                        <strong>{{Lang::get('promociones.loginMsgLip5S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip6')}}
                        <strong>{{Lang::get('promociones.loginMsgLip6S')}}</strong></p>
                    </li>
                </ul>
                <h5 class="encabezado" />
                <ul class="condiciones">
                    <li>
                        <p>
                            <STRONG>{{Lang::get('promociones.condiciones')}}</STRONG>
                        </p>
                    </li>
                    <li>
                        <p />
                    </li>
                    <li>
                        <p />
                    </li>
                    <li>
                        <p />
                    </li>
                </ul>
            </div>
	        <div class="registro">
	            <h2 class="title">{{Lang::get('promociones.registroTitle')}}</h2>
	            <h4 class="resumen_login">
	            <b>{{Lang::get('promociones.registroLogin')}}</b>&nbsp;{{Lang::get('promociones.registroLogin2')}}</h4>
	            <ul class="redes">
	                <li class="twitter">
	                    <a href="/social/Twitter" title="Twitter">
	                        <i class="tvsagui-twitter"></i>
	                    </a>
	                </li>
	                <li class="facebook">
	                    <a href="/social/Facebook" title="Facebook">
	                        <i class="tvsagui-facebook"></i>
	                    </a>
	                </li>
	                <li class="google">
	                    <a href="/social/Google" title="google">
	                        <i class="tvsagui-gplus"></i>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</article>

	  
@stop



