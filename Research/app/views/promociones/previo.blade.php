@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
       	<div class="iu-texto">
           	<div>
               	<h2 class="title">{{Lang::get('promociones.previoTitle')}}</h2>
               	<p class="parrafo parrafo_grande">{{Lang::get('promociones.previoParrafoG')}}</p>
               	<p class="parrafo">{{Lang::get('promociones.previoParrafo1')}}</p>
               	<p class="parrafo">{{Lang::get('promociones.previoParrafo2')}}</p>
               	<p class="parrafo p-resaltado">{{Lang::get('promociones.previoParrafoR')}}</p>
           	</div>
       	</div>
   	</article>
   	
@stop