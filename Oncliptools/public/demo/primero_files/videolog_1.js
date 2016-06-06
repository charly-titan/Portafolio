var url_registered='';

var videolog  = {

	
			hashCode:"",

			getHash: function () {
	
				var strHash = '';
				var randomNumber = null;
				var start = null;
				var total = null;
				for ( i = 0; i < 39; i++ ) {
					randomNumber = Math.round( Math.random() * 2 ) + 1;
					if( randomNumber == 1 ) {
						start = 65;
						total = 25;
					}
					else if( randomNumber == 2 ) {
						start = 97;
						total = 25;
					}
					else {
						start = 48;
						total = 9;
					}
					strHash += String.fromCharCode(start + Math.round(Math.random() * total));
				}
				
				return strHash;

			},

			/**
			 * Funcion que obitiene el codigo CSIE que se envia al video log
			 * @return String
			 */
			getCSIE:function () {
				
				if( document.cookie.indexOf("esmasstats=") == -1 )  {
					var nd = new Date();
					document.cookie = "esmasstats="+(nd.getYear()+"").substring(2,4)+(((nd.getMonth()+1)<10)?"0":"")+(nd.getMonth()+1)+((nd.getDate()<10)?"0":"")+nd.getDate()+((nd.getHours()<10)?"0":"")+nd.getHours()+((nd.getMinutes()<10)?"0":"")+nd.getMinutes()+((nd.getSeconds()<10)?"0":"")+nd.getSeconds()+"-"+(Math.random()*1000000000000000000)+"-"+Math.round(Math.random()*100000000)+"; expires=Fri, 31 Jan 2020 23:59:59 GMT; path=/;";
				}
				
				var begin = document.cookie.indexOf("esmasstats=");
				
				var CSIE=document.cookie.substring(begin + 11, begin + 50);
				
				return CSIE;
			},


			/**
			 * Funcion que convierte una cadena de tiempo a segundos
			 * @param String Duracion en formato HH:MM:SS
			 * @return int
			 */
			/*
			convertToSeconds:function(stringTime) {
			 	
			 	var sec = 0;
			 	if(stringTime.match(/\d\d?\:\d\d?\:\d\d?/)) {
			 		var arrTime = stringTime.split(/\:/);
			 		for(indi in arrTime){
			 			var tempovar = arrTime[indi].toString();
			 			arrTime[indi] = tempovar.replace(/^0/g,"");
			 			if(arrTime[indi] == ""){
			 				arrTime[indi] = "0";
			 			}
			 		}
			 		if(arrTime.length == 3)
			 			sec = parseInt(arrTime[0])*3600 + parseInt(arrTime[1])*60 + parseInt(arrTime[2]);
			 		else if(arrTime.length == 2)
			 			sec = parseInt(arrTime[0])*60 + parseInt(arrTime[1]);
			 		else if(arrTime.length == 1)
			 			sec = parseInt(arrTime[0]);
			 	}
			 	
			 	return sec;
			 
			}
			 */
			
			makeCookie: function (c_name, value,expiredays){
				var getdomain = document.domain.substring(document.domain.indexOf('.') + 1);
				document.cookie = c_name + "=" + value + "; path=/; domain=" + getdomain;
			},

			loadjs	:	function(url){
				var sc	=	document.createElement('script');
				sc.setAttribute('type','text/javascript');
				sc.setAttribute('src',	url);
				var hd	=	document.getElementsByTagName('head')[0];
				hd.appendChild(sc);
				return true;
			},

					
			readCookie:function (c_name){
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


			getDate: function () {
				now = new Date();
				year = "" + now.getFullYear();
				month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
				day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
				hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
				minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
				second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
				return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
			},

			isNumeric: function (n) {
			  //return !isNaN(parseFloat(n)) && isFinite(n) && (n%1===0);
				return /^\d+$/.test(n);
			},
			
			sendVideoLog:function (action, json_info) {
				
				/*	
				video_info={
							videoDuration:'00:00:10',
							progressTime:0,
							country:'mex',
							state:'dif',
							city:'mexico city',
							videoTitle:'titulo',
							playerType:'ak',
							videoType:'vod',
							ip:'',
							url:'http://www2.esmas.com/entretenimiento/farandula/554515/eiza-gonzalez-se-rie-supuesta-depresion-ruptura-con-liam-hemsworth/'

				};
				*/

				if(this.hashCode == ""){
					this.hashCode = this.getHash();	
				}


				if(typeof json_info.videoDuration == "undefined"){
					json_info.videoDuration = '0';
				}

				
				if(typeof json_info.videoTitle == "undefined"){
					json_info.videoTitle = '';
				}
				
				if(typeof json_info.country == "undefined"){
					
					if( (typeof MN_geo != "undefined") && (typeof MN_geo.country != "undefined")  ){
						json_info.country = MN_geo.country;	
					}else{
						json_info.country='';
					}
				
				}

				if(typeof json_info.state == "undefined"){
					
					if( (typeof MN_geo != "undefined") && (typeof MN_geo.state != "undefined")  ){
						json_info.state = MN_geo.state;	
					}else{
						json_info.state='';
					}
				
				}

				if(typeof json_info.city == "undefined"){
					
					if( (typeof MN_geo != "undefined") && (typeof MN_geo.city != "undefined")  ){
						json_info.city = MN_geo.city;	
					}else{
						json_info.city='';
					}
				
				}

				if(typeof json_info.ip == "undefined"){
					if( (typeof MN_geo != "undefined") && (typeof MN_geo.ip != "undefined")  ){
							json_info.ip = MN_geo.ip;	
						}else{
							json_info.ip='';
					}
				}

				//var duracion = convertToSeconds(json_info.videoDuration);


				//VALIDAR QUE SEA ENTERO//
				if(!this.isNumeric(json_info.videoDuration)){
					json_info.videoDuration=0;
				}
		
				if(!this.isNumeric(json_info.progressTime)){
					json_info.progressTime=0;
				}
				
				//No repetir en live
				if(url_registered==json_info.url && json_info.videoType=='live' && json_info.playerType=='ak'){
					return false;
				}


				url_registered=json_info.url;

				var mobile_type='none';

				try{
					
					if (typeof UAParser == "undefined") {
						this.loadjs('http://i2.esmas.com/tvolucion/js/ua-parser.min.js');
					}

					var parser = new UAParser();
					var result = parser.getResult();
					
					if (typeof result.device.type != "undefined") {
						
						if(result.device.type=='tablet'){

							if (typeof result.os.name != "undefined") {
								if(result.os.name=='iOS'){
									mobile_type='t_ios';	
								}else if(result.os.name=='Android'){
									mobile_type='t_andorid';
								}else if(result.os.name=='Windows Mobile OS' || result.os.name=='Windows Mobile' || result.os.name=='Windows Phone'){
									mobile_type='t_windows';
								}
							}else{
								mobile_type='t_other';
							}
						
						}else if(result.device.type=='mobile'){

							if (typeof result.os.name != "undefined") {
								if(result.os.name=='iOS'){
									mobile_type='p_ios';	
								}else if(result.os.name=='Android'){
									mobile_type='p_andorid';
								}else if(result.os.name=='Windows Phone OS' || result.os.name=='Windows Phone' || result.os.name=='Windows Mobile'){
									mobile_type='p_windows';
								}
							}else{
								mobile_type='p_other';
							}

						}else{
							mobile_type='o_other';	
						}

					}

				}catch(err){}

				var video_log_version="1_3";
				var url_Params =video_log_version+"|"+this.hashCode+"|"+action+"|"+this.getDate()+"|"+json_info.ip+"|"+json_info.country+"|"+json_info.state+"|"+json_info.city+"|"+json_info.videoDuration+"|"+json_info.progressTime+"|"+json_info.videoTitle+"|"+json_info.playerType+"|"+json_info.videoType+"|"+json_info.url+"|"+this.getCSIE()+"|"+(+new Date)+"|"+this.readCookie('__utma')+"|"+mobile_type;
				var src_log = "http://videolog-requests.s3-website-us-west-1.amazonaws.com/?" + url_Params;
				
				
				
				try{
					
					/*
					var fly_div = null;
					if(document.getElementById('vl'))
						fly_div = document.getElementById('vl');
					else {
						fly_div = document.createElement("div");
						fly_div.setAttribute("id", "vl");
						fly_div.setAttribute("display", "none");
						document.body.appendChild(fly_div);
					}

					fly_div.innerHTML='<img src="'+src_log+'" />';
					*/
					var img2 = null;
					if(document.getElementById('vl2'))
						img2 = document.getElementById('vl2');
					else {
						img2 = document.createElement("img");
						img2.setAttribute("id", "vl2");
						//img2.setAttribute("display", "none");
						img2.setAttribute("style", "display:none");
						document.body.appendChild(img2);
					}
					
					img2.setAttribute("src", src_log);




				}catch(err){}
				
				//img.setAttribute("src", src);
				try{
					console.log("LLAMADO APLICADO: " + src);
				}catch(err){}

				/*
				// Mandamos llamar Log de comunidades
				if( action == 'start' ) {
					var viewsLog = new Image();
					var viewsUrlLog = 'http://v.esmas.com:8081/vistas/spacer.gif?2|' + escape(linkBaseURL);
					viewsLog.src = viewsUrlLog;
				}
				*/


				return true;
			}


}





