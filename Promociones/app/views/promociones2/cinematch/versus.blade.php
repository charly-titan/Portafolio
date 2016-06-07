@extends(Config::get( 'app.main_template' ).'.'.$vista.'.main')

@section('css')

    {{ HTML::style('/cinematch/css/c5-versus-fonts.css') }}
    @if (!isset($promo_info))
        @if(count($questionAll->optionsQuestion)==2)
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/cinematch/css/vs2.css') }}
        @else
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/cinematch/css/vs-n.css') }}
        @endif
    @else
        @if (Session::get('user.identifier')!="")
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/cinematch/css/resultado.css') }}
        @else
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/cinematch/css/marcador.css') }}
        @endif
        
    @endif
    

@stop

@section('content')

<style type="text/css">
    .c5-vsx .wrapper-container .container .versus {
        background-image: url({{isset($info->properties['UrlImgStage'])?$info->properties['UrlImgStage']:'';}});
    }
    .c5-resultado .wrapper-container .container .poster {
    @if (isset($movieSelected))
        @if(count($questionAll->optionsQuestion)==2)  
            @foreach ($questionAll->optionsQuestion as $key => $value)
                @if($value['id'] == $movieSelected)
                    @if($value['pos'])
                        background-image: url({{isset($info->properties['UrlImg1Versus'])?$info->properties['UrlImg2Versus']:'';}});                   
                    @else
                        background-image: url({{isset($info->properties['UrlImg2Versus'])?$info->properties['UrlImg1Versus']:'';}});
                    @endif               
                @endif
            @endforeach
        @else
            background-image: url({{isset($info->properties['UrlImgStage'])?$info->properties['UrlImgStage']:'';}});
        @endif
    @endif
    }

    .c5-vs .wrapper-container .container .versus .img1{
        background-image: url({{isset($info->properties['UrlImg1Versus'])?$info->properties['UrlImg1Versus']:'';}});   
    }

    .c5-vs .wrapper-container .container .versus .img2{
        background-image: url({{isset($info->properties['UrlImg2Versus'])?$info->properties['UrlImg2Versus']:'';}});   
    }
    .c5-marcador .wrapper-container .container .poster{
        background-image: url({{isset($info->properties['UrlImgStage'])?$info->properties['UrlImgStage']:'';}});
    }
</style>

@if (!isset($promo_info))

    <div class="versus">
    
        @if(count($questionAll->optionsQuestion)==2)   
            <span class="vs">VS</span><?php $i=1; ?>
            @foreach ($questionAll->optionsQuestion as $key => $value)
                @if ($i==1)
                <figure class="poster img1"><?php $i++; ?>
                @else
                <figure class="poster img2">
                @endif    
                    <div class="poster-imagen">
                        <div class="imagen">
                            <a href="{{'/'.$vista.'/'.$info->short_name.'/gracias/'.$value['id']}}">
                                <img src="{{$value['img']}}" alt="poster"/>
                                <div class="votar">
                                    <span class="votar-text">VOTA</span>
                                </div>
                                <div class="img-title">{{$value['text']}}</div>
                            </a>
                        </div>
                    </div>
                </figure>
            @endforeach
        @else
            @foreach ($questionAll->optionsQuestion as $key => $value)
                <figure class="poster img2">
                    <div class="poster-imagen">
                        <div class="imagen">
                            <a href="{{'/'.$vista.'/'.$info->short_name.'/gracias/'.$value['id']}}">
                                <img src="{{$value['img']}}" alt="poster"/>
                                    <div class="votar">
                                        <span class="votar-text">VOTA</span>
                                    </div>
                                <div class="img-title">{{$value['text']}}</div>
                            </a>
                        </div>
                    </div>
                </figure>
            @endforeach
        @endif
        
    
    </div>
@else

    <div class="poster img1">
        <div>
            <h2 class="votacion">T&Uacute; VOTASTE POR:</h2>
            @foreach ($questionAll->optionsQuestion as $key => $value)
                @if($value['id'] == $movieSelected)
                <div class="poster-imagen">
                    <div class="imagen">
                        <a href="#">
                            <img class="opaco" src="{{$value['img']}}" alt="poster"/>      
                        </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="vs-sec-container">
        <div class="vs-sec">
            <h2 class="ranking">Ranking de la votación:</h2>
            <div class="vs-container">
                {{$i=0;}}
                @foreach ($questionAll->optionsQuestion as $key => $value)
                    @if($value['id'] == $movieSelected)
                <figure class="vs-sec-imagen selected">
                    @else
                <figure class="vs-sec-imagen">
                    @endif
                    <div>
                        <img src="{{$value['img']}}" alt="x-men"/>
                        <div class="lugar">
                            <span>{{++$i}}</span>
                        </div>
                        <div class="margin"></div>
                    </div>
                </figure>
                @endforeach
            </div>
        </div>
        @if ((Session::get('user.identifier')!="")&&(Session::get('user.email')!="")&&(Session::get('user.firstname')!=""))

            <!-- BEGIN: COMPONENTE RESULTADOS -->
            <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
                <?php $pas=1;?>
                <h4>{{--Session::get('user.firstname')--}} Se te abonaron {{$contestRwd->given_points}} {{$point->name}} a tu cuenta</h4>
                <p>Tienes un total de {{$puntos_user}} {{$point->name}},  
                    @foreach ($category as $value)
                        @if (($puntos_user>=$value->range_ini) &&($puntos_user<=$value->range_fin)) 
                            eres una {{$value->name}} <?php $pas=0;?>
                        @elseif ($value->range_fin==0)
                            <?php $namecate=$value->name;?>
                        @endif
                    @endforeach
                    @if ($pas)
                        eres una {{$namecate}}
                    @endif
                </p>
                <ul class="vs-sec-palomitas ">
                    @foreach ($category as $value)
                        <li>
                            <div class="tipo">#{{$value->name}}</div>
                            <div class="palomita"><img src="{{$value->img}}" alt="" height="45" width="59"></div>
                            <div class="cantidad">{{$value->range_ini}} - {{($value->range_fin)?$value->range_fin:'&#x221e'}}</div>
                        </li>
                    @endforeach
                </ul>
                <!-- <p class="comparte ">Comparte &eacute;sta votaci&oacute;n para sumar {{$contestRwd->share_points}} {{$point->name}} adicionles </p>
                <ul class="redes">
                    <li class="twitter">
                        <a href="" title="Twitter" onclick="comm_share.shareTW('https://promociones.televisa.com.mx/{{$vista}}/{{$info->short_name}}','Un comentario', 'comm_share.callback()');">
                        <a href="http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}" onclick="comm_share.shareTW(this.href,'{{(isset($info->properties['namePromotion']))?$info->properties['namePromotion']:''}}','comm_share.callback()');return false;" class="cintillo_t">    
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="" title="Facebook" onclick="comm_share.shareFB('https://promociones.televisa.com.mx/{{$vista}}/{{$info->short_name}}','comm_share.callback()');">
                        <a href="" onclick="comm_share.shareFB('http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}','comm_share.callback()');return false;" class="cintillo_t"> 
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <li class="google">
                        <a href="" title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li>
                </ul> -->
            </div>
            <!-- END: COMPONENTE RESULTADOS -->
            <!-- BEGIN: COMPONENTE RESULTADOS -->
            <div class="vs-sec-ganaste hidden-desktop">
                <h4>{{--Session::get('user.firstname')--}} Se te abonaron {{$contestRwd->given_points}} {{$point->name}} a tu cuenta</h4>
                <p>Tienes un total de {{$puntos_user}} {{$point->name}}, 
                    @foreach ($category as $value)
                        @if (($puntos_user>=$value->range_ini) &&($puntos_user<=$value->range_fin)) 
                             eres una {{$value->name}}
                        @endif
                    @endforeach
                </p>
                <ul class="vs-sec-palomitas ">
                    @foreach ($category as $value)
                        <li>
                            <div class="tipo">#{{$value->name}}</div>
                            <div class="palomita"><img src="{{$value->img}}" alt="" height="45" width="45"></div>
                            <div class="cantidad">{{$value->range_ini}} - {{$value->range_fin}}</div>
                        </li>
                    @endforeach
                </ul>
                <!-- <p class="comparte ">Comparte &eacute;sta votaci&oacute;n para sumar {{$contestRwd->share_points}} {{$point->name}} adicionles </p>
                <ul class="redes">
                    <li class="twitter">
                        <a href="http://i2.esmas.com/2015/04/17/761204/night-1-1920x1080.jpg" title="Twitter">
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="" onclick="comm_share.shareFB('https://promociones.televisa.com.mx/versus/{{$info->short_name}}','comm_share.callback()');" title="Facebook">
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <li class="google">
                        <a href="" title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li>
                </ul> -->
            </div>
            <!-- END: COMPONENTE RESULTADOS -->

            {{Session::forget('user')}}


        @else
            <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
                <p><b>Ganaste {{$contestRwd->given_points}} {{$point->name}}</b></p>
                <p>para que se agreguen a tu cuenta inicia sesi&oacute;n</p>
                <ul class="redes" style="display:block">
                    <li class="twitter">
                        <a href="/social/Twitter">
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="/social/Facebook" title="Facebook">
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <li class="google">
                        <a href="/social/Google" title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="vs-sec-ganaste hidden-desktop">
                <p><b>Ganaste {{$contestRwd->given_points}} {{$point->name}}</b></p>
                <p>para que se agreguen a tu cuenta inicia sesi&oacute;n</p>
                <ul class="redes" style="display:block">
                    <li class="twitter">
                        <a href="/social/Twitter">
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="/social/Facebook" title="Facebook">
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <li class="google">
                        <a href="/social/Google"  title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>

            
        @endif
    </div>
    @if((Session::has('user.activated'))&&(Session::get('user.activated')=="true")&&(Session::get('user.email')=="")&&(Session::get('user.firstname')==""))
        <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4><b>Confirma tus datos</b></h4>
                </div>
                <div class="modal-body">
                  <form role="form" action="/{{$vista}}/{{$info->short_name}}/confirma" method="post">
                    <div class="form-group">
                      <h4>{{Lang::get('promociones.formName')}}</h4>
                      <input type="text" class="form-control" name="usrname" placeholder="{{Lang::get('promociones.formName')}}" data-null="{{Lang::get('promociones.formNameMsgNull')}}" required>
                      {{ $errors->first('usrname', '<div class="error">:message</div>') }}
                    </div>
                    <div class="form-group">
                      <h4>{{Lang::get('promociones.formLastname')}}</h4>
                      <input type="text" class="form-control" name="lastname" placeholder="{{Lang::get('promociones.formLastname')}}" data-null="{{Lang::get('promociones.formLastname')}}" required>
                      {{ $errors->first('lastname', '<div class="error">:message</div>') }}
                    </div>
                    <div class="form-group">
                      <h4>{{Lang::get('promociones.formEmail')}}</h4>
                      <input type="email" class="form-control" name="email" placeholder="{{Lang::get('promociones.formEmail')}}" data-null="{{Lang::get('promociones.invalidEmail')}}" required>
                      {{ $errors->first('email', '<div class="error">:message</div>') }}
                    </div>
                    <div class="form-group">
                        <h4>{{Lang::get('promociones.formGender')}}
                        <div class="radio">
                            {{Form::radio('genero','male',true,array('data-requiere'=>'true','data-format'=>'masculino','data-null'=>Lang::get('promociones.formGenderMsgNull'),'id'=>'masculino'))}}
                            <span>{{Lang::get('promociones.formGenderM')}}</span>
                            {{Form::radio('genero','female',false,array('data-requiere'=>'true','data-format'=>'femenino','data-null'=>Lang::get('promociones.formGenderMsgNull')))}}
                            <span>{{Lang::get('promociones.formGenderF')}}</span>
                        </div>
                        {{ $errors->first('genero', '<div class="error">:message</div>') }}
                    </div>
                     <button type="submit" class="btn btn-success btn-block" style="background-color: #f94949;">Confirmar</button>
                  </form>
                </div>
              </div>
            </div>
          </div> 
        @endif

@endif
   	
@stop

@section('scripts')
    @parent

    {{ HTML::script('/versus/js/jquery-2.1.1.min.js') }}
    {{-- HTML::script('/versus/js/head.load.min.js') --}}
    {{-- HTML::script('/versus/js/finalpage-libs.js',array('id'=>'libs')) --}}
    {{ HTML::script('/js/promociones/bootstrap.js') }}

    {{ HTML::style('/css/twmodal.css') }}

    <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>

    {{ HTML::script('/cinematch/js/main.js') }}

    <script>
        @if (!isset($promo_info))
                @if(count($questionAll->optionsQuestion)==2)
                    $('body').removeClass();
                    $('body').addClass('c5-vs');
                @else
                    $('body').removeClass();
                    $('body').addClass('c5-vsx');
                @endif
        @else
                @if (Session::get('user.identifier')!="")
                    $('body').removeClass();
                    $('body').addClass('c5-marcador');
                @else
                    $('body').removeClass();
                    $('body').addClass('c5-resultado');
                @endif
            
        @endif 

        $(document).ready(function() {
            @if(Session::has('user.activated'))
                $('#myModal').modal('show');
            @else
                $('#myModal').modal('hide'); 
            @endif

        });

    </script>


@stop
    
    