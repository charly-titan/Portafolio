@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="pregunta-container main-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>
            <h3>{{$info->question->questionText}}</h3>                       	
				

                @foreach($info->options as $key => $inf)
                    {{ html_entity_decode( HTML::link('canal-5/'.$info->short_name."/votacion/".$info->question->id."/".$inf->id, HTML::image($inf->img, "Logo") ) ) }}                    
                @endforeach

                <div class="pregunta-contendor-boton">
                    {{Form::submit('Enviar',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>

        </div>              
        <div class="pregunta-container main-form">
            
        </div>    
    </article>
    
    
@stop