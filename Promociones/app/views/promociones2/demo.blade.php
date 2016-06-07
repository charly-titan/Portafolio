@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container" style="width: 660px">
        <div class="pregunta-container main-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>            
            
            {{Form::open(array('url'=>'canal-5/'.$short_name."/foto",'id'=>'contact-form-confirm-pregunta','method' => 'get'))}} 
                <div class="pregunta-contendor-boton">
                    {{Form::submit('Sube tu Foto',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>
           	{{Form::close()}}
            {{Form::open(array('url'=>'canal-5/'.$short_name."/test",'id'=>'contact-form-confirm-pregunta','method' => 'get'))}} 
                <div class="pregunta-contendor-boton">
                    {{Form::submit('Test',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>
            {{Form::close()}}

            <div class="pregunta-contendor-boton">
                <a href="http://www2.esmas.com/test/test-3/testnuevo/fotos_telenovela.html" target="_blank">    
                    {{Form::submit('Fotogaleria',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </a>    
            </div>                    
        </div>        

    </article>
   	
@stop