@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

    <article class="left-container">
       	<div class="iu-texto">
           	<div>
               	 <h2 class="title">{{isset($short_name)?$short_name:''}}</h2>
                <p class="resumen">{{isset($contentTerminosCond)?$contentTerminosCond:''}}</p>
           	</div>
       	</div>
   	</article>
   	
@stop