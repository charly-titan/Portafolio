@extends(Config::get( 'app.main_template' ).'.'.$vista.'.main')

@section('css')

    {{ HTML::style('/promo/cinematch/css/c5-versus-fonts.css') }}
    @if (!isset($promo_info))
        @if(count($questionAll->optionsQuestion)==2)
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/promo/cinematch/css/vs2.css') }}
        @else
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/promo/cinematch/css/vs-n.css') }}
        @endif
    @else
        @if (Session::get('user.identifier')!="")
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/promo/cinematch/css/resultado.css') }}
        @else
            {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/promo/cinematch/css/marcador.css') }}
        @endif
        
    @endif

    <!-- <link rel="stylesheet" type="text/css" href="http://hermes.esmas.com.mx:4503/etc/designs/television/local/clientlibs/television/gigya/global/fix.gigya.min.css"/>
    <link rel="stylesheet" type="text/css" href="http://hermes.esmas.com.mx:4503/etc/designs/television/local/clientlibs/television/gigya/global/gigya.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://television.televisa.com/television/local/clientlibs/television/amql/componentes/global/global.css">  -->

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
        <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
            <b id ="login_gigya"></b>
            <div id ="login_gigya_social"></div>
            <div id ="divUserStatusGM"></div>
            <div id ="social_gigya_cards"></div>
        </div>

        <div class="vs-sec-ganaste hidden-desktop">
            <b id ="login_gigya"></b>
            <div id ="login_gigya_social"></div>
            <div id ="divUserStatusGM"></div>
            <div id ="social_gigya_cards"></div>
        </div>
        
    </div>
    
   	
@stop

@section('scripts')
    @parent

    {{ HTML::script('/versus/js/jquery-2.1.1.min.js') }}
    {{ HTML::script('/versus/js/head.load.min.js') }}
    {{ HTML::script('/versus/js/finalpage-libs.js',array('id'=>'libs')) }}
    {{ HTML::script('/js/promociones/bootstrap.js') }}

    {{ HTML::style('/css/twmodal.css') }}

    <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>

    {{ HTML::script('/versus/js/main.js') }}

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

    // $(document).ready(function() {
    //     @if(Session::has('user.activated'))
    //         $('#myModal').modal('show');
    //     @else
    //         $('#myModal').modal('hide'); 
    //     @endif

    // });

    </script>

   <!--  
    <script src="http://hermes.esmas.com.mx:4503/etc/designs/televisa/shared/clientlibs/js/gigya_global.js"></script>
    <script src="http://hermes.esmas.com.mx:4503/etc/designs/televisa/shared/clientlibs/js/dil.js"></script>
 -->
    <script>

    var social_engage_external_config ={
        callbacks       : {
            "onLoad"        : "prepareUI",
            "islogged"      : "isLogged",
            "isnewuser"     : "isNewUser"
           
        },
        modal           :   false,  
        urlCssGigya     :   '/css/pepsi-gigya.css',
        templates       : {
            usernotlogged   :   '<p><b>Ganaste {{$contestRwd->given_points}} {{$point->name}}</b></p>'+
                                '<p>para que se agreguen a tu cuenta <u id="start_session" class="btn btn-lg btn-info">Inicia Sesi&oacute;n</u></p>',
            
            userlogged      :   '<img id="show_status" src="{'+'{thumbnailURL}'+'}" width="48" height="48"/>',

            social_networks  :  '<h6>Ingrese a su cuenta</h6>'+
                                '<div id="gigya_modal" class="social-component"></div>',
            
            user_status     :   '<div id="divUserStatus" class="login-form">'+
                                    '<button id="close_session" class="close_gigya">'+
                                        '<span class="txt-gigya-md-session">Cerrar sesión</span></button>'+
                                '</div>',

            is_newuser     :  '<h6>Gracias por registrarte</h6>'+
                                '<p class="big">Bienvenido {'+'{nickname}'+'}</p>'+
                                '<p>Por registrarte tienes un bono de 100 Lichipuntos</p>'+
                                '<p class="big">Muy pronto te diremos como conseguir mas.</p>',            
                                
            modalstructure  :   '<div id="login_gigya_social" class="full-video login-ligth">'+
                                    '<div class="cont-full slideDownVideo">'+
                                        '<div id="login-close" class="cerrarv video-f login-cl"><i class="icon-close"></i></div>'+
                                        '<div id="gigya_body_modal" class="login-form">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
        }   
                                
    };

    function prepareUI(){
        //console.info("initialize UI");
        $("#login_gigya").css("visibility", "visible");
    }

    function isLogged(uuid){
        social_engage.config.usr_uid = uuid;
    }
    function isNewUser(){
        $("#login_gigya_social").clone().attr('id', 'modal_welcome').appendTo(document.body);
        $("#modal_welcome div#gigya_body_networks").attr("id", "gigya_body_welcome");
        $("#modal_welcome div#login-close").attr("id", "close_welcome");
        $("#close_welcome").click(function(){ $("#modal_welcome").remove(); })
        $("#gigya_body_welcome").html(social_engage.templates.is_newuser);
            $("#modal_welcome").css("visibility", "visible").show();

    }
</script>
<!-- <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/js/tim_big_data.js"></script>
 -->
<script type="text/javascript" src="/js/social_engage.js"></script>
<!-- <script src="https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/social_promo.js"></script> -->

@stop
    
    