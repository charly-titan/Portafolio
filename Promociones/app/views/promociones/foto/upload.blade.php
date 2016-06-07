



@section('header')
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
                        <a href="/canal5/" target="_blank">{{Lang::get('promociones.titleHeader')}}</a>
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
                <article class="stage-img"></article>
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
			/*background: url(http://finalpage.esmas.com/apps/prototipo/amqlichita/source/img/back1.svg) ;
			  background-size: cover;
			  background-repeat: no-repeat;
			  color:#fff;
		*/}
		.page-title h3, .service .service-item h4, .iu-texto,.iu-texto h4,.iu-texto h5 , .iu-texto ul.mecanica li, .iu-texto ul.mecanica li p, .iu-texto ul.mecanica li p strong, .iu-texto p{
			/*color:#FFF;*/
		}
		.stage-container{
			  /*border-bottom: 6px solid orange;*/
		}


.iu-texto h2{
	/*color:orange;*/
}

		.block{
			border-bottom:none;
		}

		.service .service-item h4{
			font-family: arial;
		}
		.cintillo-promo, .header-promo, .stage-container{
			/*background-color: orange;*/
		}

		.shots .block{
			/*color: orange;*/
		}
		div, h5, h3, li, .page-title h3, .pricing .pricing-item li, .page-title h3, .page-title p{
			/*color:#fff;*/
		}

/* Small devices (tablets, 768px and up) */
@media (max-width: 768px) {
	.list-unstyled 	li img{
		/*max-width: 20px;
  		max-height: 20px;
  		background-color: red;
  		border: #FFF;*/
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
		
	<body class=" js-off" id="main">
	    

		
	    @if(Session::get('urlImage') != "" && $info['accion']!='editar')
	    @section('content')
	    <div class="service block">
			<!-- Container -->
			<div class="container">
				<!-- Page Title -->
				<div class="page-title text-center">
					<!-- Heading -->
					<h3>Revisa o cambia tu Foto</h3>
					<br />					
					<br />
				</div>								
		    </div>

	    	<div class="row">   		    			    	
	    		<div style='display: inline-table'>
	    			<div class="service-item">
						{{ HTML::image(Session::get('urlImage'), 'alt', array(  'id'=>'imageTest', 'class'=>'img-responsive' ))}}    												
					</div>									    			
    			</div>	
    			<div style='display: inline-table; vertical-align: top; padding-left: 30px'>
    				<br />
    				<p><a href="/foto/editar">Editar foto</a></p>
    				<p><a href="{{Session::get('urlImage')}}" id='linkFoto' target="_blank">tamaño original</a></p>	    				
    				<br />
    				<br />
    				<div style='display: block'>
	    				<a href="/social/Facebook" class="download"><i class="fa fa-facebook"></i> Facebook </a>
						<a href="/social/Twitter" class="download"><i class="fa fa-twitter"></i> Twitter </a>
						<a href="/social/Google" class="download"><i class="fa fa-google-plus"></i> Google </a>
					</div>
					<br />
					<br />
					<div style='display: block'>
	    				<a href="/foto/votar" class="download"> Votar </a>						
					</div>
    			</div>	

				

	        	
    				       		
	    	</div>   
	    </div>	
	    @stop

	    @endif

	    @if($info['accion']=='editar' || ($info['accion']=='index' && Session::get('urlImage')==''))

			

			@if (Session::get('user.identifier')!="") 
			
			@section('content')

			    <article class="left-container">
			        <div class="iu-texto"> 
						<div class="service block">
							<!-- Container -->
							<div class="container">
								<!-- Page Title -->
								<div class="page-title text-center">
									<!-- Heading -->
									<h3>Sube tu Foto</h3>
									<!-- Paragraph -->
									<p>Sube una foto tuya y comparte para ganar. </p>
								</div>								
						    </div>	

						    <div id='divImage' style='display: none'>   		    	
						    		
				    			{{ HTML::image('', 'alt', array( 'width' => 300, 'height' => 300, 'id'=>'imageTest' ))}}
				    			{{Form::open(array('url'=>'/foto/save-foto','method'=>'POST'))}}
				    				{{Form::text('urlImage'," ", array('id'=>'urlImage'))}}
				    				{{Form::submit('Guardar',array('id'=>'botonGuardar','class'=>'btn-confirmar','name'=>'guardar'))}}
					        	{{Form::close()}}			        	
				    				       		
					    	</div>   
						   
							<div id='demo'>            				                
					       		{{Form::open(array('url'=>'/foto/uploadimg','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
					        	{{Form::close()}}
					    	</div>   

						</div>
				</div>
				</article>
			@stop

			@section('aside_right')
				
			@stop

			@else


@section('aside_right')

    <aside class="right-container">
        <div class="btns-share">
            <h2>¡Comparte esta promoción con tus amigos!</h2>
            <div class="share-container">
                <div id="widgetSocialShare2"></div>
            </div>
        </div>
        
        
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

			@section('content')

    <article class="left-container">
        <div class="iu-texto">
            <div class="terminos-condiciones">
                <h2 class="title">{{Lang::get('promociones.titleContainer')}}</h2>
                <h4 class="resumen_login">{{Lang::get('promociones.resumen_login')}}</h4>
                <h5 class="encabezado">{{Lang::get('promociones.encabezado')}}</h5>
                <ul class="mecanica">
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip1')}}
                        <strong>{{Lang::get('promociones.loginMsgLip1S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip2')}}
                        <strong>{{Lang::get('promociones.loginMsgLip2S')}}</strong>y 
                        <strong>{{Lang::get('promociones.loginMsgLip2S1')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip3')}}
                        <strong>{{Lang::get('promociones.loginMsgLip3S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip4')}}</p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip5')}} 
                        <strong>{{Lang::get('promociones.loginMsgLip5S')}}</strong></p>
                    </li>
                    <li>
                        <p>{{Lang::get('promociones.loginMsgLip6')}}
                        <strong>{{Lang::get('promociones.loginMsgLip6S')}}</strong></p>
                    </li>
                </ul>
                <h5 class="encabezado" />
                <ul class="condiciones">
                    <li>
                        <p>
                            <STRONG>{{Lang::get('promociones.condiciones')}}</STRONG>
                        </p>
                    </li>
                    <li>
                        <p />
                    </li>
                    <li>
                        <p />
                    </li>
                    <li>
                        <p />
                    </li>
                </ul>
            </div>
	        <div class="registro">
	            <h2 class="title">{{Lang::get('promociones.registroTitle')}}</h2>
	            <h4 class="resumen_login">
	            <b>{{Lang::get('promociones.registroLogin')}}</b>&nbsp;{{Lang::get('promociones.registroLogin2')}}</h4>
	            <ul class="redes">
	                <li class="twitter">
	                    <a href="/social/Twitter" title="Twitter">
	                        <i class="tvsagui-twitter"></i>
	                    </a>
	                </li>
	                <li class="facebook">
	                    <a href="/social/Facebook" title="Facebook">
	                        <i class="tvsagui-facebook"></i>
	                    </a>
	                </li>
	                <li class="google">
	                    <a href="/social/Google" title="google">
	                        <i class="tvsagui-gplus"></i>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</article>

	  
@stop


			@endif

		@endif
		


		<div class="mm-page">
    
           

                <div class="c5-wapper">
                    
                    @section('header')
                    @show

                        <section class="wrapper-container">
                                
                                @section('banner')
                                @show

                                    <div class="container">
                                        
                                        @section('content')
                                        @show
										@section('aside_right')
										@show

                                        
                                        
                                        
                                    </div>

                        </section>

                    
                    
                </div>

                


        </div>

		<script src="/fasi/js/jquery.js"></script>
	    {{ HTML::script("js/dropzone/dropzone.min.js") }}
	    
	    <script>
	    	/************* DropZone *******************/	
			Dropzone.options.myDropzone = {
				maxFiles: 1,
				paramName: "file",
				addRemoveLinks : true,
				maxFilesize: 10,
				acceptedFiles: ".jpg, .jpeg, .gif, .png",
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
				dictResponseError: 'Error uploading file!',
			  	init: function() {
				    this.on("success", function(file, responseText) {
				    	console.log(responseText+1);
				    				    	
				    	//$("#imageTest").attr('src',responseText);
				    	//$("#linkFoto").attr('href',responseText);
				    	$("#urlImage").val(responseText);

				    	$("#botonGuardar").click();
				    	//$("#divImage").show();	
				    	$
				    	

				    });
				}
			};					
	    </script>
	    {{ HTML::script('js/promociones/tvsyload.js') }}
	{{ HTML::script('js/promociones/jquery-2.1.1.min.js') }}
	{{ HTML::script('js/promociones/tvsa.loadimg.js') }}
	{{ HTML::script('js/promociones/headertelevisaConfigurable.js',array('async'=>'async','charset'=>'utf-8')) }}
	{{ HTML::script('js/promociones/footertelevisaCQconfig.min.js') }}
	{{ HTML::script('js/promociones/head.load.min.js') }}
	{{ HTML::script('js/promociones/finalpage-libs.js',array('id'=>'libs')) }}

	</body>	

</html>






