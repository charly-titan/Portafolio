function loadScript(i,t){var e=document.createElement("script");return e.setAttribute("type","text/javascript"),e.setAttribute("src",i),"undefined"!=typeof t&&e.setAttribute("charset",t),document.getElementsByTagName("body")[0].appendChild(e),!0}var $container,init="",$md=!1,$mt=!1,$ms=!1,cubo=1,portrait=0,inicio=0,nvueltas=0,pagination=null,layuot_options=null,mq_desktop=null,mq_tablet=null,mq_movil=null,maxitems=0,secondArr={},counter=0,firstArr=[["169","300x169","mm-amarillo"],["225","300x225",""],["457","343x457","mm-amarillo"],["225","300x225",""],["169","300x169",""],["tesugerimos","300x400","mm-amarillo"],["457","343x457","mm-amarillo"],["169","300x169",""],["225","300x225",""],["portrate","300x600",""],["225","300x225",""],["negro","300x169","mm_negro"],["457","343x457","mm-amarillo"],["225","300x225",""],["225","300x225",""]],secondArr=[["169","300x169","mm-amarillo"],["225","300x225",""],["box_banner","300x250",""],["225","300x225",""],["169","300x169",""],["457","343x457","mm-amarillo"],["457","343x457","mm-amarillo"],["169","300x169",""],["225","300x225",""],["457","343x457",""],["225","300x225",""],["negro","300x169","mm_negro"],["457","343x457",""],["169","300x169",""],["169","300x169",""]];!function(i){function t(){a.each(function(){var t=i(this),e=t.width(),a=t.height(),n=t.data("resize");(e!==n.w||a!==n.h)&&(n.w=e,n.h=a,t.triggerHandler("resize"))}),e=setTimeout(t,250)}var e,a=i([]);i.event.special.resize={setup:function(){var e=i(this);a=a.add(e),e.data("resize",{w:e.width(),h:e.height()}),1===a.length&&t()},teardown:function(){var t=i(this);a=a.not(t),t.removeData("resize"),a.length||clearTimeout(e)}}}(jQuery);var mv={};mv.init=function(){$(".mv-relacionado-container").owlCarousel({items:1,navigation:!0,customNavigation:!0,lazyLoad:!0,controlClass:"owl-nav",navClass:["mv-prev","mv-next"],responsive:!0,singleItem:!0,mouseDrag:!1,touchDrag:!1}),$(window).width()>948&&$(".mv-elemento-relacionado").each(function(){$(this).children("h4").hover(function(){$(this).parent().toggleClass("hovered")})})};var func={bannerInit:function(i){"undefined"!=typeof googletag&&(googletag.cmd.push(function(){var t=googletag.sizeMapping().addSize([980,140],[300,250]).addSize([740,140],[728,90]).addSize([320,140],[320,50]).build();googletag.defineSlot(adUnit,[300,250],i).defineSizeMapping(t).addService(googletag.pubads()).setTargeting("position","middle-btf"),googletag.display(i)}),cubo++)},bannerPortraitInit:function(i){"undefined"!=typeof googletag&&(googletag.cmd.push(function(){var t=googletag.sizeMapping().addSize([980,140],[300,600]).addSize([740,140],[]).addSize([320,140],[]).build();googletag.defineSlot(adUnit,[300,600],i).defineSizeMapping(t).addService(googletag.pubads()).setTargeting("position","middle-btf"),googletag.display(i)}),portrait++)},mediaDesktop:function(){idCubo="banner_box_"+cubo,$(".box_banner_"+cubo).html('<div class="banner-grid"><article class="publicidad"><p>PUBLICIDAD</p><div id="'+idCubo+'" class="mm-img"></div></article></div>'),func.bannerInit(idCubo),func.mediaDesktopPortrait()},mediaDesktopPortrait:function(){idPortrait="portrait_banner_"+portrait,$(".portrait_banner_"+portrait).length&&($(".portrait_banner_"+portrait).html('<div class="banner-grid"><article class="publicidad"><p>PUBLICIDAD</p><div id="'+idPortrait+'" class="mm-img"></div></article></div>'),func.bannerPortraitInit(idPortrait))},mediaTablet:function(){idCubo="banner_box_"+cubo,$(".box_banner_"+cubo).html('<div class="banner-grid"><article class="publicidad"><p>PUBLICIDAD</p><div id="'+idCubo+'" class="mm-img"></div></article></div>'),func.bannerInit(idCubo)},mediaSmartPhone:function(){$(".box_banner").html('<img class="mm-img" href="#" src="../../..http://i2.esmas.com/finalpage/entretenimiento/images/banner1.png" width="300" height="225">')},media_desktop:function(i){i&&"function"==typeof i&&($md||(i(),$md=!0,$mt=!1,$ms=!1))},media_tablet:function(i){i&&"function"==typeof i&&($mt||(i(),$md=!1,$mt=!0,$ms=!1))},media_smartphone:function(i){i&&"function"==typeof i&&($ms||(i(),$md=!1,$mt=!1,$ms=!0))},share_reload:function(){try{socialShare.indexNotesExpanded()}catch(i){}},comunities_load:function(){function i(){e++,"undefined"==typeof init_comunidades&&(viewing.init(),clearTimeout(t)),e>20&&clearTimeout(t)}try{var t,e=0;loadScript("http://comentarios.esmas.com/js/communities.js"),t=setInterval(i,3e3)}catch(a){}},quitar_biografias:function(i){var i=i.toLowerCase();return i=i.replace("biografias/","")}},gridFluido={colWidth:function(){var columnNum=1,columnWidth=0,columnWidths=0;w=$container.width();var margenes=eval($container.data("margins"));return null===mq_desktop?!1:(w>mq_desktop?(columnNum=3,marginst=margenes[0][0],marginsl=margenes[0][1]):w>mq_tablet?(columnNum=3,marginst=margenes[1][0],marginsl=margenes[1][1]):w>=mq_movil&&(columnNum=2,marginst=margenes[2][0],marginsl=margenes[2][1]),$container.find(".item").each(function(){var $item=$(this),ivisible=!0,ww=$container.width();columnWidths=(ww-marginsl*(columnNum-1))/columnNum;var column=eval($item.data("options")),wd=$container.width();wd>mq_desktop?(columns=column[0],ivisible=column[3]):wd>mq_tablet?(columns=column[1],ivisible=column[4]):wd>mq_movil&&(columns=column[2],ivisible=column[5]),3==columns?width=columnWidths*columnNum+2*marginsl:2==columns?width=columnWidths*columnNum:1==columns&&(width=columnWidths),$container.css(mq_desktop>wd?{"padding-right":marginsl,"padding-left":marginsl}:{padding:0}),ivisible?$item.css({width:width,"margin-bottom":marginst}).removeClass("h0"):$item.css({width:0,transform:"none",margin:0}).addClass("h0")}),columnWidth)},widthGutter:function(){var columnNum=1;w=$container.width(),index=0,marginl=0;var margenes=eval($container.data("margins"));return null===mq_desktop?!1:(w>mq_desktop?(columnNum=3,marginst=margenes[0][0],marginsl=margenes[0][1],func.media_desktop(func.mediaDesktop)):w>mq_tablet?(columnNum=3,marginst=margenes[1][0],marginsl=margenes[1][1],func.media_tablet(func.mediaTablet)):w>=mq_movil&&(columnNum=2,marginst=margenes[2][0],marginsl=margenes[2][1],func.media_smartphone(func.mediaSmartPhone)),marginsl)},grid:function(){$container.isotope({itemSelector:".item",masonry:{columnWidth:gridFluido.colWidth(),gutter:gridFluido.widthGutter()}})},loadData:function(e){$(".btn_container").hide(),$(".loader").css("display","inline-block");var ritems=0,ultimo=0,bandera=0,arr_vueltas=0,layuot_options=eval($container.data("options")),mq_desktop=parseInt(layuot_options[0]),mq_tablet=parseInt(layuot_options[1]),mq_movil=parseInt(layuot_options[2]),w=$container.width();w>mq_desktop?pagination=eval($container.data("desktop")):w>mq_tablet?pagination=eval($container.data("tablet")):w>mq_movil&&(pagination=eval($container.data("smartphone"))),pagination_items=parseInt(pagination[0]),pagination_vueltas=parseInt(pagination[1]),maxitems=pagination_items,e.preventDefault();var $results,num=0,irefresh=0,sortType="meta:creationDate:D";return $md=!1,$mt=!1,$ms=!1,$(".btn_container").css("padding-top","55px"),$.gsa({GSA_domain:"http://googleak.esmas.com/search",GSA_query:$container.data("query"),GSA_num:maxitems,GSA_client:$container.data("client"),GSA_site:$container.data("site"),GSA_requiredfields:$container.data("requiredfields"),GSA_start:inicio,GSA_partialfields:$container.data("partialfields"),GSA_sort:sortType},function(data){if(data.RES){$results=$.gsa.results(data),ritems+=pagination_items;var elem="",finalizo=0,ww=0,hh=0,extras=!0,$image,tipo="",layuot_options=eval($container.data("options")),mq_desktop=parseInt(layuot_options[0]),mq_tablet=parseInt(layuot_options[1]),mq_movil=parseInt(layuot_options[2]);if($results){for(nvueltas++,i=0;i<maxitems;i++)if(i<=eval(data.RES["@attributes"].EN)-eval(data.RES["@attributes"].SN)){var contentType=$results[i].tipo,category="",categoryurl="",description_txt="",title=$results[i].title,urls=$results[i].URL,icono_vf="",url_actualsite="";if("articulo"==contentType)category=$results[i].category.toLowerCase().indexOf("biograf")>-1?"Famosos":$results[i].category,categoryurl=$results[i].categoryUrl.toLowerCase().indexOf("biograf")>-1?func.quitar_biografias($results[i].categoryUrl):$results[i].categoryUrl,description_txt=$results[i].summary;else if("galeria"==contentType){category="Fotogaler&iacute;as";var galUrl=$results[i].URL,galSpaces=galUrl.split("/"),numSpaces=galSpaces.length;numSpaces>3&&(url_actualsite="http://"+galSpaces[2]+"/"),categoryurl=url_actualsite+$results[i].url_canal,description_txt=$results[i].tituloLargo}for("undefined"!=typeof $container.data("icons_vf")?("undefined"!=typeof $results[i].extras&&$results[i].extras.indexOf("yt")>-1&&(icono_vf='<div class="mm-icon-container"><i class="tvsagui-video"></i></div>',extras=!1),"undefined"!=typeof $results[i].videosRelacionado&&extras?(icono_vf='<div class="mm-icon-container"><i class="tvsagui-video"></i></div>',extras=!0):"undefined"!=typeof $results[i].galeriasRelacionada&&(icono_vf='<div class="mm-icon-container"><i class="tvsagui-foto"></i></div>',extras=!0)):"galeria"==contentType&&(icono_vf='<div class="mm-icon-container"><i class="tvsagui-foto"></i></div>',extras=!0),arr=init&&1===nvueltas?firstArr:secondArr,bandera>=arr.length&&(bandera=0,arr_vueltas=i),j=0;j<arr.length;j++){if("169"==arr[j+bandera][0]){"articulo"==contentType?$image="undefined"!=typeof $results[i]["300x169"]?$results[i]["300x169"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"galeria"==contentType&&($image="undefined"!=typeof $results[i].thumbnail_url_300x169?$results[i].thumbnail_url_300x169:$results[i].thumbnail_url),ww=300,hh=169,tipo=arr[j+bandera][2],ultimo=arr.length*nvueltas;break}if("225"==arr[j+bandera][0]){"articulo"==contentType?$image="undefined"!=typeof $results[i]["300x225"]?$results[i]["300x225"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"galeria"==contentType&&($image="undefined"!=typeof $results[i].thumbnail_url_320x240?$results[i].thumbnail_url_320x240:$results[i].thumbnail_url),ww=300,hh=225,tipo=arr[j+bandera][2],ultimo=arr.length*nvueltas;break}if("457"==arr[j+bandera][0]){"articulo"==contentType?$image="undefined"!=typeof $results[i]["343x457"]?$results[i]["343x457"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"galeria"==contentType&&($image="undefined"!=typeof $results[i].thumbnailTop_url?$results[i].thumbnailTop_url:"undefined"!=typeof $results[i].thumbnail_url_320x240?$results[i].thumbnail_url_320x240:$results[i].thumbnail_url),ww=300,hh=400,tipo=arr[j+bandera][2],ultimo=arr.length*nvueltas;break}if("box_banner"==arr[j+bandera][0]){$image="articulo"==contentType?"undefined"!=typeof $results[i]["300x250"]?$results[i]["300x250"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"undefined"!=typeof $results[i].thumbnail_url_320x240?$results[i].thumbnail_url_320x240:$results[i].thumbnail_url,ww=300,hh=250,tipo="box_banner",ultimo=arr.length*nvueltas;break}if("portrate"==arr[j+bandera][0]){$image="articulo"==contentType?"undefined"!=typeof $results[i]["300x400"]?$results[i]["300x400"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"undefined"!=typeof $results[i].thumbnail_url_343x457?$results[i].thumbnail_url_343x457:$results[i].thumbnail_url,ww=300,hh=642,tipo="portrate",ultimo=arr.length*nvueltas;break}if("tesugerimos"==arr[j+bandera][0]){$image="articulo"==contentType?"undefined"!=typeof $results[i]["300x400"]?$results[i]["300x400"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"undefined"!=typeof $results[i].thumbnail_url_343x457?$results[i].thumbnail_url_343x457:$results[i].thumbnail_url,ww=300,hh=600,tipo="tesugerimos",ultimo=arr.length*nvueltas;break}if("negro"==arr[j+bandera][0]){"articulo"==contentType?$image="undefined"!=typeof $results[i]["300x169"]?$results[i]["300x169"]:"undefined"!=typeof $results[i]["300x150"]?$results[i]["300x150"]:$results[i]["120x90"]:"galeria"==contentType&&($image="undefined"!=typeof $results[i].thumbnail_url_300x169?$results[i].thumbnail_url_300x169:$results[i].thumbnail_url),ww=300,hh=169,tipo="mm-negro",ultimo=arr.length*nvueltas;break}}if(bandera++,elem="box_banner"==tipo?'<div class="item" data-options="[desktop=1, tablet=3, movil=2, desktop_visible=true, tablet_visible=false, movil_visible=false]"><div class="box_banner_'+cubo+" mm-container "+tipo+' grid-element" style="opacity: 0;"><div class="ads-300-x" style="opacity: 1;"><div class="title-ads">publicidadida</div><div id="ban03_televisa"><div id="google_ads_iframe_/5644/es.televisa.lifestyle/entretenimiento/home_1__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/5644/es.televisa.lifestyle/entretenimiento/home_1" name="google_ads_iframe_/5644/es.televisa.lifestyle/entretenimiento/home_1" width="300%" height="225" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style="background:transparent"></body></html>&quot;" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/5644/es.televisa.lifestyle/entretenimiento/home_1__hidden__" name="google_ads_iframe_/5644/es.televisa.lifestyle/entretenimiento/home_1__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style="background:transparent"></body></html>&quot;" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div></div></div></div>':"portrate"==tipo?'<div class="item" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=false, movil_visible=false]" style="width: '+ww+"px; height: "+hh+'px;"><div class="ads-300-x portrait_banner_'+portrait+' hidden-mobile hidden-tablet"><div class="title-ads">publicidad</div><div id="ban03_televisa"></div></div>':"tesugerimos"==tipo?'<div class="item icarrusel" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=true, movil_visible=true]"><article class="mv-container" id="masleido"><div class="mv-rel-content-container"><div class="mv-relacionado-container"></div><div class="owl-nav"><div class="mv-button mv-prev iu-btn disabled"><i class="tvsagui-flechaizquierda"></i></div><div class="mv-button mv-next iu-btn"><i class="tvsagui-flechaderecha"></i></div></div></div></article></div>':'<div class="item" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=true, movil_visible=true]"><div class="mm-container '+tipo+' grid-element" style="opacity: 0;"><a href="'+categoryurl+'" class="mm-topic-a"><div class="mm-topic iu-btn"><span>'+category+'</span></div></a><a href="'+urls+'" class="mm-vinculo"><div class= "mm-img-container"><img class="mm-img" href="#" src="'+$image+'" alt="'+title+'">'+icono_vf+'</div><h3 class="mm-content-title">'+title+'</h3><div class="mm-text-container"><p>'+description_txt+'</p></div></a><div class="mm-social"><div href="#" class="mm-compartir"><span>Comparte la nota</span></div><div href="#" class="mm-social-icons" data-comm-share="true" data-comm-img="'+$image+'" data-comm-url="'+urls+'" data-comm-title="'+title+'"></div></div></div></div>',null!==urls&&0===$("#iso [href='"+urls+"']").length&&$container.isotope("insert",$(elem)),"tesugerimos"==tipo)try{mv.init()}catch(e){}$container.on("layoutComplete",function(){w>mq_desktop?func.media_desktop(func.mediaDesktop):w>mq_tablet?func.media_tablet(func.mediaTablet):w>mq_movil&&func.media_smartphone(func.mediaSmartPhone)}),inicio+=1}else finalizo++;nvueltas>=pagination_vueltas||finalizo>0?($(".btn_container").hide(),$(".infinite-scrolling").css("margin-bottom","24px")):$(".btn_container").show();var show=setTimeout(function(){$(".item").children(0).css("opacity",1),$(".loader").css("display","none"),$(".btn_container").css("padding-top","0px"),gridFluido.grid(),func.share_reload(),clearTimeout(show),func.comunities_load()},100);$("#iso .item").resize(function(){gridFluido.grid()}),$(window).trigger("scroll")}}else $(".loader").css("display","none");w>mq_desktop&&func.mediaDesktopPortrait()}),!1}};$(document).ready(function(){$container=$(".layout"),colWidth=gridFluido.colWidth(),widthGutter=gridFluido.widthGutter(),grid=gridFluido.grid(),layuot_options=eval($container.data("options")),mq_desktop=parseInt(layuot_options[0]),mq_tablet=parseInt(layuot_options[1]),mq_movil=parseInt(layuot_options[2]),init=eval($container.data("autoinit")),w=$container.width(),w>=mq_desktop?pagination=eval($container.data("desktop")):w>=mq_tablet?pagination=eval($container.data("tablet")):w>=mq_movil&&(pagination=eval($container.data("smartphone"))),maxitems=parseInt(pagination[0]),parseInt(pagination[1])>0&&$(".btn_container").show(),$(".btn_container").on("click",gridFluido.loadData),init&&$(".btn_container").trigger("click"),$(window).on("resize",gridFluido.grid),$("#iso .item").resize(gridFluido.grid),gridFluido.grid()}),window.onload=function(){gridFluido.grid()};