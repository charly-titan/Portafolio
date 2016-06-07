var social_engage_external_config ={
    callbacks       : {
        "onLoad" : "settearUI" 
        },
    modal           :   true,
    cid             : "Sitio Pepsi Music",
    // urlCssGigya         : '/css/pepsi-gigya.css',
    templates   : {
        usernotlogged   :   '<div id="start_session" class="login bigbutton"></div>',
        userlogged      :   '<div id="userName" class="login loginmenu" style="display:block"; visibility:visible;>'+
                            '<span id="tagname" class="welcome redfont">Hola {{usuario}}</span><br>'+
                            '<span id="show_status" class="close bluefont">'+
                            'Cerrar Sesi&oacute;n</span>'+
                            '</div>',
        social_networks  :  '<div class="login-form">'+
                            '<p class="ui-gy-txt--paragraph">Ingresa con tu Red Social</p>'+
                            '<div id="gigya_modal" class="social-component"></div>'+
                            '</div>'
    },
    share_buttons_tpl  : {
                facebook    : '<div id="div_button_fb" class="facebook"><a></a></div>',
                twitter     : '<div id="div_button_tw" class="twitter"><a></a></div>'
    }
};
function settearUI(){
    var html_structure = '<p class="sharingtitle bluefont">Compartir en:</p>'+
                            '<div style="width:100px;" id="widgetSocialShare5"></div>';

    if(document.location.href.search("pepsi-music") != 1){
        if(document.getElementById("widgetSocialShare5") == undefined){ 
            $("#widgetSocialGigyaFoot").html(html_structure);
        }
        if(document.getElementById("COMM_comments_facebook") == undefined){
            $("#comments_gigya").attr("id","COMM_comments_facebook");
        }
    }
}
