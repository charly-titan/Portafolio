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
        <div class="col-md-12">
            <section class="widget">
                <header>
                    <h4>  </h4>
                </header>
                <div  class="body">
                    <div class="body text-align-center">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php
                                    echo $exito;
                                    ?> 
                                </div>
                                <div class="col-xs-4"> 

                                    @if (Session::has('registration_success'))
                                    <div class="alert alert-success" id="exito">
                                        {{ Session::get('registration_success') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-xs-4"> 

                                    @if (Session::has('alert_warning'))
                                    <div class="alert alert-warning" id="exito">
                                        {{ Session::get('alert_warning') }}
                                    </div>
                                    @endif

                                    @if (Session::has('info_succes'))
                                    <div class="alert alert-success" id="exito">
                                        {{ Session::get('info_succes') }}
                                    </div>
                                    @endif

                                    @if (Session::has('transmitted'))
                                    <div class="alert alert-danger" id="exito">
                                        {{ Session::get('transmitted') }}
                                    </div>
                                    @endif
                                    @if (Session::has('program'))
                                    <div class="alert alert-danger" id="exito">
                                        {{ Session::get('program') }}
                                    </div>
                                    @endif
                                    @if (Session::has('show'))
                                    <div class="alert alert-danger" id="exito">
                                        {{ Session::get('show') }}
                                    </div>
                                    @endif

                                </div>
                                <div class="col-xs-2"> 
                                    <a href="{{ URL::to('programUrl/')}}" class='btn btn-sm btn-warning ' ><p class="glyphicon  glyphicon-plus-sign"></p>

                                        {{Lang::get('feeds.generate_new')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type='hidden' id='formUserPermission' value='formUserPermission'>
                    <fieldset>
                        <legend class="section">{{Lang::get('feeds.results')}}</legend>
                        <div class="body">
                            <table  class="table table-striped table-editable no-margin" id='tablePermissions'>
                                <thead>
                                    <tr>
                                        <th >{{Lang::get('feeds.program_name')}}</th>
                                        <th >{{Lang::get('feeds.start_date')}}</th>
                                        <th>{{Lang::get('feeds.ending_date')}}</th>
                                        <th >{{Lang::get('feeds.site_url')}}</th>
                                        <th>{{Lang::get('feeds.status')}}</th>
                                        <th>{{Lang::get('feeds.advertising')}}</th>
                                        <th>{{Lang::get('feeds.days')}}</th>
                                        <th >{{Lang::get('feeds.update')}}</th>
                                    </tr>
                                </thead>
                                <tbody  class="table table-striped table-editable no-margin" id='datosTable'>
                                    @foreach($queryResult as $resp )
                                    <tr>
                                        <td>
                                            {{ $resp->nameFeed }}
                                        </td>
                                        <td>
                                            <p style="display:none" >{{ $startTime =$resp->startTime }}</p>

                                            <?php
                                            echo date('h:i:s a ', strtotime($startTime));
                                            ?>
                                        </td>
                                        <td>
                                            <p style="display:none" >  {{ $endTime=$resp->endTime }}</p>
                                            <?php
                                            echo date('h:i:s a ', strtotime($endTime));
                                            ?>
                                        </td>

                                        <td>{{ $resp->url }}</td>
                                        <td><p style="display:none" >{{ $statu =$resp->status }} </p>
                                            <?php
                                            if ($statu == 1) {
                                                echo '<i class="eicon-check" style="margin-left: 36%;"></i>';
                                            }else{
                                                echo '<i class="eicon-cancel" style="margin-left: 36%;"></i>';
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            @if($resp->statusAdvertising == 1)
                                                <i class="eicon-check" style="margin-left: 36%;"></i>
                                            @else
                                                <i class="eicon-cancel" style="margin-left: 36%;"></i>
                                            @endif
                                        </td>
                                        <td> <p style="display:none" > 
                                                {{ $Monday = $resp->Monday}},
                                                {{ $Tuesday = $resp->Tuesday}},
                                                {{ $Wednesday = $resp->Wednesday}},
                                                {{ $Thursday = $resp->Thursday}},
                                                {{ $Friday = $resp->Friday}},
                                                {{ $Saturday = $resp->Saturday}},
                                                {{$Sunday = $resp->Sunday}}
                                            </p>
                                            <?php
                                            if ($Monday == 1) {
                                                echo 'L ';
                                            }
                                            if ($Tuesday == 1) {
                                                echo 'M ';
                                            }
                                            if ($Wednesday == 1) {
                                                echo 'M ';
                                            }
                                            if ($Thursday == 1) {
                                                echo 'J ';
                                            }
                                            if ($Friday == 1) {
                                                echo 'V ';
                                            }
                                            if ($Saturday == 1) {
                                                echo 'S ';
                                            }
                                            if ($Sunday == 1) {
                                                echo 'D ';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            {{ HTML::link('controller/editprofile/'. $resp->id_url,'',array('class' => 'btn btn-warning glyphicon glyphicon-edit')) }}
                                      
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        </div>
                    </fieldset>
                    <div id='valSitePerm'></div>
                </div>
            </section>
        </div>
    </div>
</div>

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


@endif
@endif
@stop

@section('scripts')
@parent



{{ HTML::style('css/formAccount.css')}}
{{ HTML::style('css/jquery.dataTables.css')}}   
{{ HTML::script('js/userPermissions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}

@stop