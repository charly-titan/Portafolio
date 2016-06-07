
<!DOCTYPE HTML>
<html>
<head>
<title>Vive Latino 2016</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="css/imgeffect.css" />
<script src="/js/jquery.min.js"></script>
<!-- start gallery Script -->
<script type="text/javascript" src="js/jquery.easing.min.js"></script>	
<script type="text/javascript" src="js/jquery.mixitup.min.js"></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<link href="css/rotating-card.css" rel="stylesheet" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="css/timeline.css">

<script src="http://cdn.livefyre.com/Livefyre.js"></script>
<script>
Livefyre.require([
    'streamhub-wall#3',
    'streamhub-sdk#2'
], function(LiveMediaWall, SDK) {
    var wall = window.wall = new LiveMediaWall({
        el: document.getElementById("wall"),
        collection: new (SDK.Collection)({
            "network": "livefyre.com",
            "siteId": "313878",
            "articleId": "1",
            "environment": "livefyre.com"
        })
    });
});
</script>
<script>
    $(document).ready(function()
    {
    
    $('body').on("click",'.heart',function()
    {
        
        var A=$(this).attr("id");
        var B=A.split("like");
        var messageID=B[1];
        var C=parseInt($("#likeCount"+messageID).html());
        $(this).css("background-position","")
        var D=$(this).attr("rel");
       
        if(D === 'like') 
        {      
        $("#likeCount"+messageID).html(C+1);
        $(this).addClass("heartAnimation").attr("rel","unlike");
        
        }
        else
        {
        $("#likeCount"+messageID).html(C-1);
        $(this).removeClass("heartAnimation").attr("rel","like");
        $(this).css("background-position","left");
        }


    });


    });
</script>

</head>

<body>
		<!----start-header--------- -->
				<div class="header_bg">

					<div class="wraphr">
						<div class="header">
							<!--------start-logo---- -->
							<div class="logo">
								<a href="index.html"><img src="images/logococa.png" alt="" /></a>
							</div>	
							<!--------end-logo------- -->
							<!----start-nav------ -->	
							<div class="nav">
								<ul>
								   <li class="active"><a href="#home">Inicio</a></li>
								   <li><a href="#">REDES SOCIALES</a></li>
								   <li><a href="#">COCA-COLA.FM</a></li>
								   <li><a href="#">COCA-COLA ZERO</a></li>
								   <li><a href="#">COCA-COLA LIFE</a></li>
								   <li><a href="#">COCA-COLA LIGHT</a></li>
								   <li><a href="#">VIDEOS</a></li>
								 <div class="clear"> </div>
								 </ul>
							</div>
							<!-----end-nav------ -->
							<div class="clear"> </div>
						</div>
					</div>

				</div>
		<!------end-header---------- -->


<div class="ads_super">
                    <img src="images/ad3.png" class="adspleca" />
                    </div>

<div class="dashboard">
    <div class="videoplayer">
        <iframe src="http://amp.televisa.com/embed/embed_jw.php?id=338650" frameborder="0" class="iframe-videoplayer" allowfullscreen></iframe>
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default senal-uno">CARPA</button>
          </div>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default senal-tres">VL</button>
          </div>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default senal-dos">TECATE</button>
          </div>
        </div>
    </div>
    <div class="aside">
        <img src="images/chat.png" class="img_chat" />
    </div>
    <div class="clear"></div>
</div>


</div>
<!-----end-slider-------->

<div id="timeline-embed"></div>
<script type="text/javascript">
        var timeline_config = {
         width: "100%",
         height: "230",
         source: 'https://docs.google.com/spreadsheets/d/1QlsCtV1qnnyPCIxmsSyFqRJ3RJdcFE85ccNlpJYj5_Q/pubhtml',
          start_zoom_adjust: '1',
          lang: 'es'
        }
      </script>

	<script type="text/javascript" src="js/storyjs-embed.js"></script>





<div class="row social_twitter_cards">

    <h2 class="titles_section">¿Cuál es tu genero favorito?</h2>

    <section class="kratos-information">
        <article class="kratos-information__content">
            <h4 class="kratos-information__content-title">#SoyRock</h4>
            <p class="kratos-information__content-cifra">%65</p>
        </article>
        <article class="kratos-information__content">
            <h4 class="kratos-information__content-title">#SoyPop</h4>
            <p class="kratos-information__content-cifra">%35</p>
        </article>
    </section>

</div>


<div class="apoya_bandas">

    <h2 class="titles_section">Sigue y apoya a tus bandas</h2>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">LOS AUTÉNTICOS DECADENTES</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">DLD</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">ROCK TU IDIOMA SINFÓNICO</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">ABOMINABLES</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">CARLA MORRISON</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">SILVA DE ALEGRÍA</p></div></article>


    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">AGRUPACIÓN CARIÑO</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">APOLO</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">CHARLIE RODD</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">CHETES</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">OF MONSTERS AND MEN</p></div></article>

    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">THE PRODIGY</p></div></article>


    <article class="hd-torneocard"><div class="hd-torneocard__iconwrapper"><div class="hd-torneocard__icon">
        
        <div class="heart " id="like1" rel="like"></div>

    </div></div><div class="hd-torneocard__data"><p class="hd-torneocard__title">VICENTICO</p></div></article>



</div>




<div class="middleads">
                    <img src="images/ad2.png" class="adspleca" /></div>


<div class="row social_juntos">

	<h2 class="titles_section">Juntos somos #ViveLatino2016</h2>

	<!-- CARD -->
  <div class="col-xs-12 col-sm-4 col-md-3">
			<blockquote class="twitter-tweet" data-lang="es"><p lang="es" dir="ltr">.<a href="https://twitter.com/ikvoficial">@ikvoficial</a> tiene nuevo sencillo que se llama &quot;Gallo negro&quot;: <a href="https://t.co/Sy0yrvfyWH">https://t.co/Sy0yrvfyWH</a> ¿Qué opinas de él?</p>&mdash; vivelatino (@vivelatino) <a href="https://twitter.com/vivelatino/status/703347074226479105">26 de febrero de 2016</a></blockquote>
	</div>
	<!-- END CARD -->

	<!-- CARD -->
  <div class="col-xs-12 col-sm-4 col-md-3">
			<blockquote class="twitter-tweet" data-lang="es"><p lang="es" dir="ltr">Musicaliza tu fin de semana con los sonidos que darán vida al <a href="https://twitter.com/hashtag/VL16?src=hash">#VL16</a> el 23 y 24 de abril: <a href="https://t.co/G2JuCZsFbD">https://t.co/G2JuCZsFbD</a> <a href="https://twitter.com/hashtag/YoVivoElVive?src=hash">#YoVivoElVive</a></p>&mdash; vivelatino (@vivelatino) <a href="https://twitter.com/vivelatino/status/703382562572349440">27 de febrero de 2016</a></blockquote>
	</div>
	<!-- END CARD -->

	<!-- CARD -->
  <div class="col-xs-12 col-sm-4 col-md-3">
			<blockquote class="twitter-tweet" data-lang="es"><p lang="es" dir="ltr"><a href="https://twitter.com/hashtag/YoVivoElVive?src=hash">#YoVivoElVive</a> con la jazzista mexicana <a href="https://twitter.com/ingridebp">@ingridebp</a>, quien compartirá su &quot;cuento&quot; sonora con el <a href="https://twitter.com/hashtag/VL16?src=hash">#VL16</a> el 24 de abril: <a href="https://t.co/mgY35uDOH4">https://t.co/mgY35uDOH4</a></p>&mdash; vivelatino (@vivelatino) <a href="https://twitter.com/vivelatino/status/703002486353711104">25 de febrero de 2016</a></blockquote>
	</div>
	<!-- END CARD -->

    <!-- CARD -->
  <div class="col-xs-12 col-sm-4 col-md-3">
            <blockquote class="twitter-tweet" data-lang="es"><p lang="es" dir="ltr">Como parte de la nueva ola de la música colombiana <a href="https://twitter.com/hashtag/YoVivoElVive?src=hash">#YoVivoElVive</a> con la fusión de ritmos que propone <a href="https://twitter.com/LACHIVAGANTIVA">@LACHIVAGANTIVA</a> <a href="https://t.co/n2UyGQ0hn5">https://t.co/n2UyGQ0hn5</a></p>&mdash; vivelatino (@vivelatino) <a href="https://twitter.com/vivelatino/status/702255326083461121">23 de febrero de 2016</a></blockquote>
    </div>
    <!-- END CARD -->


<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

</div>

     	</div>




<!----start-header--------- -->
                <div class="header_bg">

                    <div class="wraphr"> 
                            <div class="nav">
                                <ul>
                                   <li class="active"><a href="#home">Inicio</a></li>
                                   <li><a href="#">REDES SOCIALES</a></li>
                                   <li><a href="#">COCA-COLA.FM</a></li>
                                   <li><a href="#">COCA-COLA ZERO</a></li>
                                   <li><a href="#">COCA-COLA LIFE</a></li>
                                   <li><a href="#">COCA-COLA LIGHT</a></li>
                                   <li><a href="#">VIDEOS</a></li>
                                 <div class="clear"> </div>
                                 </ul>
                            </div>
                            <!-----end-nav------ -->
                    </div>

                </div>
        <!------end-header---------- -->



                    <footer class="copyright" itemprop="breadcrumb" role="contentinfo">
            <p>© 2016 <a target="_blank" href="http://www.coca-colamexico.com.mx">The Coca-Cola Company</a>, todos los derechos reservados, <a target="_blank" href="/es/terminos-y-condiciones/">Términos y Condiciones</a> | <a target="_blank" href="/es/Aviso_de_Privacidad/">Aviso de Privacidad</a> | <a target="_blank" href="http://beverageinstitute.org">Instituto de Bebidas para la Salud y Bienestar</a></p>
<p><a target="_blank" href="http://www.fundacioncoca-cola.com.mx/">Fundación Coca-Cola</a> | <a target="_blank" href="http://www.sustentabilidadcoca-cola.com.mx">Informe de Sustentabilidad</a> | <a target="_blank" href="http://www.coca-colamexico.com.mx">Coca-Cola México</a> | <a href="http://www.coca-colamexico.com.mx/trabaja_con_nosotros.html" target="_blank">Trabaja con Nosotros</a>&nbsp; | <a href="/es/politicas-redes/">Politicas Redes</a> | Política de Cookies</p>
<p>
                </p>
        </footer>



</body>
</html>