var box_config = "";
var templates = "";
var box_code = {
	config	: {
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