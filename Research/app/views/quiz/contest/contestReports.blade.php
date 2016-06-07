@extends(Config::get( 'app.main_template' ).'.main')

@section('content')
<style>
    .error{color: red;}
</style>
@if ($userPermission["create"])
    <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-8"> 
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                    @if ($reporte==1)
                    <h2><strong>Reporte de Registros</strong></h2>
                    @else
                    <h2><strong>Reporte de Participantes</strong></h2>
                    @endif                        
                </header>
                <div>          
                    <div class="widget-body no-padding">
                        {{Form::open(array('method' => 'POST','url' => '/report/generate','class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                        <header>Selecciona el concurso para generar el reporte</header>
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <!--label class="label">Concurso</label-->
                                    <label class="select">
                                        <select name="contest" id='contest'>
                                            @foreach ($dataContest as $contest)
                                            <option value='{{$contest->id_contest}}'>{{$contest->short_name}}</option>
                                            @endforeach
                                        </select> <i></i> 
                                    </label>
                                    @if (Session::get('msg'))
                                    <br>
                                    <span class="error">{{Session::get('msg')}}</span>
                                    @endif    
                                </section>
                            </div>
                        </fieldset>
                        {{Form::hidden('reporte',$reporte)}}
                        <footer>
                            {{ HTML::link('/',Lang::get('formAccount.cancel'),array('class' => 'btn btn-default')) }}
                            {{Form::submit('Generar reporte',array('class'=>'btn btn-primary'))}}
                        </footer>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
         </article> 
    </div>

@endif

@stop


