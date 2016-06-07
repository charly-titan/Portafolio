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

@section('titulo')
    <!-- BEGIN: TITULO -->
        <div class="iu-texto">
            <div class="terminos-condiciones">
                <h2 class="title">{{isset($info->properties['titleClosure'])?$info->properties['titleClosure']:''}}</h2>
                <h4 class="resumen_login">{{isset($contentText->textClosure)?$contentText->textClosure:''}}</h4>
            </div>
        </div>
    <!-- END: TITULO -->
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
            <h2 class="votacion">PEL&Iacute;CULA GANADORA:</h2>
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
        
    </div>
   	
@stop

@section('scripts')
    @parent

    {{ HTML::script('/versus/js/jquery-2.1.1.min.js') }}
    {{ HTML::script('/js/promociones/bootstrap.js') }}

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
    