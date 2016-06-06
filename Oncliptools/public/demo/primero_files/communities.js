


/*
//Block load comments
try{
	if(typeof comm_general_config=="undefined"){var comm_general_config={comments:{load:{comments:0}},views:{load:0}};
	}else{comm_general_config.comments.load.comments=0;comm_general_config.views.load=0;}
}catch(e){}
*/
/**
 * @author gmancera
 */
var communities = {
	comments_server		:	"http://comentarios.esmas.com/",
	comments_origin		:	"http://comentarios.esmas.com/",
	url			:	"",
	pSound		:	true,
	sPying		:	false,
	fb_supported:	true,
	active_service	:	"",
	twform			:	"",
	popupobject		:	"",
	//Produccion
	/*
	keys 		:	{	"facebook"	:	{ "esmas"			:	119046504784892}},
	*/
	keys:{"facebook":{"esmas":119046504784892,"televisa":122079244481169,"adobecqms":124210587591670}},
	//Desarrollo				
	//keys 		:	{	"facebook"	:	{"esmas"			:	121854091179595}},
	page_info	:	{	"url"			:	"",
						"fb_status" 	:	0,
						"tw_status" 	:	0,
						"domain_key"	:	""},
	page_info	:	{	"url"			:	"",
						"bitly"			:	"",
						"meta"			:	"",
						"fb_status" 	:	0,
						"tw_status" 	:	0,
						"domain_key"	:	"",
						"facebook"		:	0,
						"msg"			:	""	},
	sites		:	{
						
						 "esmas"			:	"esmas.com",
						 "televisadeportes"	:	"televisadeportes.com",
						 "templeo"			:	"templeo.com",
						 "televisa"			:	"televisa.com",
						 "carasonline"		:	"carasonline.net",
						 "televisa"		:	"noticieros.televisa.com"
		
					},

	msg			:	{ facebook : {}, twitter : {}	},
		
	/* Funciones para el dominio y la Url */
	cl_domain	:	function(domain){
		tmp_domain	=	domain.split(".");
		if(tmp_domain.length==2){
			return tmp_domain[0];
		}else{
			if(tmp_domain[1].length>3){
				return 	tmp_domain[1];
			}else{
				return 	tmp_domain[0];
			}
		}
		
	}, 
	cl_url		:	function(a){
		b=a.search(/\?/);
		if(b!=-1){
			b=a.search(/\=/);
			if (b != -1) {
				a=a.replace(/\=/g,"_");
				a=a.replace(/\&/g,"/");
				a=a.replace("?","/no_clean_url/");
			}
		}
		b=a.search(/\#/);
		if(b!=-1){a=a.substring(0,b)}
		b=a.search(/\?/);
		if(b!=-1){a=a.substring(0,b)}
		return a
	},
	loadJS	:	function(url, charset){
		var sc	=	document.createElement('script');
		sc.setAttribute('type','text/javascript');
		sc.setAttribute('src',	url);
		if('undefined' != typeof charset){
			sc.setAttribute('charset',charset);
		}
		var hd	=	document.getElementsByTagName('head')[0];
		hd.appendChild(sc);
		return true;
	},
	makeCookie : function(c_name, value,expiredays){
		var getdomain = document.domain.substring(document.domain.indexOf('.') + 1);
		document.cookie = c_name + "=" + value + "; path=/; domain=" + getdomain;
	},
	readCookie : function(c_name){
		if (document.cookie.length>0){
			c_start=document.cookie.indexOf(" "+c_name + "=");
			if (c_start!=-1){
				c_start=c_start + c_name.length+2;
				c_end=document.cookie.indexOf(";",c_start);
				if (c_end==-1){c_end=document.cookie.length;}
				return unescape(document.cookie.substring(c_start,c_end));
		   	}
		}
		if (document.cookie.length>0){
			c_start=document.cookie.indexOf(""+c_name + "=");
			if (c_start!=-1){
				c_start=c_start + c_name.length+2;
				c_end=document.cookie.indexOf(";",c_start);
				if (c_end==-1){c_end=document.cookie.length;}
				return unescape(document.cookie.substring(c_start,c_end));
			}
		}
		return null;
	},
	startComments:function(){
		if (document.getElementById("COMM_comments_social")){
			this.loadJS(this.comments_server+"js/commenta_2_0.js");
		}else if(document.getElementById("COMM_comments_social_2")){
			this.loadJS(this.comments_server+"js/commenta_2_2.js");
		}else if(document.getElementById("COMM_comments_facebook")){
			setTimeout("communities.loadFBComments();",1000);
		}
	},
	loadFBComments:function(){
		if(document.getElementById("comm_div_num")){
			document.getElementById("comm_div_num").innerHTML='<fb:comments-count href="'+this.url+'"></fb:comments-count>';
		}
		if (document.getElementById("COMM_comments_facebook")){
			document.getElementById("COMM_comments_facebook").innerHTML='<div class="fb-comments" data-href="'+this.url+'" data-numposts="10" data-colorscheme="light"></div>';
		}
	},
	startMoreViews:function(){
		if (document.getElementById("COMM_more_views_social")){
			this.loadJS(this.comments_server+"js/printMoreViews.js");
		}
	},
	setView : function(url){
		if (typeof url == "undefined") { url=this.url;	}
		//COMM_img_set = document.createElement("IMG");
		//COMM_img_set.style.display="none";
			//COMM_img_set.src = "http://v.esmas.com:8081/vistas/spacer.gif?1|"+url;
		//COMM_img_set.src = "http://v.esmas.com:8081/vistas/spacer.gif?1|"+url+"|"+(+new Date);
		//document.body.appendChild(COMM_img_set);	

		COMM_img_set_2 = document.createElement("IMG");
		COMM_img_set_2.style.display="none";
		COMM_img_set_2.src = "http://views-tim.s3-website-us-east-1.amazonaws.com/vistas/spacer.gif?1|"+url+"|"+(+new Date);
		document.body.appendChild(COMM_img_set_2);
	},
	setVote : function(url, positive_votes, negative_votes, votes_type){
		if (typeof url == "undefined") { url=this.url;	}
		//COMM_img_set = document.createElement("IMG");
		//COMM_img_set.src = "http://v.esmas.com:8081/votos/spacer.gif?1|"+positive_votes+"|"+negative_votes+"|"+votes_type+"|"+url;
		//document.body.appendChild(COMM_img_set);
		COMM_img_set_2 = document.createElement("IMG");
		COMM_img_set_2.src = "http://views-tim.s3-website-us-east-1.amazonaws.com/votos/spacer.gif?1|"+positive_votes+"|"+negative_votes+"|"+votes_type+"|"+url+"|"+(+new Date);
		document.body.appendChild(COMM_img_set_2);
	},
	stars_votes	:	function(num_star,url,base_stars,callback_fun){
		if (typeof base_stars == "undefined") {var base_stars=5;}
		if (typeof url == "undefined") { url	=	this.cl_url(this.url); }
		if(num_star<11 && num_star>0){
			//this.loadJS(this.origin+'views/set.php?stars='+num_star+'&url='+url);	
			var negative_votes=base_stars-num_star;
			this.setVote(url,num_star,negative_votes,1);
			if (typeof callback_fun != "undefined"){
				eval(callback_fun);
			}
		}
	},
	startMailing:function(){
		if (document.getElementById("mailing")){
			this.loadJS(this.comments_server+"mailing/js/mailing.js");
		}
	},
	startImageFeed:function(){
		if (document.getElementById("comm_instagram_feed")){
			this.loadJS(this.comments_server+"js/feed_images.js");
		}
	},
	checkStatus_fb	:	function(login,fcall){
		if('undefined' == typeof login){login=false;}
		if('undefined' == typeof fcall){fcall="";}
		if('undefined' == typeof FB){setTimeout("communities.checkStatus_fb("+login+",'"+fcall+"');",350); return 0;}
		 
		FB.getLoginStatus(function(response) {
			
			if (response.session) {
				wait4me	=	setTimeout(fcall,500);
				communities.page_info["fb_status"]=1;
				return 1;
		  	}else{
				if(response.status=="connected"){
					wait4me	=	setTimeout(fcall,500);
					communities.page_info["fb_status"]=1;
					return 1;
			}
			
			if(login){
				communities.login_fb(fcall); 
			}
			communities.page_info["fb_status"]=0;
			
			return 0;
		  }
		});	
	},
	login_fb		:	function(fcall){
		if('undefined' == typeof FB){setTimeout("communities.login_fb('"+fcall+"');",750); return 0;}
		
		FB.login( 	function(response) {
						
			if (response.session) {
				if (response.perms) {
					wait4me = setTimeout(fcall,500);
					communities.page_info["fb_status"]= 1;
					 
				}else{
					communities.page_info["fb_status"]= 2; 
				}
			}else {
				
				if(response.status=="connected"){
					if (response.perms) {
						wait4me = setTimeout(fcall,500);
						communities.page_info["fb_status"]= 1;
						
					}else {
						wait4me = setTimeout(fcall,500);
						communities.page_info["fb_status"]= 2; 
					}	
				}else{
					communities.page_info["fb_status"]= 0; 	
				}
			}
		}, {scope:'publish_stream,email,user_birthday,user_hometown'});
	},
	initFB: function(){
			
		if(document.getElementById("widgetSocialShare")){
			if(!document.getElementById("tim_fb_button")){
				setTimeout("communities.initFB();",1000);
				return 0;
			}
		}

		this.page_info["domain_key"]	=	this.cl_domain(document.domain);
				
		if('undefined' == typeof this.keys["facebook"][this.page_info["domain_key"]]){
			this.fb_supported=false;
			//try{console.log("Domain no allowed");}catch(err){}
		}//else{
						
			if(!document.getElementById("fb-root")){
				var d = document.createElement('div'); d.id="fb-root";
				document.getElementsByTagName('body')[0].appendChild(d);
			}
	
			if('undefined' == typeof FB){

				
				var fb_communities_id=communities.keys["facebook"][communities.page_info["domain_key"]];
				if( 'undefined' == typeof communities.keys["facebook"][communities.page_info["domain_key"]] ){
					fb_communities_id=119046504784892;	
				}
				(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId="+fb_communities_id+"&version=v2.0";
					  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				
				/*
				var f = document.createElement('script');
				f.async = true;
				f.src = document.location.protocol + '//connect.facebook.net/es_ES/all.js';
				document.getElementById('fb-root').appendChild(f);
				*/
				
				
			}		
			/*
			var fb_communities_id=communities.keys["facebook"][communities.page_info["domain_key"]];
			if( 'undefined' == typeof communities.keys["facebook"][communities.page_info["domain_key"]] ){
				fb_communities_id=119046504784892;	
			}

			window.fbAsyncInit = function(){
				FB.init({
					appId: fb_communities_id,
					status: true,
					cookie: true,
					xfbml: true
				});
			}
			*/
					
		//}
	},
	startSocialShare : function(){
		this.loadJS(this.comments_server+"js/socialShare.js");
	},
	startSocialShare2 : function(){
		this.loadJS(this.comments_server+"js/socialShare_2.js");
	},
	startSocialShare3 : function(){
		this.loadJS(this.comments_server+"js/socialShare_3.js");
	},
	startSocialShare4 : function(){
		this.loadJS(this.comments_server+"js/socialShare_4.js");
	},
	startMinxMin : function(){
		this.loadJS(this.comments_server+"js/minxmin.js");
	},
	init:function(){
	
		communities.url	=	communities.cl_url(document.location.href);	
		
		if (document.getElementById("wdg_twitt_01") || document.getElementById("wdg_twitt_02") ){
			this.loadJS(this.comments_server+'js/tweeting_rga.js');
		}else if (typeof tweet_config!="undefined"){
			this.loadJS(this.comments_server+'js/tweeting.js');
		}

		if(typeof config_socialMedia !="undefined" || document.getElementById("widgetSocialShare")){
			this.startSocialShare();
			/*
			if (document.location.href.search("televisa/deportes")!=-1 || document.location.href.search("deportes.televisa.com")!=-1 ){
				setTimeout("communities.startSocialShare();",5000);
			}else{
				this.startSocialShare();	
			}
			*/
		}else if(document.getElementById("widgetSocialShare2")){
			this.startSocialShare2();
		}else if(document.getElementById("widgetSocialShare3")){
			this.startSocialShare3();
		}else if(document.getElementById("widgetSocialShare4")){
			this.startSocialShare4();
		}

		this.initFB();
		this.startComments();		
		this.startMoreViews();		
		this.setView();
		this.startMailing();	
		this.startImageFeed();		

		if(typeof config_mxm !="undefined" || document.getElementById("minutos") || document.getElementById("minDeportes")){
			this.startMinxMin();
		}
				
		if ( document.getElementById("comm_num_views") || document.getElementById("comm_num_comments") || document.getElementById("comm_num_comments2") || document.getElementById("comm_num_stars") ){
			var display_views=true;
			try{if(comm_general_config.views.load==0){display_views=false;}}catch(err){}
			if(display_views){this.loadJS(this.comments_server+"views/load.php?url="+this.url);}
		}
		
		try{
				poll = document.getElementsByClassName("esmas_safe_simple_poll_box");
				if (poll.length > 0) {
					
					if (document.location.href.search("www.televisa.com/canal5/")!=-1 || document.location.href.search("cgs-003.esmas.com/")!=-1 ){
                		this.loadJS(this.comments_server+'js/polls.js');
                		this.loadcss("http://i2.esmas.com/comunidades/css/polls/main.css");
            		}else{
						this.start_polls(poll);
						this.loadcss("http://i2.esmas.com/comunidades/css/polls/main.css");
					}
				}

		}catch (err) {}

		if('undefined' != typeof json_stars){this.multiple_stars();}
			
	}, /* END: init() */
	//START tim_social functions
	start_polls	:	function(polls){
		try {
			
			if ('undefined' == typeof polls) {
				polls = document.getElementsByClassName("esmas_safe_simple_poll_box");
			}
			
			if ('undefined' != typeof esmas_safe_boxattributes) {
				
				if (esmas_safe_boxattributes.length==polls.length) {
						
					wait4me	=	this.readmeta();
					info={};
					
					for (i = 0; i < esmas_safe_boxattributes.length; i++) {
						
						id		=	esmas_safe_boxattributes[i][0].box_id;
						
						info[id]={};
						
						info[id]["box_guid"]=	esmas_safe_boxattributes[i][0].box_guid;
						info[id]["img"]		=	"http://i2.esmas.com/comunidades/img/polls/faceEncuestasThumb.jpg";
						info[id]["msg"]		=	"Participa en la encuesta de "+this.sites[this.page_info["domain_key"]];
						info[id]["url"]		=	this.page_info["url"]+"#poll_"+id;
						info[id]["title"]	=	this.page_info["meta"]["title"];
						info[id]["enc_guid"]=	"";
						anc	='<a href="#poll_'+id+'"></a>';
						
						if (esmas_safe_boxattributes[i][0].encuestas[0].url != "") {
							info[id]["msg"]="Participa en la encuesta "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name;
							info[id]["url"]=esmas_safe_boxattributes[i][0].encuestas[0].url;
							info[id]["title"]="Encuesta: "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name;
						}
						if(esmas_safe_boxattributes[i][0].encuestas[0].enc_name!=""){
							info[id]["title"]= "Encuesta: "+esmas_safe_boxattributes[i][0].encuestas[0].enc_name;
						}
						if ('undefined' != typeof esmas_safe_boxattributes[i][0].encuestas[0].img){
							info[id]["img"]=esmas_safe_boxattributes[i][0].encuestas[0].img;
						}
						if('undefined' != typeof esmas_safe_boxattributes[i][0].encuestas[0].enc_guid){
							if (esmas_safe_boxattributes[i][0].encuestas[0].enc_guid != "") {
								info[id]["enc_guid"]=esmas_safe_boxattributes[i][0].encuestas[0].enc_guid;
							}	
						}
						
						this.msg.twitter[id]={};
						this.msg.twitter[id]=info[id];
						this.msg.facebook[id]={};
						this.msg.facebook[id]=info[id];
						
						code='<div class="ts_poll_cont"><ul class="share_poll_tim_social">';
						code+='<li class="poll_text_share"> <div>COMPARTE ESTA ENCUESTA </div></li>';
						code+='<li><input type="button" class="btn_poll_twitter_off" id="btn_poll_twitter_'+id+'" onclick="communities.active_twitter_poll('+id+')" /></li>';
						code+='<li><input type="button" class="btn_poll_facebook_off" id="btn_poll_facebook_'+id+'" onclick="communities.active_facebook_poll('+id+')" /></li></ul>'; 
						code+='<div id="cnt_fb_poll'+id+'" class="invisible_ts"></div>';
						code+='<div id="cnt_tw_poll'+id+'" class="invisible_ts"></div></div>';
						
						if(document.getElementById("esmas_safe_simplepoll_iframe_"+info[id]["box_guid"])){
							
							if(document.getElementById("safe_poll_socialmedia_"+info[id]["enc_guid"])){
								
								if(!document.getElementById("btn_poll_twitter_"+id)){
									document.getElementById("safe_poll_socialmedia_"+info[id]["enc_guid"]).innerHTML=anc+code;
								}
							}	
						}else{setTimeout("communities.start_polls();",500);}

						if(!document.getElementById("tim_social_frame_container")){
							a = document.createElement("div");
				        	a.id = "tim_social_frame_container";
				        	a.name = "tim_social_frame_container";
				        	try{
				        		a.style.display="none";
				        	}catch(err){	}
				        	document.getElementsByTagName("body")[0].appendChild(a);
				        	document.getElementById("tim_social_frame_container").innerHTML = '<iframe src="' + communities.comments_server + '" height="1" width="1" frameborder="0" name="tim_social_frame" id="tim_social_frame" allowtransparency="yes"></iframe>';
						}
						
					}
				}else{setTimeout("communities.start_polls();",500); }
			}/* 'undefined' */
			else {
				setTimeout("communities.start_polls();",500);
				
			}/* else:'undefined' */
		}catch(err){	}
		
	},
	///BEGIN Twitter Poll
	active_twitter_poll	:	function(num){
		this.active_service="twitter";
		this.community_stats();
		this.page_info["bitly"]="";
		if(document.getElementById("cnt_tw_poll"+num)){
			if(document.getElementById("cnt_tw_poll"+num).className=="visible_ts"){
				document.getElementById("cnt_tw_poll"+num).className="invisible_ts";
				document.getElementById("cnt_fb_poll"+num).className="invisible_ts";
				document.getElementById("btn_poll_twitter_" + num).className="btn_poll_twitter_off";
				document.getElementById("btn_poll_facebook_" + num).className="btn_poll_facebook_off";
			}else{
				document.getElementById("cnt_tw_poll"+num).className="visible_ts";
				document.getElementById("cnt_fb_poll"+num).className="invisible_ts";
				document.getElementById("btn_poll_twitter_" + num).className="btn_poll_twitter_on";
				document.getElementById("btn_poll_facebook_" + num).className="btn_poll_facebook_off";
			}
		}
		
		this.loadJS(this.comments_server+"bitly/?url="+this.msg.facebook[num].url);
		
		if(this.page_info["bitly"]==""){this.start_twitterpoll(num);}else{this.start_twitterpoll(num);}
	},
	start_twitterpoll	:	function(ele,num){
		if('undefined' == typeof num){num=0;}
		
		if(num<5 && this.page_info["bitly"]==""){
			setTimeout("communities.start_twitterpoll("+ele+","+(num+1)+")",500);
			return false;
		}
		if(this.page_info["bitly"]==""){
			this.page_info["bitly"]=this.msg.facebook[ele].url;	
		}
		this.page_info["bitly"]+='#poll_'+ele
		
		if(document.getElementById("cnt_tw_poll"+ele)){
				this.print_twform("cnt_tw_poll"+ele,this.msg.twitter[ele].msg+" "+this.page_info["bitly"]);
		}		
	},
	print_twform	:	function(div,msg){
		code='<form method="get" action="http://comentarios.esmas.com/twitterPost.php" target="tim_social_frame" id="twitter_form" name="twitter_form">';
		code+='<textarea id="twitter_text" name="comment" >'+msg+'</textarea>';
		code+='<input type="button" value="&nbsp;" onclick="communities.sendmsgTWpoll(this.form);"  class="btn_enviar">';
		code+='</form>';
		if (document.getElementById(div)) {
			document.getElementById(div).innerHTML=code;
		}
	},
	sendmsgTWpoll	:function(obj){
		if(obj.twitter_text.value==''){
			alert('Inserta un comentario');
			return false;
		}
		this.twform=obj;
		var popup_handler=window.open(this.comments_server+'tw_popup2.php?url='+document.location.href+'&ran='+(+new Date),'Registro','width=800,height=400');
						
		this.waitpopup(popup_handler);
	},
	waitpopup	:	function(el){
		this.popupobject=el;
		if(el.closed){
			this.reedTwittCoookie();
		}else{
			setTimeout("communities.waitpopup(communities.popupobject)",1000);	
		}
	},
	reedTwittCoookie:function(num){
		if('undefined' == typeof num){num=0;}
		if(this.readCookie("tw_user_data")){
			
			var tmp=this.readCookie("tw_user_data").split("|");
			
			document.getElementById("tim_social_frame").src=this.comments_server;
			
			this.twform.submit();
			
			alert("Has compartido la encuesta.");
			this.active_service="twitter";
			this.community_stats(this.url,1);
		}else{
			if(num==0){
				this.loadJS(this.comments_server+"readTwitterCookie3.php?url="+document.location.href);	
			}
			if (num < 10) {
				setTimeout("communities.reedTwittCoookie("+(num+1)+")",1000);
			}else{
				alert("No se ha podido enviar el mensaje");
			}
			
		}
	},
	///END Twitter Poll
	///BEGIN Facebook Poll
	active_facebook_poll	:	function(num){
		
		this.active_service="facebook";
		this.community_stats();
		
		if(document.getElementById("cnt_fb_poll"+num)){
			
			if(document.getElementById("cnt_fb_poll"+num).className=="visible_ts"){
				
				document.getElementById("cnt_fb_poll"+num).className="invisible_ts";
				document.getElementById("cnt_tw_poll"+num).className="invisible_ts";
				document.getElementById("btn_poll_twitter_" + num).className="btn_poll_twitter_off";
				document.getElementById("btn_poll_facebook_" + num).className="btn_poll_facebook_off";
			}else{
				
				document.getElementById("cnt_fb_poll"+num).className="visible_ts";
				document.getElementById("cnt_tw_poll"+num).className="invisible_ts";
				document.getElementById("btn_poll_twitter_" + num).className="btn_poll_twitter_off";
				document.getElementById("btn_poll_facebook_" + num).className="btn_poll_facebook_on";
			}
		}
		
		if(document.getElementById("cnt_fb_poll"+num)){
			
			document.getElementById("cnt_fb_poll"+num).innerHTML="";
		}
		
		this.print_fbform("cnt_fb_poll"+num,this.msg.facebook[num].url,this.msg.facebook[num].msg,this.msg.facebook[num].title,this.msg.facebook[num].img,"communities.pollfbOk()","communities.pollfbEr()")
	},
	print_fbform	:	function(div,url,msg,title,img,callbackok,callbackerr){
		
		if('undefined' == typeof msg){msg="Entra a ver esto, seguro te interesara tanto como a mi";}
		if('undefined' == typeof url){url=this.page_info["url"];}
		if('undefined' == typeof title){title="";}
		if('undefined' == typeof img){img="";}
		if('undefined' == typeof callbackok){callbackok="alert('El mensaje ha sido publicado en tu muro')";}
		if('undefined' == typeof callbackerr){callbackerr="alert('El mensaje no ha podido ser publicado. \n\r Por Favor intentalo nuevamente mas tarde.')";}
		code='<form method="post" name="FB_tim_social_poll" target="tim_social_frame" action="http://comunidades.esmas.com/facebook/post/" >';
		code+='<textarea name="msg">'+msg+'</textarea>';
		code+='<input type="hidden" value="'+url+'" name="url">';
		code+='<input type="hidden" value="'+title+'" name="description">';
		code+='<input type="hidden" value="'+img+'" name="img">';
		code+='<input type="hidden" value="'+callbackok+'" name="callbackok">';
		code+='<input type="hidden" value="'+callbackerr+'" name="callbackerr">';
		code+='<input type="button" value="&nbsp;" onclick="communities.sendmsgFBpoll(this.form);"  class="btn_enviar">';
		code+='</form>';
		if (document.getElementById(div)) {
			document.getElementById(div).innerHTML=code;
		}
	},
	sendmsgFBpoll: function (obj){
		if(obj.msg.value==""){
			return false;
		}
		if(this.page_info["fb_status"]==0){
			wait4me = this.checkStatus_fb(true,"communities.sendFBFormpoll('"+obj.msg.value+"','"+obj.url.value+"','"+obj.description.value+"','"+obj.img.value+"','communities.pollfbOk()','communities.pollfbEr()')");
			return false;
		}
		this.sendFBFormpoll(obj.msg.value,obj.url.value,obj.description.value,obj.img.value,obj.callbackok.value,obj.callbackerr.value);
		return false;
	},
	sendFBFormpoll	:	function(msg,url,title,img,callbackok,callbackerr){
		if('undefined' == typeof msg){return false;}
		if('undefined' == typeof url){url=this.page_info["url"];}
		if('undefined' == typeof title){title="";}
		if('undefined' == typeof img){img="";}
		if('undefined' == typeof callbackok){callbackok="alert('El mensaje ha sido publicado en tu muro')";}
		if('undefined' == typeof callbackerr){callbackerr="alert('El mensaje no ha podido ser publicado. \n\r Por Favor intentalo nuevamente mas tarde.')";}
		apost={message:msg,link:url}
			
		if(title!=""){ apost["name"]=title;	}
		if(img!=""){ apost["picture"]=img;	}
		if('undefined' != typeof tim_poll_config){apost["picture"]=tim_poll_config.img;}
		
		FB.api('/me/feed', 'post', apost, function(response) {
			  if (!response || response.error) {
				setTimeout(callbackerr,500);
			  } else {
			  	communities.active_service="facebook";
				communities.community_stats(communities.url,1);
				eval(callbackok);
			  }
		});
	},
	pollfbOk	:	function(){
		alert("La encuesta ha sido compartida en tu perfil.");
	},
	pollfbEr	:	function(){
		alert("No ha sido posible publicar tu mensaje por favor intentalo nuevamente mas tarde.");
	},
	///END Facebook Poll
	readmeta	:	function(){
		try{
			if(this.page_info["meta"]==""){
				this.page_info["meta"]={};
				var metas = document.getElementsByTagName('META');
				for (i = 0; i < metas.length; i++){
					if(metas[i].getAttribute('NAME')!=null){
						name=metas[i].getAttribute('NAME');
						name=name.toLowerCase();
						if ('undefined' == typeof this.page_info["meta"]["title"]) {
							this.page_info["meta"]["title"] = document.title;
						}
						else {
							if (name == "title"){this.page_info["meta"]["title"] = metas[i].getAttribute('CONTENT'); }
							if (name == "description"){this.page_info["meta"]["description"] =	metas[i].getAttribute('CONTENT'); }
						}/*undefined*/
					}
				}
			}
		}catch(err){}
		return true;
	},
	loadcss:function (url){
		//alert(url)
		var cssNode = document.createElement('link');
		cssNode.type = 'text/css';
		cssNode.rel = 'stylesheet';
		cssNode.href = url;
		document.getElementsByTagName("head")[0].appendChild(cssNode);	
	},
	community_stats	:	function(url,service_status){
		if (typeof url == "undefined") { url=this.url;	}
		if (typeof service_status == "undefined") { service_status=0;}
		if(typeof video_embed_url!="undefined"){
				url=video_embed_url;
		}
		COMM_img_set = document.createElement("IMG");
		COMM_img_set.src = "http://v.esmas.com:8081/"+this.active_service+"/spacer.gif?1|"+service_status+"|"+url;
		if(this.active_service!=""){
			if(service_status==0){text_share="open";}else{text_share="share";}
			try{pageTracker._setCustomVar(1,"Social_Share_"+this.active_service+"_"+text_share,url,2);}catch(e){}
			document.body.appendChild(COMM_img_set);	
		}
	},
	multiple_stars	:	function(){
		this.loadJS(this.comments_server+'js/comm_stars_2.js');
	},
	//END tim_social functions
	getTinyUrl: function(normal_url, callback, num_tries, clear_var ){
		var max_counts=5;

		if(typeof clear_var !="undefined" ){
			delete this.page_info['bitly'];
			var num_tries=1;
			this.loadJS(this.comments_server+"bitly/index2.php?url="+this.cl_url(normal_url));
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;
		}

		if(typeof this.page_info['bitly'] !="undefined" && this.page_info['bitly'] !=""){
			eval(callback+'("'+this.page_info['bitly']+'");');
			return true;
		}else if (typeof num_tries == "undefined" ||  num_tries==0) {
			var num_tries=1;
			this.loadJS(this.comments_server+"bitly/index2.php?url="+this.cl_url(normal_url));
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;
		}else if (num_tries<max_counts){
			num_tries+=1;
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;	
		}else{
			eval(callback+'("'+normal_url+'");');
			return false;
		}
	}
	/*
	getTinyUrl: function(normal_url, callback, num_tries, clear_var ){
		var max_counts=5;
		
		//var d = new Date();
		//var Y = d.getFullYear();
		//var m = String(d.getMonth()+1);
		//if(m.length==1){m='0'+m}
		var url_md5=hex_md5(this.cl_url(normal_url));
		var sub_dir=url_md5.substring(0,3);

		//this.comments_server='http://stagin.esmas.com/';

		if(typeof clear_var !="undefined" ){
			delete this.page_info['bitly'];
			var num_tries=1;
			//this.loadJS(this.comments_server+"bitlystorage/"+Y+"/"+m+"/"+url_md5+"?url="+this.cl_url(normal_url));
			this.loadJS(this.comments_server+"bitlystorage/"+sub_dir+"/"+url_md5+"?url="+this.cl_url(normal_url));
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;
		}

		if(typeof this.page_info['bitly'] !="undefined" && this.page_info['bitly'] !=""){
			eval(callback+'("'+this.page_info['bitly']+'");');
			return true;
		}else if (typeof num_tries == "undefined" ||  num_tries==0) {
			var num_tries=1;
			//this.loadJS(this.comments_server+"bitlystorage/"+Y+"/"+m+"/"+url_md5+"?url="+this.cl_url(normal_url));
			this.loadJS(this.comments_server+"bitlystorage/"+sub_dir+"/"+url_md5+"?url="+this.cl_url(normal_url));
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;
		}else if (num_tries<max_counts){
			num_tries+=1;
			setTimeout("communities.getTinyUrl('"+normal_url+"','"+callback+"',"+num_tries+")",300);
			return true;	
		}else{
			eval(callback+'("'+normal_url+'");');
			return false;
		}
	}
	*/
};

if(typeof init_comunidades=="undefined"){
	var init_comunidades=1;
	communities.init(); 
}
if(typeof config_mailing=="undefined"){
    var config_mailing = {
        msgs:{
            "title"  : 'Televisi&oacuten',
            "text"   : 'Inscr&iacute;bete y recibe las noticias m&aacute;s populares y lo &uacuteltimo de las telenovelas',
            "button_text"   : 'Inscr&iacute;bete',
            "thanks_text"   : 'Gracias por suscribirte.',
            "input_text"	: 'Correo electr&oacute;nico',
            "working_msg"   : 'La informaci&oacute;n se est&aacute; enviando.' 
        },
        templates: {
            "form"   :'<form method="post" action="{server}" target="social_mailing" name="mailing-form-post" id="mailing-form-post" onsubmit="return mailing.validate(this);"> <div class="container-top"><div class="img-download"></div><p>{text}</p></div><div class="container-email"><div class="container-right"><input type="text" value="{input_text}" name="email"  onfocus="mailing.cleaninput(this)" onblur="mailing.cleaninput(this,0)"  class="email-txt"></div></div><div class="container-btn"><input type="submit" value="{button_text}" class="subscribe"></div></form>',
            "working"   : '<div class="container-top"><div class="img-download"></div><p>{working_msg}</p></div><div class="container-email"><div class="container-right"></div></div>',
            "thanks"    : '<div class="container-top"><div class="img-download"></div><p>{thanks_text}</p></div><div class="container-email"><div class="container-right"></div></div>'
        },
        imgs : {
            logo     : 'http://i2.esmas.com/comunidades/registro/img/multireg_ic_tvsa.png'
        },
        css  : 'http://i2.esmas.com/comunidades/css/mailing/mailing-rediseno.css'
    };
}
var hexcase=0;function hex_md5(a){return rstr2hex(rstr_md5(str2rstr_utf8(a)))}function hex_hmac_md5(a,b){return rstr2hex(rstr_hmac_md5(str2rstr_utf8(a),str2rstr_utf8(b)))}function md5_vm_test(){return hex_md5("abc").toLowerCase()=="900150983cd24fb0d6963f7d28e17f72"}function rstr_md5(a){return binl2rstr(binl_md5(rstr2binl(a),a.length*8))}function rstr_hmac_md5(c,f){var e=rstr2binl(c);if(e.length>16){e=binl_md5(e,c.length*8)}var a=Array(16),d=Array(16);for(var b=0;b<16;b++){a[b]=e[b]^909522486;d[b]=e[b]^1549556828}var g=binl_md5(a.concat(rstr2binl(f)),512+f.length*8);return binl2rstr(binl_md5(d.concat(g),512+128))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binl(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(c%32)}return a}function binl2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(c%32))&255)}return a}function binl_md5(p,k){p[k>>5]|=128<<((k)%32);p[(((k+64)>>>9)<<4)+14]=k;var o=1732584193;var n=-271733879;var m=-1732584194;var l=271733878;for(var g=0;g<p.length;g+=16){var j=o;var h=n;var f=m;var e=l;o=md5_ff(o,n,m,l,p[g+0],7,-680876936);l=md5_ff(l,o,n,m,p[g+1],12,-389564586);m=md5_ff(m,l,o,n,p[g+2],17,606105819);n=md5_ff(n,m,l,o,p[g+3],22,-1044525330);o=md5_ff(o,n,m,l,p[g+4],7,-176418897);l=md5_ff(l,o,n,m,p[g+5],12,1200080426);m=md5_ff(m,l,o,n,p[g+6],17,-1473231341);n=md5_ff(n,m,l,o,p[g+7],22,-45705983);o=md5_ff(o,n,m,l,p[g+8],7,1770035416);l=md5_ff(l,o,n,m,p[g+9],12,-1958414417);m=md5_ff(m,l,o,n,p[g+10],17,-42063);n=md5_ff(n,m,l,o,p[g+11],22,-1990404162);o=md5_ff(o,n,m,l,p[g+12],7,1804603682);l=md5_ff(l,o,n,m,p[g+13],12,-40341101);m=md5_ff(m,l,o,n,p[g+14],17,-1502002290);n=md5_ff(n,m,l,o,p[g+15],22,1236535329);o=md5_gg(o,n,m,l,p[g+1],5,-165796510);l=md5_gg(l,o,n,m,p[g+6],9,-1069501632);m=md5_gg(m,l,o,n,p[g+11],14,643717713);n=md5_gg(n,m,l,o,p[g+0],20,-373897302);o=md5_gg(o,n,m,l,p[g+5],5,-701558691);l=md5_gg(l,o,n,m,p[g+10],9,38016083);m=md5_gg(m,l,o,n,p[g+15],14,-660478335);n=md5_gg(n,m,l,o,p[g+4],20,-405537848);o=md5_gg(o,n,m,l,p[g+9],5,568446438);l=md5_gg(l,o,n,m,p[g+14],9,-1019803690);m=md5_gg(m,l,o,n,p[g+3],14,-187363961);n=md5_gg(n,m,l,o,p[g+8],20,1163531501);o=md5_gg(o,n,m,l,p[g+13],5,-1444681467);l=md5_gg(l,o,n,m,p[g+2],9,-51403784);m=md5_gg(m,l,o,n,p[g+7],14,1735328473);n=md5_gg(n,m,l,o,p[g+12],20,-1926607734);o=md5_hh(o,n,m,l,p[g+5],4,-378558);l=md5_hh(l,o,n,m,p[g+8],11,-2022574463);m=md5_hh(m,l,o,n,p[g+11],16,1839030562);n=md5_hh(n,m,l,o,p[g+14],23,-35309556);o=md5_hh(o,n,m,l,p[g+1],4,-1530992060);l=md5_hh(l,o,n,m,p[g+4],11,1272893353);m=md5_hh(m,l,o,n,p[g+7],16,-155497632);n=md5_hh(n,m,l,o,p[g+10],23,-1094730640);o=md5_hh(o,n,m,l,p[g+13],4,681279174);l=md5_hh(l,o,n,m,p[g+0],11,-358537222);m=md5_hh(m,l,o,n,p[g+3],16,-722521979);n=md5_hh(n,m,l,o,p[g+6],23,76029189);o=md5_hh(o,n,m,l,p[g+9],4,-640364487);l=md5_hh(l,o,n,m,p[g+12],11,-421815835);m=md5_hh(m,l,o,n,p[g+15],16,530742520);n=md5_hh(n,m,l,o,p[g+2],23,-995338651);o=md5_ii(o,n,m,l,p[g+0],6,-198630844);l=md5_ii(l,o,n,m,p[g+7],10,1126891415);m=md5_ii(m,l,o,n,p[g+14],15,-1416354905);n=md5_ii(n,m,l,o,p[g+5],21,-57434055);o=md5_ii(o,n,m,l,p[g+12],6,1700485571);l=md5_ii(l,o,n,m,p[g+3],10,-1894986606);m=md5_ii(m,l,o,n,p[g+10],15,-1051523);n=md5_ii(n,m,l,o,p[g+1],21,-2054922799);o=md5_ii(o,n,m,l,p[g+8],6,1873313359);l=md5_ii(l,o,n,m,p[g+15],10,-30611744);m=md5_ii(m,l,o,n,p[g+6],15,-1560198380);n=md5_ii(n,m,l,o,p[g+13],21,1309151649);o=md5_ii(o,n,m,l,p[g+4],6,-145523070);l=md5_ii(l,o,n,m,p[g+11],10,-1120210379);m=md5_ii(m,l,o,n,p[g+2],15,718787259);n=md5_ii(n,m,l,o,p[g+9],21,-343485551);o=safe_add(o,j);n=safe_add(n,h);m=safe_add(m,f);l=safe_add(l,e)}return Array(o,n,m,l)}function md5_cmn(h,e,d,c,g,f){return safe_add(bit_rol(safe_add(safe_add(e,h),safe_add(c,f)),g),d)}function md5_ff(g,f,k,j,e,i,h){return md5_cmn((f&k)|((~f)&j),g,f,e,i,h)}function md5_gg(g,f,k,j,e,i,h){return md5_cmn((f&j)|(k&(~j)),g,f,e,i,h)}function md5_hh(g,f,k,j,e,i,h){return md5_cmn(f^k^j,g,f,e,i,h)}function md5_ii(g,f,k,j,e,i,h){return md5_cmn(k^(f|(~j)),g,f,e,i,h)}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)}function bit_rol(a,b){return(a<<b)|(a>>>(32-b))};