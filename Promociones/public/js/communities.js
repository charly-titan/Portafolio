var communities={comments_server:"http://promociones.televisa.com.mx/",comments_origin:"http://promociones.televisa.com.mx/",url:"",pSound:!0,sPying:!1,fb_supported:!0,active_service:"",twform:"",popupobject:"",keys:{facebook:{esmas:0x6c45aca123fc,televisa:0x6f07ca007291,adobecqms:0x70f807f363f6}},page_info:{url:"",bitly:"",meta:"",fb_status:0,tw_status:0,domain_key:"",facebook:0,msg:""},sites:{esmas:"esmas.com",televisadeportes:"televisadeportes.com",templeo:"templeo.com",televisa:"televisa.com",carasonline:"carasonline.net"},
msg:{facebook:{},twitter:{}},cl_domain:function(c){try{return tmp_domain=c.split("."),2==tmp_domain.length?tmp_domain[0]:3<tmp_domain[1].length?tmp_domain[1]:tmp_domain[0]}catch(d){return c}},cl_url:function(c){b=c.search(/\?/);-1!=b&&(b=c.search(/\=/),-1!=b&&(c=c.replace(/\=/g,"_"),c=c.replace(/\&/g,"/"),c=c.replace("?","/no_clean_url/")));b=c.search(/\#/);-1!=b&&(c=c.substring(0,b));b=c.search(/\?/);-1!=b&&(c=c.substring(0,b));return c},loadJS:function(c,d){var e=document.createElement("script");
e.setAttribute("type","text/javascript");e.setAttribute("src",c);"undefined"!=typeof d&&e.setAttribute("charset",d);document.getElementsByTagName("head")[0].appendChild(e);return!0},makeCookie:function(c,d,e){e=document.domain.substring(document.domain.indexOf(".")+1);document.cookie=c+"="+d+"; path=/; domain="+e},readCookie:function(c){return 0<document.cookie.length&&(c_start=document.cookie.indexOf(" "+c+"="),-1!=c_start)||0<document.cookie.length&&(c_start=document.cookie.indexOf(""+c+"="),-1!=
c_start)?(c_start=c_start+c.length+2,c_end=document.cookie.indexOf(";",c_start),-1==c_end&&(c_end=document.cookie.length),unescape(document.cookie.substring(c_start,c_end))):null},startComments:function(){document.getElementById("COMM_comments_social")?this.loadJS(this.comments_server+"js/commenta_2_0.js"):document.getElementById("COMM_comments_social_2")?this.loadJS(this.comments_server+"js/commenta_2_2.js"):document.getElementById("COMM_comments_facebook")&&communities.loadFBComments()},loadFBComments:function(){var c=
this.url,d=10,e=624;"undefined"!=typeof comment_url&&(c=comment_url);try{"undefined"!=typeof $("#COMM_comments_facebook").attr("data-comm-numposts")&&(d=$("#COMM_comments_facebook").attr("data-comm-numposts"))}catch(f){}try{"undefined"!=typeof $("#COMM_comments_facebook").attr("data-comm-width")&&(e=$("#COMM_comments_facebook").attr("data-comm-width"))}catch(g){}document.getElementById("COMM_comments_facebook")&&(document.getElementById("COMM_comments_facebook").innerHTML='<div class="fb-comments" data-width="'+
e+'" data-numposts="'+d+'" data-href="'+c+'" data-colorscheme="light"></div>');document.getElementById("comm_div_num")&&(document.getElementById("comm_div_num").innerHTML='<fb:comments-count href="'+c+'"></fb:comments-count>')},startMoreViews:function(){document.getElementById("COMM_more_views_social")&&this.loadJS(this.comments_server+"js/printMoreViews.js")},setView:function(c){"undefined"==typeof c&&(c=this.url);COMM_img_set_2=document.createElement("IMG");COMM_img_set_2.style.display="none";COMM_img_set_2.src=
"https://views-tim.s3-website-us-east-1.amazonaws.com/vistas/spacer.gif?1|"+c+"|"+ +new Date;document.body.appendChild(COMM_img_set_2)},setVote:function(c,d,e,f){"undefined"==typeof c&&(c=this.url);COMM_img_set_2=document.createElement("IMG");COMM_img_set_2.src="http://views-tim.s3-website-us-east-1.amazonaws.com/votos/spacer.gif?1|"+d+"|"+e+"|"+f+"|"+c+"|"+ +new Date;document.body.appendChild(COMM_img_set_2)},stars_votes:function(c,d,e,f){"undefined"==typeof e&&(e=5);"undefined"==typeof d&&(d=this.cl_url(this.url));
11>c&&0<c&&(this.setVote(d,c,e-c,1),"undefined"!=typeof f&&eval(f))},loadBitly:function(){this.loadJS(this.comments_server+"bitly/load.php?url="+communities.cl_url(document.location.href))},startMailing:function(){document.getElementById("mailing")&&this.loadJS(this.comments_server+"mailing/js/mailing.js")},startImageFeed:function(){document.getElementById("comm_instagram_feed")&&this.loadJS(this.comments_server+"js/feed_images.js")},checkStatus_fb:function(c,d){"undefined"==typeof c&&(c=!1);"undefined"==
typeof d&&(d="");if("undefined"==typeof FB)return setTimeout("communities.checkStatus_fb("+c+",'"+d+"');",350),0;FB.getLoginStatus(function(e){if(e.session||"connected"==e.status)return wait4me=setTimeout(d,500),communities.page_info.fb_status=1;c&&communities.login_fb(d);return communities.page_info.fb_status=0})},login_fb:function(c){if("undefined"==typeof FB)return setTimeout("communities.login_fb('"+c+"');",750),0;FB.login(function(d){d.session?d.perms?(wait4me=setTimeout(c,500),communities.page_info.fb_status=
1):communities.page_info.fb_status=2:"connected"==d.status?d.perms?(wait4me=setTimeout(c,500),communities.page_info.fb_status=1):(wait4me=setTimeout(c,500),communities.page_info.fb_status=2):communities.page_info.fb_status=0},{scope:"publish_actions"})},initFB:function(){if(document.getElementById("widgetSocialShare")&&!document.getElementById("tim_fb_button"))return setTimeout("communities.initFB();",1E3),0;this.page_info.domain_key=this.cl_domain(document.domain);"undefined"==typeof this.keys.facebook[this.page_info.domain_key]&&
(this.fb_supported=!1);if(!document.getElementById("fb-root")){var c=document.createElement("div");c.id="fb-root";document.getElementsByTagName("body")[0].appendChild(c)}if("undefined"==typeof FB){c=communities.keys.facebook[communities.page_info.domain_key];"undefined"==typeof communities.keys.facebook[communities.page_info.domain_key]&&(c=0x6c45aca123fc);var d,e=document.getElementsByTagName("script")[0];document.getElementById("facebook-jssdk")||(d=document.createElement("script"),d.id="facebook-jssdk",
d.src="//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId="+c+"&version=v2.2",e.parentNode.insertBefore(d,e))}},startSocialShare:function(){this.loadJS(this.comments_server+"js/socialShare.js")},startSocialShare2:function(){this.loadJS(this.comments_server+"js/socialShare_2.js")},startSocialShare3:function(){this.loadJS(this.comments_server+"js/socialShare_3.js")},startSocialShare4:function(){this.loadJS(this.comments_server+"js/socialShare_4.js")},startSocialShare5:function(){this.loadJS(this.comments_server+
"js/socialShare_5.js")},startSocialShare6:function(){this.loadJS(this.comments_server+"js/socialShare_6.js")},startSocialShare7:function(){this.loadJS(this.comments_server+"js/socialShare_7.js")},startMinxMin:function(){this.loadJS(this.comments_server+"js/minxmin.js")},init:function(){communities.url=communities.cl_url(document.location.href);document.getElementById("wdg_twitt_01")||document.getElementById("wdg_twitt_02")?this.loadJS(this.comments_server+"js/tweeting_rga.js"):"undefined"!=typeof tweet_config&&
this.loadJS(this.comments_server+"js/tweeting.js");-1==document.location.href.search("entretenimiento.televisa.com/")&&-1==document.location.href.search("finalpage.esmas.com/")&&-1==document.location.href.search("televisa-entretenimiento/")&&-1==document.location.href.search("centauro.esmas.com.mx")&&-1==document.location.href.search("front-end-projects.esmas.com/")&&-1==document.location.href.search("cgs-003.esmas.com/")&&-1==document.location.href.search("estilodevida.televisa.com/")||communities.startSocialShare5();
"undefined"!=typeof config_socialMedia||document.getElementById("widgetSocialShare")?setTimeout("communities.startSocialShare();",700):document.getElementById("widgetSocialShare2")?setTimeout("communities.startSocialShare2();",700):document.getElementById("widgetSocialShare3")?communities.startSocialShare3():document.getElementById("widgetSocialShare4")?this.startSocialShare4():document.getElementById("widgetSocialShare5")?setTimeout("communities.startSocialShare5();",700):document.getElementById("widgetSocialShare6")?
setTimeout("communities.startSocialShare6();",700):document.getElementById("widgetSocialShare7")&&setTimeout("communities.startSocialShare7();",700);this.initFB();this.startComments();this.startMoreViews();this.setView();this.startMailing();this.startImageFeed();("undefined"!=typeof config_mxm||document.getElementById("minutos")||document.getElementById("minDeportes")||document.getElementById("masleido")||document.getElementById("titulares_nt")||document.getElementById("fotos_nt")||document.getElementById("videos_nt"))&&
this.startMinxMin();if(document.getElementById("comm_num_views")||document.getElementById("comm_num_comments")||document.getElementById("comm_num_comments2")||document.getElementById("comm_num_stars")){var c=!0;try{0==comm_general_config.views.load&&(c=!1)}catch(d){}c&&this.loadJS(this.comments_server+"views/load.php?url="+this.url)}try{poll=document.getElementsByClassName("esmas_safe_simple_poll_box"),0<poll.length&&(-1!=document.location.href.search("www.televisa.com/canal5/")||-1!=document.location.href.search("cgs-003.esmas.com/")||
-1!=document.location.href.search("cgs-003.esmas.com/")?this.loadJS(this.comments_server+"js/polls.js"):this.start_polls(poll),this.loadcss("http://i2.esmas.com/comunidades/css/polls/main.css"))}catch(e){}"undefined"!=typeof json_stars&&this.multiple_stars();"http://noticieros.televisa.com/programas-primero-noticias/#escaleta"==document.location.href&&this.loadJS("http://beta.oncliptools.com/js/escaleta.js")},start_polls:function(c){try{if("undefined"==typeof c&&(c=document.getElementsByClassName("esmas_safe_simple_poll_box")),
"undefined"!=typeof esmas_safe_boxattributes)if(esmas_safe_boxattributes.length==c.length)for(wait4me=this.readmeta(),info={},i=0;i<esmas_safe_boxattributes.length;i++){if(id=esmas_safe_boxattributes[i][0].box_id,info[id]={},info[id].box_guid=esmas_safe_boxattributes[i][0].box_guid,info[id].img="http://i2.esmas.com/comunidades/img/polls/faceEncuestasThumb.jpg",info[id].msg="Participa en la encuesta de "+document.domain,info[id].url=this.page_info.url+"#poll_"+id,info[id].title=this.page_info.meta.title,
info[id].enc_guid="",anc='<a href="#poll_'+id+'"></a>',""!=esmas_safe_boxattributes[i][0].encuestas[0].url&&(info[id].msg="Participa en la encuesta "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name,info[id].url=esmas_safe_boxattributes[i][0].encuestas[0].url,info[id].title="Encuesta: "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name),""!=esmas_safe_boxattributes[i][0].encuestas[0].enc_name&&(info[id].title="Encuesta: "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name),"undefined"!=typeof esmas_safe_boxattributes[i][0].encuestas[0].img&&
(info[id].img=esmas_safe_boxattributes[i][0].encuestas[0].img),"undefined"!=typeof esmas_safe_boxattributes[i][0].encuestas[0].enc_guid&&""!=esmas_safe_boxattributes[i][0].encuestas[0].enc_guid&&(info[id].enc_guid=esmas_safe_boxattributes[i][0].encuestas[0].enc_guid),this.msg.twitter[id]={},this.msg.twitter[id]=info[id],this.msg.facebook[id]={},this.msg.facebook[id]=info[id],code='<div class="ts_poll_cont"><ul class="share_poll_tim_social">',code+='<li class="poll_text_share"> <div>COMPARTE ESTA ENCUESTA </div></li>',
code+='<li><input type="button" class="btn_poll_twitter_off" id="btn_poll_twitter_'+id+'" onclick="communities.active_twitter_poll('+id+')" /></li>',code+='<li><input type="button" class="btn_poll_facebook_off" id="btn_poll_facebook_'+id+'" onclick="communities.active_facebook_poll('+id+')" /></li></ul>',code+='<div id="cnt_fb_poll'+id+'" class="invisible_ts"></div>',code+='<div id="cnt_tw_poll'+id+'" class="invisible_ts"></div></div>',document.getElementById("esmas_safe_simplepoll_iframe_"+info[id].box_guid)?
document.getElementById("safe_poll_socialmedia_"+info[id].enc_guid)&&!document.getElementById("btn_poll_twitter_"+id)&&(document.getElementById("safe_poll_socialmedia_"+info[id].enc_guid).innerHTML=anc+code):setTimeout("communities.start_polls();",500),!document.getElementById("tim_social_frame_container")){a=document.createElement("div");a.id="tim_social_frame_container";a.name="tim_social_frame_container";try{a.style.display="none"}catch(d){}document.getElementsByTagName("body")[0].appendChild(a);
document.getElementById("tim_social_frame_container").innerHTML='<iframe src="'+communities.comments_server+'" height="1" width="1" frameborder="0" name="tim_social_frame" id="tim_social_frame" allowtransparency="yes"></iframe>'}}else setTimeout("communities.start_polls();",500);else setTimeout("communities.start_polls();",500)}catch(e){}},active_twitter_poll:function(c){this.active_service="twitter";this.community_stats();document.getElementById("cnt_tw_poll"+c)&&("visible_ts"==document.getElementById("cnt_tw_poll"+
c).className?(document.getElementById("cnt_tw_poll"+c).className="invisible_ts",document.getElementById("cnt_fb_poll"+c).className="invisible_ts",document.getElementById("btn_poll_twitter_"+c).className="btn_poll_twitter_off"):(document.getElementById("cnt_tw_poll"+c).className="visible_ts",document.getElementById("cnt_fb_poll"+c).className="invisible_ts",document.getElementById("btn_poll_twitter_"+c).className="btn_poll_twitter_on"),document.getElementById("btn_poll_facebook_"+c).className="btn_poll_facebook_off");
"undefined"!=typeof communities.page_info.bitly&&""!=communities.page_info.bitly||this.loadJS(this.comments_server+"bitly/?url="+this.msg.facebook[c].url);this.start_twitterpoll(c)},start_twitterpoll:function(c,d){"undefined"==typeof d&&(d=0);if(5>d&&""==this.page_info.bitly)return setTimeout("communities.start_twitterpoll("+c+","+(d+1)+")",500),!1;""==this.page_info.bitly&&(this.page_info.bitly=this.msg.facebook[c].url);this.page_info.bitly+="#poll_"+c;document.getElementById("cnt_tw_poll"+c)&&this.print_twform("cnt_tw_poll"+
c,this.msg.twitter[c].msg+" "+this.page_info.bitly)},print_twform:function(c,d){code='<form method="get" action="http://comentarios.esmas.com/twitterPost.php" target="tim_social_frame" id="twitter_form" name="twitter_form">';code+='<textarea id="twitter_text" name="comment" >'+d+"</textarea>";code+='<input type="button" value="&nbsp;" onclick="communities.sendmsgTWpoll(this.form);"  class="btn_enviar">';code+="</form>";document.getElementById(c)&&(document.getElementById(c).innerHTML=code)},sendmsgTWpoll:function(c){if(""==
c.twitter_text.value)return alert("Inserta un comentario"),!1;this.twform=c;tw_status=encodeURIComponent(c.twitter_text.value);window.open("https://twitter.com/intent/tweet?status="+tw_status,"popupwindow","width=700,height=300")},waitpopup:function(c){this.popupobject=c;c.closed?this.reedTwittCoookie():setTimeout("communities.waitpopup(communities.popupobject)",1E3)},reedTwittCoookie:function(c){"undefined"==typeof c&&(c=0);this.readCookie("tw_user_data")?(this.readCookie("tw_user_data").split("|"),
document.getElementById("tim_social_frame").src=this.comments_server,this.twform.submit(),alert("Has compartido la encuesta."),this.active_service="twitter",this.community_stats(this.url,1)):(0==c&&this.loadJS(this.comments_server+"readTwitterCookie3.php?url="+document.location.href),10>c?setTimeout("communities.reedTwittCoookie("+(c+1)+")",1E3):alert("No se ha podido enviar el mensaje"))},active_facebook_poll:function(c){this.active_service="facebook";this.community_stats();document.getElementById("cnt_fb_poll"+
c)&&("visible_ts"==document.getElementById("cnt_fb_poll"+c).className?(document.getElementById("cnt_fb_poll"+c).className="invisible_ts",document.getElementById("cnt_tw_poll"+c).className="invisible_ts",document.getElementById("btn_poll_twitter_"+c).className="btn_poll_twitter_off",document.getElementById("btn_poll_facebook_"+c).className="btn_poll_facebook_off"):(document.getElementById("cnt_fb_poll"+c).className="visible_ts",document.getElementById("cnt_tw_poll"+c).className="invisible_ts",document.getElementById("btn_poll_twitter_"+
c).className="btn_poll_twitter_off",document.getElementById("btn_poll_facebook_"+c).className="btn_poll_facebook_on"));document.getElementById("cnt_fb_poll"+c)&&(document.getElementById("cnt_fb_poll"+c).innerHTML="");this.print_fbform("cnt_fb_poll"+c,this.msg.facebook[c].url,this.msg.facebook[c].msg,this.msg.facebook[c].title,this.msg.facebook[c].img,"communities.pollfbOk()","communities.pollfbEr()")},print_fbform:function(c,d,e,f,g,h,k){"undefined"==typeof e&&(e="Entra a ver esto, seguro te interesara tanto como a mi");
"undefined"==typeof d&&(d=this.page_info.url);"undefined"==typeof f&&(f="");"undefined"==typeof g&&(g="");"undefined"==typeof h&&(h="alert('El mensaje ha sido publicado en tu muro')");"undefined"==typeof k&&(k="alert('El mensaje no ha podido ser publicado. \n\r Por Favor intentalo nuevamente mas tarde.')");code='<form method="post" name="FB_tim_social_poll" target="tim_social_frame" action="http://comunidades.esmas.com/facebook/post/" >';code+='<textarea name="msg">'+e+"</textarea>";code+='<input type="hidden" value="'+
d+'" name="url">';code+='<input type="hidden" value="'+f+'" name="description">';code+='<input type="hidden" value="'+g+'" name="img">';code+='<input type="hidden" value="'+h+'" name="callbackok">';code+='<input type="hidden" value="'+k+'" name="callbackerr">';code+='<input type="button" value="&nbsp;" onclick="communities.sendmsgFBpoll(this.form);"  class="btn_enviar">';code+="</form>";document.getElementById(c)&&(document.getElementById(c).innerHTML=code)},sendmsgFBpoll:function(c){if(""==c.msg.value)return!1;
if(0==this.page_info.fb_status)return wait4me=this.checkStatus_fb(!0,"communities.sendFBFormpoll('"+c.msg.value+"','"+c.url.value+"','"+c.description.value+"','"+c.img.value+"','communities.pollfbOk()','communities.pollfbEr()')"),!1;this.sendFBFormpoll(c.msg.value,c.url.value,c.description.value,c.img.value,c.callbackok.value,c.callbackerr.value);return!1},sendFBFormpoll:function(c,d,e,f,g,h){if("undefined"==typeof c)return!1;"undefined"==typeof d&&(d=this.page_info.url);"undefined"==typeof e&&(e=
"");"undefined"==typeof f&&(f="");"undefined"==typeof g&&(g="alert('El mensaje ha sido publicado en tu muro')");"undefined"==typeof h&&(h="alert('El mensaje no ha podido ser publicado. \n\r Por Favor intentalo nuevamente mas tarde.')");apost={message:c,link:d};""!=e&&(apost.name=e);""!=f&&(apost.picture=f);"undefined"!=typeof tim_poll_config&&(apost.picture=tim_poll_config.img);FB.api("/v2.2/me/feed","post",apost,function(c){!c||c.error?setTimeout(h,500):(communities.active_service="facebook",communities.community_stats(communities.url,
1),eval(g))})},pollfbOk:function(){alert("La encuesta ha sido compartida en tu perfil.")},pollfbEr:function(){alert("No ha sido posible publicar tu mensaje por favor intentalo nuevamente mas tarde.")},readmeta:function(){try{if(""==this.page_info.meta){this.page_info.meta={};var c=document.getElementsByTagName("META");for(i=0;i<c.length;i++)null!=c[i].getAttribute("NAME")&&(name=c[i].getAttribute("NAME"),name=name.toLowerCase(),"undefined"==typeof this.page_info.meta.title?this.page_info.meta.title=
document.title:("title"==name&&(this.page_info.meta.title=c[i].getAttribute("CONTENT")),"description"==name&&(this.page_info.meta.description=c[i].getAttribute("CONTENT"))))}}catch(d){}return!0},loadcss:function(c){var d=document.createElement("link");d.type="text/css";d.rel="stylesheet";d.href=c;document.getElementsByTagName("head")[0].appendChild(d)},community_stats:function(c,d){"undefined"==typeof c&&(c=this.url);"undefined"==typeof d&&(d=0);"undefined"!=typeof video_embed_url&&(c=video_embed_url);
COMM_img_set=document.createElement("IMG");COMM_img_set.src="http://v.esmas.com:8081/"+this.active_service+"/spacer.gif?1|"+d+"|"+c;if(""!=this.active_service){text_share=0==d?"open":"share";try{pageTracker._setCustomVar(1,"Social_Share_"+this.active_service+"_"+text_share,c,2)}catch(e){}document.body.appendChild(COMM_img_set)}},multiple_stars:function(){this.loadJS(this.comments_server+"js/comm_stars_2.js")},getTinyUrl:function(c,d,e){if("undefined"!=typeof this.page_info.bitly_original&&this.page_info.bitly_original!=
this.cl_url(c)&&"undefined"==typeof e)return e=1,delete this.page_info.bitly,delete this.page_info.bitly_original,this.loadJS(this.comments_server+"bitly/index.php?url="+this.cl_url(c)),setTimeout("communities.getTinyUrl('"+c+"','"+d+"',"+e+")",300),!0;if("undefined"!=typeof this.page_info.bitly&&""!=this.page_info.bitly)return eval(d+'("'+this.page_info.bitly+'");'),!0;if("undefined"==typeof e||0==e)return e=1,this.loadJS(this.comments_server+"bitly/index.php?url="+this.cl_url(c)),setTimeout("communities.getTinyUrl('"+
c+"','"+d+"',"+e+")",300),!0;if(5>e)return setTimeout("communities.getTinyUrl('"+c+"','"+d+"',"+(e+1)+")",300),!0;eval(d+'("'+c+'");');return!1}};if("undefined"==typeof init_comunidades){var init_comunidades=1;communities.loadBitly();communities.init()}
if("undefined"==typeof config_mailing)var config_mailing={msgs:{title:"Televisi&oacuten",text:"Inscr&iacute;bete y recibe las noticias m&aacute;s populares y lo &uacuteltimo de las telenovelas",button_text:"Inscr&iacute;bete",thanks_text:"Gracias por suscribirte.",input_text:"Correo electr&oacute;nico",working_msg:"La informaci&oacute;n se est&aacute; enviando."},templates:{form:'<form method="post" action="{server}" target="social_mailing" name="mailing-form-post" id="mailing-form-post" onsubmit="return mailing.validate(this);"> <div class="container-top"><div class="img-download"></div><p>{text}</p></div><div class="container-email"><div class="container-right"><input type="text" value="{input_text}" name="email"  onfocus="mailing.cleaninput(this)" onblur="mailing.cleaninput(this,0)"  class="email-txt"></div></div><div class="container-btn"><input type="submit" value="{button_text}" class="subscribe"></div></form>',
working:'<div class="container-top"><div class="img-download"></div><p>{working_msg}</p></div><div class="container-email"><div class="container-right"></div></div>',thanks:'<div class="container-top"><div class="img-download"></div><p>{thanks_text}</p></div><div class="container-email"><div class="container-right"></div></div>'},imgs:{logo:"http://i2.esmas.com/comunidades/registro/img/multireg_ic_tvsa.png"},css:"http://i2.esmas.com/comunidades/css/mailing/mailing-rediseno.css"};