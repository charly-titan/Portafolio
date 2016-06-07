// var communities = {
//      /* Funciones para el dominio y la Url */
//  cl_domain : function(domain){
//      try{
//          tmp_domain  = domain.split(".");
//          if(tmp_domain.length==2){
//              return tmp_domain[0];
//          }else{
//              if(tmp_domain[1].length>3){
//                  return  tmp_domain[1];
//              }else{
//                  return  tmp_domain[0];
//              }
//          }
//      }catch(e){return domain}
        
//  }, 
//  cl_url    : function(a){
//      b=a.search(/\?/);
//      if(b!=-1){
//          b=a.search(/\=/);
//          if (b != -1) {
//              a=a.replace(/\=/g,"_");
//              a=a.replace(/\&/g,"/");
//              a=a.replace("?","/no_clean_url/");
//          }
//      }
//      b=a.search(/\#/);
//      if(b!=-1){a=a.substring(0,b)}
//      b=a.search(/\?/);
//      if(b!=-1){a=a.substring(0,b)}
//      return a
//  },
//  loadJS  : function(url, charset){
//      var sc  = document.createElement('script');
//      sc.setAttribute('type','text/javascript');
//      sc.setAttribute('src',  url);
//      if('undefined' != typeof charset){
//          sc.setAttribute('charset',charset);
//      }
//      var hd  = document.getElementsByTagName('head')[0];
//      hd.appendChild(sc);
//      return true;
//  },
//  loadcss:function (url){
//      //alert(url)
//      var cssNode = document.createElement('link');
//      cssNode.type = 'text/css';
//      cssNode.rel = 'stylesheet';
//      cssNode.href = url;
//      document.getElementsByTagName("head")[0].appendChild(cssNode);  
//  },
//  makeCookie : function(c_name, value,expiredays){
//      var getdomain = document.domain.substring(document.domain.indexOf('.') + 1);
//      document.cookie = c_name + "=" + value + "; path=/; domain=" + getdomain;
//  },
//  readCookie : function(c_name){
//      if (document.cookie.length>0){
//          c_start=document.cookie.indexOf(" "+c_name + "=");
//          if (c_start!=-1){
//              c_start=c_start + c_name.length+2;
//              c_end=document.cookie.indexOf(";",c_start);
//              if (c_end==-1){c_end=document.cookie.length;}
//              return unescape(document.cookie.substring(c_start,c_end));
//              }
//      }
//      if (document.cookie.length>0){
//          c_start=document.cookie.indexOf(""+c_name + "=");
//          if (c_start!=-1){
//              c_start=c_start + c_name.length+2;
//              c_end=document.cookie.indexOf(";",c_start);
//              if (c_end==-1){c_end=document.cookie.length;}
//              return unescape(document.cookie.substring(c_start,c_end));
//          }
//      }
//      return null;
//  }
// }


//***************config external television
if(document.location.href.search("television.televisa.com")!=-1){

    if(document.location.href.search("antes-muerta-que-lichita")!=-1){
        var social_engage_external_config ={
            callbacks       : {
                "onLoad"        : "prepareUI",
                "islogged"      : "isLogged",
                "isnewuser"     : "isNewUser"
            },
            modal           :   true,
            urlCssGigya     :   'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/pepsi-gigya.css',
            templates       : {
                usernotlogged   :   '<p id="start_session"><i class="icon-user"></i><span>Iniciar sesiÃ³n</span></p>',
                userlogged      :   '<img id="show_status" src="{{thumbnailURL}}" width="48" height="48"/>',

                social_networks  :   '<h6>Ingrese a su cuenta</h6>'+
                                    '<div id="gigya_modal" class="social-component"></div>',
                
                user_status     :   '<div id="divUserStatus" class="login-form">'+
                                        '<button id="close_session" class="close_gigya">'+
                                            '<span class="txt-gigya-md-session">Cerrar sesiÃ³n</span></button>'+
                                    '</div>',

                is_newuser     :  '<h6>Gracias por registrarte</h6>'+
                                    '<p class="big">Bienvenido {{nickname}}</p>'+
                                    '<p>Por registrarte tienes un bono de 100 Lichipuntos</p>'+
                                    '<p class="big">Muy pronto te diremos como conseguir mas.</p>',            
                                    
                modalstructure  :   '<div id="login_gigya_social" class="full-video login-ligth">'+
                                        '<div class="cont-full slideDownVideo">'+
                                            '<div id="login-close" class="cerrarv video-f login-cl"><i class="icon-close"></i></div>'+
                                            '<div id="gigya_body_networks" class="login-form">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
            }   

        };

        function prepareUI(){
            //console.info("initialize UI");
            $("#login_gigya").css("visibility", "visible");
        }

        function isLogged(uuid){
            social_engage.config.usr_uid = uuid;
        }
        function isNewUser(){
            $("#login_gigya_social").clone().attr('id', 'modal_welcome').appendTo(document.body);
            $("#modal_welcome div#gigya_body_networks").attr("id", "gigya_body_welcome");
            $("#modal_welcome div#login-close").attr("id", "close_welcome");
            $("#close_welcome").click(function(){ $("#modal_welcome").remove(); })
            $("#gigya_body_welcome").html(social_engage.templates.is_newuser);
                $("#modal_welcome").css("visibility", "visible").show();

        }
    }else{
        // var social_engage_external_config ={
        // callbacks       : {
        //     "onLoad"        : "prepareUI",
        //     "islogged"      : "isLogged", 
        //     "isnewuser"     : "nuevoUsuario"                        
        // },
        // modal           :   true,
        // urlCssGigya     :   'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/pepsi-gigya.css',
        // templates       : {
        //     usernotlogged   :   '<a href="#" class="ui-gy-login__content ui-gy--tele" id="start_session" title="gigya-session">'+
        //                             '<i class="ui-gy-icon--login"></i>Inicia Sesi&#243n'+
        //                         '</a>', 
        //     userlogged      :   '<a href="#" class="ui-gy-login__content init" id="show_status" title="gigya-session">'+
        //                                '<img src="{{thumbnailURL}}" class="ui-gy-login__avatar"/>'+
        //                               'Mi cuenta'+
        //                             '</a>',
        //     social_networks  :  '<h2 class="ui-gy-txt--title">Bienvenidos a la comunidad Televisa</h2>'+
        //                         '<p class="ui-gy-txt--paragraph">Ingresa con tu Red Social</p>'+
        //                         '<div id="gigya_modal" class="social-component"></div>',

        //     user_status     :   '<div id="divUserStatus" class="login-form">'+
        //                             '<button id="close_session" class="close_gigya">'+
        //                                 '<span class="txt-gigya-md-session">Cerrar sesiÃ³n</span></button>'+
        //                         '</div>',

        //     closeSession    :   '<div class="ui-gy-modal__content alert js-config">'+
        //                             '<h1 class="ui-gy-txt--title">{{usuario}}!</h1>'+
        //                             '<button id="close_session" class="ui-gy-btn ui-gy-btn--block ui-gy--tele">Cerrar SesiÃ³n</button>'+
        //                             '<i class="ui-gy-modal-icon--close"></i>'+
        //                         '</div>',

        //     modalstructure  :   '<section id="login_gigya_social" class="ui-gy-modal" data-animate="fade-in" style="display:none;">'+
        //                             '<div class="ui-gy-modal__content js-share"><i id="login-close" class="ui-gy-modal-icon--close"></i>'+    
        //                                 '<div id="gigya_body_networks" class="login-form"></div>'+
        //                             '</div>'+
        //                          '</section>'
        // }   
                                
        // };



        // function prepareUI(){
        //     $("body").addClass("ui-gy");
            
        //     if($(window).width() >= 648){
        //         $("#login_gigya_mobile").html("");
        //         $("#login_gigya").css("display","inline-block");
        //         $("#start_session").css("display","block"); 
        //     }else if($(window).width() <= 647){
        //         $("#login_gigya").html("");
        //         $("#login_gigya_mobile").html(social_engage.templates.usernotlogged);
        //         $("#login_gigya_mobile").css("display","block");
        //         $("#start_session").click(function() {
        //             social_engage.displayLoginOptions();
        //         });
        //         //$(".mobilesub").css("display", "block");
        //     }
            
        // }

        // function nuevoUsuario(){
        //     //console.log("Bienvenido nuevo usuario: callback isNewUser");
        // } 

        // function isLogged(uuid){
        //     social_engage.config.usr_uid = uuid;
        //     $("body").addClass("ui-gy");
        //     if($(window).width() >= 648){
        //         $("#login_gigya_mobile").html("");
        //         $("#login_gigya").css("display","inline-block");
        //     }else if($(window).width() <= 647){
        //         $("#login_gigya").html("");
        //         $("#login_gigya_mobile").html(social_engage.templates.userlogged);
        //         $("#close_session").click(function() {
        //             social_engage.destroySesion();
        //         });
        //     }
        // }
    }
}


if(typeof custId=="undefined"){
    var custId="";
}
var login_params="";
var gig_uid;
var userStatusParams = {
                        containerID: 'divUserStatus'
                };
var share_params="";
var comments_params="";



var social_engage ={
    config : {
        debug               : true,
        login_params        : {
            version: 2
            ,autoLogin:true
            ,showTermsLink: 'false'
            ,hideGigyaLink:true
            ,height: 100
            ,width: '100%'
            ,containerID: 'login_gigya_social'
            ,buttonsStyle: 'fullLogoColored'
            ,autoDetectUserProviders: ''
            ,facepilePosition: 'none'
            ,lastLoginIndication:'none'
        }, /* login_params */           
        comments_params     : {
            categoryID: 'test1'
            ,streamID: ''
            ,version: 2
            ,containerID: 'comments_gigya'
            ,deviceType: 'auto'
            ,moreEnabledProviders: ["facebook","twitter","googleplus"]
            ,cid: ''
            ,enabledProviders: ["facebook","twitter","googleplus"]
        },
        share_params        : {
            containerID: 'btnShareContainer'
            ,shareButtons: 'facebook,twitter'
            ,iconsOnly: true
            ,userAction: ''
        },   
        domain_name         : "televisa",
        gigya_url_js        : "http://cdn.gigya.com/js/gigya.js",
        enabledProviders    :["facebook","twitter","googleplus"],
        lang                :"es",
        modal               : true,

        urlCssGigya         : 'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/pepsi-gigya.css',
        usr_uid             : null,
        callbacks           :{
            "onLoad"        : "",
            "islogged"      : "", 
            "isnotlogged"   : "", 
            "isnewuser"     : "", 
            "modalstart"    : "",
            "modalclose"    : ""
        }       
    },
        
    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Llaves de los sitios registrados en Gigya
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    domain_key      : {
        "televisa"              : {    "key"            : "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF",
                                        "siteName"      : "Televisa"
        }, /* Televisa */
         "televisadeportes"     : {    "key"            : "3_Dm8WSu6sVRA1kqyXM8SIxuBhcTlnUxXqrTVwF6VWORpcKAbPaaCJsdajX-Q5zIyp",
                                        "siteName"      : "deportes.televisa.com (TelevisaDeportes.com)"
        } /* Televisa Deportes */
    },
    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Templates para controlar la vista de los servicios
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    templates       : {
        usernotlogged   :   '<a href="#" id="start_session" class="gigya-content"><i class="gigya-icon"></i>Inicia SesiÃ³n</a>', 
        userlogged      :   '<i class="gigya-icon"></i>Bienvenido {{nickname}} <a href="#">Cerrar sesiÃ³n</a>',
        modalstructure  :   '<div id="login_gigya_social" class="login_box close">'+
                                '<div class="login-cl"><span id="login-close" class="closeoverlay login-cl"></span></div>'+ 
                                '<div id="gigya_body_networks" class="cont-full slideDownVideoModal">'+
                                '</div>'+   
                            '</div>',
        social_networks :   '<div class="login-form">'+
                                '<div id="gigya_modal" class="social-component"></div>'+
                            '</div>',
        user_status     :   '<div class="login-form">'+
                                '<div id="divUserStatus">{{nickname}}</div>'+
                                '<button id="close_session" class="close_gigya"><span>Cerrar SesiÃ³n</span></button>'+
                            '</div>',

        userEmail       :   '<div id="social_gy_mail" class="social-gy-mail-form">'+
                                '<p></p>'+
                                '<h4 class="gy-txt-subtitle">Ingresa tu correo electrÃ³nico</h4>'+
                                '<p><input type="text" class="input-gy-mail" name="gigya_email" id="txt_gigya_email"></p>'+
                                '<p id="social_msg_error" class="txt-err-gy-mail"></p>'+
                                '<button id="btnSaveEmail" class="btn_save_gy_mail">Guardar</button>'+
                            '</div>',
        is_newuser      :  '<h6>Gracias por registrarte</h6>'+
                            '<p class="big">Bienvenido {{nickname}}</p>'+
                            '<p>Por registrarte tienes un bono de 100 Lichipuntos</p>'+
                            '<p class="big">Muy pronto te diremos como conseguir mas.</p>'
    },

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Inicializa los servicios de gigya de forma asyncrona
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    loadGigya               : function(){
        if(typeof gigya == "undefined"){
            var s = document.createElement('script');
            s.type='text/javascript';
            s.async=true;
            s.src = "http://cdn.gigya.com/js/gigya.js?apiKey="+this.domain_key[this.config.domain_name]["key"];
            s.text = "{ siteName: '"+this.domain_key[this.config.domain_name]["siteName"]+"',enabledProviders: 'facebook,twitter,googleplus',lang: '"+this.domain_key[this.config.domain_name]["siteName"]+"'}";
            document.getElementsByTagName('head')[0].appendChild(s);
        }
    },
        

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Controlador de servicio login
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    startLogin              : function(){
        gigya.socialize.getUserInfo({ callback: social_engage.setearUI });
        //gigya.socialize.getUserSettings({callback: social_engage.printResponse});
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
    audience_manager        : function(user){
        try{
            gig_uid = user.UID;
            custId = gig_uid;
            if (custId && typeof custId !== 'undefined') {
                televisaDil.api.aamIdSync({
                    dpid : "31642",
                    dpuuid : custId,
                    minutesToLive : 20160
                });
            }  
        }catch (err) {}
    },

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Funcion que verifica el estado de un usuario
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    setearUI                : function(res) {
        social_engage.runCallbackExist('onLoad'); 
        if (res.user != null && res.user.isConnected) { 
            //console.info("El usuario esta logueado");
            social_engage.settingTemplates(res.user);
            social_engage.displayUserLooged(res.user);
            social_engage.audience_manager(res.user);
            social_engage.runCallbackExist('islogged', res.user.UID);
            social_engage.destroyLoginOptions();
            social_engage.requireEmail(res);
        } else {
            social_engage.displayUsernotLogged(res.user);
            
            social_engage.runCallbackExist('isnotlogged');
            //console.info("El usuario NO esta logueado");
        }
    },

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Funcion para destruir la sesion del usuario
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    destroySesion           : function(){
        gigya.socialize.logout({callback:social_engage.removeSesion});
    },

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++
     * Callback despues de cerrar la sesiÃ³n del usuario
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    removeSesion            : function(response) {   
        if ( response.errorCode == 0 ) {                
            //alert('User has logged out');
            social_engage.displayUsernotLogged();
        }else { 
            //alert('Error :' + response.errorMessage); 
        } 
    },

    runCallbackExist            : function(callback, params){
        if(social_engage.config.callbacks[callback] != "undefined" && social_engage.config.callbacks[callback] != "")
          { 
            if(typeof params != "undefined"){
                social_engage.customCallback(eval(social_engage.config.callbacks[callback]), params); 
            }else{
                social_engage.customCallback(eval(social_engage.config.callbacks[callback]));
            }
          }
    },

    customCallback          : function(callback, options){
        if(typeof options != "undefined"){
            callback(options);
        }else{
            callback();
        }
    },

    displayUserLooged       : function(user){
        //this.replaceUserInfo(user,"userlogged");
        $("#login_gigya").html(this.templates["userlogged"]);
        $("#close_session").click(function() {
            social_engage.destroySesion();
        });
    },

    settingTemplates        : function(user){
        var count = Object.keys(social_engage.templates).length;
            var keys = Object.keys(social_engage.templates);
            for (var i=0; i <= count-1; i++) {
                social_engage.replaceUserInfo(user, keys[i]);
            }
    },

    requireEmail            : function(res){
        if(res.user.email.length <= 0){
            
            if(this.config.modal === true)
            {
                $("#gigya_body_networks").html(this.templates["userEmail"]);
                $("#login_gigya_social").show();
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
                //console.log("en construcciÃ³n...");
                social_engage.destroyLoginOptions();
            }

        }else{ 
            if(res.newUser === true){ 
                    social_engage.runCallbackExist('isnewuser');
            }
        }
    },

    setEmail            : function(email, usr){
                expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                 if ( !expr.test(email) ){
                    $("#social_msg_error").html("Ingresa un correo valido.");
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

    displayUsernotLogged    : function(){
        $("#login_gigya").html(this.templates["usernotlogged"]);
        $("#start_session").click(function() {
            social_engage.displayLoginOptions();
        });
    },

    displayLoginOptions     :   function(){
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

    destroyLoginOptions     :   function(){
        $("#gigya_body_networks").html("");
        if(typeof social_engage_external_config.templates.modalstructure != "undefined" && this.config.modal === true){
            $("#login_gigya_social").hide();
                social_engage.runCallbackExist('modalclose');
                $("#gigya_body_networks").html(this.templates.user_status);
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
            $("#login_gigya_social").removeClass("open").addClass("close");
            social_engage.runCallbackExist('modalclose');
            $("#gigya_body_networks").html(this.templates.user_status);
                $("#show_status").click(function(){
                    $("#login_gigya_social").show();
                });
                $("#login-close").click(function(){
                    $("#login_gigya_social").hide();
                });
        }else{ 
            $("#login_gigya_social").html(""); 
        }
    },  

    createCustomModal       : function(){
        login_params.containerID = "gigya_modal";
        $("#gigya_body_networks").html(this.templates["social_networks"]);
        social_engage.runCallbackExist('modalstart');
        $("#login_gigya_social").show();
        // $("#close_session").click(function(){
        //  social_engage.runCallbackExist('modalclose');
        // });
        $("#login-close").click(function() { 
            $("#login_gigya_social").hide();
            
        });
        gigya.socialize.showLoginUI(login_params);
    },

    createModal             : function(){
        login_params.containerID = "gigya_modal";
        $("#gigya_body_networks").html(this.templates["social_networks"]);
        $("#login_gigya_social").removeClass("close").addClass("open");
        $("#login-close").click(function() { 
            $("#login_gigya_social").removeClass("open").addClass("close"); 
        } );
        gigya.socialize.showLoginUI(login_params);
    },

    replaceUserInfo         : function(user,template){
        this.templates[template] = this.templates[template].replace("{{photoURL}}", user.photoURL);
        this.templates[template] = this.templates[template].replace("{{usuario}}", user.nickname);
        this.templates[template] = this.templates[template].replace("{{nickname}}", user.nickname);
        this.templates[template] = this.templates[template].replace("{{firstName}}", user.firstName);
        this.templates[template] = this.templates[template].replace("{{thumbnailURL}}", user.thumbnailURL);
    },

    initLogin               : function(eventObj){
        social_engage.setearUI(eventObj);
    },

        
    init                    : function (){
        if(typeof gigya == "undefined"){
            this.loadGigya();
            return false;
        }
        if(typeof social_engage_external_config != "undefined"){
            if(typeof social_engage_external_config.templates != "undefined"){
                this.templates = $.extend(this.templates, social_engage_external_config.templates);
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
        }
        if(document.getElementById("login_gigya")){
             login_params=this.config.login_params;
             this.startLogin();
             if(this.config.modal === true){
                $("#login_gigya_social").remove();
                var css = document.createElement('link');
                css.rel= 'stylesheet';
                css.href = this.config.urlCssGigya;
                document.getElementsByTagName('head')[0].appendChild(css);
                $(this.templates.modalstructure).appendTo(document.body);
            }
        }   
        // if(document.getElementById("comments_gigya")){       
        //     comments_params=this.config.comments_params;
        //     this.startComments();
        // }
        // $(social_engage.templates.login_modal).appendTo(document.body);
        // $(social_engage.templates.share_html).appendTo("#widgetSocialGigyaFoot");
        // $("#enmodal_login").html(social_engage.templates["login_networks"]);
        // if(document. getElementById("btnShareContainer")){   
        //     share_params=this.config.share_params;
        //     this.startShare();
        // }
        //gigya.socialize.showLoginUI(login_params);
    }
};


social_engage.init();

function onGigyaServiceReady(serviceName) {
    //console.info(serviceName);
    social_engage.init(); 
}




var box_config = "";
var templates = "";
var box_code = {
    config  : {
        //id del elemento a vincular
        idElement : "midiv",
    },
    templates : {


        template_form : '<div class="full-video">'+
                            '<div class="cerrarv video-f"><i class="icon-close"></i></div>'+
                            '<div class="cont-full slideDownVideo"></div>'+
                                
                                    '<iframe class="slideDownVideo" src="https://promociones.televisa.com/cklass/" frameborder="0" scrolling="0" id="corazon_enamorado"></iframe>'+
                                '</div>'
                            ,
        template_iframe : '<iframe class="slideDownVideo" src="https://promo.televisa.com/cklass/" frameborder="0" scrolling="0"></iframe>'
    },                      
    showNext : function(){
        //cambiar el contenido del lightbox
        $("div.slideDownVideo").empty();
        //embed iframe de ejemplo
        $(templates.template_iframe).appendTo($("div.full-video"));
    },
    validate :  function(){
        var codigo = document.form_uno.codigo.value;
        
        if(codigo.trim().length > 0){
            //validación test
            this.showNext(); 
            return false;
        }else{ 
            return false;
        }
    },
    hideBox : function(){
        $('.full-video').fadeOut('fast', function() {
                        $(this).remove();
                    });
    },
    showUI : function(template){
         
        $('body').append(box_code.templates.template_form);
        $('.video-f').click(function(event) {
            event.preventDefault();
            $('.full-video').fadeOut('fast', function() {
                $(this).remove();
            });
        });
    },
    start : function(){
        box_config = this.config;
        templates = this.templates;
        var div = document.getElementById(box_config.idElement);
        box_code.showUI();
    }
}


dominio = window.location.host;
// var PlayVideo = function (a,b,c){

//   var FrameVideo= $("#frmVideo").attr("src");

//     Num = FrameVideo.search("&escaleta="+escaleta.idChannel);

//     if(Num == -1){
//       escaleta.video_player_repeticion();
//     }
  
//   var iframeWin = document.getElementById("corazon_enamorado").contentWindow;

//     data = {"stream":a,"inicio":b,"fin":c};
//     iframeWin.postMessage(data, "http://amp.televisa.com");

//     escaleta.senal_status("repeat");
// }



window.addEventListener('message', callback_escaleta, false);
function callback_escaleta(event){
    wlDomains = [
      "promociones.televisa.com"
    ];
    eveOri = event.origin.replace(/^http(s)?:\/\//i, "");
    // console.log(event);
    //console.log(event.data);
    // console.log(wlDomains.indexOf(eveOri));
    // if (wlDomains.indexOf(eveOri) !== -1){
    respuesta=event.data;

    //console.log(respuesta.videoId);

       // OBTIENES EL DATO playing
      if(typeof respuesta.videoId!='undefined'){
        //if(!respuesta.videoId){
          $("#corazon_enamorado").attr("src","http://amp.televisa.com/embed/embed.php?id="+respuesta.videoId+"&canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&subcanal=0000&w=624&h=351&autoplay=true&c3=");
        //}
      }
    //}
    return 0;
  };
//box_code.start()