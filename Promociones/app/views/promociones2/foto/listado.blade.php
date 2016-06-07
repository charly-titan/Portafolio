@extends(Config::get( 'app.main_template' ).'.main')

@section('css')
  @parent
		<link href="/fasi/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="/fasi/css/font-awesome.min.css" rel="stylesheet">	
		<!-- Pretty Photo CSS -->
		<link href="/fasi/css/prettyPhoto.css" rel="stylesheet">
    <!-- Foto grid -->
    <link href="/fasi/css/grid-gallery.css" rel="stylesheet">
		
  <style>
   
    a{text-decoration: none;}
    h3{
      margin:0px !important;
    }
    .titulo-galeria{
      height: 70px;
      width: 73%;
      background: #FF5722;
      color: #FFF;
      margin: 0 auto;
      margin-top: 20px;
      padding-top: 5px;
      text-align: center;
      box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.24);
    }
    .titulo-galeria h1{
      font-size: 3em;
    }
    @media screen and (max-width:647px) {
      .titulo-galeria{
        width: 100%;
      }
      .titulo-galeria h1{ 
        font-size: 2em;
        padding-top: 2%; 
      }
    }
    @media all and (min-width:648px) and (max-width:947px) {
      .titulo-galeria{ width: 95%; }
    }

  </style>
@stop
@section('banner')
@stop
@section('content')
    <div class="jp-wrapper">
    <div class="breaking" style="visibility: hidden;">
    </div>                                     
<div class="layout clearfix infinite-scrolling" id="iso" data-options="[mq_desktop=827, mq_tablet=500, mq_smartphone=220]" data-margins="[desktop=[top=18, left=24], tablet=[top=12, left=6], movil=[top=6, left=3]]" data-desktop="[items=15, vueltas=7]" data-tablet="[items=15, vueltas=7]" data-smartphone="[items=15, vueltas=7]" >

  @if ($fotos && count($fotos)>0)
  <?php $loop = 1; $aux = 5; ?>
    @foreach ($fotos as $value)
        <div {{($loop <= 3) ? "" : "style='display:none'"}} id="{{$loop}}" class="item" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=true, movil_visible=true]">
          <article class="mm-container mm-amarillo grid-element">
              
              <a href="{{URL::to($value->voto_url)}}" class="mm-vinculo" target="_blank">
                  <div class="mm-img-container">
                      {{ html_entity_decode(HTML::image($value->foto_url, "",['class'=>'mm-img'])) }}
                  </div>
                  <h3 class="mm-content-title">{{$value->foto_name}} </h3>
              </a>
          </article>
        </div>

        @if($loop == $aux)
          <div style='display:none' data-number="{{$loop}}" class="item" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=false, movil_visible=false]">
            <div class="ads-300-x hidden-tablet hidden-mobile">
              <div class="title-ads">publicidad</div>
                <div id="ban01_300x250">
                    <h1 style="color:#000">publicidad</h1>  
                </div>
              </div>
          </div>
          <?php $aux=$aux+5; ?>
        @endif 
        <?php $loop++; ?>
    @endforeach
  @else
      <p>No se encontraron imagenes aprobadas</p>
  @endif

</div>
<div class="col-lg-12 col-md-12 text-center">
  <button id="btn-mas" data-last="3" data-total="3" class="btn btn-info btn-mas">
    Ver más
  </button>
 </div> 
</div>
<!-- Shots Ends -->	
 
@stop

@section('aside_right')
@stop

@section('scripts')
  @parent
		<!-- Javascript files -->
   <script type="text/javascript" src="/aib/files/js-plugin/jquery/jquery.1.10.2.min.js"></script>
        <script type="text/javascript" src="/aib/files/js/head.load.min.js"></script>
        <script type="text/javascript" id="libs" src="/aib/files/js/finalpage-libs.js"></script>


		<script src="/fasi/js/jquery.js"></script>
		<!-- jQuery -->
		<script src="/js/socialShare_canal5.js"></script>
		<!-- Bootstrap JS -->
		<script src="/fasi/js/bootstrap.min.js"></script>
		<!-- JQuery PrettyPhoto Js -->
		<script src="/fasi/js/jquery.prettyPhoto.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="/fasi/js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="/fasi/js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="/fasi/js/custom.js"></script>
		<script src="/boomerang/assets/milestone-counter/jquery.countTo.js"></script>
		<!-- JavaScript For This Page -->
    <script>
    $(function () { 

      $("#btn-mas").click(function(){
          fotos_inicio = $("#btn-mas").attr("data-last");
          fotos_extra = 2;
          fotos_total = parseInt(fotos_inicio) + fotos_extra;

          for(fotos_inicio; fotos_inicio <= fotos_total; fotos_inicio++ ){
              if( $( "div#" + fotos_inicio ).length > 0 ) {
                  $( "div#" + fotos_inicio ).show("slow");
                  if($('div[data-number=' + fotos_inicio+']').length > 0){
                     //console.log("elemento de publicidad numero: " + fotos_inicio);
                     $('div[data-number=' + fotos_inicio+']').show("slow");
                  }
              }else{
                  $("#btn-mas").hide();
                  break;
              }
          }
          $("#btn-mas").attr("data-last", fotos_total);
        
        });
    });
    </script>
    <script type="text/JavaScript">
        jQuery(".prettyphoto").prettyPhoto({
        overlay_gallery: false, social_tools: false
        });
        $('.milestone-count').countTo({
        //from: 50,
        //to: 250,
        //speed: 1000,
        //refreshInterval: 50,
        formatter: function (value, options) {
        return value.toFixed(options.decimals);
        },
        onUpdate: function (value) {
        console.debug(this);
        },
        onComplete: function (value) {
        console.debug(this);
        }
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
        //console.log(response);
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
        alert("Se te abonaron {{--isset($contestRwd->share_points)?$contestRwd->share_points:''--}} {{--isset($point->name)?$point->name:''--}}, tienes un total de 10");
        }


        }


        //socialShare.loadJsTwitter();

        socialShare.loadJsFacebook();


        window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
        t._e.push(f);
        };

        return t;
        }(document, "script", "twitter-wjs"));

        // Define our custom event handlers
        function clickEventToAnalytics (intentEvent) {
        if (!intentEvent) return;
        var label = intentEvent.region;
        pageTracker._trackEvent('twitter_web_intents', intentEvent.type, label);
        }

        function tweetIntentToAnalytics (intentEvent) {
        if (!intentEvent) return;
        alert("Se te abonaron 5 palomitas");
        // var label = "tweet";
        // pageTracker._trackEvent(
        //   'twitter_web_intents',
        //   intentEvent.type,
        //   label
        // );
        }

        function favIntentToAnalytics (intentEvent) {
        tweetIntentToAnalytics(intentEvent);
        }

        function retweetIntentToAnalytics (intentEvent) {
        if (!intentEvent) return;
        var label = intentEvent.data.source_tweet_id;
        pageTracker._trackEvent(
        'twitter_web_intents',
        intentEvent.type,
        label
        );
        }

        function followIntentToAnalytics (intentEvent) {
        if (!intentEvent) return;
        alert("Se te abonaron 5 palomitas");
        // var label = intentEvent.data.user_id + " (" + intentEvent.data.screen_name + ")";
        // pageTracker._trackEvent(
        //   'twitter_web_intents',
        //   intentEvent.type,
        //   label
        // );
        }

        // Wait for the asynchronous resources to load
        twttr.ready(function (twttr) {
        // Now bind our custom intent events
        twttr.events.bind('click', clickEventToAnalytics);
        twttr.events.bind('tweet', tweetIntentToAnalytics);
        twttr.events.bind('retweet', retweetIntentToAnalytics);
        twttr.events.bind('favorite', favIntentToAnalytics);
        twttr.events.bind('follow', followIntentToAnalytics);
        });


		</script>	
@stop