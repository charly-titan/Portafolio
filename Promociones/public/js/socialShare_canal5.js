



var socialShare={
		pinterest	:	["horizontal","vertical","none"],
		gplus 		:	{size:["small","medium","","tall" ],data: ["none","inline",""]},
		twitter 	: 	["none","horizontal","vertical"],
		facebook 	: 	{"data-layout":["box_count"]},
		config 		:	{ "selector" : "elements",
						  "options"  : {
							"facebook":[1,{}],
							"twitter" : [1,{}],
							"pinterest":[1,{}],
							"google":[1,{}],
							"comments":[0,{}],
							"mail":[1,{}]
							}
						},
		pageInfo 	: 	{
						"url"			: 	"",
						"description"	: 	"",
						"title"			: 	"", 
						"thumbnail"		: 	""
		},
		
		
		insertMail	: function(){
			div = '<div class="mail">';
			div +='<a href="mailto:?subject='+this.getTitle()+'&body='+this.pageInfo["url"]+'" ></a>';
			div +='</div>';
			return div;
		},

		insertTwitter	: function(){
			div = '<div class="twitter">';
			div +='<a href="http://www.twitter.com/" onclick="popUp=window.open(\'http://comentarios.esmas.com/tw_popup2.php?url='+escape(this.pageInfo["url"])+'&status='+encodeURIComponent(this.getTitle())+'\', \'popupwindow\', \'width=700,height=300\'); popUp.focus(); return false;"></a>'; 
			div +='</div>';
			return div;
		},

		insertTwitter2	: function(){
			
			twitter_url=this.pageInfo["url"];
			tw_status=encodeURIComponent(this.getTitle()+' - '+twitter_url+' ');

			div = '<div class="twitter">';
			div +='<a href="http://www.twitter.com/" onclick="popUp=window.open(\'https://twitter.com/home?status='+tw_status+'\',\'popupwindow\', \'width=700,height=300\'); popUp.focus(); return false;"></a>'; 
			div +='</div>';
			return div;
		},

		insertFacebook	: function(){
			div = '<div class="facebook">';
			div +='<a href="http://www.facebook.com/" onclick="popUp=window.open(\'https://www.facebook.com/sharer.php?u='+escape(this.pageInfo["url"])+'\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;"></a>'; 
			div +='</div>';
			return div;
		},
		
		insertPinterest	: function(){
			div = '<div class="pinterest">';
			div +='<a href="http://www.pinterest.com/" onclick="popUp=window.open(\'https://pinterest.com/pin/create/button/?url='+this.pageInfo["url"]+'&media='+this.getMetaInfo("image_src")+'&description='+encodeURIComponent(this.getMetaInfo("description"))+'\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;"></a>'; 
			div +='</div>';
			return div;
		},

		insertGoogle	: function(){
			div = '<div class="google">';
			div +='<a href="http://www.plusone.google.com/" onclick="popUp=window.open(\'https://plus.google.com/share?url='+this.pageInfo["url"]+'\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;"></a>';
			div +='</div>';
			return div;
		},

		insertComments	: function(){
			div = '<div class="comments">';
			div +='<a href="#COMM_comments_social" ><img src="/img/gplus.jpg"/></a></div>';
			div +='</div>';
			return div;
		},

		waitForBitly: function(num_try){
					
			var twitter_url=this.pageInfo["url"];
			if(typeof customUrl !="undefined"){
				twitter_url=customUrl;
			}

			//twitter_url="http://noticieros.televisa.com/mundo/1405/se-desatan-protestas-turquia-accidente-mina/";
			var tw_status='';
			if(typeof communities !="undefined"){
				if(typeof communities.page_info['bitly'] !="undefined" && communities.page_info['bitly'] !=""){
					//twitter_url=communities.page_info['bitly'];
					tw_status=encodeURIComponent(this.getTitle()+' - '+twitter_url+' ');
					popUp=window.open('http://twitter.com/home?status='+tw_status,'popupwindow', 'width=800,height=400');
					popUp.focus();
				}
			}

			if(num_try==0){

				try{
					communities.loadJS("http://comentarios.esmas.com/bitly/?url="+twitter_url);
				}catch(e){
					comunidades.loadJS("http://comentarios.esmas.com/bitly/?url="+twitter_url);
				}

				setTimeout("socialShare.waitForBitly(1)",1000);

			}else{
				tw_status=encodeURIComponent(this.getTitle()+' - '+twitter_url+' ');
				popUp=window.open('https://twitter.com/home?status='+tw_status,'popupwindow', 'width=800,height=400');
				popUp.focus();

			}

		},

		loadJsGoogle	: function(){
			window.___gcfg = {lang: 'es-419'};
			(function() {
    			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    			po.src = 'https://apis.google.com/js/plusone.js';
    			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  			})();
		},

		loadJsPinterest	: function(){
			try{communities.loadJS("//assets.pinterest.com/js/pinit.js");}catch(e){comunidades.loadJS("//assets.pinterest.com/js/pinit.js");}
		},

		loadJsTwitter	:	function (){
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
		},

		loadJsFacebook	:	function (){
			if(!document.getElementById("fb-root")){
				var div	=	document.createElement('div');
				div.setAttribute('id','fb-root');
		 		var body	=	document.getElementsByTagName('body')[0];
				body.appendChild(div);
			}
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;

			  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=122079244481169";

//			  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=227195210813596";

			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			return true;
		},

		getMetaInfo		:	function (meta){
			if(typeof meta =="undefined"){return "";}
			var description;
			var metas = document.getElementsByTagName('meta');
			for (var x=0,y=metas.length; x<y; x++) {
				if (metas[x].name.toLowerCase() == meta.toLowerCase()) {
	   				description = metas[x];
	 			}
			}
			try{
				return description.content;
			}catch(e){}

			links = document.getElementsByTagName('link');
			for (var x=0,y=links.length; x<y; x++) {
				if (links[x].rel.toLowerCase() == meta.toLowerCase()) {
	   				description = links[x];
	 			}
			}
			try{
				return description.href;
			}catch(e){}

			return "";

		},
			
		getDescription	:	function(customDescription){
			if(typeof customDescription =="undefined"){
				customDescription="";
			}else{return customDescription;}
			try{
				return self.getMetaInfo("description");
			}catch(e){return "";}
			
		},

		getTitle	:	function(){
			if(typeof customTitle =="undefined"){
				customTitle="";
			}else{return customTitle;}
			try{
				return self.getMetaInfo("title");
			}catch(e){return "";}
		},

		printNumComments:function(){

			if(typeof commenta!="undefined"){
				if(typeof commenta.json!="undefined"){
					document.getElementById('comm_div_num').innerHTML=commenta.json.data.total;
				}
			}
		},

		addCSS:function (cssCode) { 
			var styleElement = document.createElement("style");
			styleElement.type = "text/css";
			if (styleElement.styleSheet){
				styleElement.styleSheet.cssText = cssCode; 
			} else {
				styleElement.appendChild(document.createTextNode(cssCode));
			}
			document.getElementsByTagName("head")[0].appendChild(styleElement);
		},


		init	: function(){
			
			if(typeof comm_general_config !="undefined"){
				if(typeof comm_general_config.socialShare !="undefined"){

					try{this.config.options.facebook[0]=comm_general_config.socialShare.display.facebook[0];}catch(e){}
					try{this.config.options.twitter[0]=comm_general_config.socialShare.display.twitter[0];}catch(e){}
					try{this.config.options.pinterest[0]=comm_general_config.socialShare.display.pinterest[0];}catch(e){}
					try{this.config.options.google[0]=comm_general_config.socialShare.display.google[0];}catch(e){}
					//try{this.config.options.comments[0]=comm_general_config.socialShare.display.comments[0];}catch(e){}
					try{this.config.options.mail[0]=comm_general_config.socialShare.display.mail[0];}catch(e){}
				}
			}



			try{
				if(document.getElementById("widgetSocialShare2")){
					try{this.pageInfo["url"]	= document.location.href;
					if(typeof customUrl !="undefined"){
						this.pageInfo["url"]=customUrl;
					}
				}catch(e){this.pageInfo["url"]			= 	comunidades.url;}


					this.pageInfo["title"]			=	this.getTitle();
					this.pageInfo["description"]	=	this.getDescription();
					//this.pageInfo["thumbnail"]		=	this.getTitle();

					rootDiv=document.getElementById("widgetSocialShare2");

					var buttons='';
					
					if(this.config.options.mail[0]==1){buttons+=this.insertMail();}
					if(this.config.options.twitter[0]==1){buttons+=this.insertTwitter2();}
					if(this.config.options.facebook[0]==1){buttons+=this.insertFacebook();}
					if(this.config.options.pinterest[0]==1){buttons+=this.insertPinterest();}
					if(this.config.options.google[0]==1){buttons+=this.insertGoogle();}
										
					rootDiv.innerHTML=buttons;

					try{
						start_metrics_buttons();
					}catch(e){

					}

					// this.addCSS(
					// 	"#widgetSocialShare2 .compartir{width:auto;position:relative;float:right;margin:0 10px 20px}"+
					// 	"#widgetSocialShare2 .mail a,.twitter a,.facebook a,.pinterest a,.google a{width:40px;height:40px;line-height:40px;background-size: 305px auto;display:block}"+
					// 	"#widgetSocialShare2  .mail a{background-image:url(/img/c5_sprite.png);background-position: 458px 203px;background-color:#FF8D13;margin:10px 10px 0 0}"+
					// 	"#widgetSocialShare2 .twitter a{background-image:url(/img/c5_sprite.png);background-position: 534px 75px;background-color:#32D6EF;margin:10px 10px 0 0}"+
					// 	"#widgetSocialShare2 .facebook a{background-image:url(/img/c5_sprite.png);background-position: 475px 75px;background-size:300px auto;margin:10px 10px 0 0;background-color:#325994}"+
					// 	"#widgetSocialShare2 .pinterest a{background-image:url(/img/c5_sprite.png);background-position: 381px 75px;background-color:#CB2028;margin:10px 10px 0 0}"+
					// 	"#widgetSocialShare2 .google a{background-image:url(/img/c5_sprite.png);background-position: 433px 75px;background-color:#DD4C3B;margin:10px 0 0}"+
					// 	"#widgetSocialShare2 .compartir div{float:left}"+
					// 	"#widgetSocialShare2 .compartir div a{opacity:1;cursor:pointer}"+
					// 	"#widgetSocialShare2 .compartir div a:hover{transition:all .5s ease 0;-o-transition:all .5s ease 0;-mos-transition:all .5s ease 0;-webkit-transition:all .5s ease 0;opacity:.8}"+

					// 	"@media (max-width:1009px) {"+
					// 	"#widgetSocialShare2 .tui-grid-medio-T2{width:calc((100% - 10px) / 1.7);width:-o-calc((100% - 10px) / 1.7);width:-moz-calc((100% - 10px) / 1.7);width:-webkit-calc((100% - 0px) / 1.7)}"+
					// 	"#widgetSocialShare2 .compartir div{margin:0 30px 0 0}"+
					// 	"}"+

					// 	"@media (max-width:1009px) and (min-width:360px) {"+
					// 	"#widgetSocialShare2 .compartir{margin:auto;float:none;width:320px}"+
					// 	"}"+


					// 	"@media (max-width:1009px) and (min-width:401px) {"+
					// 	"#widgetSocialShare2 .category{width:calc((100% - 10px) / 2);width:-o-calc((100% - 10px) / 2);width:-moz-calc((100% - 10px) / 2);width:-webkit-calc((100% - 10px) / 2);margin:20px 0 0 10px;float:right}"+
					// 	"#widgetSocialShare2 .buscador{margin:20px 0 0 10px}"+
					// 	"#widgetSocialShare2 #search_box input{min-width:100%;height:45px;line-height:45px}"+
					// 	"#widgetSocialShare2 #search_box button{height:45px;width:40px;background-position:612px 347px}"+
					// 	"#widgetSocialShare2 .compartir div{margin:20px 30px 12px 0}"+
					// 	"#widgetSocialShare2 .compartir div a{margin:0}"+
					// 	"#widgetSocialShare2 div.google{margin:20px 0 12px}"+
					// 	"}"+

					// 	"@media (max-width:680px) {"+
					// 	"#widgetSocialShare2 .buscador{max-width:100%;min-width:100%;margin:10px 0 0 10px}"+
					// 	"#widgetSocialShare2 .audiencia{margin:15px 0 0}"+
					// 	"#widgetSocialShare2 .todoschavos{margin:0 0 5px}"+
					// 	"#widgetSocialShare2 .tui-grid-medio-T2{width:calc((100% - 0px) * 0.7);width:-o-calc((100% - 0px) * 0.7);width:-moz-calc((100% - 0px) * 0.7);width:-webkit-calc((100% - 0px) * 0.7)}"+
					// 	"#widgetSocialShare2 .todoschavos,.actitudteen,.creciditos{float:none;width:calc((100%) / 1);width:-o-calc((100%) / 1);width:-moz-calc((100%) / 1);width:-webkit-calc((100%) / 1)}"+
					// 	"#widgetSocialShare2 .actitudteen{margin:0 0 5px}"+
					// 	"#widgetSocialShare2 .paginacion{display:none}"+
					// 	"#widgetSocialShare2 .compartir div a{margin:0}"+
					// 	"#widgetSocialShare2 .compartir{margin:auto;float:none;width:320px}"+
					// 	"#widgetSocialShare2 .category{width:100%}"+
					// 	"}"+


					// 	"@media (max-width:480px) {"+
					// 	"#widgetSocialShare2 .category{margin-top:0}"+
					// 	"#widgetSocialShare2 #search_box input{max-width:100%;min-width:100%;height:45px}"+
					// 	"#widgetSocialShare2 #search_box button{height:45px;background-position:612px 348px}"+
					// 	"#widgetSocialShare2 .audiencia .todoschavos,.audiencia .actitudteen,.audiencia .creciditos,.audiencia a,.audiencia a:hover{line-height:45px;height:45px}"+
					// 	"#widgetSocialShare2 .compartir div a{margin:0}"+
					// 	"#widgetSocialShare2 .compartir{margin:auto;float:none;width:240px}"+
					// 	"#widgetSocialShare2 .compartir div{float:left;margin:5px 10px 12px 0}"+
					// 	"#widgetSocialShare2 div.google{margin:5px 0 12px}"+
					// 	"}"
					// );

				}

			}catch(e){}
		}
};

if(document.getElementById("widgetSocialShare2")){
	socialShare.init();
}