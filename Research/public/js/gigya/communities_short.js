var communities = {
		/* Funciones para el dominio y la Url */
	cl_domain : function(domain){
		try{
			tmp_domain  = domain.split(".");
			if(tmp_domain.length==2){
				return tmp_domain[0];
			}else{
				if(tmp_domain[1].length>3){
					return  tmp_domain[1];
				}else{
					return  tmp_domain[0];
				}
			}
		}catch(e){return domain}

	},
	cl_url    : function(a){
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
	loadJS  : function(url, charset){
		var sc  = document.createElement('script');
		sc.setAttribute('type','text/javascript');
		sc.setAttribute('src',  url);
		if('undefined' != typeof charset){
			sc.setAttribute('charset',charset);
		}
		var hd  = document.getElementsByTagName('head')[0];
		hd.appendChild(sc);
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
	}
};
