


@section('header')
	<header>
	        <div class="header-promo">
	            <div class="cintillo-promo">
	                <div id="tui-logo">
	                    <a href="http://www.televisa.com/canal5/" target="_blank">
	                        <img src="http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/logo.png" width=100/>
	                    </a>
	                </div>
	                <div class="vertical-container">
	                    <h1>
	                        <a href="/foto" target="_blank">Antes muerta que Lichita</a>
	                    </h1>
	                </div>
	            </div>
	        </div>
	    </header>   
@stop

@section('banner')

	<article class="banner">
        <div class="stage-promo">
            <div class="stage-container" >
                <article class="stage-img" style="background:url(http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/1530469.jpg);"></article>
            </div>
        </div>
    </article>
    
@stop
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Canal 5 - Foto</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="/fasi/css/style.css" rel="stylesheet">
		<!-- Styles -->
		

		<!-- Bootstrap CSS -->
		<link href="/fasi/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="/fasi/css/font-awesome.min.css" rel="stylesheet">	
		<!-- Pretty Photo CSS -->
		<link href="/fasi/css/prettyPhoto.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="/css/promociones/canal-5-promociones-global.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
<style type="text/css">
		body{
			background: url(http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/back1.svg) ;
			  background-size: cover;
			  background-repeat: no-repeat;
			  color:#fff;
		}
		.page-title h3, .service .service-item h4, .iu-texto,.iu-texto h4,.iu-texto h5 , .iu-texto ul.mecanica li, .iu-texto ul.mecanica li p, .iu-texto ul.mecanica li p strong, .iu-texto p{
			color:#FFF;
		}
		.stage-container{
			  border-bottom: 6px solid orange;
		}


.iu-texto h2{
	color:orange;
}

		.block{
			border-bottom:none;
		}

		.service .service-item h4{
			font-family: arial;
		}
		.cintillo-promo, .header-promo, .stage-container{
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

		.left-container, .iu-texto{
max-width: 600px;
		} 

		.right-container	{
			max-width: 300px;
		}
}
        /*}*/

		</style>

		<style>

	        .prueba{
	        	border: 2px solid red;
	        }
			.dropzone{min-height: 200px;}
	    	#demo .dropzone .dz-preview{font-size: 12px;} 
	    	img {max-width: 100%;max-height: 100%;}
	        @media all and (max-width: 1000px){
	            img{
	            width:800px;
	            height: 250px;
	            }
	        }
	        body{
				font-family: 'Source Sans Pro';
			}
			.service h3, .service div{
				font-family: 'Source Sans Pro';	
			}
		</style>
	</head>
		
	<body>
	     @section('header')
                    @show

		
	    
	    <div class="service block">
			<!-- Container -->
			<div class="container">
				<!-- Page Title -->
				<div class="page-title text-center">
					<!-- Heading -->
					<h3>Listado de fotos más votadas</h3>
					<br />					
					<br />
				</div>								
		    
	    	
	    		<div class="row">

						@if(Session::get('statusUrlImage')=='activo')
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="#"> {{ html_entity_decode(HTML::image(Session::get('urlImage'), "",['class'=>'img-responsive'])) }}
									<!-- Heading -->
									<h4>Imagen 1</h4>
									</a>
									<strong>
										<div class="milestone-count c-gray" data-from="0" data-to="1230" data-speed="2000" data-refresh-interval="80"></div>
									</strong>
									<!-- Paragraph -->
									<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
							</div>
						</div>
						@endif
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="#"> {{ html_entity_decode(HTML::image('/img/pelicula002.jpg', "",['class'=>'img-responsive'])) }}
									<!-- Heading -->
									<h4>Imagen 2</h4>
									</a>
									<strong>
										<div class="milestone-count c-gray" data-from="0" data-to="130" data-speed="2000" data-refresh-interval="80"></div>
									</strong>
									<!-- Paragraph -->
									<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="#"> {{ html_entity_decode(HTML::image('/img/pelicula001.jpg', "",['class'=>'img-responsive'])) }}
									<!-- Heading -->
									<h4>Imagen 3</h4>
									</a>
									<strong>
										<div class="milestone-count c-gray" data-from="0" data-to="120" data-speed="2000" data-refresh-interval="80"></div>
									</strong>
									<!-- Paragraph -->
									<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="service-item">
									<!-- Icon -->
									<a href="#"> {{ html_entity_decode(HTML::image('/img/pelicula003.jpg', "",['class'=>'img-responsive'])) }}
									<!-- Heading -->
									<h4>Imagen 4</h4>
									</a>
									<strong>
										<div class="milestone-count c-gray" data-from="0" data-to="100" data-speed="2000" data-refresh-interval="80"></div>
									</strong>
									<!-- Paragraph -->
									<!--p>Nemo enim ipsam quia voluptas aspernatur.</p-->
							</div>
						</div>
					
				</div>
    				       		
	    	</div>   
	    </div>	

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
			
			$('.milestone-count').countTo({

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




