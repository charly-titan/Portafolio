@extends('vcms.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Crear</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <section class="widget">
                <div class="body">
                    <!--form id="game-form" url="newGame" class="form-horizontal label-left"
                          novalidate="novalidate"
                          method="post"
                          data-parsley-priority-enabled="false"-->
                    {{Form::open(array('method'=>'POST','url'=>'newGame','class'=>'form-horizontal label-left','id'=>'user-form','data-parsley-priority-enabled'=>'false'))}}
                        <fieldset>
                            <legend class="section">
                                Partido                                
                            </legend>
                            <div class="control-group">
                                <label for="teem_local" class="control-label">Equipo Local </label>
                                <div class="controls form-group">
                                    <select id="teem_local" data-placeholder="Selecciona..."
                                            required="required" class="col-xs-12 col-sm-6 chzn-select" name="teem_local">
                                        <option value=""></option>
                                        @foreach ($teems as $key)
                                            <option value="{{$key['id']}}" id="{{$key['id']}}">{{$key['nombre']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="teem_visit" class="control-label">Equipo Visitante </label>
                                <div class="controls form-group">
                                    <select id="teem_visit" required="required"
                                            data-placeholder="Selecciona..." class="col-xs-12 col-sm-6 chzn-select" name="teem_visit">
                                        <option value=""></option>
                                        @foreach ($teems as $key)
                                            <option value="{{$key['id']}}" id="{{$key['id']}}">{{$key['nombre']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_game" class="control-label">{{Lang::get('vcms.date_label')}} </label>
                                <div class="controls form-group">
                                    <span class="form-group-btn">
                                        <a href="#" id="btn-select-calendar" class="btn btn-danger" data-date-format="yyyy/mm/dd" data-date=today();><i class="fa fa-calendar"></i></a>
                                    </span>
                                    <input id="date_game" class="col-xs-12 col-sm-5" type="text" name="date_game" value="" required="required" format="yyyy/mm/dd">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="exp" class="control-label">{{Lang::get('vcms.hour_label')}}</label>
                                <div class="controls form-group">
                                    <input type="time" id="time_game" name="time_game" value="12:00:00" class="col-xs-12 col-sm-6" required="required">
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="v2"><button type="button" class="btn btn-default">Cancelar</button></a>
                        </div>
                    {{Form::close()}} 
                </div>
            </section>
        </div>
        
    </div>

    
@stop

@section('scripts')
 @parent

    {{ HTML::script('/light-blue/lib/bootstrap-datepicker.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            
            var $Calendar = $('#date_game');
            $Calendar.datepicker({
                autoclose: false
            }).on('changeDate', function(ev){
                $Calendar.datepicker('hide');
            });

            var $btnCalendar = $('#btn-select-calendar');
            $btnCalendar.datepicker({
                autoclose: true
            }).on('changeDate', function(ev){
                    $('#date_game').val($btnCalendar.data('date'));
                $btnCalendar.datepicker('hide');
            });
        });

        

    </script>
   

@stop
