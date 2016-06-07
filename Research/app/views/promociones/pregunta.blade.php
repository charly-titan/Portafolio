@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="pregunta-container main-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo')}}</h2>
            <h3>{{Lang::get('promociones.preguntaMsg')}}</h3>

           	{{Form::open(array('url'=>'','id'=>'contact-form-confirm-pregunta'))}}
				<div class="form-box">
                    {{Form::label('respuesta', 'Respuesta')}}
                    <span class="span"></span>
                    {{Form::text('nombres','',array('id'=>'nombres','placeholder'=>Lang::get('promociones.pregPlaceName'),'data-requiere'=>'true','data-format'=>'text','data-null'=>Lang::get('promociones.pregMsgNull')))}}
                </div>
                <div class="pregunta-contendor-boton">
                    {{Form::submit('Enviar',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>
           	{{Form::close()}}
        </div>
    </article>
   	
@stop