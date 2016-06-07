
/* ******************************************************
 * Funciones y llamados necesarios para que 
 * se implemente el login en el header
 * ***************************************************** */

if(typeof window.inciarSesion === "undefined"){
	window.inciarSesion = function() {
		$("body").addClass("ui-gy"); // Se agrega una clase en el body para que se muestre de forma correcta el modal
		social_engage.displayLoginOptions();
	};
}

var callbacks = {
	sessionStart:   inciarSesion,
	sessionLogout:  function(){ gigyaHeader.loginSession(); social_engage.destroySesion(); },
	sessionPrefs:   function(){ }
};


if(typeof window.notLogged === "undefined"){
	window.notLogged = function() {
		gigyaHeader.init(false, callbacks);
	};
}

if(typeof window.isLogged === "undefined"){
	window.isLogged = function(uid){
		gigya.socialize.getUserInfo({callback:printResponse});
	};
}

if(typeof window.printResponse ==="undefined"){
	window.printResponse = function(response){
		if (response.errorCode === 0){
			var saludo = "";
			if(response.user.gender == "m"){
				saludo = "Bienvenido";
			}else if(response.user.gender == "f"){
				saludo = "Bienvenida";
			}else{
				saludo = "Bienvenid@";
			}
			var user = {
					image: response.user.thumbnailURL,
					greeting: saludo,
					name: response.user.nickname
			};
			gigyaHeader.loadSession(user);
			gigyaHeader.init(user, callbacks);
			setTimeout(function(){ $("span#pref_social").css("display", "none"); }, 1000);
		}
		else {
			console.log('Error :' + response.errorMessage);
		}
	};
}

/* ******************************************************
 * Inicia el script que controla los servicios de Gigya
 * ***************************************************** */

if(typeof custId=="undefined"){
	var custId="";
}
var login_params="";
var gig_uid;
/*var userStatusParams = {
						containerID: 'divUserStatus'
				}; */
var share_params="";
var comments_params="";



var social_engage ={
	config : {
		debug				: true,
		login_params		: {
			version: 2,
			autoLogin:true,
			showTermsLink: 'false',
			hideGigyaLink:true,
			height: 100,
			width: '100%',
			containerID: 'login_gigya_social',
			buttonsStyle: 'fullLogoColored',
			autoDetectUserProviders: '',
			facepilePosition: 'none',
			lastLoginIndication:'none',
			buttonSize: 45
		},/* login_params */
		comments_params	: {
			categoryID: 'test1',
			streamID: '',
			version: 2,
			containerID: 'COMM_comments_facebook',
			deviceType: 'auto',
			moreEnabledProviders: ["facebook","twitter","googleplus"],
			cid: '',
			enabledProviders: ["facebook","twitter","googleplus","linkedin"]
		},
		share_params			:{
			containerID			:'widgetSocialShare5',
			shareButtons		:	["twitter", "facebook", "pinterest", "googleplus"],
			share_buttons_tpl	:	null
		},
		cid:"Website",
		score_params:	{
				containerID		:'divUserStatusGM',
				width			:'100%',
				cardsContainer	:'social_gigya_cards',
				premios			:[
								{"lichipuntos" : 10000, estrellas: 10, beneficio: "Mini poster personalizado (Envío digital)"},
								{"lichipuntos" : 20000, estrellas: 20, beneficio: "Twittcam perzonalizada (Enlaze digital)"},
								{"lichipuntos" : 30000, estrellas: 30, beneficio: "Las mañanitas de Icónika para tu cumpleaños (Envio digital)"},
								{"lichipuntos" : 40000, estrellas: 40, beneficio: "Acompañar a Pedro Moreno a grabación 'Detras de camaras'"},
								{"lichipuntos" : 50000, estrellas: 50, beneficio: "Mensaje en video de Luciana o Dafne"},
								{"lichipuntos" : 60000, estrellas: 60, beneficio: "Mensaje en video de Roberto"},
								{"lichipuntos" : 70000, estrellas: 70, beneficio: "Mensaje en video de Lichita"},
								{"lichipuntos" : 80000, estrellas: 80, beneficio: "Participar como extra"},
								{"lichipuntos" : 90000, estrellas: 90, beneficio: "Asistir al final grabación"},
								{"lichipuntos" : 100000, estrellas: 100, beneficio: "Convivencia visita al foro"}
								]
		},
		domain_name			: "televisa",
		gigya_url_js		: "http://cdn.gigya.com/js/gigya.js",
		enabledProviders	:["facebook","twitter","googleplus"],
		lang				:"es",
		modal				: true,
		useTemplateLogin	: true,/*  */
		urlCssGigya			: 'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/gigya.css',
		//urlCssGigya			: '/css/pepsi-gigya.css',
		callbacks			:{
			"onLoad"		:	"",
			"islogged"		:	"",
			"isnotlogged"	:	"",
			"isnewuser"		:	"",
			"modalstart"	:	"",
			"modalclose"	:	""
		}
	},
		
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Llaves de los sitios registrados en Gigya
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	domain_key	: {
		"television"				:{		"key"			: "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF",
										"siteName"		: "Television"
		},/* Televisa */
		"noticieros"			:{		"key"			: "3_1Z-AcNEbQ5xILDjQ_ZI9TR4PynQ1N1V2JULCqUf_8sHjskIPI0OZngnDRcpzALZb",
										"siteName"		: "Noticieros Televisa"
		},/* Noticieros Televisa */
		"televisadeportes"		:{		"key"			: "3_Dm8WSu6sVRA1kqyXM8SIxuBhcTlnUxXqrTVwF6VWORpcKAbPaaCJsdajX-Q5zIyp",
										"siteName"		: "deportes.televisa.com (TelevisaDeportes.com)"
		},/* Televisa Deportes */
		"televisa"		:{		"key"			: "3_a1D5v0aTj8FVNdpvEk9N6ZSMZQARdkUuC-qhVTlu9OAyql4VClisheXakAW-Wj_h",
										"siteName"		: "Televisa"
		},
		"canal5"		:{		"key"			: "3_5AJsjrSXbIX_MKznClfDLXL0zUsbA1tDMuXYB9MFzzxPi2oN57LLa1nqeJ13ALik",
										"siteName"		: "Canal 5"
		}
	},
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Templates para controlar la vista de los servicios
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	templates		: {
		usernotlogged	:	'<a href="#" id="start_session" class="gigya-content"><i class="gigya-icon"></i>Inicia Sesión</a>',
		userlogged		:	'<i class="gigya-icon"></i>Bienvenido {{nickname}} <a href="#">Cerrar sesión</a>',
		modalstructure	:	'<div id="login_gigya_social" class="login_box close">'+
								'<div class="login-cl"><span id="login-close" class="closeoverlay login-cl"></span></div>'+
								'<div id="gigya_body_modal" class="cont-full slideDownVideoModal">'+
								'</div>'+
							'</div>',
		social_networks	:	'<div class="login-form">'+
								'<div id="gigya_modal" class="social-component"></div>'+
							'</div>',
		user_status		:	'<div id="divUserStatus" class="login-form">'+
								'<button id="close_session" class="close_gigya">'+
								'<span class="txt-gigya-md-session">Cerrar sesi&oacute;n</span></button>'+
							'</div>',
		userEmail		:	'<div id="social_gy_mail" class="social-gy-mail-form">'+
								'<p></p>'+
								'<h4 class="gy-txt-subtitle">Ingresa tu correo electr&oacute;nico</h4>'+
								'<p><input type="text" class="input-gy-mail" name="gigya_email" id="txt_gigya_email"></p>'+
								'<p id="social_msg_error" class="txt-err-gy-mail"></p>'+
								'<button id="btnSaveEmail" class="btn_save_gy_mail">Guardar</button>'+
							'</div>',
		is_newuser		:	'<h6>Gracias por registrarte</h6>'+
							'<p class="big">Bienvenido {{nickname}}</p>'+
							'<p>Por registrarte tienes un bono de 100 Lichipuntos</p>'+
							'<p class="big">Muy pronto te diremos como conseguir mas.</p>',
		gm_puntos		:	'<div class="gig_header_amql">'+
								'<div class="gig-tag-left"><span class="gig-tag">Hola {{nickname}}</span></div>'+
								'<div class="gig-tag-right">'+
									'<span id="tag-up" class="gig-tag">Tienes</span>'+
									'<div class="gig-component-puntaje">'+
										'<span class="gig-moneda"></span>'+
										'<span id="user-gig-puntos" class="gig-puntaje">2000</span>'+
									'</div>'+
									'<span id="tag-down" class="gig-tag">LICHIPUNTOS</span>'+
								'</div>'+
							'</div>',
		gm_premio_card	:	'<div data-cardid="{{idcard}}" style="{{display}}" class="gig-card gig-card-col card_1_of_2">'+
									'<div class="gig-cintillo-puntos">'+
											'<span class="gig-tag-premio">PREMIO</span>'+
											'<span class="gig-tag-lichipuntos">'+
												'<div class="gig-moneda-card"></div>{{puntos}} lichipuntos'+
											'</span>'+
											'<hr class="gig-hr-card">'+
									'</div>'+
									'<div class="gig-body-card">'+
										'<div class="gig-card-desc"><span>{{textDescription}}</span></div>'+
										'<a href="https://promociones.televisa.com.mx/gamification/" class="gig-btn-canjear btn-gig-def">Canjear</a>'+
									'</div>'+
								'</div>'
	},

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Inicializa los servicios de gigya de forma asyncrona
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	loadGigya				: function(){
		if(typeof gigya == "undefined"){
			var s = document.createElement('script');
			s.type='text/javascript';
			s.async=true;
			s.src = "http://cdn.gigya.com/js/gigya.js?apiKey="+this.domain_key[this.config.domain_name]["key"];
			s.text = "{ cid: '"+this.config.cid+"',siteName: '"+this.domain_key[this.config.domain_name]["siteName"]+"',enabledProviders: 'facebook,twitter,googleplus,linkedin',lang: '"+this.domain_key[this.config.domain_name]["siteName"]+"'}";
			document.getElementsByTagName('head')[0].appendChild(s);
		}
	},
		

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Controlador de servicio login
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	startLogin				: function(){
		gigya.socialize.getUserInfo({ callback: social_engage.setearUI });
		// register for connect status changes
		gigya.socialize.addEventHandlers({  onLogin: social_engage.initLogin,
											onConnectionAdded: social_engage.setearUI,
											onConnectionRemoved: social_engage.setearUI,
											onLogout: social_engage.setearUI
									});
	},

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Llamado al audience manager de CQ5
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	audience_manager		: function(user){
		try{
			//console.log(user);
			gig_uid = user.UID;
			custId = gig_uid;
			if (custId && typeof custId !== 'undefined') {
				televisaDil.api.aamIdSync({
					dpid : "31642",
					dpuuid : custId,
					minutesToLive : 20160
				});
			}

			var data = {};
			var parms = {data:{internalAamIdSyncResponseCode: true}, callback: social_engage.setDataInternal };
			gigya.accounts.setAccountInfo(parms);

		}catch (err) { console.log(err);}
	},

	setDataInternal : function(response){
		//console.log(response);
		var data = {};
		var parms = {data:{internalAamIdSyncResponseCode: true} };

		if (response.errorCode === 0){
				if ( null!==response.requestParams.data){
					var dataInternal = response.requestParams.data.internalAamIdSyncResponseCode;
					if(dataInternal == "undefined" || dataInternal === null || dataInternal === false){
						gigya.accounts.setAccountInfo(parms);
					}
				}
			}else if(response.errorCode == 404000){
			gigya.accounts.setAccountInfo(parms);
		}

	},

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Funcion que verifica el estado de un usuario
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	setearUI				: function(res) {
		//social_engage.runCallbackExist('onLoad');
		if(res.user !== null && res.user.isConnected){
			social_engage.settingTemplates(res.user);
			social_engage.displayUserLooged(res.user);
			social_engage.audience_manager(res.user);
			social_engage.runCallbackExist('islogged', res.user.UID);
			social_engage.destroyLoginOptions();
			social_engage.startGMPuntos('logged');
			social_engage.requireEmail(res);
		} else {
			//console.log(res.user.isConnected.length)
			social_engage.displayUsernotLogged(res.user);
			social_engage.startGMPuntos('notlogged');
			social_engage.runCallbackExist('isnotlogged');
		}
	},

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Funcion para destruir la sesion del usuario
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	destroySesion			:function(){
		gigya.socialize.logout({callback:social_engage.removeSesion});
	},

	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * Callback despues de cerrar la sesión del usuario
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	removeSesion			: function(response) {
		if(response.errorCode === 0){
			social_engage.displayUsernotLogged();
		}else {
			//console.log('Error :' + response.errorMessage); 
		}
	},

	runCallbackExist			: function(callback, params){
		if(social_engage.config.callbacks[callback] != "undefined" && social_engage.config.callbacks[callback] !== ""){
			if(typeof params != "undefined"){
				social_engage.customCallback(eval(social_engage.config.callbacks[callback]), params);
			}else{
				social_engage.customCallback(eval(social_engage.config.callbacks[callback]));
			}
		}
	},

	customCallback			:function(callback, options){
		if(typeof options != "undefined"){
			callback(options);
		}else{
			callback();
		}
	},

	displayUserLooged		: function(user){
		if(social_engage.config.useTemplateLogin === true){
			$("#login_gigya").html(this.templates["userlogged"]);
			$("#close_session").click(function() {
				social_engage.destroySesion();
			});
		}else{
			$("#close_session").click(function() {
				social_engage.destroySesion();
			});
		}
	},

	settingTemplates		: function(user){
		var count = Object.keys(social_engage.templates).length;
			var keys = Object.keys(social_engage.templates);
			for (var i=0; i <= count-1; i++) {
				social_engage.replaceUserInfo(user, keys[i]);
			}
	},

	requireEmail			: function(res){
		if(res.user.email.length <= 0){
			
			if(this.config.modal === true)
			{
				$("#gigya_body_modal").html(this.templates["userEmail"]);
				$("#login_gigya_social").show();
				if(typeof social_engage_external_config.templates.modalstructure == "undefined"){
					$("#login_gigya_social").show();
					$("#login_gigya_social").removeClass("close").addClass("open");
				}
				var _email ="";
				$("#login-close").click(function(){
					$("#login_gigya_social").hide();
						if(res.newUser === true){
							social_engage.runCallbackExist('isnewuser');

						}
					$("#login-close").unbind( "click" );
					social_engage.destroyLoginOptions();
				});
				$("#btnSaveEmail").click(function(){
					_email = $("#txt_gigya_email").val();
					social_engage.setEmail(_email, res);
				});
			}else{
				/*pintar formulario email en UI-NO-MODAL*/
				console.log("en construcción...");
			}

		}else{
			if(res.newUser === true){
					social_engage.runCallbackExist('isnewuser');
			}
		}
	},

	setEmail			: function(email, usr){
				expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if ( !expr.test(email) ){
					$("#social_msg_error").html("Ingresa un email valido.");
				}else{
					var idsParams = {
							profile: { 'email': email }
						};
					gigya.ids.setAccountInfo(idsParams);

					if(usr.newUser === true){
						social_engage.runCallbackExist('isnewuser');
					}
					$("#login-close").unbind( "click" );
					social_engage.destroyLoginOptions();
				}
	},

	displayUsernotLogged	: function(){
		if(social_engage.config.useTemplateLogin === true){
			$("#login_gigya").html(this.templates["usernotlogged"]);
			$("#start_session").click(function() {
				social_engage.displayLoginOptions();
			});
		}else{
			$("#start_session").click(function() {
				social_engage.displayLoginOptions();
			});
		}
	},

	displayLoginOptions	:	function(){
		if(this.config.modal === true){
			if (typeof social_engage_external_config.templates.modalstructure != "undefined") {
					this.createCustomModal();
			}else{
					this.createModal();
			}
		}else{
			gigya.socialize.showLoginUI(login_params);
		}
		
	},

	destroyLoginOptions	:	function(){
		$("#gigya_body_modal").html("");
		if(typeof social_engage_external_config.templates.modalstructure != "undefined" && this.config.modal === true){
			$("#login_gigya_social").hide();
				social_engage.runCallbackExist('modalclose');
				$("#gigya_body_modal").html(this.templates.user_status);
				$("#show_status").click(function(){
					$("#login_gigya_social").show();
				});
				$("#login-close").click(function(){
					$("#login_gigya_social").hide();
				});
				$("#close_session").click(function(){
					social_engage.destroySesion();
					$("#login_gigya_social").hide();
				});
		}else if(typeof social_engage_external_config.templates.modalstructure == "undefined" && this.config.modal === true){
			$("#login_gigya_social").hide();
				$("#login_gigya_social").removeClass("open").addClass("close");
				social_engage.runCallbackExist('modalclose');
			$("#gigya_body_modal").html(this.templates.user_status);
				$("#show_status").click(function(){
					$("#login_gigya_social").show();
					$("#login_gigya_social").removeClass("close").addClass("open");
				});
				$("#login-close").click(function(){
					$("#login_gigya_social").hide();
					$("#login_gigya_social").removeClass("open").addClass("close");
				});
				$("#close_session").click(function(){
					social_engage.destroySesion();
					$("#login_gigya_social").hide();
				});
		}else{
			$("#login_gigya_social").html("");
		}
	},

	createCustomModal		: function(){
		login_params.containerID = "gigya_modal";
		$("#gigya_body_modal").html(this.templates["social_networks"]);
		social_engage.runCallbackExist('modalstart');
		$("#login_gigya_social").show();
		$("#login-close").click(function() {
			$("#login_gigya_social").hide();
		});
		gigya.socialize.showLoginUI(login_params);
	},

	createModal			: function(){
		login_params.containerID = "gigya_modal";
		$("#gigya_body_modal").html(this.templates["social_networks"]);
		$("#login_gigya_social").show();
		$("#login_gigya_social").removeClass("close").addClass("open");
		$("#login-close").click(function() {
			$("#login_gigya_social").removeClass("open").addClass("close");
			$("#login_gigya_social").hide();
		} );
		gigya.socialize.showLoginUI(login_params);
	},

	nodeExist				: function(node){
		var e = (typeof document.getElementById(node) != "undefined" && document.getElementById(node) !==null) ? true : false;
		return e;
	},

	createBtn			: function(tipo, clases, id){
		var elemento;
		elemento=document.createElement(tipo);
		if(typeof(clases)!==undefined&&clases)elemento.setAttribute("class", clases);
		if(typeof(id)!==undefined&&id)elemento.setAttribute("id", id);
		return elemento;
	},

	setShareOptions		: function(){

		var image		= $('meta[property="og:image"]').attr("content");
		var url			= $('meta[property="og:url"]').attr("content");
		var title		= $('meta[property="og:title"]').attr("content");
		var description = $('meta[property="og:description"]').attr("content");
		
		var containerShare = document.getElementById(share_params.containerID);
			$(containerShare).empty();
		var num_providers = "", providers = "";
		if(share_params.share_buttons_tpl === null || share_params.share_buttons_tpl === undefined){
			num_providers =	(share_params.shareButtons).length;
			providers = share_params.shareButtons;
		}else{
			num_providers = Object.keys(share_params.share_buttons_tpl).length;
			providers = Object.keys(share_params.share_buttons_tpl);
		}

		//crear botones
		if (share_params.share_buttons_tpl !== null && social_engage_external_config.share_buttons_tpl !== undefined ) {
			
			for (var i=0; i <= num_providers-1; i++) {
				var cadena = "btn"+providers[i];
				share_params[cadena] = $.parseHTML(share_params.share_buttons_tpl[providers[i]]);
			}

		}else{

			for (var j=0; j <= num_providers-1; j++) {
				var cadena2 = "btn"+providers[j];
				share_params[cadena2] = social_engage.createBtn("div", "btn_default_gig share_gig_"+providers[j], "div_btn_"+providers[j]);
			}

		}

		for(var k=0; k <= num_providers-1; k++) {
			var str = "btn"+providers[k];
			$(containerShare).append(share_params[str]); // insertar botones en el DOM
		}
		for(var l=0; l <= num_providers-1; l++) {
			var btn = "btn"+providers[l];
			var network = providers[l];
			social_engage.addEventoClick(network, btn, url, image, title, description);
		}
	
	},
	
	addEventoClick :  function(network, boton, url, image, title, description){
		$(share_params[boton]).click(function(){
			social_engage.displayShareOptions(network, url, image, title, description);
		});
	},

	displayShareOptions : function(provider, url, image, title, description){
		var act = new gigya.socialize.UserAction();
			act.setTitle(title);
			act.setLinkBack(url);
			act.addMediaItem({ type: 'image', src: image, href: url });
			act.setDescription(description);
		var params_share= {
				provider            :   provider,
				userAction          :   act,
				facebookDialogType  :   "share"
			};
		try{
			gigya.socialize.postBookmark(params_share);
		}catch(e){
			console.log(e);
			return false;
		}
	},

	startComments   : function(){
		comments_params.streamID = document.location.href;
		if(document.location.href.search("television.televisa.com/") != -1){
			if(document.location.href.search("antes-muerta-que-lichita") != -1){
				comments_params.categoryID = "amql";
			}else{
				comments_params.categoryID = "television";
			}
		}else{
				comments_params.categoryID = "television";
		}
		try{
			gigya.comments.showCommentsUI(comments_params);
		}catch(e){
			console.log(e);
		}

	},

	startGMPuntos	:	function(status){
		var premios = this.config.score_params.premios;
		var html_cards = "";
		var numCardShow = 4;
		var hideCard = "";
		var htmlPadre = '<div id="social_gig_cards_body" class="container-gig-cards groups-gig"></div>'+
						'<div data-showmore="'+ numCardShow +'" id="gig-plus-cards" class="gig-btn-plus-cards btn-gig-def">ver más premios</div>';
		var cardsContainer = document.getElementById(this.config.score_params.cardsContainer);
		if(this.nodeExist(this.config.score_params.containerID)){
			var containerGM = document.getElementById(this.config.score_params.containerID);
			try{
				//gigya.gm.showUserStatusUI(this.config.score_params);
				if(status == "logged"){
					$(containerGM).html(this.templates.gm_puntos);
					$(containerGM).show();
				}else if(status == "notlogged"){
					//console.log("you are here")
					$(containerGM).html("");
					$(containerGM).hide();
				}
				if(this.nodeExist(this.config.score_params.cardsContainer)){
					var params = { callback:social_engage.responseGM, details: "full" };
					gigya.gm.getChallengeStatus(params);
					for (var i = 0; i <= premios.length-1; i++){
						hideCard = (i > numCardShow-1) ? "display:none" : "";
						html_cards += this.templates['gm_premio_card'].replace("{{puntos}}", premios[i].lichipuntos)
																		.replace("{{textDescription}}", premios[i].beneficio)
																		.replace("{{display}}", hideCard)
																		.replace("{{idcard}}", (i+1));
					}
					$(cardsContainer).html(htmlPadre);
					$("#social_gig_cards_body").html(html_cards);

					$("#gig-plus-cards").click(function(){
						total = premios.length;
						current = parseInt($(this).attr("data-showmore"),10);
						if(current < total){
							for(var i =  1; i <= 2; i++) {
								current++;
								$('div[data-cardid=' + (current) +']').show("slow");
							}
							$("#gig-plus-cards").attr("data-showmore", current);
						}else{
							current = current+1;
							$('div[data-cardid=' + (current) +']').show("slow");
							$("#gig-plus-cards").hide("slow");
						}
						
					});

				}
					
			}catch(e){
				console.log(e);
			}
		}
	},
	
	responseGM		:	function(response){
			if( response.errorCode === 0 ){
				if( null!==response.achievements && response.achievements.length>0) {
					$("#user-gig-puntos").html(response.achievements[0].pointsTotal);
				}else {
				console.log('No data returned');
				}
			}else {
				console.log('Error :' + response.errorMessage);
			}
	},

	replaceUserInfo			: function(user,template){
		this.templates[template] = this.templates[template].replace("{{photoURL}}", user.photoURL);
		this.templates[template] = this.templates[template].replace("{{usuario}}", user.nickname);
		this.templates[template] = this.templates[template].replace("{{nickname}}", user.nickname);
		this.templates[template] = this.templates[template].replace("{{firstName}}", user.firstName);
		this.templates[template] = this.templates[template].replace("{{thumbnailURL}}", user.thumbnailURL);
	},

	initLogin				: function(eventObj){
		social_engage.setearUI(eventObj);
	},

		
	init					: function (){
		
		if(typeof social_engage_external_config != "undefined"){
			if(typeof social_engage_external_config.templates != "undefined"){
				this.templates = $.extend(this.templates, social_engage_external_config.templates);
			}
			if(typeof social_engage_external_config.domain_name != "undefined"){
				this.config.domain_name = social_engage_external_config.domain_name;
			}
			if(typeof social_engage_external_config.comments_params != "undefined"){
				this.config.comments_params = $.extend(this.config.comments_params, social_engage_external_config.comments_params);
			}
			if (typeof social_engage_external_config.urlCssGigya != "undefined"){
				this.config.urlCssGigya = social_engage_external_config.urlCssGigya;
			}
			if (typeof social_engage_external_config.callbacks != "undefined"){
				this.config.callbacks = $.extend(this.config.callbacks, social_engage_external_config.callbacks);
			}
			if (typeof social_engage_external_config.modal != "undefined"){
				this.config.modal = social_engage_external_config.modal;
			}
			if (typeof social_engage_external_config.cid != "undefined"){
				this.config.cid = social_engage_external_config.cid;
			}
			if(typeof social_engage_external_config.share_buttons_tpl != "undefined"){
				this.config.share_params.share_buttons_tpl = $.extend(this.config.share_params.share_buttons_tpl, social_engage_external_config.share_buttons_tpl);
			}
			if(typeof social_engage_external_config.useTemplateLogin != "undefined"){
				this.config.useTemplateLogin = social_engage_external_config.useTemplateLogin;
			}
		}


		if(typeof gigya == "undefined"){
			this.loadGigya();
			social_engage.runCallbackExist('onLoad');
			return false;
		}
		

		login_params=this.config.login_params;
		
		if(this.nodeExist("login_gigya")){
			this.startLogin();
		}else{
			if(!this.config.useTemplateLogin){
				this.startLogin();
			}
		}
		

		if(this.config.modal === true){
				$("#login_gigya_social").remove();
				var css = document.createElement('link');
				css.rel= 'stylesheet';
				css.href = this.config.urlCssGigya;
				document.getElementsByTagName('head')[0].appendChild(css);
				$(this.templates.modalstructure).appendTo(document.body);
		}

		if(this.nodeExist("COMM_comments_facebook")){
			comments_params=this.config.comments_params;
			this.startComments();
		}

		if(this.nodeExist("widgetSocialShare5")){
			share_params = this.config.share_params;
			this.setShareOptions();
		}
		if(this.nodeExist(this.config.score_params.containerID)){
			this.startGMPuntos('notlogged');
		}
		
	}
};


social_engage.init();

function onGigyaServiceReady(serviceName) {
	//console.info(serviceName);
	social_engage.init();
}
