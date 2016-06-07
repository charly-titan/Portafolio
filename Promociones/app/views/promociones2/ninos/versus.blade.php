@extends(Config::get( 'app.main_template' ).'.ninos.main')


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
                            <a href="{{'/ninos/'.$info->short_name.'/gracias/'.$value['id']}}">
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
                            <a href="{{'/ninos/'.$info->short_name.'/gracias/'.$value['id']}}">
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
            <h2 class="votacion">TU VOTASTE POR:</h2>
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
                <h4>{{Session::get('user.firstname')}} se te abonaron {{$contestRwd->given_points}} {{$point->name}} a tu cuenta</h4>
                <p>Tienes un total de {{$puntos_user}} {{$point->name}},  
                    @foreach ($category as $value)
                        @if (($puntos_user>=$value->range_ini) &&($puntos_user<=$value->range_fin)) 
                            eres un@ {{$value->name}}
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
                <p class="comparte ">Comparte &eacute;sta votaci&oacute;n para sumar {{$contestRwd->share_points}} {{$point->name}} adicionles </p>
                <ul class="redes">
                    <li class="twitter">
                        <a href="" title="Twitter" onclick="comm_share.shareTW('https://promociones.televisa.com.mx/ninos/{{$info->short_name}}','Un comentario', 'comm_share.callback()');">
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="" title="Facebook" onclick="comm_share.shareFB('https://promociones.televisa.com.mx/ninos/actividad/{{$info->short_name}}','comm_share.callback()');">
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <!--li class="google">
                        <a href="" title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li-->
                </ul>
            </div>
            <!-- END: COMPONENTE RESULTADOS -->
            <!-- BEGIN: COMPONENTE RESULTADOS -->
            <div class="vs-sec-ganaste hidden-desktop">
                <h4>{{Session::get('user.firstname')}} se te abonaron {{$contestRwd->given_points}} {{$point->name}} a tu cuenta</h4>
                <p>Tienes un total de {{$puntos_user}} {{$point->name}}, 
                    @foreach ($category as $value)
                        @if (($puntos_user>=$value->range_ini) &&($puntos_user<=$value->range_fin)) 
                             eres una Lichita {{$value->name}}
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
                <p class="comparte ">Comparte &eacute;sta votaci&oacute;n para sumar {{$contestRwd->share_points}} {{$point->name}} adicionles </p>
                <ul class="redes">
                    <li class="twitter">
                        <a href="http://i2.esmas.com/2015/04/17/761204/night-1-1920x1080.jpg" title="Twitter">
                            <i class="c5-twitter"></i>
                        </a>
                    </li>
                    <li class="facebook">
                        <a href="" onclick="comm_share.shareFB('https://promociones.televisa.com.mx/ninos/{{$info->short_name}}','comm_share.callback()');" title="Facebook">
                            <i class="c5-facebook"></i>
                        </a>
                    </li>
                    <!--li class="google">
                        <a href="" title="google">
                            <i class="c5-plus"></i>
                        </a>
                    </li-->
                </ul>
            </div>
            <!-- END: COMPONENTE RESULTADOS -->

            {{Session::forget('user')}}


        @else
            <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
                <p><b>¡Buena elecci&oacute;n!</b></p>
                <p>{{isset($contentText->textThanks)?$contentText->textThanks:''}}</p>
            </div>
            <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
                <ul style="display: -webkit-inline-box;">
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt1']))?$info->properties['UrlNinosOpt1']:''}}">
                            <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt1']))?$info->properties['TxtNinosOpt1']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt1']))?$info->properties['ThumbNinosOpt1']:''}}">
                        </a>
                    </li>
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt2']))?$info->properties['UrlNinosOpt2']:''}}">
                           <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt2']))?$info->properties['TxtNinosOpt2']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt2']))?$info->properties['ThumbNinosOpt2']:''}}">
                        </a>
                    </li>
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt3']))?$info->properties['UrlNinosOpt3']:''}}">
                           <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt3']))?$info->properties['TxtNinosOpt3']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt3']))?$info->properties['ThumbNinosOpt3']:''}}">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="vs-sec-ganaste hidden-desktop">
                <p><b>¡Buena elecci&oacute;n!</b></p>
                <p>{{isset($contentText->textThanks)?$contentText->textThanks:''}}</p>
            </div>
            <div class="vs-sec-ganaste hidden-desktop">
                <ul style="display: -webkit-inline-box;">
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt1']))?$info->properties['UrlNinosOpt1']:''}}">
                            <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt1']))?$info->properties['TxtNinosOpt1']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt1']))?$info->properties['ThumbNinosOpt1']:''}}">
                        </a>
                    </li>
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt2']))?$info->properties['UrlNinosOpt2']:''}}">
                           <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt2']))?$info->properties['TxtNinosOpt2']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt2']))?$info->properties['ThumbNinosOpt2']:''}}">
                        </a>
                    </li>
                    <li style="padding-right: 10px;">
                        <a href="{{(isset($info->properties['UrlNinosOpt3']))?$info->properties['UrlNinosOpt3']:''}}">
                           <p style="font-size: 16px; color:#fff;">{{(isset($info->properties['TxtNinosOpt3']))?$info->properties['TxtNinosOpt3']:''}}</p>
                            <img src="{{(isset($info->properties['ThumbNinosOpt3']))?$info->properties['ThumbNinosOpt3']:''}}">
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
                  <form role="form" action="/ninos/{{$info->short_name}}/confirma" method="post">
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
                     <button type="submit" class="btn btn-success btn-block">Confirmar</button>
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

    var comm_share = {

        global:{
            

            _popup:"",
            callback:"",
            comment:"",
            url:""
        },

        loadJS  :   function(url, charset){
            var sc  =   document.createElement('script');
            sc.setAttribute('type','text/javascript');
            sc.setAttribute('src',  url);
            if('undefined' != typeof charset){
                sc.setAttribute('charset',charset);
            }
            var hd  =   document.getElementsByTagName('head')[0];
            hd.appendChild(sc);
            return true;
        },

        shareFB:function(href,callback){

            FB.ui({
                method: 'share',
                href: href,
                }, 
                function(response){
                    console.log(response);
                    try{
                        if('undefined' != typeof response.post_id){
                            eval(callback);                        
                        }
                    }catch(e){}
                   
                }
            );

        },

        shareTW:function(href,comment,callback){

            this.global.object_popup=window.open('http://comentarios.esmas.com/tw_popup2.php?url='+href+'&ran='+(Math.floor((Math.random()*100)+1)),'Registro','width=800,height=400');
            this.global.callback=callback;
            this.global.comment=comment;
            this.global.url=href;
            setTimeout("comm_share.waitpopup();",1000);
            return false;
        },

        waitpopup:function(){
            if(this.global.object_popup.closed){
                this.loadJS('http://comentarios.esmas.com/twitterResponse.php?href='+this.global.url+'&comment='+this.global.comment+'&callback='+this.global.callback);
            }else{
                setTimeout("comm_share.waitpopup();",2000);   
            }
        },

        callback:function(){
            $("#contador_valor").html("10");
            alert("Se te abonaron {{isset($contestRwd->share_points)?$contestRwd->share_points:''}} {{isset($point->name)?$point->name:''}}, tienes un total de 10");
        }

        
    }


    </script>


@stop
    
    