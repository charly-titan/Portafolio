@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
<style type="text/css">
.iu-texto div{font-family: Arial;}
</style>

    <article class="left-container">
       	<div class="iu-texto">
           	<div>
               	<h2 class="title">Aviso de privacidad</h2>
                <div >{{isset($contentPrivacyPolicy)?$contentPrivacyPolicy:''}}</div>
           	</div>
       	</div>
   	</article>
   	
@stop