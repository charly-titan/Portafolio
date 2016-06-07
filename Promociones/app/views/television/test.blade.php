@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container" style="width: 660px">
        <div class="pregunta-container main-form">
			<script type="text/javascript" >document.write('<script src="http' + ( ("https:" == document.location.protocol) ? "s" : "") + '://www.surveygizmo.com/s3/2078285/Quiz-Qu-personaje-eres?__output=embedjs&__ref=' + escape(document.location.origin + document.location.pathname) + '" type="text/javascript" ></scr'  + 'ipt>');</script>           
        </div>        

    </article>
   	
@stop

