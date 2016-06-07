@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

	<article class="left-container">
        <div class="iu-texto">
            <div>
                <h2 class="title">{{Lang::get('promociones.cierreTitle')}}</h2>
                <h3 class="resumen">{{Lang::get('promociones.cierreResumen')}}</h3>
                <h3 class="resumen">{{Lang::get('promociones.cierreResumen1')}}</h3>
            </div>
        </div>
    </article>
   	
@stop