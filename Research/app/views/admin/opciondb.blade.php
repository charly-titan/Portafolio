@extends(Config::get( 'app.main_template' ).'.main')

@section('content')
<style>
    .error{color: red;}
</style>
@if (($userPermission["create"]) && ((Session::get('user.email')=='elsa.salinas@televisatim.com') or (Session::get('user.email')=='gabriel.mancera@televisatim.com')))
    <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-8"> 
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2>Limpiar registros</h2>                        
                </header>
                <div>          
                    <div class="widget-body no-padding">
                        {{Form::open(array('method' => 'POST','url' => 'admin/clean','class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                        <header>Selecciona el concurso</header>
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
                        <footer>
                            {{ HTML::link('/',Lang::get('formAccount.cancel'),array('class' => 'btn btn-default')) }}
                            {{Form::submit('Ejecutar',array('class'=>'btn btn-primary'))}}
                        </footer>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
         </article> 
    </div>

    <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-10"> 
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2>Ejecutar consultas</h2>                        
                </header>
                <div>          
                    <div class="widget-body no-padding">
                        {{Form::open(array('method' => 'POST','url' => 'admin/query','class'=>'smart-form','id'=>'query-form','novalidate'=>'novalidate'))}}
                        <header>DB</header>
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="select">
                                        <select name="conne">
                                            <option value='1'>research</option>
                                            <option value='2'>promociones</option>
                                        </select> <i></i> 
                                    </label>
                                </section>
                                <section class="col col-10">
                                    <label class="label">Consulta</label>    
                                    <textarea rows="5" class="form-control" name="query"  ></textarea>
                                    @if (Session::get('msgquery'))
                                    <br>
                                    <span class="error">{{Session::get('msgquery')}}</span>
                                    @endif    
                                </section>
                            </div>
                        </fieldset>
                        <footer>
                            {{ HTML::link('/',Lang::get('formAccount.cancel'),array('class' => 'btn btn-default')) }}
                            {{Form::submit('Ejecutar',array('class'=>'btn btn-primary'))}}
                        </footer>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
         </article> 
    </div>
@endif

@stop


