/* ******************************************************
 * Se elimina la primera implementación de gigya
 * para incluir el login en el header de televisa
 * ***************************************************** */
$("#login_gigya").attr("id","_false_login_gigya");
$("#login_gigya_mobile").attr("id","_false_login_gigya_mobile");


/* ******************************************************
 * Se incluyen configuraciones para el sitio 
 * 
 * ***************************************************** */
var social_engage_external_config ={
    callbacks       : {
        "islogged" : "isLogged",
        "isnotlogged" : "notLogged"
        },
    modal           :   true,
    urlCssGigya         : 'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/gigya-noticieros.css',
    useTemplateLogin : false,
    cid             : "Canal 5",
    domain_name         : "canal5",
    comments_params     : {
        categoryID: 'Canal 5',
        cid: 'home_canal5'
    },
    templates   : {

        social_networks  :  '<h2 class="ui-gy-txt--title">Bienvenidos a la comunidad Televisa</h2>'+
                                '<p class="ui-gy-txt--paragraph">Ingresa con tu Red Social</p>'+
                                '<div id="gigya_modal" class="social-component"></div>',

        modalstructure  :   '<section id="login_gigya_social" class="ui-gy-modal" data-animate="fade-in" style="display:none;">'+
                                '<div class="ui-gy-modal__content js-share"><i id="login-close" class="ui-gy-modal-icon--close"></i>'+
                                    '<div id="gigya_body_modal" class="login-form"></div>'+
                                '</div>'+
                             '</section>'
    }
};



/* ******************************************************
 * Se configuran variables para segmentar por sitio
 * 
 * ***************************************************** */
// try{
//     var url_gigya = document.location.href.replace("http://noticieros.televisa.com/","").split("/");
//     switch(url_gigya[0]) {
//         case "telenovelas":
//             if(typeof url_gigya[1]!="undefined"){
//                 switch(url_gigya[1]){
//                     case "telemundo":
//                         social_engage_external_config.cid="Telenovela Telemundo "+url_gigya[1];
//                         social_engage_external_config.comments_params.cid="Comentarios Telemundo "+url_gigya[1];
//                         break;
//                     default:
//                         social_engage_external_config.cid="Telenovela "+url_gigya[1];
//                         social_engage_external_config.comments_params.cid="Comentarios Telenovela "+url_gigya[1];
//                 }
//             }
//             break;
//         case "programas-tv":
//             if(typeof url_gigya[1]!="undefined"){
//                 social_engage_external_config.cid="Programa TV "+url_gigya[1];
//                 social_engage_external_config.comments_params.cid="Comentarios Programa TV "+url_gigya[1];
//             }
//             break;
//         default:
//             social_engage_external_config.cid="Sitio Television ";
//             social_engage_external_config.comments_params.cid="Comentarios Television ";
//         }
// }catch (err) {}


