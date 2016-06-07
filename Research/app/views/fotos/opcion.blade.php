@extends(Config::get( 'app.main_template' ).'.main')

@section('content')
<style>
    .error{color: red;}
</style>
    <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-8"> 
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2>M&oacute;dulo de Fotos</h2>                        
                </header>
                <div>          
                    <div class="widget-body no-padding">
                        {{Form::open(array('method' => 'POST','url' => 'fotos/opcion','class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                        <header>Selecciona la opci&oacute;n</header>
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <!--label class="label">Concurso</label-->
                                    <label class="select">
                                        <select name="opcion" id='opcion' onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                            <option value='/fotos/option/{{$id_contest}}'>Selecciona..</option>
                                            <option value='/fotos/aprobar-fotos/{{$id_contest}}'>Aprobar Fotos</option>
                                            <option value='/fotos/revisar-fotos/{{$id_contest}}'>Revisar Fotos Aprobadas</option>
                                        </select> <i></i> 
                                    </label>
                                    @if (Session::get('msg'))
                                    <br>
                                    <span class="error">{{Session::get('msg')}}</span>
                                    @endif    
                                </section>
                            </div>
                        </fieldset>
                        <footer>
                            {{ HTML::link('/',Lang::get('formAccount.cancel'),array('class' => 'btn btn-default')) }}
                            {{--Form::submit('Consultar',array('class'=>'btn btn-primary'))--}}
                        </footer>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
         </article> 
    </div>

@stop


