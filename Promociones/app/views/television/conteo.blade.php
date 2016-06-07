@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="iu-texto gracias">
            
            <div>
                
                {{$conteo['question']->questionText}}
            </div>  
            <br />            
            <div>      
                <table>
                    <tr>
                        <th style='min-width: 180px; text-align: left'>Opcion</th>
                        <th>Votos</th>
                    </tr>    
                    @foreach ($conteo['conteo'] as $cont)
                        @if (isset($conteo['options'][$cont->option_id]))
                            <tr>
                                <td>{{$conteo['options'][$cont->option_id]}}</td>
                                <td>{{$cont->count}}</td>
                            </tr>

                        @endif                        
                    @endforeach 
                </table>           
            </div>
            <div class="btn-text">                    
            </div>
        </div>
    </article>
   	
@stop