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
        "isnewuser"     : "isNewUser"

        },
    modal           :   true,
    useTemplateLogin : false,
    domain_name         : "television",
    cid             : "Sitio AMQL",
    urlCssGigya         : 'https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/gigya-television.css',
    comments_params     : {
        categoryID: 'AMQL',
        cid: 'AMQL Comments'
    },
    templates   : {
        social_networks  :  '<h2 class="ui-gy-txt--title">Bienvenidos a la comunidad Televisa</h2>'+
                                '<p class="ui-gy-txt--paragraph">Ingresa con tu Red Social</p>'+
                                '<div id="gigya_modal" class="social-component"></div>',

        modalstructure  :   '<section id="login_gigya_social" class="ui-gy-modal" data-animate="fade-in" style="display:none;">'+
                                '<div class="ui-gy-modal__content js-share"><i id="login-close" class="ui-gy-modal-icon--close"></i>'+
                                    '<div id="gigya_body_modal" class="login-form"></div>'+
                                '</div>'+
                             '</section>',
            is_newuser     :  '<h6>Gracias por registrarte</h6>'+
                                '<p class="big">Bienvenido {{nickname}}</p>'+
                                '<p>Por registrarte tienes un bono de 100 Lichipuntos</p>'+
                                '<p class="big">Muy pronto te diremos como conseguir mas.</p>'


    }
};

/* ******************************************************
 * Configuración para novelas que no son AMQL
 *
 * ***************************************************** */
if (document.location.href.search("/a-que-no-me-dejas-segunda-temporada/")!=-1 || document.location.href.search("/simplemente-maria/")!=-1){
    social_engage_external_config.templates.is_newuser      =   '<h6>Gracias por registrarte</h6>'+
                                                                '<p class="big">Bienvenido {{nickname}}</p>';
}


/* ******************************************************
 * Se configuran variables para segmentar por sitio
 *
 * ***************************************************** */
if (document.location.href.search("/a-que-no-me-dejas-segunda-temporada/")!=-1 ){
    social_engage_external_config.cid="Telenovela a-que-no-me-dejas-segunda-temporada";
    social_engage_external_config.comments_params.cid="Comentarios a-que-no-me-dejas-segunda-temporada";
}
if(document.location.href.search("/simplemente-maria/")!=-1){
    social_engage_external_config.cid="Telenovela simplemente-maria";
    social_engage_external_config.comments_params.cid="Comentarios simplemente-maria";
}

/* ******************************************************
 * Bienvenida a los nuevos usuarios notificandoles que
 * ganaron puntos para AMQL
 * ***************************************************** */
function isNewUser(){
    $("#login_gigya_social").clone().attr('id', 'modal_welcome').appendTo(document.body);
    $("#modal_welcome div#gigya_body_networks").attr("id", "gigya_body_welcome");
    $("#modal_welcome div#login-close").attr("id", "close_welcome");
    $("#close_welcome").click(function(){ $("#modal_welcome").remove(); });
    $("#gigya_body_welcome").html(social_engage.templates.is_newuser);
    $("#modal_welcome").css("visibility", "visible").show();
}
