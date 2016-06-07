@extends(Config::get( 'app.main_template' ).'.main')


@section('banner')

    @section('banner')

    <article class="banner">
        <div class="stage-promo">
            <div class="stage-container" >
                <article class="stage-img"><h1>404<h1></article>
            </div>
        </div>
    </article>
    
@show
    <style>
    .stage-img h1 {
font-size: 134px;
text-align: center;
margin-top: 50px;
}
    </style>
@stop


@section('scripts')
    
    {{ HTML::script('js/promociones/tvsyload.js') }}
    {{ HTML::script('js/promociones/jquery-2.1.1.min.js') }}
    {{ HTML::script('js/promociones/tvsa.loadimg.js') }}
    {{ HTML::script('js/promociones/headertelevisaConfigurable.js',array('async'=>'async','charset'=>'utf-8')) }}
    {{ HTML::script('js/promociones/footertelevisaCQconfig.min.js') }}
    {{ HTML::script('js/promociones/head.load.min.js') }}
    {{ HTML::script('js/promociones/finalpage-libs.js',array('id'=>'libs')) }}

    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-1776907-2']);
    _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
@stop

@section('content')

	<article class="left-container">
        <div class="iu-texto">
            <div>
                
                <h2 class="title">{{Lang::get('promociones.error_title_'.$code)}}</h2>
                
                <h3 class="resumen">{{Lang::get('promociones.error_description_'.$code)}}</h3>
            </div>
        </div>
    </article>
   	
@stop

@section('aside_right')
<aside class="right-container">
        <!--div class="btns-share">
            <h2></h2>

        </div-->
        <div class="banners-desktop-1">
            <span>Publicidad</span>
            <div class="banner1" id="ban01_televisa">

    	        <script type="text/javascript" defer="defer" >
    	           googletag.display('ban01_televisa');
    	                        
    			</script>
            </div>
        </div>
    </aside>
@stop


@section('header')

    <header>
        <div class="header-promo">
            <div class="cintillo-promo">
                <div id="tui-logo">
                    @if(isset($controller))
                    <a href="http://www.televisa.com/canal5/" target="_blank">
                        <i class="c5-logo"></i>
                    </a>
                    @endif
                </div>
                <div class="vertical-container">
                    <h1>
                        <a href="http://www.televisa.com/canal5/" target="_blank">{{Lang::get('promociones.error_head_'.$code)}}</a>
                    </h1>
                </div>
            </div>
        </div>
    </header>
    
@stop


@section('footer')

    

@stop