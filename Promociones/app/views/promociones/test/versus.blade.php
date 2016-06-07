<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Antes muerta que lichita</title>
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

		<style type="text/css">
		body{
			background: url(http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/back1.svg) ;
			  background-size: cover;
			  background-repeat: no-repeat;
			  color:#fff;
		}
		.page-title h3, .service .service-item h4{
			color:#FFF;
		}

		.block{
			border-bottom:none;
		}

		.service .service-item h4{
			font-family: arial;
		}
		.cintillo-promo, .header-promo{
			background-color: orange;
		}

		.shots .block{
			color: orange;
		}
		div, h5, h3, li, .page-title h3, .pricing .pricing-item li, .page-title h3, .page-title p{
			color:#fff;
		}

/* Small devices (tablets, 768px and up) */
@media (max-width: 768px) {
	.list-unstyled 	li img{
		max-width: 20px;
  		max-height: 20px;
  		background-color: red;
  		border: #FFF;
		}
	
  }

/* Medium devices (desktops, 992px and up) */
@media (min-width: 922px) { 
 div#tui-logo {
				  
				  width: 105px;
				  height: 80px;
				  margin: 12px 22px 0px 40px;
				  z-index: 10;
			}

}

/* Large devices (large desktops, 1200px and up) */
@media (min-width: 1000px) { 
		/*@media all and (max-width: 1000px){*/
            div#tui-logo {
				  
				  width: 100px;
				  height: auto;
				  /*margin: 12px 22px 12px 40px;
				  z-index: 10;*/
			}
}
        /*}*/

		</style>
	</head>
	
	<body>

    <header>
        <div class="header-promo">
            <div class="cintillo-promo">
                <div id="tui-logo">
                    <a href="http://www.televisa.com/" target="_blank">
                        <img src="http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/logo.png" width=100/>
                    </a>
                </div>
                <div class="vertical-container">
                    <h1>
                        <a href="/versus" target="_blank">Antes muerta que Lichita</a>
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
					<!--p>Vota por tu pelicula favorita. La pelicula con mas votos será transmitida por canal 5.</p-->
				</div>

				<div class="row">
					@foreach ($questionAll->optionsQuestion as $key => $value)
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="versus/movie-selected/{{$value['order']}}"> {{ html_entity_decode(HTML::image($value['img'], "",['class'=>'img-responsive'])) }}
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
		<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
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

								<div class="col-md-3 col-sm-3 col-xs-3">
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
							<img src="/img/zapato001.jpeg" width="100" align="right">
							<h2> {{Session::get('user.firstname')}} <br>Se te abonaron  5 zapatos a tu cuenta. </h2>

							<p class="shot-para"><strong>Tienes un total de 5 zapatos </strong>
								Eres una zapato de oficina 
							</p>
							<hr>
                			<div class="row">
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/zapato001.jpeg"  width="50" align="center">
										<p><strong>1 a 150</strong></p>
										<h5> Zapato de oficina </h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										<img src="/img/zapato002.jpg"  width="50" align="center">
										<p><strong>151 a 250</strong></p>
										<h5> Zapato de fiesta</h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/zapato004.jpg"  width="50" align="center">
										<p><strong>251 a 750</strong></p>
										<h5> Zapato dorado</h5>
									</div>
								</div>
								<div class="col-md-3 col-xs-3">
									<div class="shot-content-body">
										 <img src="/img/zapato003.jpg"  width="50" align="center">
										<p><strong>751 a 1500</strong></p>
										<h5>Zapato de lujo</h5>
									</div>
								</div>
							</div>

                			<?php Session::forget('user'); ?>
							@else
							<img src="/img/zapatos.jpeg" class="img-responsive" alt="" width="100" align="right">
							<h2>Gracias por votar</h2>
							<p class="shot-para"><strong>Ganaste 5 zapatos para que se agreguen a tu cuenta inicia sesion.</strong> </p> 
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
					<h3>Los más ricachones</h3>
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
							<h5>Reina ricachona</h5>
							<!-- Paragraph -->
							<p class="col-xs-4"><!--img src="/img/palomita_acaram.jpeg" class="img-responsive"  width="20" align="left"-->1300 zapatos.</p>
							<!-- Social -->
							
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
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
									<li > <!--img src="/img/palomita_enchi.png"  width="20" align="left"--> Marco Plata - 701 zapatos</li>
									<li> <!--img src="/img/palomita_enchi.png" class="img-responsive" width="20" align="left"--> Paola Rod - 500 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_enchi.png"  class="img-responsive" width="20" align="left"--> Itzcoatl M - 356 zapatos</li>
									<li> <!--img src="/img/palomita_mant.jpeg" class="img-responsive" width="20" align="left"--> Roberto Baut - 189 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_mant.jpeg" class="img-responsive" width="20" align="left"> Elsa Salinas - 153 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_nat.jpeg" class="img-responsive" width="20" align="left"--> Elsa Salinas - 140 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_nat.jpeg" class="img-responsive" width="20" align="left"--> Mayra G - 135 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_nat.jpeg" class="img-responsive" width="20" align="left"--> Omar C - 129 zapatos</li>
									<li class="times"> <!--img src="/img/palomita_nat.jpeg" class="img-responsive" width="20" align="left"--> Gustavo T - 111 zapatos</li>
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
		<!-- jQuery -->
		<script src="/fasi/js/jquery.js"></script>
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
		</script>	
	</body>	
</html>