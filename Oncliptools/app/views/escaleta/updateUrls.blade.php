@extends('vcms.main')

@section('style')
{{ HTML::script('js/jquery-1-11.js') }} 
{{ HTML::script('js/updateUrl.js') }} 
{{ HTML::script('js/messages.js') }} 
@stop

@section('content')
@if (Sentry::check())

@if ($user = Sentry::getUser())
<div class="content container">
    <div class="row">
        <div class="col-md-10">
            <section class="widget">
                <header>
                    <h4>   <h4>{{Lang::get('feeds.update_record')}}</h4>    </h4>
                </header>

                <div  class="body">
                    <input type='hidden' id='formUserPermission' value='formUserPermission'>

                    <div class="body text-align-center">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-4">
                                    @if (Session::has('registration_success'))
                                    <div class="alert alert-success" id="exito">
                                        {{ Session::get('registration_success') }}
                                    </div>
                                    @endif
                                    
                                     @if (Session::has('alert_info'))
                                    <div class="alert alert-info" id="exito">
                                        {{ Session::get('alert_info') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-xs-4">

                                </div>
                                <div class="col-xs-4"> 
                                    {{Form::open(array('method' => 'GET','url' => 'resgitroUrls','class'=>'form-horizontal label-left','id'=>'myForm'))}}

                                    {{ Form::submit(Lang::get('feeds.previous'), array('class' => 'btn btn-success')) }}

                                    {{ Form::close() }} 
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::model($programUrl, ['method' => 'POST','url' => array('controller/editprofile/'.$programUrl->id_url,'class'=>'validar_form','id'=>'myForm','data-parsley-priority-enabled'=>'false','onsubmit'=>'return validar(this)') ])}}
                    <fieldset>
                        <div class="col-md-8">
                            <section class="widget">
                                <div class="body">
                                    <div class="control-group" >
                                        <h4>{{Lang::get('feeds.add_url')}}</h4>
                                        <div class="controls form-group">
                                            <div class="input-group col-sm-5">
                                                {{ Form::select('id', $combobox,isset($programUrl->id)?$programUrl->id:'',['class' => 'chzn-select select-block-level','id' => 'selectorPrograms'] )
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group"> 
                                        <h4>{{Lang::get('feeds.site_url')}}</h4>
                                        <div class="controls form-group">
                                            <div class="input-group col-sm-9">
                                                {{ Form::text('url', Input::old('url'), ['id' => 'url','class' => 'form-control', 'placeholder' => 'www.televisa.com']); }} 
                                            </div>{{$errors->first('url', '<span class="error">:message</span>')}}
                                            <div id="error" ></div>
                                        </div>
                                    </div>
                                    <div class="control-group" style="display: none"   >
                                        {{ Form::text('id', Input::old('id'),array('name' => 'prueba')); }}
                                    </div>
                                    <div class="row">
                                        <div class="control-group col-sm-4">
                                                <label class="control-label"><h4>{{Lang::get('feeds.turn_on')}}</h4></label>
                                                <div class="controls form-group">
                                                    {{Form::text('active_date',isset($active_date)?$active_date:'', ['class' => 'form-control date-picker', 'placeholder' => 'mm/dd/yyyy','data-date'=>'today()','id'=>'dpd1'])}}
                                                </div>
                                        </div>
                                        <div class="control-group col-sm-4">
                                            <label class="control-label"><h4>{{Lang::get('feeds.off_in')}}</h4> </label>
                                                <div class="controls form-group">
                                                    {{Form::text('inactive_date',isset($inactive_date)?$inactive_date:'', ['class' => 'form-control date-picker', 'placeholder' => 'mm/dd/yyyy','data-date'=>'today()','id'=>'dpd2'])}}
                                                </div>
                                        </div>
                                        <div class="control-group col-sm-4">
                                                <h4>{{Lang::get('feeds.status')}}</h4>
                                                <div class="controls form-group">
                                                    {{ Form::checkbox('status', 0, false,['disabled','class'=>'iCheck']) }}
                                                </div>
                                                {{$errors->first('status', '<span class="error">:message</span>')}}    
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <h4>{{Lang::get('feeds.advertising')}}</h4>
                                        <div class="controls form-group">
                                            {{ Form::checkbox('statusAdvertising', 0, false,['class'=>'iCheck']) }}
                                        </div>
                                        {{$errors->first('statusAdvertising', '<span class="error">:message</span>')}}    
                                    </div>
                                </div>
                            </section> 
                                    
                        </div>
                        <div class="col-md-4">
                            <section class="widget">
                                <div class="body">
                                    <h4 >
                                        {{Lang::get('feeds.program_name')}}:
                                    </h4>
                                    <h4>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Form::label('nameProgram', $nameProgram)}}
                                    </h4>
                                    <h4>
                                        {{"Fecha de Activacion"}}:
                                    </h4>
                                    <h4>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Form::label('inactive_date', $active_date)}}
                                    </h4>
                                    <h4>
                                        {{Lang::get('feeds.date_of')}}:
                                    </h4>
                                    <h4>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Form::label('inactive_date', $inactive_date)}}
                                    </h4>
                                    <h4>
                                        {{Lang::get('feeds.advertising')." :" }}
                                    </h4>
                                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{($programUrl->statusAdvertising == 0)?Lang::get('feeds.disabled'):Lang::get('feeds.enabled')}}</h4>
                                </div>
                            </section>         
                        </div>
                    </fieldset>
                    <div class="body text-align-center">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-3">
                                    {{ Form::submit(Lang::get('formAccount.save1'), array('class' => 'btn btn-sm btn-primary','id' => 'btnValidate')) }}                                     
                                </div>
                                <div class="col-xs-4"> 

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='valSitePerm'></div>
                </div>
            </section>
        </div>
        <div class="col-md-2">
            <section class="widget">
                <h4><i class="fa fa-clock-o"></i>{{Lang::get('feeds.start_date')}}</h4>
                <div class="body">
                    <div class="form-group">
                        {{ Form::input('time', 'startTime', null, ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'startTime']); }}
                        <div id="error2" ></div>
                    </div>

                    {{$errors->first('startTime', '<span class="error">:message</span>')}}


                    <h4><i class="fa fa-clock-o"></i>{{Lang::get('feeds.ending_date')}}</h4>
                    <div class="form-group">
                        {{ Form::input('time', 'endTime', null, ['class' => 'form-control', 'placeholder' => 'Date' ,'id' => 'endTime']); }}
                        <div id="error3" ></div>
                    </div>{{$errors->first('endTime', '<span class="error">:message</span>')}}

                </div>
            </section>         
        </div>
        <div class="col-md-2">
            <section class="widget">
                <div class="body">
                    <div class="control-group checkboxAlign">
                        {{Lang::get('feeds.broadcast')}}
                        <label class="checkbox">
                            {{ Form::checkbox('Monday', 0, false) }}
                            {{Lang::get('feeds.monday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Tuesday', 0, false) }}
                            {{Lang::get('feeds.tuesday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Wednesday', 0, false) }}
                            {{Lang::get('feeds.wednesday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Thursday', 0, false) }}
                            {{Lang::get('feeds.thursday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Friday', 0, false) }}
                            {{Lang::get('feeds.friday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Saturday', 0, false) }}
                            {{Lang::get('feeds.saturday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Sunday', 0, false) }}
                            {{Lang::get('feeds.sunday')}}
                        </label>
                    </div>

                </div>
            </section>         
        </div>
    </div>
</div>
{{ Form::close() }}
</section>
</div>


@endif
@endif
@stop
@section('scripts')
@parent
{{ HTML::script('light-blue/lib/jquery-pjax/jquery.pjax.js') }}
{{ HTML::script('light-blue/lib/icheck.js/jquery.icheck.js') }}
{{ HTML::script('light-blue/lib/jquery.autogrow-textarea.js') }}
{{ HTML::script('light-blue/lib/bootstrap/tooltip.js') }}
{{ HTML::script('light-blue/lib/bootstrap-datepicker.js') }}
{{ HTML::script('light-blue/lib/bootstrap-colorpicker.js') }}
{{ HTML::script('light-blue/lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}
{{ HTML::script('light-blue/lib/icheck.js/jquery.icheck.js') }}
{{ HTML::script('js/formAccountNewUpd.js') }} 
{{ HTML::script('js/programsUrl.js') }} 
{{ HTML::style('css/adminFeeds.css')}} 
{{ HTML::style('css/cssFiel.css')}} 
{{ HTML::script('light-blue/js/forms-elemets.js') }}   
{{ HTML::script('js/fielback.js') }}
{{ HTML::script('light-blue/lib/icheck.js/jquery.icheck.js') }}

<script>
    /* DATAPICKER RANGE*/
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('#dpd1').datepicker({
  onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
  }
  checkin.hide();
  $('#dpd2')[0].focus();
}).data('datepicker');
var checkout = $('#dpd2').datepicker({
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');
/*------------*/
</script>

    

@stop