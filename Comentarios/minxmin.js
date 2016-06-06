

var mxm_ = {
    config: {
        div_container: "minutos",
        tempo_template: "minutos",
        play_sounds: 1,
        js_server: "http://i2.esmas.com/comunidades/",
        primary_server: "http://static.esmas.com/mxm/mxm2/deportes/",
        mxm_type:"deportes",
        max_items: 6,
        first_load: 0,
        tempo: "",
        tempo_timer: "",
        tempo_tries: 1,
        auto_load: 1,
        second_load: 30,
        update_event: "update",
        elems: [],
        mxm_time: "",
        mxm_date: "",
        feed_refresh_time: 60,//20
        wide_container:false
    },
    pSound: !0,
    sPying: !1,
    calls: {
        ejson_calls: [],
        timer: "",
        timeout: 10,
        maxcalls: 10,
        makingcall: 0
    },
    init: function () {
        
        try{
            if (document.location.href.search("televisadeportes.esmas.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
                this.config.mxm_type='deportes';
            }
            if (document.location.href.search("author-televisadeportes-stage.adobecqms.net/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
                this.config.mxm_type='deportes';
            }
            if (document.location.href.search("televisadeportes-stage.adobecqms.net/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
                this.config.mxm_type='deportes';
            }
            if (document.location.href.search("content-staging-news.televisa.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/noticieros/';
                this.config.mxm_type='noticieros';
            }
            if (document.location.href.search("noticieros.televisa.com/")!=-1 ){
                if (document.location.href.search("ebola")!=-1 ){
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/noticieros/';
                    this.config.mxm_type='noticieros';
                }else if(document.getElementById("titulares_nt")){
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                }else{
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                    this.config.mxm_type='noticieros';
                }
            }
            if (document.location.href.search("www.televisa.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                this.config.mxm_type='noticieros';
            }
            if (document.location.href.search("deportes.televisa.com/")!=-1 || document.location.href.search("troya.esmas.com.mx:4503/")!=-1 || document.location.href.search("content-staging-sports.televisa.com/")!=-1 || document.location.href.search("content-staging-sports-pre.televisa.com/")!=-1 || document.location.href.search("author-televisatv-stage.adobecqms.net")!=-1 || document.location.href.search("hermes.esmas.com.mx:4503/")!=-1 || document.location.href.search("televisadeportes-stage2.adobecqms.net/")!=-1 || document.location.href.search("content-staging2-sports.televisa.com/")!=-1 || document.location.href.search('finalpage.esmas.com/public/projects/91z3-unif/')!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportesCQ5/';
                this.config.mxm_type='deportesCQ5';
                this.config.max_items=24;
            }
            if (document.location.href.search("content-staging-sports-pre.televisa.com/")!=-1){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportesCQ5/';
                this.config.mxm_type='deportesCQ5';
                this.config.max_items=24;
            }
            if (document.getElementById("minDeportes")){
                this.config.div_container='minDeportes';
                this.config.tempo_template='minDeportes';
            }
            if ( document.location.href.search("/televisa-espectaculos/")!=-1 || document.location.href.search("espectaculos.televisa.com")!=-1 || document.location.href.search("entretenimiento.televisa.com/")!=-1 || document.location.href.search("finalpage.esmas.com/")!=-1 || document.location.href.search("entretenimiento_home")!=-1 || document.location.href.search("/televisa-entretenimiento")!=-1){
                if(!document.location.href.search('finalpage.esmas.com/public/projects/91z3-unif/')!=-1){
                    this.config.mxm_type='entretenimiento';
                }
            }
            if ( document.location.href.search("/estilodevida/")!=-1 || document.location.href.search("estilodevida.televisa.com/")!=-1 ){
                this.config.mxm_type='estilodevida';
            }
            if (document.location.href.search("/fotogalerias/")!=-1 || document.location.href.search("/fotos/")!=-1 || document.location.href.search("/galerias/")!=-1 ){
                this.config.mxm_type='fotos';
            }
            if ( document.location.href.search("/me-pongo-de-pie/")!=-1 || document.location.href.search("/ponte-de-pie/")!=-1 ){
                this.config.mxm_type='mepongo';
            }
            if ( document.location.href.search("/pasion-y-poder/")!=-1 ){

                if(document.location.href.search("/fotos/")!=-1){
                    if( location.href == 'http://www.televisa.com/pasion-y-poder/fotos/'){
                        
                        this.config.mxm_type='pasion_y_poder';
                    }else{
                        this.config.mxm_type = 'fotos_pasion_y_poder';
                    }
                }else{
                    this.config.mxm_type='pasion_y_poder';
                }
                
            }
            if ( document.location.href.search("unicable.tv")!=-1 || document.location.href.search("televisaunicable-prod.adobecqms.net/")!=-1 || document.location.href.search("content-staging2-unicable.televisa.com")!=-1 ){
                this.config.mxm_type='unicable';
            }
            if ( document.location.href.search("bandamax.tv")!=-1 || document.location.href.search("televisabandamax-prod.adobecqms.net/")!=-1 ){
                this.config.mxm_type='bandamax';
            }
            if ( document.location.href.search("canalgolden.tv")!=-1 || document.location.href.search("televisagolden-prod.adobecqms.net/")!=-1 ){
                this.config.mxm_type='canalgolden';
            }
            if (document.getElementById("titulares_nt")){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                this.config.mxm_type='nttitulares';
                this.config.div_container='titulares_nt';
                this.config.tempo_template='titulares_nt';
            }
        }catch(e){}


        if(document.getElementById("minutos")){

            if($("#minutos").width()>600){
                this.config.wide_container=true;
                 this.config.max_items=20;
                //document.getElementById("minutos").innerHTML='<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><span>[[js_date|date \'HH:mm\']]</span><div class="comText"><h3>[[title]]</h3><p>[[text]]</p></div></li>';
                document.getElementById("minutos").innerHTML=
                '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template data-if-hasurl="true" id="[[txt_hash]]"><span>[[js_date|date \'HH:mm\']]</span><div class="comText"><h3>[[title]]</h3><p>[[text]]</p> <a href="[[url]]"><p class="art_latestnews_01_link" style="padding:5px 20px 10px 15px;width:270px;font-size:14px;font-weight:bold;font-style:italic;color:#067cc3;">Ver m&aacute;s</p></a> </div></li>'+
                '<!-- Default template -->'+
                '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><span>[[js_date|date \'HH:mm\']]</span><div class="comText"><h3>[[title]]</h3><p>[[text]]</p></div></li>';
            
            }else{
                //document.getElementById("minutos").innerHTML='<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><div class="art_latestnews_01_elements"><a href="http://noticieros.televisa.com/ultima-hora/" title="Link Description"><span>[[js_date|date \'HH:mm\']]</span><p>[[title | truncate 90]]</p></a></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><a href="#" onclick="return false;"><p class="art_latestnews_01_text">[[text]]</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>';
                
                if(this.config.mxm_type=="noticieros"){
                    document.getElementById("minutos").innerHTML='<li data-template data-if-hasurl="true" class="minuto [[class_hidden]] mxm_item" id="[[txt_hash]]" style="display: none;" ><div class="art_latestnews_01_elements"><a href="[[url]]" ><span>[[js_date|date \'HH:mm\']]</span><p>[[title | truncate 90]]</p></a></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><p class="art_latestnews_01_text">[[text]]</p> <a href="[[url]]" >  <p class="art_latestnews_01_link">Ver m&aacute;s</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>'+
                '<!-- Default template -->'+
                '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><div class="art_latestnews_01_elements"><a href="http://noticieros.televisa.com/ultima-hora/" ><span>[[js_date|date \'HH:mm\']]</span><p>[[title | truncate 90]]</p></a></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><a href="#" onclick="return false;"><p class="art_latestnews_01_text">[[text]]</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>';


                }else{
                    document.getElementById("minutos").innerHTML='<li data-template data-if-hasurl="true" class="minuto [[class_hidden]] mxm_item" id="[[txt_hash]]" style="display: none;" ><div class="art_latestnews_01_elements"><a href="[[url]]" ><span>[[js_date|date \'HH:mm\']]</span><p>[[title | truncate 90]]</p></a></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><p class="art_latestnews_01_text">[[text]]</p> <a href="[[url]]" >  <p class="art_latestnews_01_link">Ver m&aacute;s</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>'+
                '<!-- Default template -->'+
                '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><div class="art_latestnews_01_elements"><a href="/ultima-hora/"><span>[[js_date|date \'HH:mm\']]</span><p>[[title | truncate 90]]</p></a></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><a href="#" onclick="return false;"><p class="art_latestnews_01_text">[[text]]</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>';

                }

                            }
        }

        if(document.getElementById("minDeportes")){
            this.config.wide_container=true;
            this.config.max_items=24;
            document.getElementById("minDeportes").innerHTML=
            '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template data-if-tipo="video"    id="[[txt_hash]]"><div class="time_icon"><div class="textcolor-title2 time"><span>[[js_date|date \'HH:mm\']]</span></div><div class="icon-time"></div></div><div class="chronic comText"><h3>[[title]]</h3><div class="chronic_description"><p>[[text]]</p></div><div class="wdg_mxm_live_02_verMas"><a class="textcolor-title1" href="[[url]]" target="_blank">Ver m&aacute;s</a></div></div><div class="icon-interactive textcolor-title4"><i class="tvsa-videocamera"></i></div><div class="icon-interactive2 textcolor-title4"><i class="tvsa-camera"></i></div><div class="img_stage_01 here" style="display: none;"><div class="img_stage_01_image"><img src="http://lorempixel.com/people/624/350" data-src="[[img[0].url]]" alt="[[img[0].name]]"></div><a class="img_stage_01_whtbkg" href="[[url]]" target="_blank" style="top:inherit;" ><p class="img_stage_01_black">[[text]]</p></a></div><div class="vid_player_01 not_here mantener" style="display: none;"><div class="vid_player_01_image"><img src="http://lorempixel.com/people/625/380" data-src="[[img[0].url]]" alt="[[img[0].name]]"><!-- PLAYER --><div class="vid_player_01_image_player"><div class="theaterSideSpacer"></div><div class="vid_player_01_ip"><div class="ip_1"></div><!-- Start of Brightcove Player --><div class="ip_2"></div></div><div class="theaterSideSpacer"></div></div><div class="vid_player_01_image_none"></div><!-- // PLAYER --></div><a href="[[url]]" target="_blank"><i class="tvsa-play" id="videobtn"></i></a><div class="vid_player_01_whtbkg"><p class="vid_player_01_black">[[title]]</p></div></div> </li>'+
            '<!--li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template data-if-tipo="articulo" id="[[txt_hash]]"><div class="time_icon"><div class="textcolor-title2 time"><span>[[js_date|date \'HH:mm\']]</span></div><div class="icon-time"></div></div><div class="chronic comText"><h3>[[title]]</h3><div class="chronic_description"><p>[[text]]</p></div><div class="wdg_mxm_live_02_verMas"><a class="textcolor-title1" href="[[url]]" target="_blank">Ver m&aacute;s</a></div></div><div class="icon-interactive textcolor-title4"><i class="tvsa-camera"></i></div><div class="img_stage_01 here" style="display: none;"><div class="img_stage_01_image"><img src="http://lorempixel.com/people/624/350" data-src="[[img[0].url]]" alt="[[img[0].name]]"></div><a class="img_stage_01_whtbkg" href="[[url]]" target="_blank" style="top:inherit;"><p class="img_stage_01_black">[[text]]</p></a></div> </li-->'+
            '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template data-if-tipo="tweets"   id="[[txt_hash]]"><div class="time_icon"><div class="icon-time twitter"><i class="tvsa-twitter"></i></div></div><div class="chronic comText"><p class="textcolor-title2">[[tweet_user]]<b class="textcolor-title4">@[[tweet_screen]]</b></p><div class="chronic_description">[[text]]</div></div></li>'+
            '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template data-if-hasurl="true"   id="[[txt_hash]]"><div class="time_icon"><div class="textcolor-title2 time"><span>[[js_date|date \'HH:mm\']]</span></div><div class="icon-time"></div></div><div class="chronic comText"><h3>[[title]]</h3><div class="chronic_description"><p>[[text]]</p></div><div class="wdg_mxm_live_02_verMas"><a class="textcolor-title1" href="[[url]]" target="_blank">Ver m&aacute;s</a></div></div></li>'+
            '<!-- Default template -->'+
            '<li class="minuto [[class_hidden]] mxm_item" style="display: none;" data-template id="[[txt_hash]]"><div class="time_icon"><div class="textcolor-title2 time"><span>[[js_date|date \'HH:mm\']]</span></div><div class="icon-time"></div></div><div class="chronic comText"><h3>[[title]]</h3><div class="chronic_description"><p>[[text]]</p></div></div></li>';
        
        }
        
        if(document.getElementById("titulares_nt")){
            this.config.wide_container=true;
            this.config.max_items=7;
            document.getElementById("titulares_nt").innerHTML=
            '<li data-template data-if-hasurl="true" class="minuto [[class_hidden]] mxm_item" id="[[txt_hash]]" style="display: none;" ><div class="art_latestnews_01_elements"><article><a href="[[url]]" ><span>[[js_date|date \'HH:mm\']]</span><h5  style="text-transform:none;">[[title | truncate 90]]</h5></a></article></div></li>'+
            '<!-- Default template -->'+
            '<li data-template class="minuto [[class_hidden]] mxm_item" id="[[txt_hash]]" style="display: none;"><div class="art_latestnews_01_elements"><article><a href="/ultima-hora/"><span>[[js_date|date \'HH:mm\']]</span><h5  style="text-transform:none;">[[title | truncate 90]]</h5></a></article></div><div class="art_latestnews_01_over"><div class="art_latestnews_01_boxbg1"> </div><div class="art_latestnews_01_boxbg2"><a href="#" onclick="return false;"><p class="art_latestnews_01_text">[[text]]</p></a></div><div class="art_latestnews_01_boxbg3"> </div><div class="art_latestnews_01_boxbg4"> </div></div></li>';
        }
        
        try{
            if (document.location.href.search("televisadeportes.esmas.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
            }
            if (document.location.href.search("author-televisadeportes-stage.adobecqms.net/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
            }
            if (document.location.href.search("televisadeportes-stage.adobecqms.net/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportes/';
            }
            if (document.location.href.search("content-staging-news.televisa.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/noticieros/';
            }
            if (document.location.href.search("noticieros.televisa.com/")!=-1 ){
                if (document.location.href.search("ebola")!=-1 ){
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/noticieros/';
                }else if(document.getElementById("titulares_nt")){
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                }else{
                    this.config.primary_server='http://static.esmas.com/mxm/mxm2/nttitulares/';
                }
            }
            if (document.location.href.search("54.183.1.8:4503/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/pruebas/deportes/';
            }
            if (document.location.href.search("deportes.televisa.com/")!=-1 ){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportesCQ5/';
                this.config.max_items=24;
            }
            if (document.location.href.search("content-staging-sports-pre.televisa.com/")!=-1){
                this.config.primary_server='http://static.esmas.com/mxm/mxm2/deportesCQ5/';
                this.config.mxm_type='deportesCQ5';
                this.config.max_items=24;
            }
            
        }catch(e){}

        if(typeof Tempo == "undefined"){ 
             if( (mxm_.config.mxm_type=='deportesCQ5' && document.location.href.search("/video/")!=-1 ) || ( mxm_.config.mxm_type=='entretenimiento' && document.location.href.search("/unificacion-video/")!=-1 ) || document.location.href.search('finalpage.esmas.com/public/projects/91z3-unif/')!=-1 || (mxm_.config.mxm_type=='bandamax' && document.location.href.search("/video/")!=-1 ) || (mxm_.config.mxm_type=='unicable' && document.location.href.search("/video/")!=-1 ) || (mxm_.config.mxm_type=='canalgolden' && (document.location.href.search("/video/")!=-1)) ){
                 this.loadjs(this.config.js_server+'js/tempo2.js');
             }else{
                 this.loadjs(this.config.js_server+'js/tempo.js');
             }
        }       
    typeof jQuery.ui == "undefined" && this
            .loadjs("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js");
        if ((navigator.userAgent
            .match(/iPhone/i) || navigator
            .userAgent
            .match(/Apple/i) || navigator
            .userAgent
            .match(/iPod/i) || navigator
            .userAgent
            .match(/iPad/i)) && !navigator.userAgent
            .match(/Chrome/i)) this.config
            .feed_refresh_time = 60;//10
        if(document.getElementById("minutos") || document.getElementById("minDeportes") || document.getElementById("titulares_nt") ){this.start();}
    },
    start: function () {
        if (typeof Tempo == "object") clearTimeout(this.config
            .tempo_timer), this.call_make(this.config
            .primary_server + "mxmp.json");
        else if (this.config
            .tempo_tries < 40) this.config
            .tempo_timer = setTimeout("mxm_.start();", 500), this
            .config
            .tempo_tries++
    },
    playSound: function (a) {
        try{
            if (this.pSound && !this
                .sPying && (this.sPying = !0, !navigator
                .userAgent
                .match(/iPhone/i) && !navigator
                .userAgent
                .match(/iPod/i) && !navigator
                .userAgent
                .match(/iPad/i))) document.getElementById("comm_sound")
                .innerHTML = '<embed src="http://i2.esmas.com/comunidades/sounds/' + a + '.swf" width="1" height="1" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash">',
            setTimeout("mxm_.sPying=false;", 3E3)
        }catch(err){}
    },
    parse_info: function (a) {
        mxm_.call_ok();
        typeof a.mxm != "undefined" && this
            .fill_template(a);
        if ((navigator.userAgent
            .match(/iPhone/i) || navigator
            .userAgent
            .match(/Apple/i) || navigator
            .userAgent
            .match(/iPod/i) || navigator
            .userAgent
            .match(/iPad/i)) && !navigator.userAgent
            .match(/Chrome/i)) return this.config
            .mxm_time == a
            .mxm_time || this
            .config
            .mxm_time == "" ? (this.config
            .mxm_time = parseInt(a.mxm_time), this
            .config
            .mxm_date = a
            .mxm_date, setTimeout("mxm_.control_mxm();", this.config
            .feed_refresh_time * 1E3)) : (this.config
            .mxm_time = parseInt(a.mxm_time), this
            .config
            .mxm_date = a
            .mxm_date, setTimeout("mxm_.reload_mxm_ipad();", 500)), !1;
        if ("undefined" != typeof a.err) return this.config
            .mxm_time = parseInt(this.config
            .mxm_time) + 1, setTimeout("mxm_.reload_mxm();", this.config
            .feed_refresh_time * 1E3), !1;
        this.config
            .mxm_time = parseInt(a.mxm_time);
        this.config
            .mxm_date = a
            .mxm_date;
        setTimeout("mxm_.reload_mxm();", this.config
            .feed_refresh_time * 1E3)
    },
    fill_template: function (a) {
        if (this.config
            .first_load == 0) this.config
            .tempo = Tempo
            .prepare(this.config
            .tempo_template, {
            var_braces: "\\[\\[\\]\\]",
            tag_braces: "\\[\\?\\?\\]"
        })
            .notify(function (a) {
            if (a.type === TempoEvent
                .Types
                .RENDER_COMPLETE) {
                setTimeout("mxm_.active_elements();", 1E3);
                try {
                    if (mxm_.config
                        .first_load == 0) mxm_.config
                        .first_load = 1
                } catch (c) {}
            }
        }), jQuery(this.config
            .tempo_template)
            .show();
        else {
            nu = a.mxm
                .length;
            for (i = 0; i < a.mxm
                .length; i++) a.mxm[nu - i - 1] = this
                .element_exist(a.mxm[nu - i - 1])
        }
        this.config
            .tempo
            .prepend(a.mxm);
        this.delete_scripts();
        this.clean_elements()
    },
    delete_scripts: function () {
        jQuery("script").each(function () {
            try {
                jQuery(this).attr("src")
                    .indexOf(mxm_.config
                    .primary_server) >= 0 && jQuery(this)
                    .remove()
            } catch (a) {}
        })

    },
    show_elements: function () {
        this.config
            .elems
            .length > 0 ? (this.config
            .elems[0]
            .type == "update" ? this
            .config
            .update_event == "update" ? (jQuery("#" + this.config
            .elems[0]
            .id).html(jQuery("#" + this.config
            .elems[0]
            .id + "_new").html()), /*jQuery("#" + this.config
            .elems[0]
            .id )
            .effect("highlight", {}, 1E3),*/ jQuery("#" + this.config
            .elems[0]
            .id + "_new")
            .remove()) : (jQuery("#" + this.config
            .elems[0]
            .id).remove(), jQuery("#" + this.config
            .elems[0]
            .id + "_new")
            .attr("id", this.config
            .elems[0]
            .id)/*,
        jQuery("#" + this.config
            .elems[0]
            .id + " ").effect("highlight", {}, 1E3)
            .fadeIn("slow")
            .removeClass("mxm_hidden")*/) : /*jQuery("#" + this.config
            .elems[0]
            .id )
            .effect("highlight", {}, 1E3)
            .fadeIn("slow")
            .removeClass("mxm_hidden"),*/ this
            .config
            .elems
            .shift(), setTimeout("mxm_.show_elements();", 700)) : this
            .clean_elements();
            $('.tvsa-videocamera').unbind(); 
            $('.tvsa-camera').unbind();
            this.showPictures();
    },
    clean_elements: function () {
        var a = 1;
        jQuery("#" + this.config
            .tempo_template + " .mxm_item").each(function () {
            a > mxm_.config
                .max_items && jQuery(this)
                .html() != "" && jQuery(this)
                .remove();
            a++
        });
        try {
            adjustLine()
        } catch (b) {}


        
        if(!this.config.wide_container){
            jQuery("#minutos li").eq(-1).removeClass('art_latestnews_01_lib art_latestnews_01_lia').addClass("art_latestnews_01_lic");
            jQuery("#minutos li").eq(-2).removeClass('art_latestnews_01_lic art_latestnews_01_lia').addClass("art_latestnews_01_lib");
            jQuery("#minutos li").eq(-3).removeClass('art_latestnews_01_lib art_latestnews_01_lic').addClass("art_latestnews_01_lia");
            
            jQuery("#minDeportes li").eq(-1).removeClass('art_latestnews_01_lib art_latestnews_01_lia').addClass("art_latestnews_01_lic");
            jQuery("#minDeportes li").eq(-2).removeClass('art_latestnews_01_lic art_latestnews_01_lia').addClass("art_latestnews_01_lib");
            jQuery("#minDeportes li").eq(-3).removeClass('art_latestnews_01_lib art_latestnews_01_lic').addClass("art_latestnews_01_lia");
            
            jQuery("#titulares_nt li").eq(-1).removeClass('art_latestnews_01_lib art_latestnews_01_lia').addClass("art_latestnews_01_lic");
            jQuery("#titulares_nt li").eq(-2).removeClass('art_latestnews_01_lic art_latestnews_01_lia').addClass("art_latestnews_01_lib");
            jQuery("#titulares_nt li").eq(-3).removeClass('art_latestnews_01_lib art_latestnews_01_lic').addClass("art_latestnews_01_lia");
            this.load_tooltip(Televisa,jQuery);
        }
        
    },
    active_elements: function () {
        jQuery(".mxm_hidden").each(function () {
            max_itms = mxm_.config
                .elems
                .length;
            if (jQuery(this).html()) tmp_a = [], jQuery(this).attr("id")
                .indexOf("_new") > 0 ? (tmp_a.id = jQuery(this)
                .attr("id")
                .replace("_new", ""), tmp_a
                .type = "update") : (tmp_a.id = jQuery(this)
                .attr("id"), tmp_a
                .type = "new"), mxm_
                .config
                .elems
                .unshift(tmp_a)
        });
        mxm_.config
            .elems
            .length > 0 && this
            .playSound("pong");
        mxm_.show_elements()
    },
    element_exist: function (a) {
        document.getElementById(a.txt_hash) && (a.txt_hash += "_new");
        a.class_hidden = "mxm_hidden";
        return a
    },
    loadjs: function (a) {
        var b = document.createElement("script");
        b.setAttribute("type", "text/javascript");
        b.setAttribute("src", a);
        b.setAttribute("charset", "UTF-8");
        b.onload = b
            .onreadystatechange = function () {};
        document.getElementsByTagName("head")[0]
            .appendChild(b);
        return !0
    },
    call_make: function (a) {
        max_itms = this.calls
            .ejson_calls
            .length;
        for (i = finded = 0; i < max_itms; i++) this.calls
            .ejson_calls[i]
            .url == a && (finded = i + 1);
        if (finded == 0) this.calls
            .ejson_calls[max_itms] = [], this
            .calls
            .ejson_calls[max_itms]
            .url = a, this
            .calls
            .ejson_calls[max_itms]
            .tries = 0;
        this.call_start()
    },
    call_start: function () {
        
        if (this.calls
            .makingcall == 0 && (this.calls
            .makingcall = 1, this
            .calls
            .ejson_calls
            .length > 0)) {
            if (this.calls
                .ejson_calls[0]
                .tries >= this
                .calls
                .maxcalls) this.calls
                .ejson_calls[0]
                .url == "http://minxmin.esmas.com/storage/mxmp.json" && this
                .call_make(this.config
                .primary_server + "mxmp.json"), this
                .calls
                .ejson_calls
                .length == 1 && setTimeout("mxm_.call_make('" + this.config
                .primary_server + "controlp.json');", 1E3), this
                .calls
                .ejson_calls = this
                .reduce_array(this.calls
                .ejson_calls);
            this.calls
                .ejson_calls
                .length > 0 ? (this.calls
                .ejson_calls[0]
                .tries += 1, this
                .loadjs(this.calls
                .ejson_calls[0]
                .url), this
                .calls
                .timer = setTimeout("mxm_.calls.makingcall=0; mxm_.call_start();", this.calls
                .timeout * 1E3)) : this
                .calls
                .makingcall = 0
          
        }
        
    },
    reload_mxm: function () {
        this.config
            .mxm_date == "" || this
            .config
            .mxm_time == "" ? this
            .call_make(this.config
            .primary_server + "controlp.json") : this
            .call_make(this.config
            .primary_server + this
            .config
            .mxm_date + "/" + (parseInt(this.config
            .mxm_time) + 2) + "p.json")
    },
    reload_mxm_ipad: function () {
        this.config
            .mxm_date == "" || this
            .config
            .mxm_time == "" ? this
            .call_make(this.config
            .primary_server + "controlp.json") : this
            .call_make(this.config
            .primary_server + this
            .config
            .mxm_date + "/" + (parseInt(this.config
            .mxm_time) + 1) + "p.json")
    },
    control_mxm: function () {
        this.call_make(this.config
            .primary_server + "controlp.json?" +new Date + "=cachebust")
    },
    call_ok: function () {
        this.calls
            .ejson_calls = this
            .reduce_array(this.calls
            .ejson_calls);
        this.calls
            .makingcall = 0;
        clearTimeout(this.calls
            .timer);
        this.calls
            .ejson_calls
            .length > 0 && this
            .call_start()
    },
    reduce_array: function (a) {
        num = a.length;
        tmp_a = [];
        for (i = 1; i < num; i++) tmp_a = [], tmp_a = a[i];
        return tmp_a
    },
    
    showPictures:function(){
        try{
            if (document.getElementById("minDeportes")){
                //Click camera
                $('.tvsa-camera').on('click',function(event){
                    $('.tvsa-videocamera').removeClass("textcolor-title1"); 
                    $('.tvsa-camera').removeClass("textcolor-title1");
                    $('.vid_player_01').removeClass('here').addClass('not_here');
                    $('.img_stage_01').removeClass('here').addClass('not_here');
                    $('.tvsa-camera').removeClass("tvsa-mxm-close");
                    $(this).parent().next('.img_stage_01').removeClass('not_here').addClass('here');
                    //$(this).toggleClass('tvsa-mxm-close');
                    ocultar();
                    
                    //---BEGIN: Ocultar y mostrar imagenes y videos. 
                    
                    /*activo_vid = 0;
                    if(activo_img == 0){
                        //Esconder todo
                        $('.vid_player_01').hide();
                        $('.tvsa-videocamera').removeClass("tvsa-error"); 
                        $('.tvsa-videocamera').removeClass("textcolor-title1"); 
                        
                        
                        $('.img_stage_01').hide();
                        $('.tvsa-camera').removeClass("textcolor-title1");
                        /*............./
                        activo_img = 1;
                    }
                    else{
                        activo_img=0;
                    }*/
                    var edo_this = $(this).parent().next('.img_stage_01').css('display'); 
                    if(edo_this == 'block' ){
                        $(this).parent().next('.img_stage_01').removeClass('here').addClass('not_here');
                        $(this).parent().next('.img_stage_01').hide();
                        $(this).addClass("textcolor-title1");
                        
                    }
                    else{
                        $(this).parent().next('.img_stage_01').show();
                        $(this).toggleClass('tvsa-mxm-close');
                    }
                    
                    $(this).toggleClass("textcolor-title1");
                    $(this).parent().siblings('.not_here').hide();
                    $(this).parent().siblings('.vid_player_01').hide();
                    $(this).parent().siblings('.icon-interactive').find('i').removeClass("textcolor-title1");
                });
                
                //Click videocamera
                $('.tvsa-videocamera').on('click',function(event){ 
                    $('.tvsa-videocamera').removeClass("active");          
                    activo_vid = $(this).attr('class');
                    if(activo_vid == "tvsa-videocamera"){
                        //Esconder todo
                        $('.vid_player_01').hide();
                        $('.tvsa-videocamera').removeClass("tvsa-mxm-close"); 
                        $('.tvsa-videocamera').removeClass("textcolor-title1"); 
                        $('.img_stage_01').hide();
                        $('.tvsa-camera').removeClass("textcolor-title1");  
                        $('.tvsa-camera').show();           
                    }
                    
                    //vsa-videocamera textcolor-title1 active tvsa-error
                    $(this).addClass("active");
                    $(this).parent().siblings('.vid_player_01').toggle();
                    $(this).toggleClass("textcolor-title1");
                    $(this).parent().siblings('.img_stage_01').hide();
                    $(this).parent().siblings('.icon-interactive2').find('i').removeClass("tvsa-mxm-close").removeClass("textcolor-title1");
                    $(this).toggleClass('tvsa-mxm-close');
                    activo_vid2 = $(this).attr('class');
                    $('.tvsa-camera').removeClass("tvsa-mxm-close");
                    $('tvsa-camera').show(); 
                    if( activo_vid2 == "tvsa-videocamera active"){
                        $('.tvsa-videocamera').removeClass("active");
                    }
                    
                });
                
                //Parseo tweets
                $("#minDeportes .chronic_description").linkify({
                     tagName: 'a',
                     target: '_blank',
                     newLine: '\n',
                     linkClass: null,
                     linkAttributes: null
                });
                
            }
        }catch(e){ }
    
    },
    
    load_tooltip:function(T, $){
        var $parent = $('div.art_latestnews_01');        
        var $clickListA = $parent.find('.art_latestnews_01_lasth');
        var $clickListB = $parent.find('.art_latestnews_01_morev');
        var $overLink = $parent.find('.art_latestnews_01_list1 li');
        
        $clickListA.bind('click', function(evt) {
            evt.preventDefault();
            $('.art_latestnews_01_morev').removeClass("selected");
            $(this).addClass("selected");
            $('.art_latestnews_01_list1').show();
            $('.art_latestnews_01_list2').hide();
        });
        
        $clickListB.bind('click', function(evt) {
            evt.preventDefault();
            $(this).addClass("selected");
            $('.art_latestnews_01_lasth').removeClass("selected");
            $('.art_latestnews_01_list1').hide();
            $('.art_latestnews_01_list2').show();
        });
        
        if (T.getDeviceSize() == 'large') {
            $overLink.bind('mouseover', function(evt) {
                evt.preventDefault();
                $(this).find('.art_latestnews_01_over').css("display","block");
            });
            $overLink.bind('mouseout', function(evt) {
                evt.preventDefault();
                $(this).find('.art_latestnews_01_over').css("display","none");
            });   
        } 
    }

};

mxm_.init(); 

    var viewing = {
            config  :{
                main_var    : "viewing",
                vertical    : "entretenimeinto",
                js_server   : "http://i2.esmas.com/comunidades/",
                tempo       : [],
                searchs     : [],
                items       : [
            /*      {"template" : "tweet-hor", "screen_name" : "acidminds"  },
                    {"template" : "tweet-ver", "hashtags" : "ClasicasDeAMLO"    }*/
                ]
            },
            
            
                    
            loadjs      : function(url){
                    var sc        =        document.createElement('script');
                    sc.setAttribute('type','text/javascript');
                    sc.setAttribute('src',        url);
                    sc.setAttribute('charset',        'UTF-8');
                    var hd        =        document.getElementsByTagName('head')[0];
                    hd.appendChild(sc);
                    return true;
            },
            

            selectService:function(url){
                var services_array=new Array();
                                       
                services_array[0]=new Array();
                services_array[0]['name']='Noticieros Mexico';
                services_array[0]['search']='/mexico/';
                services_array[0]['service']='NT_DF.json';

                services_array[1]=new Array();
                services_array[1]['name']='Noticieros DF';
                services_array[1]['search']='/mexico-df/';
                services_array[1]['service']='NT_mexico.json';

                services_array[2]=new Array();
                services_array[2]['name']='Noticieros Estados';
                services_array[2]['search']='/mexico-estados/';
                services_array[2]['service']='NT_mundo.json';

                services_array[3]=new Array();
                services_array[3]['name']='Noticieros Mundo';
                services_array[3]['search']='/mundo/';
                services_array[3]['service']='NT_estados.json';

                services_array[4]=new Array();
                services_array[4]['name']='Noticieros Especiales';
                services_array[4]['search']='/especiales/';
                services_array[4]['service']='NT_economia.json';

                services_array[5]=new Array();
                services_array[5]['name']='Noticieros Economia';
                services_array[5]['search']='/economia/';
                services_array[5]['service']='NT_mexico.json';
          /*
                services_array[6]=new Array();
                services_array[6]['name']='Noticieros Glitter';
                services_array[6]['search']='/estilo-de-vida/';
                services_array[6]['service']='NT_opinion.json';

                services_array[7]=new Array();
                services_array[7]['name']='Noticieros Opinion';
                services_array[7]['search']='/opinion/';
                services_array[7]['service']='NT_glitter.json';

                services_array[8]=new Array();
                services_array[8]['name']='Noticieros Ciencia y Tecnologia';
                services_array[8]['search']='/ciencia-y-tecnologia/';
                services_array[8]['service']='NT_cultura.json';

                services_array[9]=new Array();
                services_array[9]['name']='Noticieros Cultura';
                services_array[9]['search']='/cultura/';
                services_array[9]['service']='NT_ciencia.json';
          */
                
                for(var i=0;i<services_array.length;i++){
                    //alert(services_array[i]['search'])
                    if(url.search(services_array[i]['search'])!=-1){
                        return  "http://static.esmas.com/comunidades/views/"+services_array[i]['service']
                        //alert("http://static.esmas.com/comunidades/views/"+services_array[i]['service'])
                        break;
                    }
                }
                //return  "http://static.esmas.com/comunidades/views/noticieros2.json";
                return  "http://static.esmas.com/comunidades/views/NT_mexico.json";

            },

            start_boxes : function(){
                if(typeof Tempo == "undefined"){
                    setTimeout(this.config["main_var"]+".start_boxes();",500);
                    return 0;
                }
                
                //this.loadjs("http://static.esmas.com/comunidades/views/noticieros2.json");
                try{
                    var url_page=communities.url;
                }catch(e){
                    var url_page=comunidades.url;
                }

                if(mxm_.config.mxm_type=="deportes"){
                    this.loadjs("http://static.esmas.com/comunidades/views/brazil2014.json");
                }else if(mxm_.config.mxm_type=="deportesCQ5"){

                    /*****************************************************************************************/
                    /*****************************************************************************************/
                    
                    if(document.location.href.search("/video/")!=-1){

                        if(document.location.href.search("/video/futbol-internacional/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/futbol_internacional_v.json");
                        }else if(document.location.href.search("/video/futbol-mexicano/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/futbol_mexicano_v.json");
                        }else if(document.location.href.search("/video/coleccion-privada/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/coleccion_privada_v.json");
                        }else if(document.location.href.search("/video/futbol-retro/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/futbol_retro_v.json");
                        }else if(document.location.href.search("/video/seleccion-mexicana/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/seleccion_mexicana_v.json");
                        }else if(document.location.href.search("/video/boxeo/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/boxeo_v.json");
                        }else if(document.location.href.search("/video/martes-knock-out/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/martes_knock_out_v.json");
                        }else if(document.location.href.search("/video/programas-tv/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/programas_tv_v.json");
                        }else if(document.location.href.search("/video/deporte/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/deporte_v.json");
                        }else if(document.location.href.search("/video/noticiero-td/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/noticiero_td_v.json");
                        }else if(document.location.href.search("/video/tribunal-td/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/tribunal_td_v.json");
                        }else if(document.location.href.search("/video/accion/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/accion_v.json");
                        }else if(document.location.href.search("/video/jugada/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/jugada_v.json");
                        }else if(document.location.href.search("/video/latitudes/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/latitudes_v.json");
                        }else if(document.location.href.search("/video/conecta-td/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/conecta_td_v.json");
                        }else if(document.location.href.search("/video/td-style/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/td_style_v.json");
                        }else if(document.location.href.search("/video/cuerpo-perfecto/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/cuerpo_perfecto_v.json");
                        }else if(document.location.href.search("/video/tdn/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/tdn_v.json");
                        }else if(document.location.href.search("/video/videoblogs/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/videoblogs_v.json");
                        }else if(document.location.href.search("/video/noticias/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/noticias_v.json");
                        }else if(document.location.href.search("/video/web-td/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/web_td_v.json");
                        }else if(document.location.href.search("/video/-piojometeme/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/_piojometeme_v.json");
                        }else if(document.location.href.search("/video/copa-america/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/copa_america_v.json");
                        }else if(document.location.href.search("/video/copa-oro/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/copa_oro_v.json");
                        }else if(document.location.href.search("/video/mas-deporte/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/mas_deporte_v.json");
                        }else if(document.location.href.search("/us/video/futbol/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_futbol_v.json");
                        }else if(document.location.href.search("/us/video/goles-de-la-semana/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_goles_semana_v.json");
                        }else if(document.location.href.search("/us/video/box/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_box_v.json");
                        }else if(document.location.href.search("/us/video/otros-deportes/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_otros_deportes_v.json");
                        }else if(document.location.href.search("/us/video/luchas/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_luchas_v.json");
                        }else if(document.location.href.search("/us/video/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/televisa_deportes_us_v.json");
                        }else{
                            this.loadjs("http://static.esmas.com/comunidades/views/deportes_v.json");   
                        }

                    }else if(document.location.href.search("finalpage.esmas.com/public/projects/91z3-unif/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/futbol_internacional_v.json");
                    }else{
                       this.loadjs("http://static.esmas.com/comunidades/views/TD.json");  
                    } 


                }else if(mxm_.config.mxm_type=="entretenimiento"){

                    if(document.location.href.search("/farandula/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_farandula.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");
                    }else if(document.location.href.search("/cine/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_cine.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");
                    }else if(document.location.href.search("/musica/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_musica.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");
                    }else if(document.location.href.search("/series/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_series.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");
                    }else if(document.location.href.search("/public/")!=-1 || document.location.href.search("/proyectos/")!=-1){                            /* SE METIO LA CONDICION DE PAGINA finalpage que pertenece a deportes*/
                        this.loadjs("http://static.esmas.com/comunidades/views/futbol_internacional_v.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");
                    }else{
                        //this.loadjs("http://static.esmas.com/comunidades/views/gall_entretenimiento.json");
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_entretenimiento_f.json");    
                    }
     
                }else if(mxm_.config.mxm_type=="estilodevida"){
                    if(document.location.href.search("/salud/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_estilo.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/estilo/")!=-1){
                        //this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_maternidad.json");
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/maternidad/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_tendencias.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/hombre/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_tendencias.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/tendencias/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_hogar.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/hogar/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_pareja.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else if(document.location.href.search("/pareja/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo_salud.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");
                    }else{
                        this.loadjs("http://static.esmas.com/comunidades/views/n_gall_estilo.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/estilo.json");    
                    }
                     
                }else if(mxm_.config.mxm_type=="mepongo"){
                    if(document.location.href.search("/videos/")!=-1){
                        //this.loadjs("http://static.esmas.com/comunidades/views/me_pongo_v.json");
                        this.loadjs("http://static.esmas.com/comunidades/views/me_pongo.json");
                    }else if(document.location.href.search("/galerias/")!=-1){
                        //this.loadjs("http://static.esmas.com/comunidades/views/gall_me_pongo.json");
                        this.loadjs("http://static.esmas.com/comunidades/views/me_pongo.json");
                    }else{
                        this.loadjs("http://static.esmas.com/comunidades/views/me_pongo.json");
                    }
                }else if(mxm_.config.mxm_type=="fotos"){
                    if(this.config.vertical=='noticieros'){
                        this.loadjs("http://static.esmas.com/comunidades/views/gall_noticieros.json"); 
                    }else if(this.config.vertical=='estilodevida'){
                        this.loadjs("http://static.esmas.com/comunidades/views/gall_estilo.json");
                    }else if(this.config.vertical=='deportes'){
                        this.loadjs("http://static.esmas.com/comunidades/views/gall_td.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/gall_entretenimiento2.json");
                        //this.loadjs("http://static.esmas.com/comunidades/views/gall_noticieros.json"); 
                    }else if(this.config.vertical=='television'){
                        if(document.location.href.search("/us/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_usa.json");
                        }else if(document.location.href.search("/muchacha-italiana-viene-a-casarse/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_muchacha.json");
                        }else if(document.location.href.search("/yo-no-creo-en-los-hombres/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_no_creo.json");
                        }else if(document.location.href.search("/la-sombra-del-pasado/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_la_sombra.json");
                        }else if(document.location.href.search("/mi-corazon-es-tuyo/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_mi_corazon.json");
                        }else if(document.location.href.search("/hasta-el-fin-del-mundo/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_hasta_el_fin.json");
                        }else if(document.location.href.search("/los-miserables/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_los_miserables.json");
                        }else if(document.location.href.search("/senora-acero/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_acero.json");
                        }else if(document.location.href.search("/en-otra-piel/")!=-1){
                            //this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_otra_piel.json");
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json"); 
                        }else if(document.location.href.search("/aurora/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_aurora.json");
                        }else if(document.location.href.search("/que-te-perdone-dios/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_perdone_dios.json");
                        }else if(document.location.href.search("/amores-con-trampa/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_con_trampa.json");
                        }else if(document.location.href.search("/hoy/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_hoy.json");
                        }else if(document.location.href.search("/la-rosa-de-guadalupe/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json"); 
                            //this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_la_rosa.json");
                        }else if(document.location.href.search("/como-dice-el-dicho/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_como_dice.json");
                        }else if(document.location.href.search("/laura/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_laura.json");
                        }else if(document.location.href.search("/estrella2/")!=-1){
                            //this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_estrella2.json");
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json"); 
                        }else if(document.location.href.search("/sabadazo/")!=-1){
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_sabadazo.json");
                        }else if(document.location.href.search("/hermosa-esperanza/")!=-1){
                            //this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_esperanza.json");
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json"); 
                        }else if(document.location.href.search("/programas-series-y-mas/")!=-1){
                            //this.loadjs("http://static.esmas.com/comunidades/views/gall_tv_series.json");
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json"); 
                        }else{
                            this.loadjs("http://static.esmas.com/comunidades/views/gall_television.json");  
                        }
                         
                    }else{
                        //this.loadjs("http://static.esmas.com/comunidades/views/gall_entretenimiento2.json");
                        this.loadjs("http://static.esmas.com/comunidades/views/gall_entretenimiento.json");
                    }   
                }else if( mxm_.config.mxm_type == 'pasion_y_poder' ){

                    this.loadjs("http://static.esmas.com/comunidades/views/pasion_y_poder_v.json");

                }else if( mxm_.config.mxm_type == 'fotos_pasion_y_poder'){
                    
                    this.loadjs("http://static.esmas.com/comunidades/views/gall_pasion_y_poder.json");
                
                }else if(mxm_.config.mxm_type=="bandamax"){
                    
                    if(document.location.href.search("/fotos/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/f_bandamax.json");
                    }else if(document.location.href.search("/video/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/v_bandamax.json");
                    }else{
                        this.loadjs("http://static.esmas.com/comunidades/views/bandamax.json");
                    }

                }else if(mxm_.config.mxm_type=="unicable"){
                    if(document.location.href.search("/fotos/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/f_unicable.json");
                    }else if(document.location.href.search("/video/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/v_unicable.json");
                    }else{
                        this.loadjs("http://static.esmas.com/comunidades/views/unicable.json");
                    }

                }else if(mxm_.config.mxm_type=="canalgolden"){

                    if(document.location.href.search("/video/")!=-1){
                        this.loadjs("http://static.esmas.com/comunidades/views/v_canalgolden.json");
                    }
                }
                else{
                    this.loadjs("http://static.esmas.com/comunidades/views/noticieros2.json");  
                }
                                
                if(document.getElementById("comm_masleido")){
                    
                    document.getElementById("comm_masleido").innerHTML=
                    '<div class="str_pleca_01 section">'+
                        '<div class="str_pleca_01_title">'+
                                '<h2>'+
                                    '<a target="_self" title="Te puede interesar">Te puede interesar<span class="str_pleca_01_arrowa selected"></span>'+
                                        '<span class="str_pleca_01_arrowb"></span>'+
                                    '</a>'+
                                '</h2>'+
                        '</div>'+
                        '<!-- END: str_pleca_01 -->'+
                    '</div>'+
                    '<div class="mix_3arts_02" id="comm_inner_views" >'+
                        '<div data-template>'+
                            '<div class="mix_1arts_09" >'+
                                '<div>'+
                                    '<ul class="mix_1arts_09_thumb">'+
                                        '<li>'+
                                            '<a target="_blank" title="[[title]]" href="[[url]]" title="[[title]]"> <img alt="Luna roja" src="http://i2.esmas.com/spacer.gif" data-src="[[thumbnail]]">'+
                                            '<span class="mix_1arts_09_sprite [[icon_class]]"></span>'+
                                            '<small>[[topico]]</small>'+
                                            '<h3>[[title]]</h3>'+
                                            '<span class="icon"></span> </a>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="clearBoth"></div>'+
                    '</div>';
                    this.loadjs(this.selectService(url_page));

                    setTimeout('viewing.vc();',500);
                }
                
                setTimeout('viewing.post_load_manipulation()',1000);
                
            },

            vc:function(){
                try{
                    jQuery("#comm_inner_views div").eq(0).addClass("mix_3arts_02_first");
                    jQuery("#comm_inner_views div").eq(6).addClass("mix_3arts_02_last");     
                }catch(e){}
            },

            post_load_manipulation:function(){
                
                jQuery("#masleido div").eq(0).addClass("art_latestnews_01_lic");
                jQuery("#masleido li").eq(-4).addClass("art_latestnews_01_lib");
                jQuery("#masleido li").eq(-6).addClass("art_latestnews_01_lia");

            },
            
            init    : function(){

                if(typeof Tempo == "undefined"){ 
                    if((mxm_.config.mxm_type=='deportesCQ5' && document.location.href.search("/video/")!=-1 ) || ( mxm_.config.mxm_type=='entretenimiento' && document.location.href.search("/unificacion-video/")!=-1 ) || document.location.href.search('finalpage.esmas.com/public/projects/91z3-unif/')!=-1 || (mxm_.config.mxm_type=='bandamax' && document.location.href.search("/video/")!=-1 ) || (mxm_.config.mxm_type=='unicable' && document.location.href.search("/video/")!=-1 ) || (mxm_.config.mxm_type=='canalgolden' && document.location.href.search("/video/")!=-1 ) ){
                        this.loadjs(this.config.js_server+'js/tempo2.js');
                    }else{
                        this.loadjs(this.config.js_server+'js/tempo.js');
                    }
                }
                                
                if(document.getElementById("masleido")){
                
                    try{this.config.vertical=document.location.href.split('/')[2].split('.')[0];}catch(e){}

                    if(document.location.href.search("/mexico/")!=-1){
                        this.config.vertical="noticieros";
                    }else if(document.location.href.search("/television/")!=-1){
                        this.config.vertical="television";
                    }else if(document.location.href.search("/deportes/")!=-1){
                        this.config.vertical="deportes";
                    }else if(document.location.href.search("/public/")!=-1){
                        this.config.vertical="deportes";
                    }
                    
                    //http://finalpage.esmas.com/proyectos/entretenimiento/pantallas/js/owl.carousel.js
                    //http://finalpage.esmas.com/proyectos/entretenimiento/pantallas/js/common.iu-mv.js
                    //http://finalpage.esmas.com/proyectos/entretenimiento/pantallas/js/layout.iu-grid-fluido.js

                     /*************************************************************************************************/
                    /***************************************************************************************************/
                    /*   SE AGREGA EL CONTENIDO DE DEPORTES DE LA PAGINA finalpage  */

                    if((mxm_.config.mxm_type=='deportesCQ5' && (document.location.href.search("/video/")!=-1 || document.location.href.search('finalpage.esmas.com/public/projects/91z3-unif/')!=-1 )) || ( mxm_.config.mxm_type=='entretenimiento' && document.location.href.search("/unificacion-video/")!=-1 ) || (mxm_.config.mxm_type=='bandamax' && (document.location.href.search("/video/")!=-1)) || (mxm_.config.mxm_type=='unicable' && (document.location.href.search("/video/")!=-1)) || (mxm_.config.mxm_type=='canalgolden' && (document.location.href.search("/video/")!=-1)) ){

                        document.getElementById("masleido").innerHTML=  
                            '<ul>'+
                                '<li data-template>'+
                                    '<div class="um-scroll">'+
                                        '<div class="um">'+
                                            '<div class="um-container">'+
                                                '<a href="[[url]]" target="_blank">'+
                                                    '<div class="card-img-content">'+
                                                        '<img src="http://i2.esmas.com/spacer.gif" data-src="[[thumbnail]]" alt="[[title]]">'+
                                                        '<div class="icon-border"><i class="unif-videoplay"></i></div>'+
                                                                '<div class="timer">[[duration]]</div>'+
                                                                //'<div class="topic lifestyle">Deportes</div>'+
                                                        '<div class="bg"></div>'+
                                                    '</div>'+
                                                    '<figcaption>'+
                                                        '<h4>[[title]]</h4>'+
                                                        '<span class="fecha">Fecha: [[release_date]]</span>'+
                                                        '<div class="ellipsis"></div>'+
                                                    '</figcaption>'+
                                                '</a>'+
                                                '<a href="#" class="mm-compartir-btn">'+
                                                    '<i class="unif-dots"></i>'+
                                                '</a>'+
                                            '</div>'+
                                            /*'<div class="mm-social">'+
                                                '<div class="mm-compartir">'+
                                                    '<i class="unif-dots"></i>'+
                                                '</div>'+
                                                    '<div class="mm-social-icons" data-whatsapp="whatsapp://send/" data-sharetitle="Compartir video en:" data-cancel="true" data-comm-share="true" data-comm-img="[[thumbnail]]" data-comm-url="[[url]]" data-comm-title="[[title]]">'+
                                                        '<div class="art-sociales">'+
                                                            '<div class="titulo-comp-video">Compartir video en:</div>'+
                                                                '<a href="whatsapp://send/" class="art-whatsapp"><i class="tvsagui-whatsapp"></i></a>'+
                                                                '<a href="mailto:?subject=[[title]];body=[[url]]" class="art-mail"><i class="tvsagui-mail"></i></a>'+
                                                                '<a href="#" onclick="popUp=window.open(\'http://comentarios.esmas.com/tw_popup2.php?url=[[url]];status=[[title]]\', \'popupwindow\', \'width=700,height=300\'); popUp.focus(); return false;" class="art-twitter"><i class="tvsagui-twitter"></i></a>'+
                                                                '<a href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?u=[[url]]\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;" class="art-facebook"><i class="tvsagui-facebook"></i></a>'+
                                                                '<a onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=[[url]];media=http://i2.esmas.com/2015/06/17/777308/[[thumbnail]];description=[[description]]\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;" class="art-pinterest"><i class="tvsagui-pinterest"></i></a>'+
                                                                '<a href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=[[url]]\', \'popupwindow\', \'width=800,height=400\');popUp.focus();return false;" class="art-googleplus"><i class="tvsagui-gplus"></i></a>'+
                                                                '<a href="#" class="art-cancel"><i class="tvsagui-cancel"></i></a>'+
                                                            '</div>'+
                                                    '</div>'+
                                            '</div>'+*/
                                            '<div class="mm-social">'+
                                                '<div class="mm-compartir">'+
                                                    '<i class="unif-dots"></i>'+
                                                '</div>'+
                                                    '<div class="mm-social-icons" data-whatsapp="whatsapp://send/" data-sharetitle="Compartir video en:" data-cancel="true" data-comm-share="true" data-comm-img="[[thumbnail]]" data-comm-url="[[url]]" data-comm-title="[[title]]">'+
                                                    '</div>'+
                                            '</div>'+


                                        '</div>'+
                                    '</div>'+
                                '</li>'+
                            '</ul>';

                    /*************************************************************************************************/
                    /***************************************************************************************************/


                    }else if( mxm_.config.mxm_type=="entretenimiento" || mxm_.config.mxm_type=="estilodevida"  || mxm_.config.mxm_type=='pasion_y_poder' || mxm_.config.mxm_type=='bandamax' || mxm_.config.mxm_type=='unicable' || (mxm_.config.mxm_type=='bandamax' && (document.location.href.search("/fotos/")!=-1)) || (mxm_.config.mxm_type=='unicable' && (document.location.href.search("/fotos/")!=-1)) ){

                        var more_title="TE SUGERIMOS";
                        if ( typeof $("#masleido").attr('data-title')!="undefined" ){more_title=$("#masleido").attr('data-title');}
                        document.getElementById("masleido").innerHTML=
                            '<div class="mv-title iu-pleca">'+
                                '<h2>'+
                                    '<span>'+more_title+'</span>'+
                                '</h2>'+
                            '</div>'+
                            '<div class="mv-vinculo" id="masleido_top" >'+
                                '<div data-template>'+
                                    '<div class="mm-img-container">'+
                                        '<a href="[[url]]">'+
                                            '<img class="mm-img" data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="imagen" width="300" height="225" />'+
                                            '<div class="mm-icon-container">'+
                                                '<i class="[[icon_class2]]"></i>'+
                                            '</div>'+
                                        '</a>'+
                                    '</div>'+
                                    '<div class="mv-topic">'+
                                        '<a href="[[url]]">[[channel]]</a>'+
                                    '</div>'+
                                    '<h3 class="mv-content-title">'+
                                        '<a href="[[url]]">[[title]]</a>'+
                                    '</h3>'+
                                '</div>'+
                            '</div>'+
                            '<div class="mv-rel-content-container">'+
                                '<div class="mv-relacionado-container televisa-carrusel" data-options="items:1; navigation:true; customNavigation:true; lazyLoad:true; controlClass:&quot;owl-nav&quot;; navClass:[&quot;mv-prev&quot;, &quot;mv-next&quot;]; responsive:true; singleItem:true; mouseDrag:false; touchDrag:false;">'+
                                    '<ul class="mv-owlpage" id="masleido_bottom1">'+
                                        '<li class="mv-elemento-relacionado"  data-template>'+
                                            '<div class="mv-relacionado-img">'+
                                                '<a href="[[url]]">'+
                                                    '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="imagen" width="90" height="51" />'+
                                                    '<div class="mm-icon-container">'+
                                                        '<i class="[[icon_class2]]"></i>'+
                                                    '</div>'+
                                                '</a>'+
                                            '</div>'+
                                            '<div class="mv-topic">'+
                                                '<a href="[[url]]">[[channel]]</a>'+
                                            '</div>'+
                                            '<h4 class="mv-relacionado-title">'+
                                                '<a href="[[url]]">'+
                                                '<i class="[[icon_class2]]"></i>[[title]]</a>'+
                                            '</h4>'+
                                        '</li>'+
                                    '</ul>'+
                                    '<ul class="mv-owlpage" id="masleido_bottom2">'+
                                        '<li class="mv-elemento-relacionado" data-template>'+
                                            '<div class="mv-relacionado-img">'+
                                                '<a href="[[url]]">'+
                                                    '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="imagen" width="90" height="51" />'+
                                                '</a>'+
                                                '<div class="mm-icon-container">'+
                                                    '<i class="[[icon_class2]]"></i>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="mv-topic">'+
                                                '<a href="[[url]]">[[channel]]</a>'+
                                            '</div>'+
                                            '<h4 class="mv-relacionado-title">'+
                                                '<a href="[[url]]">'+
                                                '<i class="[[icon_class2]]"></i>[[title]]</a>'+
                                            '</h4>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div class="owl-nav">'+
                                    '<div class="mv-button mv-prev iu-btn disabled">'+
                                        '<i class="tvsagui-flechaizquierda"></i>'+
                                    '</div>'+
                                    '<div class="mv-button mv-next iu-btn">'+
                                        '<i class="tvsagui-flechaderecha"></i>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }else if (mxm_.config.mxm_type=="mepongo"){
                        var more_title="M&aacute;s Vistos";
                        if ( typeof $("#masleido").attr('data-title')!="undefined" ){more_title=$("#masleido").attr('data-title');}
                        document.getElementById("masleido").innerHTML=
                            '<h3 class="title-mas-vistos">'+more_title+'</h3>'+
                            '<ul class="container-mas-vistos">'+
                                '<li data-template>'+
                                    '<a href="[[url]]">'+
                                        '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" />'+
                                        '<i class=""></i>'+
                                        '<div class="hoverdecolor"></div>'+
                                        '<div class="centrador">'+
                                            '<h4>[[title]]</h4>'+
                                        '</div>'+
                                    '</a>'+
                                '</li>'+
                            '</ul>';
                    }else if(mxm_.config.mxm_type=="fotos" || mxm_.config.mxm_type == 'fotos_pasion_y_poder'){

                        var is_carousel=false;
                        if ( typeof $("#masleido").attr('data-comm-carousel')!="undefined" ){is_carousel=true;}

                        /*
                        for (var i=0; i<$("#masleido img").length; i++){
                            $("#masleido img:eq("+i+")").attr("src", $("#masleido img:eq("+i+")").attr("data-src"))   
                        }
                        */
                        if(is_carousel){
                            document.getElementById("masleido").innerHTML=
                                //'<div data-item-distance="0" data-min-duration="500" data-duration="500" data-max-duration="500" data-item-count-desktop="3" data-item-count-tablet="3" data-item-count-mobile="3" class="  carousel carousel-top-ten" data-has-bullets="true" data-has-buttons="false">'+
                                    '<div class="carousel-page" style="" id="masleido_1">'+
                                        '<div class="carousel-item" data-template>'+
                                            '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                '<div class="imagen" style=" width: 84px; height:63px;">'+
                                                    '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" width="84" height="63" />'+
                                                    //'<img data-src="[[thumbnail]]" src="[[thumbnail]]" alt="[[title]]" width="84" height="63" />'+
                                                '</div>'+
                                            '</a>'+
                                            '<p class="topic color-light">Fotogaler&iacute;as</p>'+
                                            '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                '<h2 class="item-title-small">[[title]]</h2>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="carousel-page" style="  display: none;" id="masleido_2">'+
                                        '<div class="carousel-item" data-template>'+
                                            '<a href="#hallo" title="[[title]]" class="#hallo">'+
                                                '<div class="imagen" style=" width: 84px; height:63px;">'+
                                                    '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" width="84" height="63" />'+
                                                    //'<img data-src="[[thumbnail]]" src="[[thumbnail]]" alt="[[title]]" width="84" height="63" />'+
                                                '</div>'+
                                            '</a>'+
                                            '<p class="topic color-light">Fotogaler&iacute;as</p>'+
                                            '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                '<h2 class="item-title-small">[[title]]</h2>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="carousel-page" style="  display: none;" id="masleido_3">'+
                                        '<div class="carousel-item" data-template>'+
                                            '<a href="#hallo" title="[[title]]" class="#hallo">'+
                                                '<div class="imagen" style=" width: 84px; height:63px;">'+
                                                    '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" width="84" height="63" />'+
                                                    //'<img data-src="[[thumbnail]]" src="[[thumbnail]]" alt="[[title]]" width="84" height="63" />'+
                                                '</div>'+
                                            '</a>'+
                                            '<p class="topic color-light">Fotogaler&iacute;as</p>'+
                                            '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                '<h2 class="item-title-small">[[title]]</h2>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>';
                                //'</div>';

                            try{refreshMoreViews(document.getElementById('masleido'));}catch(e){}
                        }else{
                            document.getElementById("masleido").innerHTML=
                                '<div class="desktop-1 first">'+
                                   '<section class="mix-note-thumbs">'+
                                       '<section class="notes-thumbs" id="masleido_1">'+
                                           '<div class="carousel-item" data-template >'+
                                               '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                   '<div class="imagen" style=" width: 84px; height:63px;">'+
                                                       '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" width="84" height="63" />'+
                                                   '</div>'+
                                               '</a>'+
                                               '<p class="topic color-light">[[channel]]</p>'+
                                               '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                   '<h2 class="item-title-small">[[title]]</h2>'+
                                               '</a>'+
                                           '</div>'+
                                       '</section>'+
                                   '</section>'+
                               '</div>'+
                               '<div class="desktop-1">'+
                                   '<section class="mix-note-thumbs">'+
                                       '<section class="notes-thumbs" id="masleido_2">'+
                                           '<div class="carousel-item" data-template>'+
                                               '<a href="[[url]]" title="Da convocatoria a preliminar" class="#hallo">'+
                                                   '<div class="imagen" style=" width: 84px; height:63px;">'+
                                                       '<img data-src="[[thumbnail]]" src="http://i2.esmas.com/spacer.gif" alt="[[title]]" width="84" height="63" />'+
                                                   '</div>'+
                                               '</a>'+
                                               '<p class="topic color-light">[[channel]]</p>'+
                                               '<a href="[[url]]" title="[[title]]" class="#hallo">'+
                                                   '<h2 class="item-title-small">[[title]]</h2>'+
                                               '</a>'+
                                           '</div>'+
                                       '</section>'+
                                   '</section>'+
                               '</div>';
                        }

                    }else{    
                        document.getElementById("masleido").innerHTML='<li data-template><div class="mix_1arts_07"><ul class="articles"><li style="margin-bottom:10px;"><a href="[[url]]" title="[[title]]" class="link"><img style=" width:86px !important; height:66px !important;" width="86" height="66" src="http://i2.esmas.com/spacer.gif" data-src="[[thumbnail]]" alt="[[title]]"/><span class="sprite [[icon_class]]"></span><h3>[[topico | truncate 28]]</h3><p>[[title | truncate 76]]</p><span class="icon"></span></a></li></ul></div></li>';                
                    }


                }
                
                this.start_boxes();
                
                
            }
            
            
    };
    
    if(document.getElementById("masleido")){
        //viewing.init(); 
        setTimeout("viewing.init();", 1000);
    }
    
    var activo_img = 0;
    var activo_vid = 0; 
        
    function ocultar(){
            $('.not_here').hide();
            $('.vid_player_01 .not_here').hide();
            $('.img_stage_01 .not_here').hide();
            $('.vid_player_01 .not_here').css('display','none');
            $('.img_stage_01 .not_here').css('display','none');
            $('.tvsa-videocamera').removeClass("tvsa-mxm-close");
            $('.tvsa-camera').show(); 
    };
    
    if(document.getElementById("videos_nt")){
        document.getElementById("videos_nt").innerHTML='<li data-template >'+
                                                                '<div >'+
                                                                    '<article><a href="[[url]]" >'+
                                                                        '<div class="mxm-contenedor-img" >'+
                                                                            '<img src="http://lorempixel.com/people/624/350" data-src="[[img[0].url]]" alt="[[img[0].name]]" width="84" height="63">'+
                                                                            '<i class="noti-video"></i>'+
                                                                        '</div>'+
                                                                        '<div class="mxm-contenedor-texto" style="text-transform:none;">'+
                                                                            '<h5>[[title | truncate 90]]</h5>'+
                                                                            '<span>[[js_date|date \'DD MMM. YYYY\']]</span>'+
                                                                        '</div>'+
                                                                    '</a></article>'+
                                                                '</div>'+
                                                            '</li>'; 
        mxm_.fillvideo=function(a){
            videos_nt = Tempo
                       .prepare("videos_nt", {
                       var_braces: "\\[\\[\\]\\]",
                       tag_braces: "\\[\\?\\?\\]"
            });
            videos_nt.prepend(a.mxm);
            var a = 1;
            jQuery("#videos_nt li").each(function () {
                if ((a > 5) && (jQuery(this).html() != "")){
                    jQuery(this).remove(); 
                }
                a++
            });
        };
        if (document.location.href.search("noticieros.televisa.com/us/")!=-1 ){
            mxm_.loadjs("http://static.esmas.com/mxm/mxm2/ntvideosUS/mxmp.json");    
        }else{
            mxm_.loadjs("http://static.esmas.com/mxm/mxm2/ntvideos/mxmp.json");
        }
    }
    
    if(document.getElementById("fotos_nt")){
        document.getElementById("fotos_nt").innerHTML='<li data-template >'+
                                                                '<div >'+
                                                                    '<article><a href="[[url]]" >'+
                                                                        '<div class="mxm-contenedor-img" >'+
                                                                            '<img src="http://lorempixel.com/people/624/350" data-src="[[img[0].url]]" alt="[[img[0].name]]" width="84" height="63">'+
                                                                            '<i class="noti-camara"></i>'+
                                                                        '</div>'+
                                                                        '<div class="mxm-contenedor-texto" style="text-transform:none;">'+
                                                                            '<h5>[[title | truncate 90]]</h5>'+
                                                                            '<span>[[js_date|date \'DD MMM. YYYY\']]</span>'+
                                                                        '</div>'+
                                                                    '</a></article>'+
                                                                '</div>'+
                                                            '</li>'; 
        mxm_.fillfoto=function(a){
            fotos_nt = Tempo
                       .prepare("fotos_nt", {
                       var_braces: "\\[\\[\\]\\]",
                       tag_braces: "\\[\\?\\?\\]"
            });
            fotos_nt.prepend(a.mxm);
            var a = 1;
            jQuery("#fotos_nt li").each(function () {
                if ((a > 5) && (jQuery(this).html() != "")){
                    jQuery(this).remove(); 
                }
                a++;
            });
        };
        mxm_.loadjs("http://static.esmas.com/mxm/mxm2/ntfotos/mxmp.json");   
    }


    (function($){var noProtocolUrl=/(^|["'(\s]|&lt;)(www\..+?\..+?)((?:[:?]|\.+)?(?:\s|$)|&gt;|[)"',])/g,httpOrMailtoUrl=/(^|["'(\s]|&lt;)((?:(?:https?|ftp):\/\/|mailto:).+?)((?:[:?]|\.+)?(?:\s|$)|&gt;|[)"',])/g,linkifier=function(html){return html.replace(noProtocolUrl,'$1<a target="_blank" href="<``>://$2">$2</a>$3').replace(httpOrMailtoUrl,'$1<a target="_blank" href="$2" >$2</a>$3').replace(/"<``>/g,'"http')},linkify=$.fn.linkify=function(cfg){if(!$.isPlainObject(cfg)){cfg={use:(typeof cfg=='string')?cfg:undefined,handleLinks:$.isFunction(cfg)?cfg:arguments[1]}}var use=cfg.use,allPlugins=linkify.plugins||{},plugins=[linkifier],tmpCont,newLinks=[],callback=cfg.handleLinks;if(use==undefined||use=='*'){for(var name in allPlugins){plugins.push(allPlugins[name])}}else{use=$.isArray(use)?use:$.trim(use).split(/ *, */);var plugin,name;for(var i=0,l=use.length;i<l;i++){name=use[i];plugin=allPlugins[name];if(plugin){plugins.push(plugin)}}}this.each(function(){var childNodes=this.childNodes,i=childNodes.length;while(i--){var n=childNodes[i];if(n.nodeType==3){var html=n.nodeValue;if(html.length>1&&/\S/.test(html)){var htmlChanged,preHtml;tmpCont=tmpCont||$('<div/>')[0];tmpCont.innerHTML='';tmpCont.appendChild(n.cloneNode(false));var tmpContNodes=tmpCont.childNodes;for(var j=0,plugin;(plugin=plugins[j]);j++){var k=tmpContNodes.length,tmpNode;while(k--){tmpNode=tmpContNodes[k];if(tmpNode.nodeType==3){html=tmpNode.nodeValue;if(html.length>1&&/\S/.test(html)){preHtml=html;html=html.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');html=$.isFunction(plugin)?plugin(html):html.replace(plugin.re,plugin.tmpl);htmlChanged=htmlChanged||preHtml!=html;preHtml!=html&&$(tmpNode).after(html).remove()}}}}html=tmpCont.innerHTML;if(callback){html=$('<div/>').html(html);newLinks=newLinks.concat(html.find('a').toArray().reverse());html=html.contents()}htmlChanged&&$(n).after(html).remove()}}else if(n.nodeType==1&&!/^(a|button|textarea)$/i.test(n.tagName)){arguments.callee.call(n)}}});callback&&callback($(newLinks.reverse()));return this};linkify.plugins={mailto:{re:/(^|["'(\s]|&lt;)([^"'(\s&]+?@.+\.[a-z]{2,7})(([:?]|\.+)?(\s|$)|&gt;|[)"',])/gi,tmpl:'$1<a target="_blank"  href="mailto:$2">$2</a>$3'},tUser:{re:/(^|\s|[^\w\d])@(\w+)/gi,tmpl:'$1@<a target="_blank" href="http://www.twitter.com/$2" >$2</a>'},tHashtag:{re:/(^|\s|[^\w\d])#(\w+)/gi,tmpl:function(match,pre,hashTag){return pre+'<a target="_blank" href="https://twitter.com/hashtag/'+encodeURIComponent(hashTag)+'" >#'+hashTag+'</a>'}}}})(jQuery);

var viewEvents = {

    scroll_carousel : function(){

        try{
            //$('.um-scroll .mm-social').initShare();
            //$('.carousel-smoth').scrollCarousel();
            onSuccessMostViewed();
        socialShare.indexNotesExpanded();
        }catch(e){}
        
    },
    loadingJson : function(status){

        try{
            (status=='start')? $('#masleido').parent().addClass('loader') : $('#masleido').parent().removeClass('loader');
        }catch(e){}
        
    }
}
