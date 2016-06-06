@extends('vcms.main')

@section('content')
    <div class="single-widget-container">
        <section class="widget login-widget">
            <header class="text-align-center">
                <h4>{{Lang::get('login.login_title')}}</h4>
            </header>
            <span class="error">{{ $errors->first('msg') }}</span>
            <div class="body">
                <!--form class="no-margin"
                      action="login" method="post">
                      {{Form::open(array('method' => 'POST', 'url' => 'login', 'class' => 'no-margin'))}}
                    <fieldset>
                        <div class="form-group no-margin">
                            <label for="email" >{{Lang::get('login.email')}}</label>
                            <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="eicon-user"></i>
                                    </span>
                                <input id="email" type="email" class="form-control input-lg"
                                       placeholder="{{Lang::get('login.email_placeholder')}}">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="password" >{{Lang::get('login.password')}}</label>

                            <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                <input id="password" type="password" class="form-control input-lg"
                                       placeholder="{{Lang::get('login.password_placeholder')}}">
                            </div>

                        </div>
                    </fieldset>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-block btn-lg btn-danger">
                            <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                            <small>{{Lang::get('login.sigin')}}</small>
                        </button>
                        <div class="forgot"><a class="forgot" href="#">{{Lang::get('login.forgot')}}</a></div>
                    </div>
               {{Form::close()}}-->

               {{Form::open(array('method' => 'POST', 'url' => 'login', 'class' => 'no-margin'))}}

                <fieldset>
                <div class="form-group no-margin">
                    {{Form::label(Lang::get('login.email'))}}
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            <i class="eicon-user"></i>
                        </span>
                    {{Form::text('email', '', array('class' => 'form-control input-lg', 'placeholder'=> Lang::get('login.email_placeholder'), 'required'=>'required'))}}
                </div>
                <span class="error">{{ $errors->first('login') }}</span>
                <div class="form-group">
                    {{Form::label(Lang::get('login.password'))}}
                    <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                    {{Form::password('password', array('class' => 'form-control input-lg', 'placeholder'=> Lang::get('login.password_placeholder'), 'required'=>'required'))}}
                    </div>
                    <span class="error">{{ $errors->first('password') }}</span>
                </div>
                </fieldset>
                <div class="form-actions">
                        <button type="submit" class="btn btn-block btn-lg btn-danger">
                            <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                            <small>{{Lang::get('login.sigin')}}</small>
                        </button>
                        <div class="forgot">
                            <a class="forgot" href="/emailPass">{{Lang::get('login.forgot')}}</a>    
                        </div>
                </div>
                {{Form::close()}}
            </div>
            <footer>
                <div class="facebook-login">
                    <a href="/social"><span><i class="fa fa-google-plus-square fa-lg"></i> {{Lang::get('login.google_login')}}</span></a>
                </div>
            </footer>
        </section>
    </div>
@stop
     @if(Session::has('msg')) 
          <script type="text/javascript">

              window.onload = function() {

                    var leng = $("#language-combo").select2("val");

                    if(leng == 'es'){msg = "Se te ha cambiado tu contraseña con exito"}
                    else{msg = "It has changed your password you successfully"}

                    alert(msg)
                    window.location.href = "/login";
                }
          </script>      
    @endif
    @if(Session::has('msgExpirado')) 
          <script type="text/javascript">

            window.onload = function() {

                    var leng = $("#language-combo").select2("val");

                    if(leng == 'es'){msgExpirado = "Ha expirado la url vuelve a enviar correo para cambio de contraseña"}
                    else{msgExpirado = "Expired url to resend mail for password change"}

                    alert(msgExpirado)
                    window.location.href = "/login";
            }

          </script>      
    @endif