﻿if(typeof jQuery==="undefined"){console.error("Header Global: Error al cargar el header, es necesario jQuery.")}jQuery.fn.headerTelevisa=function(){var b=jQuery(this[0]);var a=b.find("#nav-mobil-menu");function d(){var l=new Array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");var k=new Array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");f=new Date();b.find("div.topnav span.date").html(k[f.getDay()]+" "+f.getDate()+" "+l[f.getMonth()]+", "+g(f.getHours())+":"+g(f.getMinutes()));f=null}function g(k){return(k>9?k:"0"+k)}function j(){if(jQuery(window).width()>623){a.show()}else{b.find(".collapsable-verticals").hide();a.hide()}}b.find("#menu").on("click",function(k){k.preventDefault();a.slideToggle();jQuery(this).toggleClass("active")});var c=b.find(".search_term");b.find(".search_submit").on("click",function(k){if(c.val()===""){k.preventDefault();jQuery("#suggest_term > option").remove();if(b.find("div.topnav div.inner>a.menu").css("display")==="none"){if(c.is(":hidden")){c.css("width","0px").show().animate({width:"180px"},{duration:500}).focus()}else{c.animate({width:"0px"},500,function(){jQuery(this).hide()})}}else{c.css("width","100%").slideToggle()}c.focus();return false}else{k.preventDefault();term=b.find(".search_term").val();term=term.replace(" ","+");window.open("http://result.televisa.com/universal/#"+encodeURI(term),"_blank");c.val("").toggle()}});c.on("keyup",function(k){locked=jQuery("form.site_search").data("locked");if((!locked||locked===undefined)&&jQuery("input.search_term").val().length>2){e()}else{jQuery("#suggest_term > option").remove()}});function e(){$query=jQuery("input.search_term").val();jQuery("#suggest_term > option").remove();jQuery.ajax({dataType:"jsonp",contentType:"application/json",url:"http://result.televisa.com/universal/search-responder-tvsa.php",cache:true,async:false,jsonpCallback:"searchAsYouType",data:{query:$query},beforeSend:function(){jQuery("form.site_search").data("locked",true)},success:function(k){jQuery.each(k.results,function(l,m){jQuery("#suggest_term").append(jQuery("<option>",{value:m.name}))})},complete:function(){jQuery("form.site_search").data("locked",false)},error:function(){jQuery("form.site_search").data("locked",false);console.error("Log Busqueda: Error ajax al cargar datos de busqueda")}})}jQuery(window).on("resize",function(k){k.preventDefault();j()});j();b.find(".collapsable-verticals").hide();d();h();function h(){setInterval(function(){d()},30000)}};jQuery.fn.headerTelevisaRender=function(b){jQuery(window).on("resize",function(n){n.preventDefault();m();k()});function m(){$menu.find("div.collapsable-verticals div.inner>div div.big-news a strong").each(function(n,o){tem=jQuery(o).data("text");salto=0;trun=tem.substring(0,65);if(jQuery(o).height()>=80){trun=trun.substring(0,60);for(i=0;i<trun.length;i++){if(tem[i]===" "){salto=i}}trun=trun.substring(0,salto)}jQuery(o).html(trun)})}function k(o,p,q,n){w=jQuery(window).width();nav=jQuery("#nav-mobil-menu>ul>li");if(w<624&&l()){jQuery.each(nav,function(){pc=jQuery(this).find("a").data("pcolor");jQuery(this).css("background-color",pc);jQuery(this).find("a").attr("href",jQuery(this).find("a").data("href"))})}else{nav.css("background-color","transparent");jQuery.each(nav,function(){jQuery(this).find("a").attr("href","#")});jQuery("div.collapsable-verticals div.inner>div em.sectiontitle.color-text").css("color",o);jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div.filtering a i").css("color",q);jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div.filtering a").hover(function(){jQuery(this).find("i").css("color",n)},function(){jQuery(this).find("i").css("color",q)});jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div .maintitle").hover(function(){jQuery(this).css("color",n)},function(){jQuery(this).css("color",q)});jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div strong.maintitle.color-text").css("color",q);jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div a small.color-text.topic").css("color",p);jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div.big-news small.topic").css("color",p)}}function a(o){w=jQuery(window).width()/2-40+"px";jQuery("#nav_header_televisa div.collapsable-verticals").append(jQuery("<div>",{id:"canvasloader-container",style:"padding-left: "+w+"; padding-top: 200px;"}));var n=new CanvasLoader("canvasloader-container");n.setColor("#ababab");n.setShape("square");n.setDiameter(80);n.setDensity(80);n.setRange(0.8);n.setSpeed(2);n.setFPS(20);n.show()}function c(n){var o,p=document.createElement("p");p.innerHTML=n;o=p.textContent||p.innerText;p=null;return o}function j(){jQuery("#nav_header_televisa").headerTelevisa();k();jQuery("#nav-mobil-menu>ul>li>a").on("click",function(n){w=jQuery(window).width();cp=jQuery(this).data("pcolor");cs=jQuery(this).data("scolor");ct=jQuery(this).data("tcolor");cc=jQuery(this).data("ccolor");if(w>623){n.preventDefault();type=jQuery(this).data("collapsable");coll=jQuery("#nav_header_televisa div.collapsable-verticals");if(coll.attr("id")=="collapsable-"+type){coll.slideToggle();jQuery(this).toggleClass()}else{if(coll.css("display")!="none"){coll.slideToggle(0,function(){$collapsable=jQuery("#nav_header_televisa div.collapsable-verticals").empty();d(type,cp,cs,ct,cc);coll.slideToggle(0);a(cp);coll.attr("id","collapsable-"+type);coll.attr("data-name",type.replace("data-",""))})}else{$collapsable=jQuery("#nav_header_televisa div.collapsable-verticals").empty();d(type,cp,cs,ct,cc);coll.slideToggle();a(cp);coll.attr("id","collapsable-"+type);coll.attr("data-name",type.replace("data-",""))}jQuery.each(jQuery("#nav-mobil-menu>ul>li>a"),function(o,p){if(coll.css("display")!="none"&&jQuery(p).data("collapsable")==type){jQuery(p).addClass("active")}else{jQuery(p).removeClass("active")}})}}else{jQuery(this).submit()}})}function d(r,o,p,q,n){base="http://feeds.noticierostelevisa.esmas.com/menutelevisa-com/";url_base=base+"nav_"+r.replace("data-","")+".js";jQuery.ajax({dataType:"jsonp",encoding:"ISO-8859-1",url:url_base,cache:true,jsonpCallback:"collapsable",success:function(s){g(s);if(r==="data-deportes"){jQuery(".big-news").remove();jQuery(".small-news").css("margin-left","0");jQuery(".collapsable-content-inner").append(jQuery("<div>",{id:"MXMSection"}));jQuery("#MXMSection").mxmTelevisaDeportes(o,p)}m();k(o,p,q,n)},error:function(){console.error("Log Header: Error ajax al cargar datos colapsable "+r)}})}function l(){return !!document.createElement("video").canPlayType}function e(){if(l()){jQuery("head").append('<link rel="stylesheet" href="http://i2.esmas.com/hf/header/css/headertelevisa.min.css">');var n=n||[];n.push(["_setAccount","UA-1776907-2"]);(function(){var p=document.createElement("script");p.type="text/javascript";p.async=true;p.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var q=document.getElementsByTagName("script")[0];q.parentNode.insertBefore(p,q)})()}else{document.createElement("nav");document.createElement("header");jQuery("head").append('<link rel="stylesheet" href="http://i2.esmas.com/hf/header/css/headertelevisaNoHTML5.min.css">')}var o={logo:{title:"Ir a Televisa",link:"http://www.televisa.com",target:"_self"},menu:[{id_nav:1,title:"Televisi\u00f3n",id:"data-television",value:"Televisi\u00f3n",url:"http://television.televisa.com",target:"_blank",Pcolor:"#F68428",Scolor:"#DCC224",Tcolor:"#BE5031",Ccolor:"#F76A42"},{id_nav:2,title:"Deportes",id:"data-deportes",value:"Deportes",url:"http://deportes.televisa.com/",target:"_blank",Pcolor:"#A70A0B",Scolor:"#D6A256",Tcolor:"#6F0707",Ccolor:"#A90B0B"},{id_nav:3,title:"Noticieros",id:"data-noticieros",value:"Noticieros",url:"http://noticieros.televisa.com/",target:"_blank",Pcolor:"#0078C0",Scolor:"#AFBF24",Tcolor:"#36378B",Ccolor:"#4A4BC0"},{id_nav:4,title:"Entretenimiento",id:"data-entretenimiento",value:"Entretenimiento",url:"http://www2.esmas.com/entretenimiento/",target:"_blank",Pcolor:"#E2B528",Scolor:"#2FC8BB",Tcolor:"#2FC8BB",Ccolor:"#13BAAC"},{id_nav:5,title:"Esmas",id:"data-esmas",value:"Esmas",url:"http://www2.esmas.com/",target:"_blank",Pcolor:"#4972CE",Scolor:"#999999",Tcolor:"#3F61AE",Ccolor:"#6077AD"},{id_nav:6,title:"Ni\u00f1os",id:"data-ninos",value:"Ni\u00f1os",url:"http://ninos.televisa.com/",target:"_blank",Pcolor:"#3FB9B5",Scolor:"#F7D031",Tcolor:"#2C9692",Ccolor:"#3FCAC5"}]};h(o);j();jQuery("#nav_header_televisa div.topnav nav ul li a").removeClass("active")}function g(n){$collapsable=jQuery("#nav_header_televisa div.collapsable-verticals");$collapsable.empty().append(jQuery("<div>",{"class":"inner"}).append(jQuery("<div>",{"class":"collapsable-content open"}).append(jQuery("<div>",{"class":"collapsable-content-inner"}))));jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.collapsable-content-inner").append(jQuery("<a>",{rel:"nofollow",href:n.nameSection==="Noticieros"?"http://noticieros.televisa.com/":n.url,target:"_self",title:n.title,"data-name":"titulo-"+normalize(($("<textarea />").html(n.value.replace("Ir a ","")).text()).toLowerCase())}).append(jQuery("<strong>",{"class":"maintitle color-text",html:jQuery(window).width()<947?n.value.replace("Ir a ",""):n.value,"data-name":"titulo-"+normalize(($("<textarea />").html(n.value.replace("Ir a ","")).text()).toLowerCase())}).append(jQuery("<i>",{"class":"tvsaFH-double-caret-right",style:"padding-left: 10px; text-decoration: none;"}))),jQuery("<div>",{"class":"categories"}),jQuery("<div>",{"class":"featured"}),jQuery("<hr>",{"class":"clearboth"}),jQuery("<div>",{"class":"filtering"}));jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.collapsable-content-inner > a").on("click",function(o){if(typeof uid_call=="function"){var p=jQuery(this).attr("data-name");var q=jQuery("#nav_header_televisa div.collapsable-verticals").attr("data-name");uid_call("header-global.vertical."+q+"."+p,"clickout");_gaq.push(["_trackEvent","header-global","vertical."+q,p]);p=q=null}});jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.categories").append(jQuery("<em>",{"class":"sectiontitle color-text",html:n.categorias.title_category}),jQuery("<ul>"));jQuery.each(n.categorias.list_category,function(o,p){jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.categories ul").append(jQuery("<li>").append(jQuery("<a>",{rel:"nofollow",href:p.url,title:p.title,target:p.target,html:p.value,"data-name":"categorias.categoria-"+(o+1)+"."+normalize(($("<textarea />").html(p.value).text()).toLowerCase()).replace("+","mas").replace("&","").replace(/ /g,"_").replace(":","")})))});jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.categories ul li a").on("click",function(o){if(typeof uid_call=="function"){var p=jQuery(this).attr("data-name");var q=jQuery("#nav_header_televisa div.collapsable-verticals").attr("data-name");uid_call("header-global.vertical."+q+"."+p,"clickout");_gaq.push(["_trackEvent","header-global","vertical."+q,p]);p=q=null}});jQuery("#nav_header_televisa div.collapsable-verticals div.inner div.featured").append(jQuery("<em>",{"class":"sectiontitle color-text",html:n.destacados.title}),jQuery("<div>",{"class":"big-news"}),jQuery("<div>",{"class":"small-news"}));jQuery.each(n.destacados.notes,function(o,p){if(o>4){return false}noteTipo=(p.name_row_label==="topic_nota_main"?"big-news":"small-news");imgTipo=(p.name_row_label==="topic_nota_main"?p.img["300x209"]:p.img["84x67"]);jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div."+noteTipo).append(jQuery("<a>",{rel:"nofollow",href:p.url,"class":"item",target:p.target,"data-name":noteTipo==="big-news"?"big-news.nota":"small-news.nota-"+(o+(n.nameSection==="Deportes"?1:0))}).append(jQuery("<span>",{"class":"figure"}).append(jQuery("<img>",{src:c(imgTipo)||c(p.img["120x90"])||c(p.img["300x209"]),alt:"",width:noteTipo==="big-news"?"300":"84",height:noteTipo==="big-news"?"209":"67"})),jQuery("<span>",{"class":"figcaption"}).append(jQuery("<small>",{"class":"color-text topic",html:p.topic}),jQuery("<strong>",{html:p.titulo,"data-text":p.titulo}))))});jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div.featured a").on("click",function(o){if(typeof uid_call=="function"){var p=jQuery(this).attr("data-name");var q=jQuery("#nav_header_televisa div.collapsable-verticals").attr("data-name");uid_call("header-global.vertical."+q+"."+p,"clickout");_gaq.push(["_trackEvent","header-global","vertical."+q,p]);p=q=null}});jQuery.each(n.share,function(o,p){jQuery("#nav_header_televisa div.collapsable-verticals div.inner>div div.filtering").append(jQuery("<a>",{rel:"nofollow",href:p.url,title:p.title,target:p.targer}).append(jQuery("<i>",{"class":(p.tipo).replace("tvsa","tvsaFH")+" color-text",html:(!l()?p.title:"")}),jQuery("<i>",{"class":p.tipo==="tvsa-videocamera"||p.tipo==="tvsa-camera"?"color-text-title":"",html:p.tipo==="tvsa-videocamera"?"Videos":(p.tipo==="tvsa-camera"?"Fotos":"")})))})}function h(n){jQuery("body").prepend(jQuery("<header>",{"class":"nav_header_televisa",id:"nav_header_televisa"}).append(jQuery("<div>",{"class":"topnav"}),jQuery("<div>",{"class":"collapsable-verticals"})));$menu=jQuery("#nav_header_televisa");$menu.find("div.topnav").append(jQuery("<div>",{"class":"inner"}).append(jQuery("<a>",{rel:"nofollow",id:"menu","class":"menu",href:""}),jQuery("<a>",{rel:"nofollow","class":(b.biglogo?"logo big "+b.vertical:"logo"),href:n.logo.link,target:n.logo.target}).append(jQuery("<span>",{"class":"mobile-logo"}),jQuery("<span>",{"class":(b.vertical===false?"":b.vertical)})),jQuery("<span>",{"class":"date"}),jQuery("<form>",{"class":"site_search",target:"_blank"}),jQuery("<nav>",{id:"nav-mobil-menu"})));$menu.find(".site_search").append(jQuery("<button>",{"class":"search_submit",type:"submit"}).append(jQuery("<div>").append(jQuery("<i>",{"class":"tvsaFH-search"}))),jQuery("<input>",{type:"search","class":"search_term",value:"",placeholder:"Ingresa tu búsqueda aquí",list:"suggest_term",autocomplete:"off"}),jQuery("<datalist>",{id:"suggest_term"}));$menu.find("#nav-mobil-menu").append(jQuery("<ul>",{"class":(b.biglogo?"big":"")}));jQuery.each(n.menu,function(o,p){if(p.value===""||p.url===""){return false}$menu.find("#nav-mobil-menu>ul").append(jQuery("<li>").append(jQuery("<a>",{rel:"nofollow",html:p.value,target:p.target,"data-href":p.url,"data-collapsable":p.id,"data-pcolor":p.Pcolor,"data-scolor":p.Scolor,"data-tcolor":p.Tcolor,"data-ccolor":p.Ccolor,"data-name":(p.id).replace("data-","")})))});$menu.find("div.topnav a.logo").on("click",function(o){if(typeof uid_call=="function"){uid_call("header-global.principal.logo-televisa","clickin");_gaq.push(["_trackEvent","header-global","principal","logo-televisa"])}});$menu.find("#nav-mobil-menu>ul li a").on("click",function(o){if(typeof uid_call=="function"){var p=jQuery(this).attr("data-name");uid_call("header-global.principal."+p,"clickin");_gaq.push(["_trackEvent","header-global","principal",p]);p=null}})}e()};jQuery.fn.mxmTelevisaDeportes=function(e,g){var a=jQuery(this[0]);var d="http://static-televisadeportes.esmas.com/sportsdata/futbol/data/timetvjsonp.js";var c="http://static-televisadeportes.esmas.com/sportsdata/futbol/data/tickers/Ticker_1.js";var b="http://static-televisadeportes.esmas.com/sportsdata/futbol/data/tickers/";var j=0;function h(){jQuery.ajax({dataType:"jsonp",url:d,jsonpCallback:"timetv",success:function(n){var p=n.timetv;var o=n.fechatv;var q=p.split(":");l(q[0]+q[1]);r();function r(){setInterval(function(){a.empty();l(q[0]+q[1])},60000)}},error:function(o,p,n){mxm_urlDataTime="00"}})}function l(n){a.append(jQuery("<h6>",{text:"Minuto x Minuto","class":"color-primario"}),jQuery("<div>").append("<ul>"));jQuery.ajax({dataType:"jsonp",jsonpCallback:"mainwtdata",url:c+"?v="+n,success:function(o){k(o.ticker.widgets.widgets[0].id,n)}})}function k(o,p){var n="";jQuery.ajax({dataType:"jsonp",jsonpCallback:"wdata",url:b+"TickerFutbol_"+o+".js?v="+p,success:function(q){jQuery.each(q.matches.match,function(r,s){if(r===7){return false}if(s){fechaMXM=m(s);matchUrl=s.Website;elementVideoMXM=s.MXvideo.split("@@@");cam=elementVideoMXM!==""?"cam"+r:"";typeClassMXM=m(s,1);a.find("ul").append(jQuery("<li>",{"class":typeClassMXM||"color-primario"}).append(jQuery("<span>",{"class":"time",html:fechaMXM}),jQuery("<span>",{"class":"name "+cam}).append(jQuery("<a>",{rel:"nofollow",href:matchUrl,target:"_blank",html:s.equipos.local.name+" - "+s.equipos.visit.name,"data-name":"mxm.elemento-"+(r+1)})),jQuery("<span>",{"class":"result",html:s.equipos.local.goals+" &middot;&middot;&middot; "+s.equipos.visit.goals})));if(elementVideoMXM[0]!==""){a.find("ul li span.name.cam"+r).append(jQuery("<a>",{rel:"nofollow",href:elementVideoMXM[0],target:"_black"}).append(jQuery("<i>",{"class":"tvsaFH-videocamera color-primario"})))}}});jQuery("#MXMSection .color-primario, #MXMSection h6").css("color",e);jQuery("#MXMSection .color-secundario").css("color",g);jQuery("#MXMSection div ul li span.name a").on("click",function(r){if(typeof uid_call=="function"){var s=jQuery(this).attr("data-name");uid_call("header-global.vertical.deportes."+s,"clickout");_gaq.push(["_trackEvent","header-global","vertical.deportes",s]);s=null}})}})}function m(o,p){p=(p)?p:0;if(o.periodabrev==""){todayMXM=new Date();mxm_dateEvent=o.MatchDate.split("-");var n=new Date(mxm_dateEvent[2],(mxm_dateEvent[1]-1),mxm_dateEvent[0]);if(n==todayMXM){if(p==0){return o.MatchHour2}else{return"color-secundario"}}else{dataMatchDate=o.MatchDate.split("-");if(p==0){return dataMatchDate[0][2]+dataMatchDate[0][3]+"/"+dataMatchDate[1]}else{return"color-secundario"}}}else{if(o.periodabrev=="FIN"){if(p==0){return o.periodabrev[0].toUpperCase()+o.periodabrev.slice(1).toLowerCase()}else{return""}}else{if(p==0){time=o.periodabrev.replace("'","");return time+(time=="MT"?"":"&rdquo;")}else{return""}}}}h()};var normalize=(function(){var a="ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",e="AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",d={};for(var b=0,c=a.length;b<c;b++){d[a.charAt(b)]=e.charAt(b)}return function(m){var l=[];for(var h=0,k=m.length;h<k;h++){var g=m.charAt(h);if(d.hasOwnProperty(m.charAt(h))){l.push(d[g])}else{l.push(g)}}return l.join("")}})();(function(A){var d=function(a,k){typeof k=="undefined"&&(k={});this.init(a,k)},b=d.prototype,h,j=["canvas","vml"],c=["oval","spiral","square","rect","roundRect"],B=/^\#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/,z=navigator.appVersion.indexOf("MSIE")!==-1&&parseFloat(navigator.appVersion.split("MSIE")[1])===8?true:false,C=!!document.createElement("canvas").getContext,l=true,g=function(m,n,k){var m=document.createElement(m),o;for(o in k){m[o]=k[o]}typeof n!=="undefined"&&n.appendChild(m);return m},e=function(m,n){for(var k in n){m.style[k]=n[k]}return m},r=function(m,n){for(var k in n){m.setAttribute(k,n[k])}return m},s=function(m,n,k,o){m.save();m.translate(n,k);m.rotate(o);m.translate(-n,-k);m.beginPath()};b.init=function(m,n){if(typeof n.safeVML==="boolean"){l=n.safeVML}try{this.mum=document.getElementById(m)!==void 0?document.getElementById(m):document.body}catch(k){this.mum=document.body}n.id=typeof n.id!=="undefined"?n.id:"canvasLoader";this.cont=g("div",this.mum,{id:n.id});if(C){h=j[0],this.can=g("canvas",this.cont),this.con=this.can.getContext("2d"),this.cCan=e(g("canvas",this.cont),{display:"none"}),this.cCon=this.cCan.getContext("2d")}else{h=j[1];if(typeof d.vmlSheet==="undefined"){document.getElementsByTagName("head")[0].appendChild(g("style"));d.vmlSheet=document.styleSheets[document.styleSheets.length-1];var o=["group","oval","roundrect","fill"],p;for(p in o){d.vmlSheet.addRule(o[p],"behavior:url(#default#VML); position:absolute;")}}this.vml=g("group",this.cont)}this.setColor(this.color);this.draw();e(this.cont,{display:"none"})};b.cont={};b.can={};b.con={};b.cCan={};b.cCon={};b.timer={};b.activeId=0;b.diameter=40;b.setDiameter=function(a){this.diameter=Math.round(Math.abs(a));this.redraw()};b.getDiameter=function(){return this.diameter};b.cRGB={};b.color="#000000";b.setColor=function(a){this.color=B.test(a)?a:"#000000";this.cRGB=this.getRGB(this.color);this.redraw()};b.getColor=function(){return this.color};b.shape=c[0];b.setShape=function(a){for(var k in c){if(a===c[k]){this.shape=a;this.redraw();break}}};b.getShape=function(){return this.shape};b.density=40;b.setDensity=function(a){this.density=l&&h===j[1]?Math.round(Math.abs(a))<=40?Math.round(Math.abs(a)):40:Math.round(Math.abs(a));if(this.density>360){this.density=360}this.activeId=0;this.redraw()};b.getDensity=function(){return this.density};b.range=1.3;b.setRange=function(a){this.range=Math.abs(a);this.redraw()};b.getRange=function(){return this.range};b.speed=2;b.setSpeed=function(a){this.speed=Math.round(Math.abs(a))};b.getSpeed=function(){return this.speed};b.fps=24;b.setFPS=function(a){this.fps=Math.round(Math.abs(a));this.reset()};b.getFPS=function(){return this.fps};b.getRGB=function(a){a=a.charAt(0)==="#"?a.substring(1,7):a;return{r:parseInt(a.substring(0,2),16),g:parseInt(a.substring(2,4),16),b:parseInt(a.substring(4,6),16)}};b.draw=function(){var n=0,o,m,p,t,v,D,y,G=this.density,H=Math.round(G*this.range),E,x,F=0;x=this.cCon;var u=this.diameter;if(h===j[0]){x.clearRect(0,0,1000,1000);r(this.can,{width:u,height:u});for(r(this.cCan,{width:u,height:u});n<G;){E=n<=H?1-1/H*n:E=0;D=270-360/G*n;y=D/180*Math.PI;x.fillStyle="rgba("+this.cRGB.r+","+this.cRGB.g+","+this.cRGB.b+","+E.toString()+")";switch(this.shape){case c[0]:case c[1]:o=u*0.07000000000000001;t=u*0.47+Math.cos(y)*(u*0.47-o)-u*0.47;v=u*0.47+Math.sin(y)*(u*0.47-o)-u*0.47;x.beginPath();this.shape===c[1]?x.arc(u*0.5+t,u*0.5+v,o*E,0,Math.PI*2,false):x.arc(u*0.5+t,u*0.5+v,o,0,Math.PI*2,false);break;case c[2]:o=u*0.12;t=Math.cos(y)*(u*0.47-o)+u*0.5;v=Math.sin(y)*(u*0.47-o)+u*0.5;s(x,t,v,y);x.fillRect(t,v-o*0.5,o,o);break;case c[3]:case c[4]:m=u*0.3,p=m*0.27,t=Math.cos(y)*(p+(u-p)*0.13)+u*0.5,v=Math.sin(y)*(p+(u-p)*0.13)+u*0.5,s(x,t,v,y),this.shape===c[3]?x.fillRect(t,v-p*0.5,m,p):(o=p*0.55,x.moveTo(t+o,v-p*0.5),x.lineTo(t+m-o,v-p*0.5),x.quadraticCurveTo(t+m,v-p*0.5,t+m,v-p*0.5+o),x.lineTo(t+m,v-p*0.5+p-o),x.quadraticCurveTo(t+m,v-p*0.5+p,t+m-o,v-p*0.5+p),x.lineTo(t+o,v-p*0.5+p),x.quadraticCurveTo(t,v-p*0.5+p,t,v-p*0.5+p-o),x.lineTo(t,v-p*0.5+o),x.quadraticCurveTo(t,v-p*0.5,t+o,v-p*0.5))}x.closePath();x.fill();x.restore();++n}}else{e(this.cont,{width:u,height:u});e(this.vml,{width:u,height:u});switch(this.shape){case c[0]:case c[1]:y="oval";o=140;break;case c[2]:y="roundrect";o=120;break;case c[3]:case c[4]:y="roundrect",o=300}m=p=o;t=500-p;for(v=-p*0.5;n<G;){E=n<=H?1-1/H*n:E=0;D=270-360/G*n;switch(this.shape){case c[1]:m=p=o*E;t=500-o*0.5-o*E*0.5;v=(o-o*E)*0.5;break;case c[0]:case c[2]:z&&(v=0,this.shape===c[2]&&(t=500-p*0.5));break;case c[3]:case c[4]:m=o*0.95,p=m*0.28,z?(t=0,v=500-p*0.5):(t=500-m,v=-p*0.5),F=this.shape===c[4]?0.6:0}x=r(e(g("group",this.vml),{width:1000,height:1000,rotation:D}),{coordsize:"1000,1000",coordorigin:"-500,-500"});x=e(g(y,x,{stroked:false,arcSize:F}),{width:m,height:p,top:v,left:t});g("fill",x,{color:this.color,opacity:E});++n}}this.tick(true)};b.clean=function(){if(h===j[0]){this.con.clearRect(0,0,1000,1000)}else{var a=this.vml;if(a.hasChildNodes()){for(;a.childNodes.length>=1;){a.removeChild(a.firstChild)}}}};b.redraw=function(){this.clean();this.draw()};b.reset=function(){typeof this.timer==="number"&&(this.hide(),this.show())};b.tick=function(m){var k=this.con,n=this.diameter;m||(this.activeId+=360/this.density*this.speed);h===j[0]?(k.clearRect(0,0,n,n),s(k,n*0.5,n*0.5,this.activeId/180*Math.PI),k.drawImage(this.cCan,0,0,n,n),k.restore()):(this.activeId>=360&&(this.activeId-=360),e(this.vml,{rotation:this.activeId}))};b.show=function(){if(typeof this.timer!=="number"){var k=this;this.timer=self.setInterval(function(){k.tick()},Math.round(1000/this.fps));e(this.cont,{display:"block"})}};b.hide=function(){typeof this.timer==="number"&&(clearInterval(this.timer),delete this.timer,e(this.cont,{display:"none"}))};b.kill=function(){var k=this.cont;typeof this.timer==="number"&&this.hide();h===j[0]?(k.removeChild(this.can),k.removeChild(this.cCan)):k.removeChild(this.vml);for(var m in this){delete this[m]}};A.CanvasLoader=d})(window);