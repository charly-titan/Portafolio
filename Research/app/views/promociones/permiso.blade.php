@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="iu-texto permiso">
            <div>
                <h2 class="title">{{Lang::get('promociones.permisoTitle')}}</h2>
                <h3 class="resumen">{{Lang::get('promociones.permisoResumen')}}</h3>
                <div class="btn-text">
                    {{ HTML::link('#', Lang::get('promociones.permisoMsg')) }}
                </div>
            </div>
        </div>
    </article>
   	
@stop