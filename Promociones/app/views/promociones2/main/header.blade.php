@section('header')
    <style type="text/css">
    @if (isset($info->properties['UrlImgLogo']))
        #tui-logo{
            background-image: url({{isset($info->properties['UrlImgLogo'])?$info->properties['UrlImgLogo']:'';}});
        }
        div#tui-logo{
            height: 60px;
            width: 65px;
            background-size: auto auto !important;
            background-position: center center;
            background-repeat: no-repeat !important;
        }
    @endif
    .header-promo a, .c5-logo{text-decoration:none;}
    @foreach ($info->properties as $key => $value)
        @if($key == 'colorHeader')
            .header-promo{background-color:{{$value}};}
        @elseif($key == 'colorTitleHead' && isset($value) )
            .vertical-container a{color: {{$value}}; }
        @elseif($key == 'colorFont' && isset($value) )
            h2.title{color: {{$value}}; }
            h2.pregunta-titulo{color: {{$value}}; }
            div.title-foto span{color: {{$value}}; }
        @elseif($key == 'colorFooter' && isset($value) )
            .container-footer{background-color: {{$value}}; }
        @endif
    @endforeach

    @media (max-width: 648px){
        .cintillo-promo{ height: 84px;}
    }
    </style>
   
    <header>
        <div class="header-promo">
            <div class="cintillo-promo">
                <div id="tui-logo">
                    <a href="{{'/'.(isset($info->properties['channel'])?$info->properties['channel']:'').'/'.$short_name.'/'}}" title="logotipo {{isset($info->properties['channel'])?$info->properties['channel']:''}}" target="_blank">
                         @if (!isset($info->properties['UrlImgLogo']))
                            <i class="c5-logo"></i>
                         @endif

                    </a>
                </div>
                <div class="vertical-container">
                    <h1>
                        <p>{{isset($info->properties['titlePleca'])?$info->properties['titlePleca']:''}}</p>
                    
                    </h1>
                </div>
            </div>
        </div>
    </header>
    
@show