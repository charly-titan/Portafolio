@extends(Config::get( 'app.main_template' ).'.main')
@section('css')
    @parent
    <link href="/fasi/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome CSS -->
    <link href="/fasi/css/font-awesome.min.css" rel="stylesheet"> 
    <!-- Pretty Photo CSS -->
    <link href="/fasi/css/prettyPhoto.css" rel="stylesheet">
    
    <style>
        /* Open Sans */
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,600);

        header{
            height: 60px;
        }
        .header-promo{
            box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.24);
        }
        .screenshot img{
            margin: 0px auto;
            width: 400px;
            max-width: 100%;
        }
        body{
            font-family: 'Source Sans Pro';
        }
        .service h3, .service div{
            font-family: 'Source Sans Pro'; 
        }
        .container{
            width: 85%;
        }
        .cards{
            margin: 0 auto;
        }
        .card-foto{
            margin-top: 40px;
            position: relative;
            box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.24);
            margin-bottom: 25px;
            padding: 15px;
        }
        .title-foto{
            background: #00BCD6;
            color:#FAFAFA;
            margin: 0px;
            height: auto;
            min-height: 50px;
            width: 100%;
            text-align: center;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
        }
        .title-foto span{ 
            font-size: 2em; width: 100%; line-height: 50px;

        }
        .shotcontent{
            margin: 0 auto;
            text-align: center;
            height: 150px;
            height: auto;
        }
        #tui-logo {
            animation: GoBack 5s 1;
        }
        @media all and (max-width:948px) {
            .container{ width: 90%; }
            .title-foto span{ font-size: 1.3em; }
        }
        @media screen and (max-width:647px) {
            .container{ width: 95%; }
            .title-foto span{ font-size: 1.1em; }
        }
        @media screen and (max-width:480px) {
            .container{ width: 100%; }
            .title-foto span{ font-size: 1.2em; }
            .title-foto{ position: relative;}
        }

        @media all and (max-width: 767px){
            img{
                width: 200px;
            }
            .sugerencias img{
                max-width: 100px;
            }
        }
        #sugerencias .img-thumbnail{
            border:150px;
            border-radius:4px; /* slight round in images in gallery */
            margin:0px;
            padding:0px;

        }
        a.download{
            color:#fff;
            display:inline-block;
            text-decoration:none;
            font-size:17px;
            font-weight:bold;
            padding:0px 25px;
            border-radius:5px;
            background:#39a5e2;
            line-height:50px;
            box-shadow: 0 2px 0 0 rgba(255,255,255,0.2) inset,0 2px 3px rgba(0,0,0,0.3);
            -webkit-transition: background 1s ease;
            -moz-transition: background 1s ease;
            -o-transition: background 1s ease;
            -ms-transition: background 1s ease;
            transition: background 1s ease;
            margin-top:2px !important;
        }
        a.download:hover{
            background:#1c97dd;
            -webkit-transition: background 1s ease;
            -moz-transition: background 1s ease;
            -o-transition: background 1s ease;
            -ms-transition: background 1s ease;
            transition: background 1s ease;
        }

        a.download{
            margin-bottom:20px;
        }
        div.cards{
            font-family: 'Open Sans', sans-serif !important;
            -webkit-font-smoothing: antialiased !important;
        }
    </style>
@stop
@section('banner')
@stop
@section('content')

<!-- Shots starts -->
    <div class="shots block">
      <div class="container">
        <!-- shot1-->
        <div class="row cards">
          <div class="col-md-12 card-foto">
                <div class="title-foto">
                    <span>Foto de {{$info_foto['user_name']}} </span>
                </div>
                <hr>
                <div class="screenshot">
                    {{ html_entity_decode(HTML::image($info_foto['foto_url'], "",['class'=>'img-responsive','alt'=>'image'])) }}
                    <span style="display:none">{{$info_foto['foto_name']}}</span>
                </div>
          </div>
          <div class="col-md-12 card-foto">
            
          @if (!isset($votoRegister))
            <div class="shotcontent">
              <div class="title-foto">
                  <span>Para votar por esta foto necesitas iniciar sesion</span>
              </div>
              <hr>
              @if ($info_foto['status']=='pending')
               <p>Esta foto esta en revisión, sin embargo tu voto quedará registrado</p><hr>
              @endif
              <a href="/social/Facebook" class="download"><i class="fa fa-facebook"></i> Facebook</a>
              <a href="/social/Twitter" class="download"><i class="fa fa-twitter"></i> Twitter</a>
              <a href="/social/Google" class="download"><i class="fa fa-google-plus"></i> Google</a>
              
            </div>

          @else
            <div class="shotcontent">

              <hr>
              @if ($votoRegister)
                 <div class="title-foto">
                  <span>Tu voto ha sido registrado</span>
                </div>
              @else
                <div class="title-foto">
                  <span>Ya votaste anteriormente para este concurso</span>
                </div>
              @endif
              <hr>
                <a href="/foto/{{$info['short_name']}}">
                  <button type="button" class="btn btn-default">Revisa las fotos más votadas</button>
               </a>
            </div>
          @endif
          </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 card-foto col-lg-offset-1 col-md-offset-1 col-sm-offset-1 ">
            <div class="shotcontent">
              <div class="title-foto">
                  <span>También te puede interesar</span>
              </div>
              <hr>
            </div>
              <div id="sugerencias">
              <div class="row text-center">  
              @foreach($sugeridos as $value)
                  <div class="col-lg-3 col-sm-3 col-xs-3">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <a href="{{URL::to($value->voto_url)}}" class="mm-vinculo" >
                        {{ html_entity_decode(HTML::image($value->foto_url, "",['class'=>'img-thumbnail img-responsive'])) }}
                      </a>
                    </div>
                    <div class="panel-footer">
                      {{$value->foto_name}}
                    </div>
                  </div> 
                  </div>
              @endforeach
              </div>
              </div>
          </div>

        </div>
      </div>
    </div>
    
@stop
@section('aside_right')
@stop
@section('scripts')
    @parent
     <script type="text/javascript" src="http://i2.esmas.com/finalpage/entretenimiento/js/jquery-2.1.0.js"></script>
        <script type="text/javascript" src="http://i2.esmas.com/finalpage/entretenimiento/js/head.load.min.js"></script>
        <script type="text/javascript" id="libs" src="http://i2.esmas.com/finalpage/entretenimiento/js/finalpage-libs.js"></script>
    <!-- Javascript files -->
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