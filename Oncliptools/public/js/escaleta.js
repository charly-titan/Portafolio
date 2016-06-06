if(!document.getElementById("escaleta_main")){
  $("<div class='escaleta-main' id='escaleta_main'></div>").insertAfter(".header");
}

var dispositivo = navigator.userAgent.toLowerCase();

if (dispositivo.search(/iphone|ipod|ipad|android/) > -1) {
  $('html').addClass('mobile');
}

var idDFPObject="";
var idDFP ="";

//$(document).find("#widgetSocialShare5").removeAttr('id');

var escaleta = {

  AmazonEscaleta    : "http://communities-dev.s3-website-us-west-1.amazonaws.com/escaleta/",
  UrlJson           : "json/",
  UrlStatus         : "js/status.js",
  UrlLive           : "escaleta2/js/escaleta2_vivo.js",
  UrlRepeat         : "escaleta2/js/escaleta2_repeticion.js",
  urlFramePlayer    : "http://amp.televisa.com/embed/embed_escaleta.php?id=276790",
  UrlPublicity      : "escaleta2/js/escaleta_publicidad.html",
  timeOut           : 60000,
  frame_id          : "",
  subcanal          : "",
  idChannel         : "",
  idProgram         : "",
  flag              : false,
  serverDateChange  : '',
  flagRepeat        : false,
  changeJson        : false,
  noticierosVideo   : false,
  jsonNull          : false,


  program_code      : {
                        1311  :   { code:"prime", title:'Primero Noticias, con Carlos Loret de Mola', url:'programas-primero-noticias'},
                        1321  :   { code:"lolit", title:'Noticiero, conducido por Lolita Ayala', url:'programas-noticiero-con-lolita-ayala' },
                        1713  :   { code:"ntjld", title:'El Noticiero, con Joaquín Lopez-Doriga', url:'programas-noticiero-con-joaquin-lopez-doriga' },
                        1808  :   { code:"alas3", title:'A las 3, conducido por Paola Rojas', url:'foro-tv-a-las-tres' },
                        1795  :   { code:"adela", title:'Las Noticias por Adela', url:'programas-las-noticias-por-adela' },
                        2699  :   { code:"elman", title:'El Mañanero y Debatitlán, con Brozo', url:'foro-tv-el-mananero' },
                        2925  :   { code:"hra21", title:'Hora 21, conducido por Karla Iberia Sánchez', url:'foro-tv-hora-21' },
                        1734  :   { code:"matex", title:'Matutino Express, conducido por Esteban Arce', url:'foro-tv-matutino-express' }
                      },

  monthNames        : ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
  daysNames          : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],


  create_skeleton   :   function(){

    var container   =   $($("<main>").addClass('content-main')
                    //SECTION ESCALETA PLAYER CONTENT
                    .append($("<section>").addClass("escaleta-player-content")
                      .append($("<a>",{href:"#escaleta"}))
                      .append($("<h2>").addClass('title'))
                      .append($("<div>").addClass("escaleta-player")
                        
                        .append($("<div>").addClass("video-nt")
                          .append($("<div>").addClass("video-iframe").attr("data-href",""))
                          .append($("<div>").addClass("senal")
                            .append($("<div>").addClass("modo-senal")
                              .append($("<p>").addClass("txt-senal")))))
                        
                        .append($("<div>").addClass("escaleta-modo-redes")
                          .append($("<div>").addClass("senal-vivo")
                            .append($("<p>",{text:"señal en vivo"}).addClass("modo-senal"))
                            .append($("<i>").addClass("noti-senal")))
                          
                          .append($("<div>").addClass("vista-video")
                            .append($("<p>",{text:"VISTA TEATRO"}).addClass("modo-vista"))
                            .append($("<span>").addClass("cuadro")))
                          
                          .append($("<div>",{'id':'widgetSocialShare5'}).addClass("mm-social")
                            .append($("<p>",{text:"comparte este video"}).addClass("compartir-video"))
                            .append($("<div>").addClass("redes")
                              .append($("<i>").addClass("noti-share-mobile"))) 
                            .append($("<div>").addClass("mm-social-icons").attr('data-comm-whatsapp','').attr("data-comm-share","true").attr("data-comm-url","").attr("data-comm-title","").attr("data-comm-img",""))
                          )
                    ))
                      
                      .append($("<aside>").addClass("cubo-ads")
                        .append($("<div>").addClass("cubo-content")
                          .append($("<p>",{text:"publicidad"}).addClass("cubo-txt"))
                          .append($("<div>",{id:'ban03'}).addClass("elemento")
                            .append($("<iframe>",{ src: this.AmazonEscaleta + this.UrlPublicity,scrolling:'no',width:'300',height:'250',marginwidth:'0',marginheight:'0',frameborder:'0'}))))))

                    //SECTION ESCALETA INPUT
                    .append($("<section>").addClass("escaleta-input")
                      .append($("<div>").addClass("form")
                        .append($("<form>",{id:"select-video"})
                          .append($("<div>").addClass("select-hour")
                            .append($("<a>",{href:"#"}).addClass('lista-valor')
                              .append($("<span>",{text:''})))
                            .append($("<div>").addClass("lista-main")
                              .append($("<ul>").addClass("lista-content")))
                            .append($("<select>",{id:"hour",name:"hour"}))
                            .append($("<span>").addClass("arrow hour")
                              .append($("<i>").addClass("noti-abajo")))))))
                    
                    //SEcTION ESCALETA THUMBNAIL
                    .append($("<section>").addClass("escaleta-thumbnail")
                      .append($("<div>").addClass("escaleta-thumbs-content"))
                      .append($("<span>").addClass("back")
                        .append($("<i>").addClass("noti-izquierda")))
                      .append($("<span>").addClass("next")
                        .append($("<i>").addClass("noti-derecha"))))
                  );

    if( document.getElementsByClassName("escaleta-main") ){
      if(document.getElementsByClassName("content-main").length == 0){
        $( ".escaleta-main" ).append( container );
      }
    }

    return 1;
  },

  create_calendar : function(){

    if($(".select-month").find(".month").length == 0){

        $("#select-video").prepend($("<div>").addClass("select-month")
                            .append($("<input>",{type:"text",id:"month",name:"month"}).attr("data-min","2015-09-01").attr("data-max","2015-10-10"))
                              .append($("<span>").addClass("arrow month")
                                .append($("<i>").addClass("noti-abajo"))))
    }

  },
  create_redirect : function(){

    $(".escaleta-main").children().remove();
    $(".escaleta-main").removeAttr("data-status data-status-repeat data-readjson");//$(".ui-grid-fluid-triple").find(".redirect").parent().remove()
    window.location.href="#";

    if(document.getElementsByClassName("redirect").length == 0){

      date = new Date();
      month = date.getMonth();
      day = date.getDate();

      MsgTitle = 'El programa en vivo <strong>"'+this.program_code[escaleta.idProgram].title+' del '+day+' de '+this.monthNames[month]+'"</strong> ha finalizado para ver la repetición da click en el boton';

      var redirect = $($("<section>").addClass('ui-grid-fluid-triple')
                    .append($("<section>").addClass('redirect')
                      .append($("<article>").addClass('redirect-mensaje')
                        //.append($('<p>',{text:MsgTitle}).addClass('mensaje-txt'))
                        .append($("<p>"+MsgTitle+"</p>").addClass('mensaje-txt'))
                        .append($('<a>').addClass('mensaje-button').attr('href',this.program_code[escaleta.idProgram].url)
                          .append($('<i>').addClass('button-icon noti-redirect'))
                          .append($('<p>',{text:'ver la repetición'}).addClass('button-txt'))))

                    .append($("<section>").addClass('ui-grid-fluid-triple')
                      .append($("<div>").addClass('ads_combo_02')
                        .append($("<div>",{id:'ban04'}).addClass('elemento'))))));

        $( redirect ).insertAfter("#escaleta_main");
    }

  },

  loadcss  :  function (file_url){

    var ccs=document.createElement("link");
        ccs.setAttribute("rel", "stylesheet");
        ccs.setAttribute("type", "text/css");
        ccs.setAttribute("href", file_url);
        document.getElementsByTagName("head")[0].appendChild(ccs);
  
  },

  loadJS  : function(file_url){

    $('script[src="' + file_url + '"]').remove();

    var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = file_url;
      document.head.appendChild(s);

  },

  load_videolog : function(){
    escaleta.loadJS("http://i2.esmas.com/tvolucion/js/ua-parser.min.js");
    escaleta.loadJS("http://i2.esmas.com/comunidades/js/videolog_1.js");
  },

  start_video_player  :   function(){

    if(!document.getElementById("frmVideo")){

      var container = document.createElement("iframe");
        container.id  = "frmVideo";
        container.src   =  "";
        container.className = "iframe-videoplayer";
        this.frame_id = window.frames.length;
        document.getElementsByClassName("video-iframe")[0].appendChild(container);
    }
  },

  video_player_vivo : function(){

    try{
      idChannelNew = parseInt(this.idChannel)+1;
      srcFrame  = escaleta.urlFramePlayer + this.subcanal + "&escaleta=" + idChannelNew + "&sn=" + this.program_code[this.idProgram].code;
    
      $("h2.title").text('');
      $(".thumbs").removeClass('active');
      $('.escaleta-main').find('#frmVideo').attr('src',srcFrame)

    }catch(e){}

  },

  video_player_repeticion : function(){ 

    var contentCarrusel = $('.content-carrusel'),
        id    =   contentCarrusel.find('a').first().attr('id'),
        img   =   contentCarrusel.find('li a img').first().attr('src'),
        href  =   contentCarrusel.find('a').first().attr('href');
        text  =   contentCarrusel.find('p').first().text();

    contentCarrusel.find('li a').first().parent().click();
    contentCarrusel.find('li a').first().parent().addClass("active");

    var videoRepeat = contentCarrusel.find('li a').first().data("video");

      paramDate = href.split("_");
      
      param    = videoRepeat.split(",");      
      urlNew   = "&iniTime="+ param[0] +"&clipDuration="+ param[1];
      srcFrame = this.urlFramePlayer + this.subcanal + "&escaleta=" + escaleta.idChannel + urlNew + "&sn=" + escaleta.program_code[escaleta.idProgram].code;

      $(".escaleta-main").find('#frmVideo').removeAttr('src').attr( 'src',srcFrame);

      window.location.href="#"+id+"_"+paramDate[2];
      this.flagRepeat = true;


      /* REDES SOCIALES*/
         var contentShare = $('.content-main').find('.mm-social-icons');

        var dataFirst = {
                        img: img,
                        url: window.location.href,
                        title: text
                        };

        contentShare.attr({
                          'data-comm-img': dataFirst.img,
                          'data-comm-url': dataFirst.url,
                          'data-comm-title': text,
                          'data-comm-whatsapp': 'Noticieros Televisa, toda la información de México y el mundo en un sólo lugar'
                        });
        //socialShare.indexNotesExpanded();
        social_engage.setShareOptions();
      /*****************/
      return true;

  },

  durationPlayer : function(time){

    try{
      var hours = Math.floor( time / 3600 ),  
        minutes = Math.floor( (time % 3600) / 60 ),
        seconds = time % 60;
             
        minutes =   ("0"+minutes).slice(-2);
        seconds =   ("0"+seconds).slice(-2);
        hours   =   ("0"+hours).slice(-2);
        duration =   minutes + ":" + seconds;

        return duration;
    }catch(e){}
    
  },

  senal_status : function(status1){

    status = $(".escaleta-main").attr("data-status");
    contentEscaleta = $(".content-main");

    if(status == "Live show" || (status == "Live show" && status1 == 'live') || status1 == 'live'){
      contentEscaleta.find(".senal").removeClass('repeticion').addClass('vivo').find('.txt-senal').text('en vivo');
      contentEscaleta.find('.senal-vivo').removeClass('activo').addClass('inactivo');
      $(".mm-social").hide();
    }else{
      contentEscaleta.find(".senal").removeClass('vivo').addClass('repeticion').find('.txt-senal').text('repeticion');
      contentEscaleta.find('.senal-vivo').removeClass('activo').addClass('inactivo');
    }

    if(status == "Live show" && status1 == 'repeat'){
      contentEscaleta.find(".senal").removeClass('vivo').addClass('repeticion').find('.txt-senal').text('repeticion');
      contentEscaleta.find('.senal-vivo').removeClass('inactivo').addClass('activo');
    }

  },

  characterReplace:function(title){
    
        var Latinise={};Latinise.latin_map={"Á":"A","Ă":"A","Ắ":"A","Ặ":"A","Ằ":"A","Ẳ":"A","Ẵ":"A","Ǎ":"A","Â":"A","Ấ":"A","Ậ":"A","Ầ":"A","Ẩ":"A","Ẫ":"A","Ä":"A","Ǟ":"A","Ȧ":"A","Ǡ":"A","Ạ":"A","Ȁ":"A","À":"A","Ả":"A","Ȃ":"A","Ā":"A","Ą":"A","Å":"A","Ǻ":"A","Ḁ":"A","Ⱥ":"A","Ã":"A","Ꜳ":"AA","Æ":"AE","Ǽ":"AE","Ǣ":"AE","Ꜵ":"AO","Ꜷ":"AU","Ꜹ":"AV","Ꜻ":"AV","Ꜽ":"AY","Ḃ":"B","Ḅ":"B","Ɓ":"B","Ḇ":"B","Ƀ":"B","Ƃ":"B","Ć":"C","Č":"C","Ç":"C","Ḉ":"C","Ĉ":"C","Ċ":"C","Ƈ":"C","Ȼ":"C","Ď":"D","Ḑ":"D","Ḓ":"D","Ḋ":"D","Ḍ":"D","Ɗ":"D","Ḏ":"D","ǲ":"D","ǅ":"D","Đ":"D","Ƌ":"D","Ǳ":"DZ","Ǆ":"DZ","É":"E","Ĕ":"E","Ě":"E","Ȩ":"E","Ḝ":"E","Ê":"E","Ế":"E","Ệ":"E","Ề":"E","Ể":"E","Ễ":"E","Ḙ":"E","Ë":"E","Ė":"E","Ẹ":"E","Ȅ":"E","È":"E","Ẻ":"E","Ȇ":"E","Ē":"E","Ḗ":"E","Ḕ":"E","Ę":"E","Ɇ":"E","Ẽ":"E","Ḛ":"E","Ꝫ":"ET","Ḟ":"F","Ƒ":"F","Ǵ":"G","Ğ":"G","Ǧ":"G","Ģ":"G","Ĝ":"G","Ġ":"G","Ɠ":"G","Ḡ":"G","Ǥ":"G","Ḫ":"H","Ȟ":"H","Ḩ":"H","Ĥ":"H","Ⱨ":"H","Ḧ":"H","Ḣ":"H","Ḥ":"H","Ħ":"H","Í":"I","Ĭ":"I","Ǐ":"I","Î":"I","Ï":"I","Ḯ":"I","İ":"I","Ị":"I","Ȉ":"I","Ì":"I","Ỉ":"I","Ȋ":"I","Ī":"I","Į":"I","Ɨ":"I","Ĩ":"I","Ḭ":"I","Ꝺ":"D","Ꝼ":"F","Ᵹ":"G","Ꞃ":"R","Ꞅ":"S","Ꞇ":"T","Ꝭ":"IS","Ĵ":"J","Ɉ":"J","Ḱ":"K","Ǩ":"K","Ķ":"K","Ⱪ":"K","Ꝃ":"K","Ḳ":"K","Ƙ":"K","Ḵ":"K","Ꝁ":"K","Ꝅ":"K","Ĺ":"L","Ƚ":"L","Ľ":"L","Ļ":"L","Ḽ":"L","Ḷ":"L","Ḹ":"L","Ⱡ":"L","Ꝉ":"L","Ḻ":"L","Ŀ":"L","Ɫ":"L","ǈ":"L","Ł":"L","Ǉ":"LJ","Ḿ":"M","Ṁ":"M","Ṃ":"M","Ɱ":"M","Ń":"N","Ň":"N","Ņ":"N","Ṋ":"N","Ṅ":"N","Ṇ":"N","Ǹ":"N","Ɲ":"N","Ṉ":"N","Ƞ":"N","ǋ":"N","Ñ":"N","Ǌ":"NJ","Ó":"O","Ŏ":"O","Ǒ":"O","Ô":"O","Ố":"O","Ộ":"O","Ồ":"O","Ổ":"O","Ỗ":"O","Ö":"O","Ȫ":"O","Ȯ":"O","Ȱ":"O","Ọ":"O","Ő":"O","Ȍ":"O","Ò":"O","Ỏ":"O","Ơ":"O","Ớ":"O","Ợ":"O","Ờ":"O","Ở":"O","Ỡ":"O","Ȏ":"O","Ꝋ":"O","Ꝍ":"O","Ō":"O","Ṓ":"O","Ṑ":"O","Ɵ":"O","Ǫ":"O","Ǭ":"O","Ø":"O","Ǿ":"O","Õ":"O","Ṍ":"O","Ṏ":"O","Ȭ":"O","Ƣ":"OI","Ꝏ":"OO","Ɛ":"E","Ɔ":"O","Ȣ":"OU","Ṕ":"P","Ṗ":"P","Ꝓ":"P","Ƥ":"P","Ꝕ":"P","Ᵽ":"P","Ꝑ":"P","Ꝙ":"Q","Ꝗ":"Q","Ŕ":"R","Ř":"R","Ŗ":"R","Ṙ":"R","Ṛ":"R","Ṝ":"R","Ȑ":"R","Ȓ":"R","Ṟ":"R","Ɍ":"R","Ɽ":"R","Ꜿ":"C","Ǝ":"E","Ś":"S","Ṥ":"S","Š":"S","Ṧ":"S","Ş":"S","Ŝ":"S","Ș":"S","Ṡ":"S","Ṣ":"S","Ṩ":"S","Ť":"T","Ţ":"T","Ṱ":"T","Ț":"T","Ⱦ":"T","Ṫ":"T","Ṭ":"T","Ƭ":"T","Ṯ":"T","Ʈ":"T","Ŧ":"T","Ɐ":"A","Ꞁ":"L","Ɯ":"M","Ʌ":"V","Ꜩ":"TZ","Ú":"U","Ŭ":"U","Ǔ":"U","Û":"U","Ṷ":"U","Ü":"U","Ǘ":"U","Ǚ":"U","Ǜ":"U","Ǖ":"U","Ṳ":"U","Ụ":"U","Ű":"U","Ȕ":"U","Ù":"U","Ủ":"U","Ư":"U","Ứ":"U","Ự":"U","Ừ":"U","Ử":"U","Ữ":"U","Ȗ":"U","Ū":"U","Ṻ":"U","Ų":"U","Ů":"U","Ũ":"U","Ṹ":"U","Ṵ":"U","Ꝟ":"V","Ṿ":"V","Ʋ":"V","Ṽ":"V","Ꝡ":"VY","Ẃ":"W","Ŵ":"W","Ẅ":"W","Ẇ":"W","Ẉ":"W","Ẁ":"W","Ⱳ":"W","Ẍ":"X","Ẋ":"X","Ý":"Y","Ŷ":"Y","Ÿ":"Y","Ẏ":"Y","Ỵ":"Y","Ỳ":"Y","Ƴ":"Y","Ỷ":"Y","Ỿ":"Y","Ȳ":"Y","Ɏ":"Y","Ỹ":"Y","Ź":"Z","Ž":"Z","Ẑ":"Z","Ⱬ":"Z","Ż":"Z","Ẓ":"Z","Ȥ":"Z","Ẕ":"Z","Ƶ":"Z","Ĳ":"IJ","Œ":"OE","ᴀ":"A","ᴁ":"AE","ʙ":"B","ᴃ":"B","ᴄ":"C","ᴅ":"D","ᴇ":"E","ꜰ":"F","ɢ":"G","ʛ":"G","ʜ":"H","ɪ":"I","ʁ":"R","ᴊ":"J","ᴋ":"K","ʟ":"L","ᴌ":"L","ᴍ":"M","ɴ":"N","ᴏ":"O","ɶ":"OE","ᴐ":"O","ᴕ":"OU","ᴘ":"P","ʀ":"R","ᴎ":"N","ᴙ":"R","ꜱ":"S","ᴛ":"T","ⱻ":"E","ᴚ":"R","ᴜ":"U","ᴠ":"V","ᴡ":"W","ʏ":"Y","ᴢ":"Z","á":"a","ă":"a","ắ":"a","ặ":"a","ằ":"a","ẳ":"a","ẵ":"a","ǎ":"a","â":"a","ấ":"a","ậ":"a","ầ":"a","ẩ":"a","ẫ":"a","ä":"a","ǟ":"a","ȧ":"a","ǡ":"a","ạ":"a","ȁ":"a","à":"a","ả":"a","ȃ":"a","ā":"a","ą":"a","ᶏ":"a","ẚ":"a","å":"a","ǻ":"a","ḁ":"a","ⱥ":"a","ã":"a","ꜳ":"aa","æ":"ae","ǽ":"ae","ǣ":"ae","ꜵ":"ao","ꜷ":"au","ꜹ":"av","ꜻ":"av","ꜽ":"ay","ḃ":"b","ḅ":"b","ɓ":"b","ḇ":"b","ᵬ":"b","ᶀ":"b","ƀ":"b","ƃ":"b","ɵ":"o","ć":"c","č":"c","ç":"c","ḉ":"c","ĉ":"c","ɕ":"c","ċ":"c","ƈ":"c","ȼ":"c","ď":"d","ḑ":"d","ḓ":"d","ȡ":"d","ḋ":"d","ḍ":"d","ɗ":"d","ᶑ":"d","ḏ":"d","ᵭ":"d","ᶁ":"d","đ":"d","ɖ":"d","ƌ":"d","ı":"i","ȷ":"j","ɟ":"j","ʄ":"j","ǳ":"dz","ǆ":"dz","é":"e","ĕ":"e","ě":"e","ȩ":"e","ḝ":"e","ê":"e","ế":"e","ệ":"e","ề":"e","ể":"e","ễ":"e","ḙ":"e","ë":"e","ė":"e","ẹ":"e","ȅ":"e","è":"e","ẻ":"e","ȇ":"e","ē":"e","ḗ":"e","ḕ":"e","ⱸ":"e","ę":"e","ᶒ":"e","ɇ":"e","ẽ":"e","ḛ":"e","ꝫ":"et","ḟ":"f","ƒ":"f","ᵮ":"f","ᶂ":"f","ǵ":"g","ğ":"g","ǧ":"g","ģ":"g","ĝ":"g","ġ":"g","ɠ":"g","ḡ":"g","ᶃ":"g","ǥ":"g","ḫ":"h","ȟ":"h","ḩ":"h","ĥ":"h","ⱨ":"h","ḧ":"h","ḣ":"h","ḥ":"h","ɦ":"h","ẖ":"h","ħ":"h","ƕ":"hv","í":"i","ĭ":"i","ǐ":"i","î":"i","ï":"i","ḯ":"i","ị":"i","ȉ":"i","ì":"i","ỉ":"i","ȋ":"i","ī":"i","į":"i","ᶖ":"i","ɨ":"i","ĩ":"i","ḭ":"i","ꝺ":"d","ꝼ":"f","ᵹ":"g","ꞃ":"r","ꞅ":"s","ꞇ":"t","ꝭ":"is","ǰ":"j","ĵ":"j","ʝ":"j","ɉ":"j","ḱ":"k","ǩ":"k","ķ":"k","ⱪ":"k","ꝃ":"k","ḳ":"k","ƙ":"k","ḵ":"k","ᶄ":"k","ꝁ":"k","ꝅ":"k","ĺ":"l","ƚ":"l","ɬ":"l","ľ":"l","ļ":"l","ḽ":"l","ȴ":"l","ḷ":"l","ḹ":"l","ⱡ":"l","ꝉ":"l","ḻ":"l","ŀ":"l","ɫ":"l","ᶅ":"l","ɭ":"l","ł":"l","ǉ":"lj","ſ":"s","ẜ":"s","ẛ":"s","ẝ":"s","ḿ":"m","ṁ":"m","ṃ":"m","ɱ":"m","ᵯ":"m","ᶆ":"m","ń":"n","ň":"n","ņ":"n","ṋ":"n","ȵ":"n","ṅ":"n","ṇ":"n","ǹ":"n","ɲ":"n","ṉ":"n","ƞ":"n","ᵰ":"n","ᶇ":"n","ɳ":"n","ñ":"n","ǌ":"nj","ó":"o","ŏ":"o","ǒ":"o","ô":"o","ố":"o","ộ":"o","ồ":"o","ổ":"o","ỗ":"o","ö":"o","ȫ":"o","ȯ":"o","ȱ":"o","ọ":"o","ő":"o","ȍ":"o","ò":"o","ỏ":"o","ơ":"o","ớ":"o","ợ":"o","ờ":"o","ở":"o","ỡ":"o","ȏ":"o","ꝋ":"o","ꝍ":"o","ⱺ":"o","ō":"o","ṓ":"o","ṑ":"o","ǫ":"o","ǭ":"o","ø":"o","ǿ":"o","õ":"o","ṍ":"o","ṏ":"o","ȭ":"o","ƣ":"oi","ꝏ":"oo","ɛ":"e","ᶓ":"e","ɔ":"o","ᶗ":"o","ȣ":"ou","ṕ":"p","ṗ":"p","ꝓ":"p","ƥ":"p","ᵱ":"p","ᶈ":"p","ꝕ":"p","ᵽ":"p","ꝑ":"p","ꝙ":"q","ʠ":"q","ɋ":"q","ꝗ":"q","ŕ":"r","ř":"r","ŗ":"r","ṙ":"r","ṛ":"r","ṝ":"r","ȑ":"r","ɾ":"r","ᵳ":"r","ȓ":"r","ṟ":"r","ɼ":"r","ᵲ":"r","ᶉ":"r","ɍ":"r","ɽ":"r","ↄ":"c","ꜿ":"c","ɘ":"e","ɿ":"r","ś":"s","ṥ":"s","š":"s","ṧ":"s","ş":"s","ŝ":"s","ș":"s","ṡ":"s","ṣ":"s","ṩ":"s","ʂ":"s","ᵴ":"s","ᶊ":"s","ȿ":"s","ɡ":"g","ᴑ":"o","ᴓ":"o","ᴝ":"u","ť":"t","ţ":"t","ṱ":"t","ț":"t","ȶ":"t","ẗ":"t","ⱦ":"t","ṫ":"t","ṭ":"t","ƭ":"t","ṯ":"t","ᵵ":"t","ƫ":"t","ʈ":"t","ŧ":"t","ᵺ":"th","ɐ":"a","ᴂ":"ae","ǝ":"e","ᵷ":"g","ɥ":"h","ʮ":"h","ʯ":"h","ᴉ":"i","ʞ":"k","ꞁ":"l","ɯ":"m","ɰ":"m","ᴔ":"oe","ɹ":"r","ɻ":"r","ɺ":"r","ⱹ":"r","ʇ":"t","ʌ":"v","ʍ":"w","ʎ":"y","ꜩ":"tz","ú":"u","ŭ":"u","ǔ":"u","û":"u","ṷ":"u","ü":"u","ǘ":"u","ǚ":"u","ǜ":"u","ǖ":"u","ṳ":"u","ụ":"u","ű":"u","ȕ":"u","ù":"u","ủ":"u","ư":"u","ứ":"u","ự":"u","ừ":"u","ử":"u","ữ":"u","ȗ":"u","ū":"u","ṻ":"u","ų":"u","ᶙ":"u","ů":"u","ũ":"u","ṹ":"u","ṵ":"u","ᵫ":"ue","ꝸ":"um","ⱴ":"v","ꝟ":"v","ṿ":"v","ʋ":"v","ᶌ":"v","ⱱ":"v","ṽ":"v","ꝡ":"vy","ẃ":"w","ŵ":"w","ẅ":"w","ẇ":"w","ẉ":"w","ẁ":"w","ⱳ":"w","ẘ":"w","ẍ":"x","ẋ":"x","ᶍ":"x","ý":"y","ŷ":"y","ÿ":"y","ẏ":"y","ỵ":"y","ỳ":"y","ƴ":"y","ỷ":"y","ỿ":"y","ȳ":"y","ẙ":"y","ɏ":"y","ỹ":"y","ź":"z","ž":"z","ẑ":"z","ʑ":"z","ⱬ":"z","ż":"z","ẓ":"z","ȥ":"z","ẕ":"z","ᵶ":"z","ᶎ":"z","ʐ":"z","ƶ":"z","ɀ":"z","ﬀ":"ff","ﬃ":"ffi","ﬄ":"ffl","ﬁ":"fi","ﬂ":"fl","ĳ":"ij","œ":"oe","ﬆ":"st","ₐ":"a","ₑ":"e","ᵢ":"i","ⱼ":"j","ₒ":"o","ᵣ":"r","ᵤ":"u","ᵥ":"v","ₓ":"x"};
    String.prototype.latinise=function(){return this.replace(/[^A-Za-z0-9\[\] ]/g,function(a){return Latinise.latin_map[a]||a})};
    String.prototype.latinize=String.prototype.latinise;
    String.prototype.isLatin=function(){return this==this.latinise()}

      titleEdit = title.replace(/ /g,"-");
      titleEditChar = titleEdit.replace(/[`~!@#$%^&*()_|+=?;:'",.<>\{\}\[\]\\\/]/g,"");
      trimTitle = titleEditChar.substring(0, 70);
      titleVideo = trimTitle.latinize().toLowerCase();

      return titleVideo;

  },

  JsonVideoLog : function(title,duration){

    date = new Date();
    month = date.getMonth()+1;
    year = date.getFullYear();
    day = date.getDate();

    dateNow = year+"-"+("0"+month).slice(-2)+"-"+("0"+day).slice(-2);

    urlOrigin = "http://escaleta.televisa.com/";


    if(duration != 0){

      durationVideo = duration;
      titleVideo = title;

    }else{
      durationVideo = "00:00:00";
      titleVideo = title;
    }

    json_info = {
          videoDuration:durationVideo,
          progressTime:0,
          country:'mex',
          state:'dif',
          city:'mexico city',
          videoTitle:titleVideo,
          playerType:'ak',
          videoType:'vod',
          ip:'',
          url: urlOrigin+escaleta.program_code[escaleta.idProgram].code+"/"+dateNow+"/"+titleVideo
      };

    return json_info;   
  },

  VideoUrlShare:function(paramtherShare){

    this.flagRepeat = true;
    IDparameter = paramtherShare.split("_");

        escaleta.serverDateChange = IDparameter[2];

        if(IDparameter.length == 3){
            id = IDparameter[0];
            secuency = IDparameter[1];
            dateCreateJson = IDparameter[2];


            if( typeof $("#"+id+"_"+secuency).attr("data-video")!='undefined' ){

              var paramtherShareUrl = $("#"+id+"_"+secuency).attr("data-video"),
                IDparameterUrl = paramtherShareUrl.split(","),
                iniTime = IDparameterUrl[0],
                clipDuration = IDparameterUrl[1];

              urlNew = "&iniTime="+iniTime+"&clipDuration="+clipDuration;

              srcFrame = this.urlFramePlayer + this.subcanal + "&escaleta=" + escaleta.idChannel + urlNew + "&sn=" + escaleta.program_code[escaleta.idProgram].code;
              $(".escaleta-main").find('#frmVideo').removeAttr('src').attr( 'src', srcFrame);
              
              $(".thumbs").removeClass('active');
              $("#"+id+"_"+secuency).parent().addClass('active').click();;

              horario = $("#"+id+"_"+secuency).parent().parent().data('horario');

              $("#"+id+"_"+secuency).parent().parent().addClass('selected pulse')
              $(".select-hour").find('a span').text(horario);

              this.positionPlayer("a#"+id+"_"+secuency);

              return true;
            }
        }
  },

  addStatusContent:function(status,active){

    $(".escaleta-main").attr("data-status",status).attr("data-status-repeat",active);
  
  },

  changeButtonLive:function(){

    $(document).on('touchstart mousedown', '.senal-vivo.activo', function() {
      event.preventDefault();
      window.location.href = "#escaleta";
      escaleta.senal_status("live");
      escaleta.video_player_vivo();
      videolog.sendVideoLog('start', escaleta.JsonVideoLog("live",0));
    });
  },
  customDataJson:function(data){

    var statusPage  = data.statusDisplay,
        statusUrl   = data.statusUrl,
        urlPage   = data.url;

      if(window.location.href.search("#")!= -1){

        locationUrl = window.location.href;
        idShare = locationUrl.split("#");

        urlShare = idShare[0];
        paramtherShare = idShare[1];

      }else{

        urlShare = location.href;
        paramtherShare = '';
      }


      if(urlPage == urlShare){

        if(statusUrl!='urlInactive'){

          serverDate = data.serverDate;
          statusAdvertising = data.statusAdvertising;
          statusPlayer = data.statusPlayer;
          this.idChannel = data.idChannel;
          this.idProgram = data.idProgram;

          $(".ui-grid-fluid-triple").find(".redirect").parent().remove();

          if($('script[src="'+ this.AmazonEscaleta+this.UrlRepeat +'"]').length === 0){ 
            escaleta.loadJS(this.AmazonEscaleta + this.UrlRepeat);
          }


          if( ( this.flag && $(".escaleta-main").attr('data-readjson') === "true" ) && !this.changeJson ) { 
            this.readJson(data.idProgram,serverDate); 
          }
          
          if( $(".escaleta-main").attr("data-status") != statusPlayer ){

            (parseInt(statusAdvertising) == 0)? this.subcanal='&subcanal=0000' : this.subcanal='';
            (statusPlayer=='Live show') ? idChannelNew = parseInt(this.idChannel)+1 : idChannelNew = this.idChannel;

            month = parseInt(serverDate.substring(4,6),10)-1;
            day = parseInt(serverDate.substring(6,8),10);

            /* LIVE SHOW */
            if( statusPlayer == 'Live show'){


              this.readJson(data.idProgram,serverDate);

              if( this.create_skeleton() ){ 

                if(statusUrl == 'urlDisplay'){ this.create_calendar(); }
                  
                
                if(!this.jsonNull){

                  this.start_video_player();
                  escaleta.senal_status();
                  escaleta.video_player_vivo();
                  //this.addStatusContent(statusPlayer,false);
                  escaleta.senal_status("live");
                  $(".mm-social").hide();
                }
                
                

                if(this.flag && this.noticierosVideo){ 

                  if(paramtherShare){

                      if(this.VideoUrlShare(paramtherShare)){
                        this.addStatusContent(statusPlayer,false);
                        this.senal_status("repeat");
                      }

                  }else{

                    //escaleta.senal_status();
                    //escaleta.video_player_vivo();
                    this.addStatusContent(statusPlayer,false);
                    //this.senal_status("live");
                    //$(".mm-social").hide();
                  }
                  this.changeButtonLive();
                  this.changeDayJson();
                  this.timeOut = 60000;
                  
                }else{
                  this.readJson(data.idProgram,serverDate);
                }  
                $("#month").val(day+" "+this.monthNames[month]);
                
              }
            }
            /* END LIVE SHOW */



            /* Finish, Not transmited, please wait*/
            if( ( (statusPlayer == 'Finished program') || (statusPlayer == 'Program not transmitted') || (statusPlayer == 'please wait') ) ) {
              
              if(paramtherShare){
                var dateReadJson = paramtherShare.split("_");

                    serverDate = dateReadJson[2];
                    month = parseInt(dateReadJson[2].substring(4,6),10)-1;
                    day = parseInt(dateReadJson[2].substring(6,8),10);
              }

              this.readJson(data.idProgram,serverDate);

              if( this.create_skeleton() ){

                this.create_calendar();
                this.start_video_player();

                    if( escaleta.flag && this.noticierosVideo){

                        if( $(".escaleta-main").attr("data-status-repeat")!= "true" ){

                          (paramtherShare) ? this.VideoUrlShare(paramtherShare) : this.video_player_repeticion();    

                          this.timeOut = 60000;
                          this.addStatusContent(statusPlayer,true);

                        }else{

                          $(".escaleta-main").attr('data-readJson',false);
                          this.addStatusContent(statusPlayer,true);
                        }
                        this.changeDayJson();
                        this.senal_status();
                        $(".content-carrusel li").first().click();

                    }else{
                         this.timeOut = 0;
                    }

                  $("#month").val(day+" "+this.monthNames[month]);
              }
            }
            /****************************************/

          }

          setTimeout("escaleta.loadJS(escaleta.AmazonEscaleta + escaleta.UrlStatus)", this.timeOut)

      }else{

        this.flagRepeat=true;
        if( typeof $(".escaleta-main").attr("data-status") != 'undefined' ){
          escaleta.create_redirect();
        }

        setTimeout("escaleta.loadJS(escaleta.AmazonEscaleta + escaleta.UrlStatus)", this.timeOut)
      }
    }       
  },

  readJson : function(idProgram,dateJson){

    UrlDateJson = this.AmazonEscaleta +  this.UrlJson + idProgram + "_" +dateJson + ".js";

    $.get(UrlDateJson)
        .done(function() {
          escaleta.loadJS(UrlDateJson);
          escaleta.jsonNull = true;
        }).fail(function() {
          escaleta.jsonNull = true;
          this.timeOut = 60000;
        });
  },

  changeDayJson:function(){

    $("#month").on('change',function(event){
      event.preventDefault();

      window.location.href="#"
      $(".escaleta-thumbs-content,#hour,.lista-content,.lista-valor span").empty();

      var value_actual = $(this).val();
      var newDate = new Date(value_actual);
      var value_change = {
          dia: newDate.getDate(),
          mes: newDate.getMonth(),
          year: newDate.getFullYear()
      };

      idJson = escaleta.idProgram+"_"+value_change.year+("0"+(value_change.mes+1)).slice(-2)+("0"+value_change.dia).slice(-2);

      escaleta.loadJS(escaleta.AmazonEscaleta+escaleta.UrlJson+idJson+".js");

      $(".content-carrusel").first().addClass('selected pulse');
      $(".select-hour a span").text($("#hour option:first").val());

      escaleta.changeJson = true;
      escaleta.flag = false;

    });

  },
  customDataSuccess:function(data){

    if( $(".escaleta-main").attr("data-status") =='Live show' ||  ($(".escaleta-main").attr("data-status") =='please wait' && !this.changeJson ) || !this.noticierosVideo ){
      this.flag =false;
    }

    try{

      idContentJson= [];
      idContentUl = [];

      if(!this.flag){

        $(".escaleta-thumbs-content a").each(function(){
          if(typeof $(this).attr("id") != "undefined" ){
            idContentUl.push($(this).attr("id"));
          }
        });

        IdVideosNotJson = this.eliminateDuplicates(idContentUl);

        rangeHours = [];
        for (var i = 0; i < data.json.length; i++) {
          rangeHours.push(data.json[i].range_time);
        } 
        rangeH = this.eliminateDuplicates(rangeHours);



        for (var i = 0; i < rangeH.length; i++) {

          if( rangeH[i] !='undefined'){

            if(!$("#hour option[value='"+rangeH[i]+"']").length>0){

              $("#hour").append($("<option>",{value:rangeH[i],text:rangeH[i]}));
              $(".lista-content").append($("<li>").addClass('lista-horario').attr('data-value',rangeH[i])
                              .append($('<a>',{href:'#',text:rangeH[i]})));
            }

          }  
        };

        for (var i = 0; i < data.json.length; i++) {

          var img = data.json[i].img,
                    title = data.json[i].title,
                    titleMod = data.json[i].titleMod,
                    stream = data.json[i].stream,
                    inicio = data.json[i].inicio,
                    duracion = data.json[i].duracion,
                    startTime = data.json[i].startTime,
                    range_time = data.json[i].range_time,
                    content_time = data.json[i].content_time,
                    id_video = data.json[i].id;

            var date = new Date(inicio*1000);

            dateJson = date.getFullYear()+( ("0"+(date.getMonth()+1)).slice(-2) )+("0"+date.getDate()).slice(-2);

            if(typeof(content_time) !='undefined'){
              
              ul = $(".escaleta-thumbs-content").find("ul#"+content_time).length;
              li = $("#"+content_time).find("a#"+id_video).length;

              if(!li){
                if(!ul){
                  $(".escaleta-thumbs-content").append($("<ul>",{id:content_time}).addClass('content-carrusel').attr("data-horario",range_time));
                }
                  $("#"+content_time).append($("<li>",{id:"video_"+i,onClick:"escaleta.title('"+title+"','"+titleMod+"');"}).addClass('thumbs')
                                      .append($("<a>",{id:id_video,href:'#'+id_video+"_"+dateJson,onClick :"PlayVideo("+stream+","+inicio+","+duracion+");escaleta.InfoVideo(this.id)"}).attr("data-video",inicio+","+duracion)
                                        .append($("<figure>")
                                          .append($("<div>").addClass("content-image")
                                            .append($("<img>",{src:img,alt:"video",title:"video"}))
                                            .append($("<time>",{text:this.durationPlayer(duracion)}).attr("datetime",this.durationPlayer(duracion))))
                                          .append($("<figcaption>")
                                            .append($("<p>",{text:titleMod}))
                                            .append($("<span>",{text:"Publicacion: "+startTime}).addClass("publicacion"))
                                            )
                                          )
                                        )
                                      );
              }
            }

            IdVideosNotJson.splice( $.inArray(id_video, IdVideosNotJson), 1 );
        }

        try{
          if(!this.noticierosVideo){
            noticieros('.video-nt', '.escaleta-main');
            this.noticierosVideo = true;
          }
        }catch(e){}  

        if( $(".escaleta-main").attr('data-readjson') === "true" ){
          try{
            loadCarrusel('.escaleta-main');
          }catch(e){} 
        }

        if(this.changeJson){
                this.video_player_repeticion(); 
                idFirstPlayer = $(".content-carrusel li a").first().attr('id');
                this.positionPlayer("a#"+idFirstPlayer);
                $(".content-carrusel li").first().click();
        }

        if(IdVideosNotJson.length > 0){
          for (var i = 0; i < IdVideosNotJson.length; i++) {
            $("#"+IdVideosNotJson[i]).parent().remove();
          };
        }

        if($(".select-hour").find("a span").text() == ''){
          $(".select-hour").find("a span").text($("#hour option:first").val());
        }

        if($(".escaleta-main").data('status') == 'please wait' || $(".escaleta-main").data('status') == 'Live show'){
                $(".escaleta-main").attr('data-readJson',true);
        }else{
                $(".escaleta-main").attr('data-readJson',false);
        }

        escaleta.flag=true;                  
      }
    }catch(e){
        try{
          if(!this.noticierosVideo){
            setTimeout("noticieros('.video-nt', '.escaleta-main')",300);
            this.noticierosVideo = true;
          }
        }catch(e){}  
    }
  },
  title : function(title,titleMod){
    
    titleHeader = '';

    ($('html').hasClass('mobile')) ? titleHeader = titleMod : titleHeader = title;
    $("h2.title").text(titleHeader);
  },
  positionPlayer : function(id){
      
    x = $(".escaleta-main");
    videos = x.find('.escaleta-thumbnail')
    defaults = {
                item_wrapper: 0
              };

    mobile = '';
    ($('html').hasClass('mobile')) ? mobile = true : mobile = false;

    var select = x.find('.escaleta-input');
    var thumbSelect = videos.find('.thumbs');
    var position = 0;
    var data = $(id).parents('.content-carrusel').data('horario');

    for (var item = 0; item<thumbSelect.length; item++) {
        if (!$(thumbSelect[item]).is('.active')) {
              if (mobile && $(window).width() <= 480) {
                  position -= $(id).outerHeight(true);
              } else {
                  position -= $(id).outerWidth(true);
              }
          }else if ($(thumbSelect[item]).is('.active')){
              if(mobile && $(window).width() <= 480){
                direction = {top: position};
              }else{
                direction = {left: position};
              }
              break;
          }
    }

    if ($('html').is('.mobile')) {

      select.find('#hour').val(data)
      videos.find('.escaleta-thumbs-content').animate(direction,300,function() {});

    } else {

        if (position == 0 ){
          videos.find('.next').removeClass('disable');
          videos.find('.back').addClass('disable'); 

        } else if (position < defaults.item_wrapper) {
              videos.find('.next').removeClass('disable');
              videos.find('.back').removeClass('disable');
              direction = {left : position};
        } else if (position > defaults.item_wrapper && position != 0) {
              videos.find('.next').removeClass('disable');
              videos.find('.back').removeClass('disable');
        }
        
        videos.find('.escaleta-thumbs-content').animate( direction , 300, function() {});

    }
  },

  eliminateDuplicates : function(arr){
    var i,
         len=arr.length,
         out=[],
         obj={};

     for (i=0;i<len;i++) {
        obj[arr[i]]=0;
     }
     for (i in obj) {
        out.push(i);
     }
     return out;
  },

  videoNext:function(){
    
    firstVideo = $("li.active").attr('id');
    nextVideo = firstVideo.split("_");
    idVideo =   parseInt(nextVideo[1]) + 1;

    IDVideo = $("#video_"+idVideo);

    $(".thumbs").removeClass('active');
    IDVideo.parent().addClass('selected pulse');
    IDVideo.addClass('active').children().click();
    IdVideoShare = $("#video_"+idVideo+" a").attr("id");
    hrefVideoShare = $("#video_"+idVideo+" a").attr("href");

    (typeof hrefVideoShare == 'undefined') ? window.location.href = "#" : window.location.href = hrefVideoShare;

    this.positionPlayer("a#"+IdVideoShare);

     text = $("#"+IdVideoShare).find('p').text(); 
     img  = $("#"+IdVideoShare).find('img').attr('src');

    /* REDES SOCIALES*/
         var contentShare = $('.content-main').find('.mm-social-icons');

        var dataFirst = {
                        img: img,
                        url: window.location.href,
                        title: text
                        };

        contentShare.attr({
                          'data-comm-img': dataFirst.img,
                          'data-comm-url': dataFirst.url,
                          'data-comm-title': text,
                          'data-comm-whatsapp': 'Noticieros Televisa, toda la información de México y el mundo en un sólo lugar'
                        });
        //socialShare.indexNotesExpanded();
        social_engage.setShareOptions();
      /*****************/

  },

  InfoVideo : function(id){

    $(".mm-social").show();
    var idVideo = $("#"+id);

    $(".thumbs").removeClass('active');
    idVideo.parent().addClass('active').parent().addClass('selected pulse');

    title = idVideo.find('p').text();

    (title) ? titleVideoMod = this.characterReplace(title) : titleVideoMod = '';
    durationVideo =  idVideo.find('time').attr('datetime');

    videolog.sendVideoLog('start', this.JsonVideoLog(titleVideoMod,durationVideo));
  },

  init : function(){
    
    if(document.getElementById("escaleta_main")){
        
      //communities.makeCookie('escaleta',1);
      //if(communities.readCookie("escaleta")){
        this.load_videolog();
        this.loadcss("http://communities-dev.s3-website-us-west-1.amazonaws.com/escaleta/escaleta2/css/escaleta2.css");
        this.loadJS("http://i2.esmas.com/finalpage/entretenimiento/js/jquery.touchSwipe.min.js");
        this.loadJS("http://finalpage.esmas.com/proyectos/noticieros/escaleta2.0/escaleta/test/js/pikaday.js");
        this.loadJS(this.AmazonEscaleta + this.UrlStatus);


      //}
    }  

  }

}


dominio = window.location.host;
var PlayVideo = function (a,b,c){

  var FrameVideo= $("#frmVideo").attr("src");

    Num = FrameVideo.search("&escaleta="+escaleta.idChannel);

    if(Num == -1){
      escaleta.video_player_repeticion();
    }
  
  var iframeWin = document.getElementById("frmVideo").contentWindow;

    data = {"stream":a,"inicio":b,"fin":c};
    iframeWin.postMessage(data, "http://amp.televisa.com");

    escaleta.senal_status("repeat");
}

escaleta.init();



window.addEventListener('message', callback_escaleta, false);
function callback_escaleta(event){
    wlDomains = [
      "amp.televisa.com"
    ];
    eveOri = event.origin.replace(/^http(s)?:\/\//i, "");

    if (wlDomains.indexOf(eveOri) !== -1){
      respuesta=event.data;

       // OBTIENES EL DATO playing
      if(typeof respuesta.playing!='undefined'){
        if(!respuesta.playing){
          escaleta.videoNext();
        }
      }
    }
    return 0;
  };