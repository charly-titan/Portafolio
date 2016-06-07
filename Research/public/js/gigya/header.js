// function inciarSesion(){
//     $("body").addClass("ui-gy");
//     social_engage.displayLoginOptions();
// }

//         var callbacks = {
//             sessionStart:   inciarSesion,
//             sessionLogout:  function(){ gigyaHeader.loginSession(); social_engage.destroySesion(); },
//             sessionPrefs:   function(){ alert('preferencias de callback'); }
//         };
        
//         // var user = {
//         //     image: 'http://im.esmas.com/100/100/lamalquerida/56',
//         //     greeting: 'Bienvenida',
//         //     name: 'Ximena Navarrete'
//         // };

//         gigyaHeader.init(false, callbacks);




// var social_engage_external_config ={
//     callbacks       : {
//         "islogged" : "isLogged"
//         },
//     modal           :   true,
//     useTemplateLogin : false,
//     cid             : "Sitio Television",
//     templates   : {

//         // userlogged      :   '<a href="#" class="ui-gy-login__content init" style="display:none">'+
//         //                         '<img class="ui-gy-login__avatar tvsaimg-loaded" src="{{thumbnailURL}}"/>'+
//         //                         '<i class="tvsaFH-caret-down"></i>'+
//         //                     '</a>'+
//         //                     '<div class="gigya-tooltip" style="display:none">'+
//         //                         '<div class="img_user_social" id="avatar_social">'+
//         //                             '<img id="avatar_usuario" src="{{thumbnailURL}}">'+
//         //                         '</div>'+
//         //                         '<span class="info_usuario" id="saludo">Bienvenido</span>'+
//         //                         '<span class="info_usuario" id="saludo_usuario"><strong>{{usuario}}</strong></span><span class="login_social" id="pref_social"><a><i class=""></i><strong>Preferencias</strong></a></span>'+
//         //                         '<span class="login_social" id="close_session"><i class=""></i><a>Cerrar sesi&oacute;n</a></span>'+
//         //                     '</div>',

//         // usernotlogged   :   '<a href="#" class="ui-gy-login__content nosession" style="display:none">'+
//         //                          '<i class="ui-gy-icon--login"></i>'+
//         //                     '</a>'+
//         //                     '<div class="gigya-tooltip aviso" style="display:none">'+
//         //                         '<span class="info_usuario" id="saludo_usuario">'+
//         //                             '<strong>'+
//         //                                 '<a href="#" id="start_session">Inicia sesi&oacute;n</a>'+
//         //                             '</strong>'+
//         //                         '</span>'+
//         //                     '</div>',

//         social_networks  :  '<h2 class="ui-gy-txt--title">Bienvenidos a la comunidad Televisa</h2>'+
//                                 '<p class="ui-gy-txt--paragraph">Ingresa con tu Red Social</p>'+
//                                 '<div id="gigya_modal" class="social-component"></div>',

//         modalstructure  :   '<section id="login_gigya_social" class="ui-gy-modal" data-animate="fade-in" style="display:none;">'+
//                                 '<div class="ui-gy-modal__content js-share"><i id="login-close" class="ui-gy-modal-icon--close"></i>'+    
//                                     '<div id="gigya_body_modal" class="login-form"></div>'+
//                                 '</div>'+
//                              '</section>'
//     }
// };


// function isLogged(uid){
//     gigya.socialize.getUserInfo({callback:printResponse});
// }

// function printResponse(response) { 
//     if ( response.errorCode == 0 ) {
//         var saludo = "";
//         if(response.user.gender == "m"){ 
//             saludo = "Bienvenido";
//         }else if(response.user.gender == "f"){
//             saludo = "Bienvenida";
//         }else{
//             saludo = "Bienvenid@";
//         }            
//         var user = {
//                 image: response.user.thumbnailURL,
//                 greeting: saludo,
//                 name: response.user.nickname
//         };
//         gigyaHeader.loadSession(user);
//         setTimeout(function(){ $("span#pref_social").css("display", "none"); }, 1000);
//     }
//     else {
//         console.log('Error :' + response.errorMessage);
//     } 
// }