if(!document.getElementById("escaleta_main")){
  $("<div class='escaleta-main' id='escaleta_main'></div>").insertAfter(".header");
}

var dispositivo = navigator.userAgent.toLowerCase();

if (dispositivo.search(/iphone|ipod|ipad|android/) > -1) {
  $('html').addClass('mobile');
}

var idDFPObject="";
var idDFP ="";

$(document).find("#widgetSocialShare5").removeAttr('id');

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
                        1713  :   { code:"ntjld", title:'El Noticiero, con Joaquin Lopez-Doriga', url:'programas-noticiero-con-joaquin-lopez-doriga' },
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
                          
                          .append($("<div>").addClass("mm-social")
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

      MsgTitle = 'El programa en vivo <strong>"'+this.program_code[escaleta.idProgram].title+' del '+day+' de '+this.monthNames[month]+'"</strong> ha finalizado para ver la repeticiÃƒÆ’Ã‚Â³n da click en el boton';

      var redirect = $($("<section>").addClass('ui-grid-fluid-triple')
                    .append($("<section>").addClass('redirect')
                      .append($("<article>").addClass('redirect-mensaje')
                        //.append($('<p>',{text:MsgTitle}).addClass('mensaje-txt'))
                        .append($("<p>"+MsgTitle+"</p>").addClass('mensaje-txt'))
                        .append($('<a>').addClass('mensaje-button').attr('href',this.program_code[escaleta.idProgram].url)
                          .append($('<i>').addClass('button-icon noti-redirect'))
                          .append($('<p>',{text:'ver la repeticíón'}).addClass('button-txt'))))

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
                          'data-comm-whatsapp': 'Noticieros Televisa, toda la informaciÃ³n de MÃ©xico y el mundo en un sÃ³lo lugar'
                        });
        socialShare.indexNotesExpanded();
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

              console.log("*************************")
              this.readJson(data.idProgram,serverDate);
              console.log("jsonNull "+this.jsonNull)

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
                item_wrapper: 0,
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
                          'data-comm-whatsapp': 'Noticieros Televisa, toda la informaciÃƒÆ’Ã‚Â³n de MÃƒÆ’Ã‚Â©xico y el mundo en un sÃƒÆ’Ã‚Â³lo lugar'
                        });
        socialShare.indexNotesExpanded();
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