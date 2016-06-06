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
        <div class="col-md-8">
            <section class="widget">
                <header>
                    <h4>
                        <i class="fa  fa-desktop"></i>
                        {{Lang::get('feeds.generate_new')}}                 
                    </h4>
                </header>
                <div  class="body">
                    <input type='hidden' id='formUserPermission' value='formUserPermission'>
                    <div class="body text-align-center">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-6">
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
                                    {{Form::open(array('method' => 'GET','url' => 'resgitroUrls','class'=>'form-horizontal label-left','id'=>'myForm'))}}

                                    {{ Form::submit(Lang::get('feeds.previous'), array('class' => 'btn btn-success ')) }}
                                    {{ Form::close() }} 
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::open(array('method' => 'POST','url' => 'storeUrl','class'=>'validar_form','id'=>'myForm','data-parsley-priority-enabled'=>'false','onsubmit'=>'return validar(this)'))}}
                    <fieldset>
                        <div class="col-md-12">
                            <section class="widget">
                                <div class="form-group" >
                                    <h4>{{Lang::get('feeds.add_url')}}</h4>
                                    <div class="controls form-group">
                                        <div class="input-group col-sm-12">
                                            {{ Form::select('id', $combobox,  $selected,['class' => 'chzn-select select-block-level','name' => 'opciones']    ) }}
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has())
                                <ul class="parsley-errors-list filled" >
                                    @if ($errors->has('opciones'))
                                    <h4 style="color: #eac85e" id="exito">{{ $errors->first('opciones') }}
                                    </h4>
                                    @endif
                                </ul>
                                @endif
                                <div class="body">
                                    <div class="form-group" >
                                        <h4>{{Lang::get('feeds.site_url')}}</h4>
                                        <div class="controls form-group">
                                            <div class="input-group col-sm-12">
                                                {{ Form::text('url', Input::old('url'), ['id' => 'url','class' => 'form-control', 'placeholder' => 'www.televisa.com']); }} 
                                                <div id="error" id="exito"></div>
                                            </div>

                                        </div>
                                    </div>
                                    @if($errors->has())
                                    <ul class="parsley-errors-list filled" >
                                        @if ($errors->has('url'))
                                        <div class="alert alert-info" id="exito">{{ $errors->first('url') }}
                                        </div>
                                        @endif
                                    </ul>
                                    @endif
                                    <div class="form-group" >
                                        <h4>{{Lang::get('feeds.off_in')}}</h4>
                                        <div class="controls form-group">
                                            <div class="input-group col-sm-12">
                                                {{ Form::input('date', 'inactive_date', null, ['class' => 'form-control', 'placeholder' => 'Date']); }} 
                                            </div>
                                        </div>
                                    </div>
                                    @if($errors->has())
                                    <ul class="parsley-errors-list filled">
                                        @if ($errors->has('inactive_date'))
                                        <il class="parsley-required">
                                            <h4 style="color: #eac85e">{{ $errors->first('inactive_date') }}
                                            </h4>
                                        </il>
                                        @endif
                                    </ul>
                                    @endif
                                    <div class="form-group">
                                        <h4>{{Lang::get('feeds.status')}}</h4>
                                        {{ Form::checkbox('status', 0, true,['class' => 'iCheck']) }}
                                    </div>
                                    @if($errors->has())
                                    <ul class="parsley-errors-list filled">
                                        @if ($errors->has('status'))
                                        <il class="parsley-required">
                                            <h4 style="color: #eac85e">{{ $errors->first('status') }}</h4>
                                        </il>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </section>         
                        </div>
                    </fieldset>
                    <div class="body text-align-center">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-4">
                                    {{Form::reset(Lang::get('formAccount.clear'),array('class'=>'btn btn-sm btn-info')) }}                                     
                                </div>
                                <div class="col-xs-4"> 
                                    {{ Form::submit(Lang::get('formAccount.save'), array('class' => 'btn btn-sm btn-primary '
                                                  ,'id' => 'btnValidate')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='valSitePerm'></div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="widget">
                <header>
                    <h4><i class="fa fa-clock-o"></i>{{Lang::get('feeds.start_date')}}</h4>
                    <div class="body">
                        <div class="form-group">
                            <div class="controls form-group">
                                <div class="input-group col-sm-12">
                                    {{ Form::input('time', 'startTime', null, ['class' => 'form-control', 'placeholder' => 'Date']); }}
                                </div>
                            </div>
                        </div>
                        @if($errors->has())
                        <ul class="parsley-errors-list filled">
                            @if ($errors->has('startTime'))
                            <il class="parsley-required">
                                <h4 style="color: #eac85e">  {{ $errors->first('startTime') }}</h4>
                            </il>
                            @endif
                        </ul>
                        @endif
                        <h4><i class="fa fa-clock-o"></i>{{Lang::get('feeds.ending_date')}}</h4>
                        <div class="form-group">
                            <div class="controls form-group">
                                <div class="input-group col-sm-12">
                                    {{ Form::input('time', 'endTime', null, ['class' => 'form-control', 'placeholder' => 'Date']); }}
                                </div>
                            </div>
                        </div>
                        @if($errors->has())
                        <ul class="parsley-errors-list filled">
                            @if ($errors->has('endTime'))
                            <il class="parsley-required" >
                                <h4 style="color: #eac85e">{{ $errors->first('startTime') }}</h4>
                            </il>
                            @endif
                        </ul>
                        @endif
                    </div>
            </section>         
        </div>
        <div class="col-md-4">
            <section class="widget">
                <div class="body">
                    <div class="control-group checkboxAlign">
                        <h4>{{Lang::get('feeds.broadcast')}}:</h4>
                        <label class="checkbox">
                            {{ Form::checkbox('Monday',  0,false  ) }}
                            {{Lang::get('feeds.monday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Tuesday', 0, false) }}
                            {{Lang::get('feeds.tuesday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Wednesday', 0, false ) }}
                            {{Lang::get('feeds.wednesday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Thursday', 0, false ) }}
                            {{Lang::get('feeds.thursday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Friday', 0, false ) }}
                            {{Lang::get('feeds.friday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Saturday', 0, false ) }}
                            {{Lang::get('feeds.saturday')}}
                        </label>
                        <label class="checkbox">
                            {{ Form::checkbox('Sunday', 0, false ) }}
                            {{Lang::get('feeds.sunday')}}
                        </label>
                    </div>

                </div>
            </section>         
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="single-widget-container error-page">
    <section class="widget transparent widget-404">

        @if (!($user->hasAnyAccess(array('video.create','users.create','roles.create'))))
        <div class="col-md-12">
            <div class="description">
                <p>Por el momento no cuenta con permisos para ver el contenido de este sitio, ya fue enviado un correo al administrador para su autorización, en breve tendrá una respuesta.</p>
            </div>
        </div>
        @endif
</div>
</section>
</div>
<!--<script type="text/javascript">

    function ValidaURL(url) {
        var regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
        return regex.test(url);

    }
    function validar(f) {
        if (!ValidaURL(f.url.value)) {
            $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-down color-red'></i> Please enter valid URL  </div>");
            f.url.focus();
            return (false);
        }
        else {
            $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-up color-blue'></i>Valid URL </div>");
        }


    }

</script>-->


<!--<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $("#exito").fadeOut(1500);
        }, 2000);
    });
</script>-->


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
{{ HTML::script('js/formAccountNewUpd.js') }} 
{{ HTML::script('js/programsUrl.js') }} 

{{ HTML::script('light-blue/js/forms-elemets.js') }}   
{{ HTML::style('css/adminFeeds.css')}} 
{{ HTML::style('css/cssFiel.css')}} 
{{ HTML::script('js/fielback.js') }}   
@stop