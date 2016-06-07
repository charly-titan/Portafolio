<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Canal 5 - Versus</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<link href="/css/promociones/canal-5-promociones-global.css" rel="stylesheet">
		<!-- Bootstrap CSS -->
		<link href="/fasi/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="/fasi/css/font-awesome.min.css" rel="stylesheet">	
		<!-- Pretty Photo CSS -->
		<link href="/fasi/css/prettyPhoto.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="/fasi/css/style.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>

    <header>
        <div class="header-promo">
            <div class="cintillo-promo">
                <div id="tui-logo">
                    <a href="http://www.televisa.com/canal5/" target="_blank">
                        <i class="c5-logo"></i>
                    </a>
                </div>
                <div class="vertical-container">
                    <h1>
                        <a href="/versus" target="_blank">Canal 5</a>
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <style>
		 img {max-width: 100%;max-height: 100%;}
        @media all and (max-width: 1000px){
            img{
            width:800px;
            height: 250px;
            }
        }
    </style>

@if (!isset($promo_info))
	<!-- Service Starts -->
	<style type="text/css">
	body{
		font-family: 'Source Sans Pro';
	}
	.service h3, .service div{
		font-family: 'Source Sans Pro';	
	}
	</style>
		
		<div class="service block">
			<!-- Container -->
			<div class="container">
				<!-- Page Title -->
				<div class="page-title text-center">
					<!-- Heading -->
					<h3>{{$questionAll->questionText}}</h3>
					<!-- Paragraph -->
					<p>Vota por tu pelicula favorita. La pelicula con mas votos será transmitida por canal 5.</p>
				</div>

				<div class="row">
					@foreach ($questionAll->optionsQuestion as $key => $value)
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="versus-canal-5/movie-selected/{{$value['order']}}"> {{ html_entity_decode(HTML::image($value['img'], "",['class'=>'img-responsive'])) }}
									<!-- Heading -->
									<h4>{{$value['text']}}</h4>
									</a>
									<!-- Paragraph -->
									<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
							</div>
						</div>
					@endforeach
				</div>

				
				
				
			</div>
		</div>
		<!-- Service Ends -->
@endif

@if (isset($promo_info))
<!-- Shots starts -->
		<div class="shots block">
			<div class="container">
				<!-- shot1-->
				<div class="row">
					<div class="col-md-4">

						@foreach ($questionAll->optionsQuestion as $key => $value)
							@if($value['order'] === $movieSelected)

								<div class="screenshot">
									{{ html_entity_decode(HTML::image($value['img'], "",['class'=>'img-responsive','alt'=>'image'])) }}
									<div class="milestone-counter">
											<center><strong>
			                            <div class="milestone-count c-gray" data-from="0" data-to="11100" data-speed="3000" data-refresh-interval="100"></div></strong></center>
			                        </div>
									<h3>{{$value['text']}}</h3>
								</div>

							@endif
						@endforeach
						
					</div>
					<div class="col-md-8">
						
						<div class="row">

						@foreach ($questionAll->optionsQuestion as $key => $value)
							@if($value['order'] != $movieSelected)

								<div class="col-md-3 col-sm-2">
									<div class="service-item">
										<a href="#">{{html_entity_decode(HTML::image($value['img'], "",['class'=>'img-responsive','alt'=>'image'])) }}
										<center><br>
										<strong>
											<div class="milestone-count c-gray" data-from="0" data-to="1230" data-speed="5000" data-refresh-interval="80"></div>
										</strong>
											<h5>{{$value['text']}}</h5></center>
										</a>
										<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
									</div>
								</div>
							@endif
						@endforeach
					


						</div>



						<div class="shotcontent">
							<hr>
							<!--h3>Praesent Tincidunt <span class="text-muted"> Tellus Augue</span></h3-->
							@if (Session::get('user.identifier')!="")
							<img src="/img/palomita_nat.jpeg" width="100" align="right">
							<h2> {{Session::get('user.firstname')}} <br>Se te abonaron  5 palomitas a tu cuenta. </h2>

							<p class="shot-para"><strong>Tienes un total de <span id="contador_valor">5</span> palomitas </strong>
								Eres una palomita Natural 
							</p>
							<hr>
                			<div class="row">
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/palomita_nat.jpeg"  width="50" align="center">
										<p><strong>1 a 150</strong></p>
										<h5> Palomita Natural</h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										<img src="/img/palomita_mant.jpeg"  width="50" align="center">
										<p><strong>151 a 250</strong></p>
										<h5> Palomita Mantequilla</h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/palomita_enchi.png"  width="50" align="center">
										<p><strong>251 a 750</strong></p>
										<h5> Palomita Enchilada</h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/palomita_acaram.jpeg"  width="50" align="center">
										<p><strong>751 a 1500</strong></p>
										<h5> Palomita de Caramelo</h5>
									</div>
								</div>
							</div>

Comparte esta votación para sumar 5 palomitas adicionales

<<<<<<< HEAD
<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="comm_share.shareFB('https://promociones.televisa.com.mx/versus-canal-5/movie-selected/0','comm_share.callback()');">
  <span class="fa facebook" aria-hidden="true">Facebook</span>
</button>

<button type="button" class="btn btn-info" aria-label="Left Align" onclick="comm_share.shareTW('https://promociones.televisa.com.mx/versus-canal-5/movie-selected/0','Un comentario', 'comm_share.callback()');">
  <span class="fa twitter" aria-hidden="true">Twitter</span>
=======
<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="comm_share.shareFB('https://promociones.sinpk2.com/versus-canal-5/movie-selected/0','comm_share.callback()');">
  <span class="fa facebook" aria-hidden="true">Facebook</span>
</button>

<button type="button" class="btn btn-info" aria-label="Left Align" >
  <a href="http://twitter.com/intent/tweet?url=https://promociones.televisa.com.mx/versus-canal-5;via=Canal5Mex"><span class="fa twitter" aria-hidden="true">Twitter</span></a>
>>>>>>> af35f869c34a024222f9a57ab97ae8800d7c74ab
</button>
                			<?php Session::forget('user'); ?>
							@else
							<img src="/img/popcorn.jpg" class="img-responsive" alt="" width="100" align="right">
							<h2>Gracias por votar</h2>
							<p class="shot-para"><strong>Ganaste 5 palomitas para que se agreguen a tu cuenta inicia sesion.</strong> </p> 
							<hr>
							
							<!--div class="row">
								<div class="col-md-6 col-xs-6">
									<div class="shot-content-body">
										<h4><i class="fa fa-cloud tblue"></i> Envelope</h4>
										<p> Cras tincidunt ligula orci, ac sodales urna tincidunt eu. Nullam lacinia placerat justo. </p>
									</div>
								</div>
								<div class="col-md-6 col-xs-6">
									<div class="shot-content-body">
										<h4><i class="fa fa-camera tblue"></i> Facebook</h4>
										<p> Praesent tincidunt tellus augue, a tempor massa iaculis non. Phasellus et mi ante. </p>
									</div>
								</div>
							</div-->
							<!--hr -->
							<a href="/social/Facebook" class="download"><i class="fa fa-facebook"></i> Facebook</a>
							<a href="/social/Twitter" class="download"><i class="fa fa-twitter"></i> Twitter</a>
							<a href="/social/Google" class="download"><i class="fa fa-google-plus"></i> Google</a>
							

							@endif
						</div>
					</div>
					
				</div>
				<hr>
				<!-- shot1 ends -->
				
				
			</div>
		</div>
		<!-- Shots Ends -->	

		<!-- Pricing Starts -->
		
		<div class="pricing block">
			<!-- Container -->
			<div class="container">
				<!-- Page Title -->
				<div class="page-title text-center">
					<!-- Heading -->
					<h3>Los más palomeros</h3>
					<!-- Paragraph -->
					<p></p>
				</div>
				<div class="row">
					<div class="col-md-4">
						<!-- Team Item -->
						<div class="team-item">
							<!-- Image -->
							<a href="#"><img src="/fasi/img/user/1.jpg" alt="" class="img-responsive"></a>
							<!-- Name -->
							<h3>Cindy Polin</h3>
							<!-- Position -->
							<h5>Reina Palomera</h5>
							<!-- Paragraph -->
							<p><img src="/img/palomita_acaram.jpeg"  width="20" align="left">1300 palomitas.</p>
							<!-- Social -->
							
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<!-- Pricing Item -->
						<div class="pricing-item">
							<!-- Pricing Content -->
							<div class="pricing-content">
								<!-- Heading -->
								<!--h4>Basic</h4>
								<span>$5</span>
								<h6>per month</h6-->
								<!-- Order List -->
								<ul class="list-unstyled">
									<!-- List -->
									<li> <img src="/img/palomita_enchi.png"  width="20" align="left"> Marco Plata - 701 palomitas</li>
									<li> <img src="/img/palomita_enchi.png"  width="20" align="left"> Paola Rod - 500 palomitas</li>
									<li class="times"> <img src="/img/palomita_enchi.png"  width="20" align="left"> Itzcoatl M - 356 palomitas</li>
									<li> <img src="/img/palomita_mant.jpeg"  width="20" align="left"> Roberto Baut - 189 palomitas</li>
									<li class="times"> <img src="/img/palomita_mant.jpeg"  width="20" align="left"> Elsa Salinas - 153 palomitas</li>
									<li class="times"> <img src="/img/palomita_nat.jpeg"  width="20" align="left"> Elsa Salinas - 140 palomitas</li>
									<li class="times"> <img src="/img/palomita_nat.jpeg"  width="20" align="left"> Mayra G - 135 palomitas</li>
									<li class="times"> <img src="/img/palomita_nat.jpeg"  width="20" align="left"> Omar C - 129 palomitas</li>
									<li class="times"> <img src="/img/palomita_nat.jpeg"  width="20" align="left"> Gustavo T - 111 palomitas</li>
								</ul>
								<!-- Button -->
								<!--a href="#" class="btn btn-danger btn-xs">Buy Now</a-->
							</div>
						</div>
					</div>
				
				</div>
			</div>
		</div>
		
		<!-- Pricing Ends -->

@endif



    <!-- section class="slice p-15 base">
        <div class="cta-wr">
            <div class="container">
                <div class="row">
                   
                    <div class="col-md-4">
                        <a href="/social/Facebook" class="btn btn-lg btn-b-white btn-icon btn-icon-right btn-check pull-right">
                            <span>Facebook</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/social/Twitter" class="btn btn-lg btn-b-white btn-icon btn-icon-right btn-check pull-right">
                            <span>Twitter</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/social/Google" class="btn btn-lg btn-b-white btn-icon btn-icon-right btn-check pull-right">
                            <span>Google</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section -->
				<!--ul class="redes">
	                <li class="twitter">
	                    <a href="/social/Twitter" title="Twitter">
	                        <i class="tvsagui-twitter"></i>Twitter
	                    </a>
	                </li>
	                <li class="facebook">
	                    <a href="/social/Facebook" title="Facebook">
	                        <i class="tvsagui-facebook"></i>Facebook
	                    </a>
	                </li>
	                <li class="google">
	                    <a href="/social/Google" title="google">
	                        <i class="tvsagui-gplus"></i>Google
	                    </a>
	                </li>
	            </ul-->


		<!-- Footer Ends -->
			
		<!-- Scroll to top -->
		
		<span class="totop"><a href="#.home"> <i class="fa fa-chevron-up"></i> </a></span> 
		
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
        object_popup:"",
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
        alert("Se te abonaron 5 palomitas, tienes un total de 10");
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

>>>>>>> af35f869c34a024222f9a57ab97ae8800d7c74ab
		</script>	
	</body>	
</html>