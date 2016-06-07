@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="pregunta-container main-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>
            <h3>{{isset($contentText->textPhrase)?$contentText->textPhrase:''}}</h3>

           	{{Form::open(array('url'=>'canal-5/'.$short_name."/save-phrase",'id'=>'contact-form-confirm-pregunta','method' => 'post'))}}
           
				<div class="form-box">
                    {{Form::label('respuesta', 'Respuesta')}}
                    <span class="span"></span>
                    {{Form::text('nombres','',array('id'=>'nombres','placeholder'=>Lang::get('promociones.pregPlaceName'),'data-requiere'=>'true','maxlength'=>"200",'data-format'=>'text','data-null'=>Lang::get('promociones.pregMsgNull')))}}
                </div>
                <div class="pregunta-contendor-boton">
                    {{Form::submit('Enviar',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>
           	{{Form::close()}}
        </div>
    </article>
   	
@stop