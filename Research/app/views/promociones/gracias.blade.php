@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="iu-texto gracias">
            <div>
                <h2 class="title">{{Lang::get('promociones.graciasTitle')}}</h2>
                <h3 class="resumen">{{Lang::get('promociones.graciasResumen')}}</h3>
            </div>
        </div>
    </article>
   	
@stop