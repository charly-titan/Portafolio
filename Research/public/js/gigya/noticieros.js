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
    cid             : "Sitio Noticieros",
    domain_name         : "noticieros",
    comments_params     : {
        categoryID: 'noticieros',
        cid: 'home_noticieros'
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
try{
    var url_gigya = document.location.href.replace("http://noticieros.televisa.com/","").split("/");
    switch(url_gigya[0]) {
        case "mexico":
            social_engage_external_config.cid="Noticieros mexico";
            social_engage_external_config.comments_params.cid="Comentarios mexico";
            break;
        case "mexico-df":
            social_engage_external_config.cid="Noticieros mexico-df";
            social_engage_external_config.comments_params.cid="Comentarios mexico-df";
            break;
        case "mexico-estados":
            social_engage_external_config.cid="Noticieros mexico-estados";
            social_engage_external_config.comments_params.cid="Comentarios mexico-estados";
            break;
        case "mundo":
            social_engage_external_config.cid="Noticieros mundo";
            social_engage_external_config.comments_params.cid="Comentarios mundo";
            break;
        case "especiales":
            social_engage_external_config.cid="Noticieros especiales";
            social_engage_external_config.comments_params.cid="Comentarios especiales";
            break;
        case "cultura":
            social_engage_external_config.cid="Noticieros cultura";
            social_engage_external_config.comments_params.cid="Comentarios cultura";
            break;
        case "economia":
            social_engage_external_config.cid="Noticieros economia";
            social_engage_external_config.comments_params.cid="Comentarios economia";
            break;
        case "clima":
            social_engage_external_config.cid="Noticieros clima";
            social_engage_external_config.comments_params.cid="Comentarios clima";
            break;
        case "podcast-primero-noticias":
            social_engage_external_config.cid="Noticieros podcast-primero-noticias";
            social_engage_external_config.comments_params.cid="Comentarios podcast-primero-noticias";
            break;
        case "transito":
            social_engage_external_config.cid="Noticieros transito";
            social_engage_external_config.comments_params.cid="Comentarios transito";
            break;
        case "estilo-de-vida":
            social_engage_external_config.cid="Noticieros estilo-de-vida";
            social_engage_external_config.comments_params.cid="Comentarios estilo-de-vida";
            break;
        case "ultima-hora":
            social_engage_external_config.cid="Noticieros ultima-hora";
            social_engage_external_config.comments_params.cid="Comentarios ultima-hora";
            break;
        case "opinion":
            social_engage_external_config.cid="Noticieros opinion";
            social_engage_external_config.comments_params.cid="Comentarios opinion";
            break;
        case "infografias":
            social_engage_external_config.cid="Noticieros infografias";
            social_engage_external_config.comments_params.cid="Comentarios infografias";
            break;
        case "ciencia-y-tecnologia":
            social_engage_external_config.cid="Noticieros ciencia-y-tecnologia";
            social_engage_external_config.comments_params.cid="Comentarios ciencia-y-tecnologia";
            break;
        case "foro-tv":
            social_engage_external_config.cid="Noticieros foro-tv";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv";
            break;
        case "fotos":
            social_engage_external_config.cid="Noticieros fotos";
            social_engage_external_config.comments_params.cid="Comentarios fotos";
            break;
        case "programas-noticiero-con-joaquin-lopez-doriga":
            social_engage_external_config.cid="Noticieros programas-noticiero-con-joaquin-lopez-doriga";
            social_engage_external_config.comments_params.cid="Comentarios programas-noticiero-con-joaquin-lopez-doriga";
            break;
        case "programas-primero-noticias":
            social_engage_external_config.cid="Noticieros programas-primero-noticias";
            social_engage_external_config.comments_params.cid="Comentarios programas-primero-noticias";
            break;
        case "programas-noticiero-con-lolita-ayala":
            social_engage_external_config.cid="Noticieros programas-noticiero-con-lolita-ayala";
            social_engage_external_config.comments_params.cid="Comentarios programas-noticiero-con-lolita-ayala";
            break;
        case "programas-tercer-grado":
            social_engage_external_config.cid="Noticieros programas-tercer-grado";
            social_engage_external_config.comments_params.cid="Comentarios programas-tercer-grado";
            break;
        case "programas-la-entrevista-por-adela":
            social_engage_external_config.cid="Noticieros programas-la-entrevista-por-adela";
            social_engage_external_config.comments_params.cid="Comentarios programas-la-entrevista-por-adela";
            break;
        case "programas-punto-de-partida":
            social_engage_external_config.cid="Noticieros programas-punto-de-partida";
            social_engage_external_config.comments_params.cid="Comentarios programas-punto-de-partida";
            break;
        case "programas-alebrijes-aguila-o-sol":
            social_engage_external_config.cid="Noticieros programas-alebrijes-aguila-o-sol";
            social_engage_external_config.comments_params.cid="Comentarios programas-alebrijes-aguila-o-sol";
            break;
        case "programas-las-mangas-del-chaleco":
            social_engage_external_config.cid="Noticieros programas-las-mangas-del-chaleco";
            social_engage_external_config.comments_params.cid="Comentarios programas-las-mangas-del-chaleco";
            break;
        case "programas-terapia-intensiva":
            social_engage_external_config.cid="Noticieros programas-terapia-intensiva";
            social_engage_external_config.comments_params.cid="Comentarios programas-terapia-intensiva";
            break;
        case "programas-unidad-de-quemados":
            social_engage_external_config.cid="Noticieros programas-unidad-de-quemados";
            social_engage_external_config.comments_params.cid="Comentarios programas-unidad-de-quemados";
            break;
        case "foro-tv-el-mananero":
            social_engage_external_config.cid="Noticieros foro-tv-el-mananero";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-el-mananero";
            break;
        case "foro-tv-a-las-tres":
            social_engage_external_config.cid="Noticieros foro-tv-a-las-tres";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-a-las-tres";
            break;
        case "foro-tv-paralelo-23":
            social_engage_external_config.cid="Noticieros foro-tv-paralelo-23";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-paralelo-23";
            break;
        case "foro-tv-en-1-hora":
            social_engage_external_config.cid="Noticieros foro-tv-en-1-hora";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-en-1-hora";
            break;
        case "foro-tv-es-la-hora-de-opinar":
            social_engage_external_config.cid="Noticieros foro-tv-es-la-hora-de-opinar";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-es-la-hora-de-opinar";
            break;
        case "foro-tv-el-centro-del-debate":
            social_engage_external_config.cid="Noticieros foro-tv-el-centro-del-debate";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-el-centro-del-debate";
            break;
        case "foro-tv-los-reporteros":
            social_engage_external_config.cid="Noticieros foro-tv-los-reporteros";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-los-reporteros";
            break;
        case "foro-tv-contra-campo":
            social_engage_external_config.cid="Noticieros foro-tv-contra-campo";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-contra-campo";
            break;
        case "foro-tv-sin-filtro":
            social_engage_external_config.cid="Noticieros foro-tv-sin-filtro";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-sin-filtro";
            break;
        case "foro-tv-la-mudanza":
            social_engage_external_config.cid="Noticieros foro-tv-la-mudanza";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-la-mudanza";
            break;
        case "programas-respuesta-oportuna":
            social_engage_external_config.cid="Noticieros programas-respuesta-oportuna";
            social_engage_external_config.comments_params.cid="Comentarios programas-respuesta-oportuna";
            break;
        case "foro-tv-anecdotario-secreto":
            social_engage_external_config.cid="Noticieros foro-tv-anecdotario-secreto";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-anecdotario-secreto";
            break;
        case "power-up-gamer":
            social_engage_external_config.cid="Noticieros power-up-gamer";
            social_engage_external_config.comments_params.cid="Comentarios power-up-gamer";
            break;
        case "foro-tv-matutino-express":
            social_engage_external_config.cid="Noticieros foro-tv-matutino-express";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-matutino-express";
            break;
        case "foro-tv-fractal":
            social_engage_external_config.cid="Noticieros foro-tv-fractal";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-fractal";
            break;
        case "foro-tv-agenda-publica":
            social_engage_external_config.cid="Noticieros foro-tv-agenda-publica";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-agenda-publica";
            break;
        case "foro-tv-hora-21":
            social_engage_external_config.cid="Noticieros foro-tv-hora-21";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-hora-21";
            break;
        case "foro-tv-economia-de-mercado":
            social_engage_external_config.cid="Noticieros foro-tv-economia-de-mercado";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-economia-de-mercado";
            break;
        case "foro-tv-final-de-partida":
            social_engage_external_config.cid="Noticieros foro-tv-final-de-partida";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-final-de-partida";
            break;
        case "foro-tv-retomando":
            social_engage_external_config.cid="Noticieros foro-tv-retomando";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-retomando";
            break;
        case "foro-tv-oppenheimer":
            social_engage_external_config.cid="Noticieros foro-tv-oppenheimer";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-oppenheimer";
            break;
        case "foro-tv-creadores-universitarios":
            social_engage_external_config.cid="Noticieros foro-tv-creadores-universitarios";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-creadores-universitarios";
            break;
        case "programas-reactor-ftv":
            social_engage_external_config.cid="Noticieros programas-reactor-ftv";
            social_engage_external_config.comments_params.cid="Comentarios programas-reactor-ftv";
            break;
        case "programas-noticias-y-reportajes":
            social_engage_external_config.cid="Noticieros programas-noticias-y-reportajes";
            social_engage_external_config.comments_params.cid="Comentarios programas-noticias-y-reportajes";
            break;
        case "foro-tv-glitter-cafe":
            social_engage_external_config.cid="Noticieros foro-tv-glitter-cafe";
            social_engage_external_config.comments_params.cid="Comentarios foro-tv-glitter-cafe";
            break;
        case "programas-las-noticias-por-adela":
            social_engage_external_config.cid="Noticieros programas-las-noticias-por-adela";
            social_engage_external_config.comments_params.cid="Comentarios programas-las-noticias-por-adela";
            break;
        case "ideasexchange":
            social_engage_external_config.cid="Noticieros ideasexchange";
            social_engage_external_config.comments_params.cid="Comentarios ideasexchange";
            break;
        case "lugares-genio":
            social_engage_external_config.cid="Noticieros lugares-genio";
            social_engage_external_config.comments_params.cid="Comentarios lugares-genio";
            break;
        case "por-el-planeta":
            social_engage_external_config.cid="Noticieros por-el-planeta";
            social_engage_external_config.comments_params.cid="Comentarios lugares-genio";
            break;
        case "infografias":
            social_engage_external_config.cid="Noticieros infografias";
            social_engage_external_config.comments_params.cid="Comentarios lugares-genio";
            break;
        case "interactivo-ebola":
            social_engage_external_config.cid="Noticieros interactivo-ebola";
            social_engage_external_config.comments_params.cid="Comentarios lugares-genio";
            break;
        case "ebola":
            social_engage_external_config.cid="Noticieros ebola";
            social_engage_external_config.comments_params.cid="Comentarios lugares-genio";
            break;
    }
}catch (err) {}

