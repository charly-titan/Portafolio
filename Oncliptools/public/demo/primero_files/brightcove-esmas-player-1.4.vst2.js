/**
    04/22/14 18:03
*/
/* Valida consola debug */
if (typeof console == "undefined" || typeof console.log == "undefined") var console = {
    log: function() {}
};

/* Player Interface */
var contaAd = 0;
var contaPlay = 0;
var myTimeVar;
var player;
var content;
var videoPlayer;
var adModule;
var adDuration;
var eventStatusMessage = "";
var hashCode = null;
var medComplete = 0;
var lastmedComplete = 0;
var flagStopComplete = "0";
// called when template loads, we use this to store a reference to the player and modules
// and add event listeners for the video load (when the user clicks on a video)
function onTemplateLoaded(player2) {
    if (isValidRegion) {
        player = brightcove.getExperience(player2);
        videoPlayer = player.getModule(APIModules.VIDEO_PLAYER);
        content = player.getModule(APIModules.CONTENT);
        modExp = player.getModule(APIModules.EXPERIENCE);

        videoPlayer.addEventListener(BCMediaEvent.BEGIN, onMediaPlay);
        videoPlayer.addEventListener(BCMediaEvent.PLAY, onMediaPlay);
        videoPlayer.addEventListener(BCMediaEvent.COMPLETE, mediaComplete);
        videoPlayer.addEventListener(BCMediaEvent.STOP, onMediaStop);
        //videoPlayer.addEventListener(BCMediaEvent.BUFFER_BEGIN, mediaBufferBegin);
        //videoPlayer.addEventListener(BCMediaEvent.BUFFER_COMPLETE, mediaBufferComplete);
        //videoPlayer.addEventListener(BCMediaEvent.PROGRESS, onMediaProgressFired);

        content.addEventListener(BCContentEvent.VIDEO_LOAD, onVideoLoad);
        /*
		adModule = player.getModule(APIModules.ADVERTISING);
		adModule.addEventListener(BCAdvertisingEvent.AD_COMPLETE, onAdComplete);
		adModule.addEventListener(BCAdvertisingEvent.AD_PAUSE, onAdPause);
		adModule.addEventListener(BCAdvertisingEvent.AD_START, onAdStart);
		adModule.addEventListener(BCAdvertisingEvent.AD_RESUME, onAdResume);
		adModule.addEventListener(BCAdvertisingEvent.AD_PROGRESS, onAdProgress);
		*/

        modExp.getElementByID("facebookButton").setVisible(false);
        modExp.getElementByID("twitterButton").setVisible(false);
        modExp.addEventListener(BCExperienceEvent.ENTER_FULLSCREEN, onFullScreen);
        modExp.addEventListener(BCExperienceEvent.EXIT_FULLSCREEN, onExitFullScreen);


    } else {
        var altText = '<div id="BCEsmasPlayer_error_display">' +
            '<h1>Este video <br>no est&aacute; disponible<br>para tu pa&iacute;s</h1></div>';
        document.getElementById('bcPlayer').innerHTML = altText;
        sendVideoLog("blocked");
    }
}

var onVideoLoad = function(event) {
    videoPlayer.loadVideo(event.video.id);
    hideImage();
}

var mediaComplete = function() {
    flagStopComplete = "1";
    sendVideoLog("end");
    medComplete++;
}

var onMediaPlay = function() {
    if (contaPlay == 0) {
        sendVideoLog("start");
    } else {
        if (lastmedComplete < medComplete) {
            sendVideoLog("restart");
            lastmedComplete = medComplete
        }
    }
    contaPlay++;
}

var onMediaStop = function() {
    console.log("--->Evento STOP<---");
    //sendVideoLog("stop");
}

/*
var onMediaPlay = function(){
	if(contaAd == 0){
		if(contaPlay == 0){
			 sendVideoLog("start");
		}
		if(contaPlay > 1){
			if(medComplete == 1){
				sendVideoLog("restart");
			}
		}
		contaPlay++;
	}
}
*/
/*
// Pause the BC Video Player
function playPauseAd(){
  if (videoPlayer.isPlaying()) {
	  videoPlayer.pause(true);
  } 
}

// Call when the video ad completes.
function onAdComplete(evt){
	eventStatusMessage = eventStatusMessage + "Ad completed " + contaAd + "\n";
	console.log("EVENTO: " + eventStatusMessage);
		
	if(contaAd == 1 || contaAd > 2 ){
		 sendVideoLog("end");
	}
	contaAd++;
}

// Call when the video ad is paused.
function onAdPause(evt){
	eventStatusMessage = eventStatusMessage + "Ad Paused. Position: " + evt.position + "\n";
	console.log("EVENTO: " + eventStatusMessage);
	
	if(contaAd == 1){
		// sendVideoLog("pause");
	}
}
// Call when the video ad starts            
function onAdStart(evt){
	eventStatusMessage = eventStatusMessage + "Ad Started" + contaAd + "\n";
	console.log("EVENTO ADV: " + eventStatusMessage +" \n" + "Contador: " + contaAd);
		 
	if(contaAd == 0 || contaAd > 1){
		//overlayspace.style.display="none";
	}
	if(contaAd == 1){
		 sendVideoLog("start");
	}
	if(contaAd > 2){
		 sendVideoLog("restart");
	}
}

// Call when the video ad resumes.
function onAdResume(evt){
	eventStatusMessage = eventStatusMessage + "Ad Resumed  Position: " + evt.position + "\n";
	console.log("EVENTO: " + eventStatusMessage);
}

 // Call when as the video ad plays
function onAdProgress(evt){
	eventStatusMessage = document.getElementById('adProgress').value = "Ad Progress: " + evt.position;
	//console.log("EVENTO: " + eventStatusMessage);
}
*/
/*********** END Player Interface ***********/



var isValidRegion = function() {
    var result = false;
    var geoPais = omitirAcentos(MN_geo.country.toLowerCase());
    var geoEstado = omitirAcentos(MN_geo.state.toLowerCase());
    switch (gbs) {
        case '49010dd1ebf31e2005d4c624eef19176':
            if (MN_geo.country.toLowerCase() == 'mex')
                result = true
            break;
        case '716ee5cf447289f814a8ef5f9ad86bb5':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1)
                result = true;
            break;
        case '991d48815c3a68294305aaf78e0bdeeb':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case '48bfa84d06702d2185b4b0a47eb4d01d':
            var cString = 'mex,gtm';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case '71791115dd7384c59214ad4697e6d15b':
            var cString = 'bol,chl,col,cri,ecu,gtm,hnd,nic,pan,per,pry,slv,ury,ven,mex';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case 'c1c734120e257f118c92aa2293bed0bf':
            var cString = 'ant,brb,bmu,bol,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case 'ce91be1cd60cdc434d7e5604182030bf':
            var cString = 'mex,gtm,slv,nic,hnd,pan,cri';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case '5115ee5df30264131b7a9c41b8fd752e':
            var cString = 'bol,chl,col,cri,ecu,slv,gtm,hnd,mex,nic,pan,per,pry,ury,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case 'd7491456701ad4c98d1fe0f389a1225e':
            // var cString = 'bol,chl,col,cri,ecu,slv,gtm,hnd,nic,pan,per,pry,ury,ven';
            var cString = 'bol,bhs,blz,chl,col,cri,cub,dma,ecu,dom,gtm,guy,hnd,hti,jam,mex,nic,pan,per,pry,sur,slv,tto,ury,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1)
                result = true;
            break;
        case '5fb1f955b45e38e31789286a1790398d':
            result = true;
            break;
        case '11a344833988376463d9fecda369580b':
            if (MN_geo.country.toLowerCase() == 'usa')
                result = true;
            break;
            // ESTADOS	
        case '70d696597ff47b9b71ee3c9384c62f9e':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1 && MN_geo.state.toLowerCase() != 'que' && MN_geo.state.toLowerCase() != 'querétaro') {
                result = true;
            }
            break;
        case 'e673e0d8ec9ab6188f5551fffdb8dd22':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1 && MN_geo.state.toLowerCase() != 'jal' && MN_geo.state.toLowerCase() != 'jalisco') {
                result = true;
            }
            break;
        case '69239913289a8cb723a7fa071a52625c':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1 && MN_geo.state.toLowerCase() != 'slp' && MN_geo.state.toLowerCase() != 'san luis potosí') {
                result = true;
            }
            break;
        case '0064dc1902181149302bbf47aa921928':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1 && MN_geo.state.toLowerCase() != 'nle' && MN_geo.state.toLowerCase() != 'nuevo león') {
                result = true;
            }
            break;
        case '54afac809a26220a351763e3734c8e93':
            var cString = 'usa,pri,vir,umi,asm,plw';
            if (cString.indexOf(MN_geo.country.toLowerCase()) == -1 && MN_geo.state.toLowerCase() != 'roo' && MN_geo.state.toLowerCase() != 'quintana roo') {
                result = true;
            }
            break;
            // LATAM - NOT SINGLE ESTATE
        case '1e9d517c7b36eb14ec294f39f4189583':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'que' && MN_geo.state.toLowerCase() != 'querétaro')
                result = true;
            break;
        case '57d994124e8845f6315041d77e9d295e':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'jal' && MN_geo.state.toLowerCase() != 'jalisco')
                result = true;
            break;
        case '5cc46744223866f912ff282557caadda':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'slp' && MN_geo.state.toLowerCase() != 'san luis potosí')
                result = true;
            break;
        case 'fb5361cce87bdb60261f0b41335f3771':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'nle' && MN_geo.state.toLowerCase() != 'nuevo león')
                result = true;
            break;
        case '163b5b0f07d61ae8d1e33f6a9d379631':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'roo' && MN_geo.state.toLowerCase() != 'quintana roo')
                result = true;
            break;
        case 'e4a15899c397ca5ba2b77563b90eb811':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'ver' && MN_geo.state.toLowerCase() != 'veracruz')
                result = true;
            break;
        case '9a3ae7c45fd231b425519f979ba20112':
            var cString = 'ant,arg,brb,bmu,bol,bra,bra,bhs,blz,can,chl,col,cri,cri,cub,dma,ecu,dom,guf,glp,sgs,gtm,gum,guy,hnd,hti,jam,kna,cym,lca,mtq,mex,nic,pan,per,pry,sur,stp,slv,tto,ury,vct,ven';
            if (cString.indexOf(MN_geo.country.toLowerCase()) != -1 && MN_geo.state.toLowerCase() != 'chi' && MN_geo.state.toLowerCase() != 'chihuahua')
                result = true;
            break;
        default:
            result = false;
            break;
    }
    if (document.cookie.indexOf('__aYrUtmZkj=') != -1) {
        var raVal = '';
        for (var i = 0; i < publicLockKey.length; i += 4) raVal += publicLockKey.charAt(i);
        if (eval('String.fromCharCode(' + unescape(document.cookie.substring(document.cookie.indexOf('__aYrUtmZkj=') + 12, document.cookie.indexOf('__aYrUtmZkj') + 109)) + ')') == raVal) result = true;
    }
    return result;
}

/**
 * Funcion que gestiona el evento click de los botones.
 * @return false
 */
    function onClickEvent(event) {
        if (countFireEvent++ == 0) {
            if (event.elementID == "repeatButtonOn") {
                modExp.getElementByID("repeatButtonOn").setVisible(false);
                modExp.getElementByID("repeatButtonOff").setVisible(false);
                setTimeout("play()", 1000); //Permite que desaparezca el boton de repetir video.
            } else if (event.elementID == "facebookButton") { //llama a la funcion para facebook que se encuentra en el script de comunidades.
                if (currentPlayer.useParent == true)
                    parent.tim_social.modal_facebook();
                else
                    tim_social.modal_facebook();
            } else if (event.elementID == "twitterButton") { //llama a la funcion para twitter que se encuentra en el script de comunidades.
                if (currentPlayer.useParent == true)
                    parent.tim_social.modal_twitter();
                else
                    tim_social.modal_twitter();
            } else if (event.elementID == "fantaButton") { //llama a la funcion para fanta que se encuentra en el script de comunidades.
                if (currentPlayer.useParent == true) {
                    //parent.tim_social.modal_fanta();
                    fanta.getclick();
                } else {
                    //tim_social.modal_fanta();
                    fanta.getclick();
                }
            } else if (event.elementID == "expand") { //llama a la funcion para expandir de este script.
                player.resizePlayer();
            } else if (event.elementID == "popout") { //llama a la funcion para expandir de este script.
                player.PopOut(options.ad.videoId);
            }
        }
        if (countFireEvent == totalClickEvents)
            countFireEvent = 0;
    }


    /**
     * Funcion que obtiene el codigo Hash que se envia al video log
     * @return String
     */
    function getHash() {
        var strHash = '';
        var randomNumber = null;
        var start = null;
        var total = null;
        for (i = 0; i < 39; i++) {
            randomNumber = Math.round(Math.random() * 2) + 1;
            if (randomNumber == 1) {
                start = 65;
                total = 25;
            } else if (randomNumber == 2) {
                start = 97;
                total = 25;
            } else {
                start = 48;
                total = 9;
            }
            strHash += String.fromCharCode(start + Math.round(Math.random() * total));
        }

        return strHash;
    }

    /**
     * Funcion que obitiene el codigo CSIE que se envia al video log
     * @return String
     */
    function getCSIE() {
        if (document.cookie.indexOf("esmasstats=") == -1) {
            var nd = new Date();
            document.cookie = "esmasstats=" + (nd.getYear() + "").substring(2, 4) + (((nd.getMonth() + 1) < 10) ? "0" : "") + (nd.getMonth() + 1) + ((nd.getDate() < 10) ? "0" : "") + nd.getDate() + ((nd.getHours() < 10) ? "0" : "") + nd.getHours() + ((nd.getMinutes() < 10) ? "0" : "") + nd.getMinutes() + ((nd.getSeconds() < 10) ? "0" : "") + nd.getSeconds() + "-" + (Math.random() * 1000000000000000000) + "-" + Math.round(Math.random() * 100000000) + "; expires=Fri, 31 Jan 2020 23:59:59 GMT; path=/;";
        }

        var begin = document.cookie.indexOf("esmasstats=");

        var CSIE = document.cookie.substring(begin + 11, begin + 50);

        return CSIE;
    }

    /**
     * Funcion que convierte una cadena de tiempo a segundos
     * @param String Duracion en formato HH:MM:SS
     * @return int
     */
    function convertToSeconds(stringTime) {
        var sec = 0;
        if (stringTime.match(/\d\d?\:\d\d?\:\d\d?/)) {
            var arrTime = stringTime.split(/\:/);
            for (indi in arrTime) {
                var tempovar = arrTime[indi].toString();
                arrTime[indi] = tempovar.replace(/^0/g, "");
                if (arrTime[indi] == "") {
                    arrTime[indi] = "0";
                }
            }
            if (arrTime.length == 3)
                sec = parseInt(arrTime[0]) * 3600 + parseInt(arrTime[1]) * 60 + parseInt(arrTime[2]);
            else if (arrTime.length == 2)
                sec = parseInt(arrTime[0]) * 60 + parseInt(arrTime[1]);
            else if (arrTime.length == 1)
                sec = parseInt(arrTime[0]);
        }
        return sec;
    }

    function sendVideoLog(action) {
        if (hashCode == null)
            hashCode = getHash();
        if (typeof videoDuration == "undefined") {
            videoDuration = '0';
        }
        if (typeof linkBaseURL == "undefined") {
            linkBaseURL = '';
        }
        if (typeof videoTitle == "undefined") {
            videoTitle = '';
        }


        var duracion = convertToSeconds(videoDuration);
        var ptime = '0';

        var urlParams = "action=" + action + "&duration=" + duracion + "&progresstime=" + ptime + "&cc=" + MN_geo.country.toLowerCase() + "&state=" + MN_geo.state.toLowerCase() + "&city=" + MN_geo.city.toLowerCase() + "&url=" + escape(linkBaseURL) + "&hash=" + hashCode + "&title=" + videoTitle + "&CSIE=" + getCSIE();

        var src = "http://videolog.esmas.com/set_view.php?" + urlParams;
        var img = null;

        if (document.getElementById('vl'))
            img = document.getElementById('vl');
        else {
            img = document.createElement("img");
            img.setAttribute("id", "vl");
            img.setAttribute("display", "none");
            img.setAttribute("style", "display:none;");
            document.body.appendChild(img);
        }

        img.setAttribute("src", src);
        console.log("LLAMADO APLICADO: " + src);

        // Mandamos llamar Log de comunidades
        if (action == 'start') {
            var viewsLog = new Image();
            var viewsUrlLog = 'http://v.esmas.com:8081/vistas/spacer.gif?2|' + escape(linkBaseURL);
            viewsLog.src = viewsUrlLog;
        }

        try {
            var video_info = {
                videoDuration: duracion,
                progressTime: 0,
                country: MN_geo.country.toLowerCase(),
                state: MN_geo.state.toLowerCase(),
                city: MN_geo.city.toLowerCase(),
                videoTitle: videoTitle,
                playerType: 'bc',
                videoType: 'vod',
                ip: MN_geo.ip,
                url: escape(linkBaseURL)

            };

            videolog.sendVideoLog(action, video_info);
        } catch (err) {

        }
    }

    function timeToClear() {
        clearTimeout(myTimeVar);
    }

    /***************/

    function changeVideo(videoId) {
        videoPlayer.pause();
        videoPlayer.loadVideo(videoId);
    }

    function omitirAcentos(text) {
        var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
        var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
        for (var i = 0; i < acentos.length; i++) {
            text = text.replace(acentos.charAt(i), original.charAt(i));
        }
        return text;
    }

var respondToEventBCPlayerMessage = function(e) {
    if (e.origin == 'http://www.televisa.com') {
        if (e.data == 'eventbcplayer?') {
            e.source.postMessage(flagStopComplete, "http://www.televisa.com");
        }
    }
}

window.addEventListener('message', respondToEventBCPlayerMessage, false);