@extends('vcms.main')

@section('content')
{{App::setLocale(Session::get('locale'))}}
@if (Sentry::check())

@if ($user = Sentry::getUser())
<div class="single-widget-container error-page">
    <section class="widget transparent widget-404">
        <div class="body">
            <div class="row">
                <div class="col-md-5" id="title">
                    <div class="text-align-center">{{Lang::get('vcms.welcome')}}</div>
                </div>
            </div>
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
@endif
@endif
@stop