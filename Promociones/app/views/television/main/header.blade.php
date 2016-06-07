@section('header')
    <style type="text/css">
    @if (isset($info->properties['UrlImgLogo']))
        #tui-logo{
            background-image: url({{isset($info->properties['UrlImgLogo'])?$info->properties['UrlImgLogo']:'';}});
        }
        div#tui-logo{
            background-size: cover !important;
            background-position: center center;
            background-repeat: no-repeat !important;
        }
        @media only screen and (min-width: 320px){
            div#tui-logo{
                height: 49%;
                width: 30%;
            }   
        }
        @media only screen and (min-width: 360px){
            div#tui-logo{
                height: 53%;
                width: 30%;
            }   
        }
        @media only screen and (min-width: 375px){
            div#tui-logo{
                height: 57%;
                width: 30%;
            }   
        }
        @media only screen and (min-width: 400px){
            div#tui-logo{
                height: 63%;
                width: 30%;
            }   
        }
        @media only screen and (min-width: 415px){
            div#tui-logo{
                height: 73%;
                width: 30%;
            }   
        }
        @media only screen and (min-width: 500px){
            div#tui-logo{
                height: 74%;
                width: 27%;
            }   
        }
        @media only screen and (min-width: 600px){
            div#tui-logo{
                height: 74%;
                width: 24%;
            }   
        }
        @media screen and (min-width: 640px) {
            div#tui-logo{
                width: 22%;
                height: 71%;
            }
        }
        @media screen and (min-width: 700px) {
            div#tui-logo{
                height: 76px;
                width: 177px;
            }
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
                    <a href="https://www.recetasnestle.com.mx/" title="logotipo" target="_blank">
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