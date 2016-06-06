@extends('vcms.main')
@section('content')

    <div class="single-widget-container">
        <section class="widget login-widget">
            <header class="text-align-center">
                <h4>{{Lang::get('login.new_password')}}</h4>
            </header>
            <span class="error">{{ $errors->first('msg') }}</span>
            <div class="body">

               {{Form::open(array('method' => 'POST', 'url' => 'emailPass/changepass/'.$idUser, 'class' => 'no-margin'))}}
              <!-- {{ Form::hidden('idUser', $idUser) }}-->
                <fieldset>
                <div class="form-group">
                    <label>{{Lang::get('login.password')}}</label>
                    <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                    {{Form::password('password', array('class' => 'form-control input-lg', 'placeholder'=> Lang::get('login.password_placeholder')))}}
                    </div>
                    <span class="error" style='color:red;padding-left: 4em;font-weight: bold'>
                        {{ $errors->first('password') }}
                    </span>
                </div>

                <div class="form-group">
                    <label>{{Lang::get('login.repeat_password')}}</label>
                    <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                    {{Form::password('password_repeat', array('class' => 'form-control input-lg', 'placeholder'=> Lang::get('login.password_placeholder')))}}
                    </div>
                    <span class="error" style='color:red;padding-left: 4em;font-weight: bold'>
                            {{ $errors->first('password_repeat') }}
                    </span>
                </div>
                </fieldset>
                <div class="form-actions">
                        <button type="submit" class="btn btn-block btn-lg btn-danger">
                            <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                            <small>{{Lang::get('login.send')}}</small>
                        </button>
                        <div class="forgot">
                        </div>
                </div>
                {{Form::close()}}
            </div>
        </section>
    </div>
    
@stop