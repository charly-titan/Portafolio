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
     -->

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

    </script>

    
    

@stop
    
    