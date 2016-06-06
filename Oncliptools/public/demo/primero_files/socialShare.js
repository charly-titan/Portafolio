

// var communities ={

// 	components	: [
// 		{"name": "socialMedia", "config":"config_socialMedia","div":[""], "js":"//mxm2.esmas.com/test/comunidades/socialMedia.js", "startFunction":"" }
			


		
// 	],

// 	getMetaInfo		:	function (meta){
// 			if(typeof meta =="undefined"){return "";}
// 			var description;
// 			var metas = document.getElementsByTagName('meta');
// 			for (var x=0,y=metas.length; x<y; x++) {
//   				if (metas[x].name.toLowerCase() == meta.toLowerCase()) {
//     				description = metas[x];
//   				}
// 			}
// 			if(typeof description.content !="undefined"){
// 				return description.content;
// 			}else{
// 				return " ";
// 			}
// 	},
		
// 	getDescription	:	function(customDescription){
// 		if(typeof customDescription =="undefined"){
// 			customDescription="";
// 		}else{return customDescription;}
// 		return self.getMetaInfo("description");
// 	},

// 	getTitle	:	function(customTitle){
// 		if(typeof customTitle =="undefined"){
// 			customTitle="";
// 		}else{return customTitle;}
// 		return self.getMetaInfo("title");
// 	},

// 	loadJs	:	function(url){
// 		var sc	=	document.createElement('script');
// 		sc.setAttribute('type','text/javascript');
// 		sc.setAttribute('async','true');
// 		sc.setAttribute('src',	url);
// 		var hd	=	document.getElementsByTagName('head')[0];
// 		hd.appendChild(sc);
// 		return true;
// 	},

// 	loadComponents : 	function(){
// 		try{

// 			for(numberComponent=0; numberComponent<this.components.length;numberComponent++){
// 				getJs=false;
// 				if(typeof window[this.components[numberComponent].config] !="undefined"){
// 						getJs=true;
// 				}
// 				if(typeof this.components[numberComponent]=="object"){
// 					for(divNumber=0;divNumber<this.components[numberComponent].div.length;divNumber++){
// 						if(document.getElementById(this.components[numberComponent].div[divNumber])){
// 							getJs=true;	
// 						}
// 					}
// 				}
// 				if(getJs){
// 					if(this.components[numberComponent].js!=""){
// 						this.loadJs(this.components[numberComponent].js);
// 					}
// 				}
// 			}
// 		}catch(e){}
// 	},


// 	init	: function(){
// 		try{
// 			this.loadComponents();
// 		}catch(e){}

// 	}

// };

var socialShare={
		pinterest	:	["horizontal","vertical","none"],
		gplus 		:	{size:["small","medium","","tall" ],data: ["none","inline",""]},
		twitter 	: 	["none","horizontal","vertical"],
		facebook 	: 	{"data-layout":["box_count"]},
		href_td:false,
		config 		:	{ "selector" : "elements",
						  "options"  : {
							"facebook":[1,{}],
							"twitter" : [1,{}],
							"pinterest":[1,{}],
							"google":[0,{}],
							"comments":[1,{}],
							"mail":[0,{}]
							}
						},
		pageInfo 	: 	{
						"url"			: 	"",
						"description"	: 	"",
						"title"			: 	"", 
						"thumbnail"		: 	""
		},

		insertFacebook	: function(){
			li = document.createElement('li');
			li.innerHTML='<div id="tim_fb_button" class="fb-like" data-href="'+this.pageInfo["url"]+'" data-send="false" data-layout="box_count" data-width="450" data-show-faces="false"></div>'; 
			li.setAttribute("class",'social_icon li_button_fb');
			return li;
		},

		insertTwitter	: function(){
			li = document.createElement('li');
			li.innerHTML='<a href="https://twitter.com/share" data-count="vertical" data-url="'+this.pageInfo["url"]+'" class="twitter-share-button" data-lang="en" data-size="medium">Tweet</a>'; 
			li.setAttribute("class",'social_icon li_button_tw');
			return li;
		},

		insertPinterest	: function(){
			li = document.createElement('li');
			li.innerHTML='<style> li.li_button_pt a span {margin-bottom:12px;} </style> <a data-pin-config="above" href="//pinterest.com/pin/create/button/?url='+escape(this.pageInfo["url"])+'&media='+escape(this.pageInfo["thumbnail"])+'&description='+escape(this.pageInfo["description"])+'" data-pin-do="buttonPin" ><img id="comm_pint_button" style="display:none;" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" style="margin-top:40px!important;" /></a>'; 
			li.setAttribute("style",'padding-top:42px; zoom:reset;');
			li.setAttribute("class",'social_icon li_button_pt');
			li.setAttribute("id",'li_button_pt');
			//li.setAttribute("style",'padding-top:30px');

			return li;
		},

		insertGoogle	: function(){
			li = document.createElement('li');
			li.innerHTML='<div class="g-plusone" data-size="tall" ></div>'; 
			li.setAttribute("class",'social_icon li_button_go')
;			return li;
		},

		insertComments	: function(){
			li = document.createElement('li');
			li.innerHTML="<div><div id=\"comm_div_num\" style=\" font-size: 16px; background-image:url('http://i2.esmas.com/comunidades/img/social_bubble.png'); background-repeat:no-repeat; width:77px; height:34px; padding-top:6px;  \"></div><a href=\"#COMM_comments_social\"><input type=\"image\" src=\"http://i2.esmas.com/comunidades/img/social_comment_button.png\"></div></a></div>"; 
			li.setAttribute("class",'social_icon li_button_co');
			return li;
		},

		loadJsGoogle	: function(){
			
			if(typeof gapi =="undefined"){
				window.___gcfg = {lang: 'es-419'};
				(function() {
	    			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    			po.src = 'https://apis.google.com/js/plusone.js';
	    			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  			})();
  			}
		},

		loadJsPinterest	: function(){
			
			var wait4=this.getPinterestHref();

			try{communities.loadJS("//assets.pinterest.com/js/pinit.js");}catch(e){comunidades.loadJS("//assets.pinterest.com/js/pinit.js");}
			
			//document.getElementById('comm_pint_button').style.display='block';

			if(this.href_td!=false){setTimeout("socialShare.setPinterestHref();",1500);}

			//if(this.isMobile()==false){
				setTimeout("socialShare.injectBubble(0);",1600);
			//}
			/*

			(function (w, d, load) {
				 var script, 
				 first = d.getElementsByTagName('SCRIPT')[0],  
				 n = load.length, 
				 i = 0,
				 go = function () {
				   for (i = 0; i < n; i = i + 1) {
				     script = d.createElement('SCRIPT');
				     script.type = 'text/javascript';
				     script.async = true;
				     script.src = load[i];
				     first.parentNode.insertBefore(script, first);
				   }
				 }
				 if (w.attachEvent) {
				   w.attachEvent('onload', go);
				 } else {
				   w.addEventListener('load', go, false);
				 }
				}(window, document, 
				 ['//assets.pinterest.com/js/pinit.js']
			));

			*/    
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
			  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=119046504784892";
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
			if(typeof description.content !="undefined"){
				return description.content;
			}else{
				return " ";
			}
		},
			
		getDescription	:	function(customDescription){
			if(typeof customDescription =="undefined"){
				customDescription="";
			}else{return customDescription;}
			try{
				return self.getMetaInfo("description");
			}catch(e){return "";}
			
		},

		getTitle	:	function(customTitle){
			if(typeof customTitle =="undefined"){
				customTitle="";
			}else{return customTitle;}
			try{
				return self.getMetaInfo("title");
			}catch(e){return "";}
		},

		printNumComments:function(num_tries){
			var max_tries=20;
			if( (typeof commenta!="undefined") && (typeof commenta.json!="undefined") && (typeof commenta.json.data!="undefined") ){
				document.getElementById('comm_div_num').innerHTML=commenta.json.data.total;
			}else{
				if(num_tries<=max_tries){
					setTimeout("socialShare.printNumComments("+(num_tries+1)+");",400);
				}else{
					document.getElementById('comm_div_num').innerHTML="0";	
				}
			}
		},

		injectBubble:function(num_tries){
			var max_tries=20;
			try{
				var li=document.getElementById('li_button_pt');
				var span_element=li.getElementsByTagName('a')[0].getElementsByTagName('span')[0];
				span_element.className="no_class";
				
				span_element.style.position="absolute";
				span_element.style.color="#777";
				span_element.style.textAlign="center";
				span_element.style.textIndent=0;
				span_element.style.background="url('http://i2.esmas.com/comunidades/img/count_north_white_rect_20_1.png')";
				span_element.style.backgroundSize ="40px 39px";
				span_element.style.bottom="21px";
				span_element.style.left="0px";
				span_element.style.height="39px";
				span_element.style.width="40px";	
				span_element.style.font="16px Arial, Helvetica, sans-serif";
				span_element.style.lineHeight="34px";

				span_element.style.marginBottom="2px";
								
			}catch(e){
				//alert(num_tries)
				if(num_tries<=max_tries){
					setTimeout("socialShare.injectBubble("+(num_tries+1)+");",400);
				}

			}

		},


		init	: function(){
			
			//this.getPinterestHref();
			

			if(typeof comm_general_config !="undefined"){
				if(typeof comm_general_config.socialShare !="undefined"){

					try{this.config.options.facebook[0]=comm_general_config.socialShare.display.facebook[0];}catch(e){}
					try{this.config.options.twitter[0]=comm_general_config.socialShare.display.twitter[0];}catch(e){}
					try{this.config.options.pinterest[0]=comm_general_config.socialShare.display.pinterest[0];}catch(e){}
					try{this.config.options.google[0]=comm_general_config.socialShare.display.google[0];}catch(e){}
					try{this.config.options.comments[0]=comm_general_config.socialShare.display.comments[0];}catch(e){}
					try{this.config.options.mail[0]=comm_general_config.socialShare.display.mail[0];}catch(e){}
				}
			}


			try{
				if(document.getElementById("widgetSocialShare")){
					
					if( typeof comment_url!="undefined"){
						this.pageInfo["url"]=comment_url;
						this.pageInfo["title"]			=	"";
						this.pageInfo["description"]	=	"";
					}else{
						try{this.pageInfo["url"]=communities.url;}catch(e){this.pageInfo["url"]=comunidades.url;}
						this.pageInfo["title"]			=	this.getTitle();
						this.pageInfo["description"]	=	this.getDescription();
						//this.pageInfo["thumbnail"]		=	this.getTitle();
					}

					

					rootDiv=document.getElementById("widgetSocialShare");

					var firstContainer	=	document.createElement('div');
					firstContainer.setAttribute('class','wdg_social_01');
					
					var secondContainer	=	document.createElement('div');
					secondContainer.setAttribute('class','social-icons');

					var ul	=	document.createElement('ul');

					if(this.config.options.facebook[0]==1){ul.appendChild(this.insertFacebook());}
					if(this.config.options.twitter[0]==1){ul.appendChild(this.insertTwitter());}
					if(this.config.options.pinterest[0]==1){ul.appendChild(this.insertPinterest());}
					if(this.config.options.google[0]==1){ul.appendChild(this.insertGoogle());}
					
					//if(document.getElementById("COMM_comments_social") || document.getElementById("COMM_comments_social_2") || document.getElementById("COMM_comments") || document.getElementById("comments_container") ){
						if( typeof sosialShare_comments=="undefined" || sosialShare_comments==true  ){
							if(this.config.options.comments[0]==1){
								ul.appendChild(this.insertComments());
								setTimeout("socialShare.printNumComments(0);",800);
							}
						}
					//}
					
					secondContainer.appendChild(ul);
					firstContainer.appendChild(secondContainer);
					rootDiv.appendChild(firstContainer);

					
					if (document.location.href.search("/deportes/")!=-1 ){
						firstContainer.setAttribute("id",'social_hidden_div');
						firstContainer.style.display='none';
						setTimeout("socialShare.displayBar(0);",3000);
					}

					
					this.loadJsTwitter();
					
					if (this.checkPinterestClass()==true){
						//setTimeout("socialShare.loadJsPinterest();",5000);
						setTimeout("socialShare.wait4PintButton(0);",2000);
					}else{
						this.loadJsPinterest();	
					}
					
					//this.loadJsFacebook();
					if(this.config.options.google[0]==1){
						this.loadJsGoogle();
					}
				}

			}catch(e){}

			//setTimeout("socialShare.replacePinterest();",1000);
		},

		replacePinterest: function(){

			try{

				if (typeof jQuery != 'undefined') {  
					
					if ($(".img_galry_01 a:eq(2) span").length>0 ){
						
						$(".img_galry_01 a:eq(2)").removeClass();
						$(".img_galry_01 a:eq(2)").addClass("td_bg pinterest back_overlay");
						$(".img_galry_01 a:eq(2)").removeAttr("data-pin-href");
						$(".img_galry_01 a:eq(2)").attr("href","http://pinterest.com/pin/create/button/?url="+document.location.href);
						$(".img_galry_01 a:eq(2)").html('<i class="tvsa-pinterest"></i>');
					}
				}

			}catch(e){}

		},

		getPinterestHref: function(){

			try{
			
				if(this.checkPinterestClass()==true){
					this.href_td=$(".lnk_pinterest").attr("href");
					$(".lnk_pinterest").attr("href","http://televisadeportes.esmas.com/");
				}

				/*
				if (typeof jQuery != 'undefined') {  
					if ($(".img_galry_01 a:eq(2)").length>0 ){
						this.href_td=$(".img_galry_01 a:eq(2)").attr("href");
						$(".img_galry_01 a:eq(2)").attr("href","http://televisadeportes.esmas.com/");
					}else if ( $(".image-container .share a:eq(2)").length>0  ){
						this.href_td=$(".image-container .share a:eq(2)").attr("href");
						$(".image-container .share a:eq(2)").attr("href","http://televisadeportes.esmas.com/");
					}else{
						if($(".pinterest").prop('tagName')=="A"){
							this.href_td=$(".pinterest").attr("href");
							$(".pinterest").attr("href","http://televisadeportes.esmas.com/");
						}
					}
				}
				*/



			}catch(e){}

			return 1;

		},
		setPinterestHref:function(){
			try{
				
				if(this.checkPinterestClass()==true){
					$(".lnk_pinterest").attr("href",this.href_td);
				}
				/*
				if (typeof jQuery != 'undefined') {  
					if ($(".img_galry_01 a:eq(2)").length>0 ){
						$(".img_galry_01 a:eq(2)").attr("href",this.href_td);
					}else if( $(".image-container .share a:eq(2)").length>0 ){
						$(".image-container .share a:eq(2)").attr("href",this.href_td);
					}else{
						if($(".pinterest").prop('tagName')=="A"){
							$(".pinterest").attr("href",this.href_td);
						}
					}
				}
				*/
			}catch(e){}
		},

		displayBar:function(num_tries){
			var max_tries=20;
			if (typeof jQuery != 'undefined') {
				if ($("#tim_fb_button span iframe").length>0 || num_tries==max_tries){
					setTimeout("document.getElementById('social_hidden_div').style.display='block';",300);	
				}else{
					setTimeout("socialShare.displayBar("+(num_tries+1)+")",400);	
				}
			}else{
				setTimeout("document.getElementById('social_hidden_div').style.display='block';",500);
			}
	
		},

		checkPinterestClass:function(){
			var isSetPinlCass=false;
			if (typeof jQuery != 'undefined') { 
				if (typeof  $(".lnk_pinterest").prop('tagName') != 'undefined'){
					if($(".lnk_pinterest").prop('tagName')=="A" || $(".lnk_pinterest").prop('tagName')=="a" ){
						isSetPinlCass=true;
					}
				}
			}
			return isSetPinlCass;
		},

		wait4PintButton:function(num_tries){
			var max_tries=20;

			if( $(".lnk_pinterest").attr("href").search("pinterest.com/pin/")!=-1 || num_tries==max_tries ){
				this.loadJsPinterest();
			}else{
				setTimeout("socialShare.wait4PintButton("+(num_tries+1)+");",500);	
			}

		},

		isMobile: function (){
			var check = false;
			(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
			return check; 
		},
			
};

// var config_socialMedia = [
// 	

// ];

socialShare.init();