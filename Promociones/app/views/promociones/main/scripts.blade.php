@section('scripts')
	
	{{ HTML::script('js/promociones/tvsyload.js') }}
	{{ HTML::script('js/promociones/jquery-2.1.1.min.js') }}
	{{ HTML::script('js/promociones/tvsa.loadimg.js') }}
	{{ HTML::script('js/promociones/headertelevisaConfigurable.js',array('async'=>'async','charset'=>'utf-8')) }}
	{{ HTML::script('js/promociones/footertelevisaCQconfig.min.js') }}
	{{ HTML::script('js/promociones/head.load.min.js') }}
	{{ HTML::script('js/promociones/finalpage-libs.js',array('id'=>'libs')) }}

<script type="text/javascript">

<?php $sectionTable = array('previo' => 'home.nota-previa','login'=>'home.promo-activa','cierre'=>'participar.concurso-finalizado','confirmacion'=>'participar.confirmar-informacion','frase'=>'participar.nombre-de-la-dinamica.presentacion','espera'=>'participar.espera','gracias'=>'participar.gracias','TOS'=>'terminos-de-servicio','avisoPrivacidad'=>'politica-de-privacidad','basesConcurso'=>'bases-del-concurso');?>

  	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '{{(isset($info->properties["uat"]))?$info->properties["uat"]:''}}']);
	_gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script type="text/javascript">
<!-- Begin DAx code -->
// <![CDATA[




function udm_(e){var t="comScore=",n=document,r=n.cookie,i="",s="indexOf",o="substring",u="length",a=2048,f,l="&ns_",c="&",h,p,d,v,m=window,g=m.encodeURIComponent||escape;if(r[s](t)+1)for(d=0,p=r.split(";"),v=p[u];d<v;d++)h=p[d][s](t),h+1&&(i=c+unescape(p[d][o](h+t[u])));e+=l+"_t="+ +(new Date)+l+"c="+(n.characterSet||n.defaultCharset||"")+"&c8="+g(n.title)+i+"&c7="+g(n.URL)+"&c9="+g(n.referrer),e[u]>a&&e[s](c)>0&&(f=e[o](0,a-8).lastIndexOf(c),e=(e[o](0,f)+l+"cut="+g(e[o](f+1)))[o](0,a)),n.images?(h=new Image,m.ns_p||(ns_p=h),h.src=e):n.write("<","p","><",'img src="',e,'" height="1" width="1" alt="*"',"><","/p",">")};

function uid_call(a, b){
ui_c2 = 6035759;
ui_ns_site = '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}';
window.b_ui_event = window.c_ui_event != null ? window.c_ui_event:"",window.c_ui_event = a;
var ui_pixel_url = 
'http://b.scorecardresearch.com/p?c1=2&c2='+ui_c2+'&ns_site='+ui_ns_site+'&name='+a+'&ns_type=hidden&type=hidden&ns_ui_type='+b;

var b="comScore=",c=document,d=c.cookie,e="",f="indexOf",g="substring",h="length",i=2048,j,k="&ns_",l="&",m,n,o,p,q=window,r=q.encodeURIComponent||escape;if(d[f](b)+1)for(o=0,n=d.split(";"),p=n[h];o<p;o++)m=n[o][f](b),m+1&&(e=l+unescape(n[o][g](m+b[h])));ui_pixel_url+=k+"_t="+ +(new Date)+k+"c="+(c.characterSet||c.defaultCharset||"")+"&c8="+r(c.title)+e+"&c7="+r(c.URL)+"&c9="+r(c.referrer)+"&b_ui_event="+b_ui_event+"&c_ui_event="+c_ui_event,ui_pixel_url[h]>i&&ui_pixel_url[f](l)>0&&(j=ui_pixel_url[g](0,i-8).lastIndexOf(l),ui_pixel_url=(ui_pixel_url[g](0,j)+k+"cut="+r(ui_pixel_url[g](j+1)))[g](0,i)),c.images?(m=new Image,q.ns_p||(ns_p=m),m.src=ui_pixel_url):c.write("<p><img src='",ui_pixel_url,"' height='1' width='1' alt='*'></p>");
}

udm_('http'+(document.location.href.charAt(4)=='s'?'s://sb':'://b')+'.scorecardresearch.com/b?c1=2&c2=6035759&ns_site={{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}&name={{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.promocion.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.{{$sectionTable[$adUnit]}}&ns_hvid=1&ns_hgal=1&category=promociones');

// ]]>



/* Boton de Confirmar */

$("#confirmar").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.confirmar-informacion.confirmar', 'clickout'); 
	_gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'confirmar-informacion', 'confirmar']);
});

/*  Boton de Enviar */

$("#enviar").on('click',function(){

	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.participar.frase.enviar', 'clickout'); 
	_gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'participar.frase', 'enviar']);
});

function start_metrics_buttons(){


	$("#widgetSocialShare2 .twitter").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-superior-redes-sociales.twitter', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-superior-redes-sociales', 'twitter']);
	});

	$("#widgetSocialShare2 .facebook").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-superior-redes-sociales.facebook', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-superior-redes-sociales', 'facebook']);
	});

	$("#widgetSocialShare2 .google").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-superior-redes-sociales.google-plus', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-superior-redes-sociales', 'google-plus']);
	});


	$("#widgetSocialShare2 .mail").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-superior-redes-sociales.mail', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-superior-redes-sociales', 'mail']);
	});

	$("#widgetSocialShare2 .pinterest").on('click',function(){
	uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-superior-redes-sociales.pinterest', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-superior-redes-sociales', 'pinterest']);
	});
}
	
	$(".redes .twitter").on('click',function(){
uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-participar-redes-sociales.twitter', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-participar-redes-sociales', 'twitter']);
});

	$(".redes .facebook").on('click',function(){
uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-participar-redes-sociales.facebook', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-participar-redes-sociales', 'facebook']);
});

	$(".redes .google").on('click',function(){
uid_call('{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}.botonera-participar-redes-sociales.google-plus', 'clickout'); _gaq.push(['_trackEvent', '{{(isset($info->properties["vertical"]))?$info->properties["vertical"]:''}}.{{(isset($info->properties["namePromotion"]))?$info->properties["namePromotion"]:''}}', 'botonera-participar-redes-sociales', 'google-plus']);
});

</script>



<noscript><p><img src="https://b.scorecardresearch.com/p?c1=2&c2=6035759&ns_site={{(isset($info->properties['vertical']))?$info->properties['vertical']:''}}&name={{(isset($info->properties['vertical']))?$info->properties['vertical']:''}}.promocion.{{(isset($info->properties['namePromotion']))?$info->properties['namePromotion']:''}}.{{(isset($info->properties['nameSectionTable']))?$info->properties['nameSectionTable']:''}}&ns_hvid=1&ns_hgal=1&category=promociones" height="1" width="1" alt="*" id='noScriptImg'></p></noscript>


<!-- End DAx code -->

</noscript>

<!-- Begin DAx code -->

<script type="text/javascript" language="JavaScript1.3" 

src="https://sb.scorecardresearch.com/c2/6035759/ct.js"></script>

<!-- End DAx code -->
@show