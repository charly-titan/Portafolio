<?php
        // Variables globales del stream
	$akamaiBaseUrl = "http://tvsawpdvr-lh.akamaihd.net/";
	$canal=$_SESSION["canal"];
        switch ($canal) {
        case "2":
           $urlSignal = $akamaiBaseUrl . "z/stch02wp_1@119660/manifest.f4m?b=500-800";
           $urlSignalHLS = $akamaiBaseUrl . "i/stch02wp_1@119660/master.m3u8?b=500-800";
	   $dvrStreamUrl = "http://tvsawpdvr-lh.akamaihd.net/i/stch02wp_1@119660/master.m3u8";
        break;
        case "ForoTV":
           $urlSignal = $akamaiBaseUrl . "z/stch04wp_1@119661/manifest.f4m?b=500-800";
           $urlSignalHLS = $akamaiBaseUrl . "i/stch04wp_1@119661/master.m3u8?b=500-800";
	   $dvrStreamUrl = "http://tvsawpdvr-lh.akamaihd.net/i/stch04wp_1@119661/master.m3u8";
        break;
        case "5":
           $urlSignal = $akamaiBaseUrl . "z/stch05wp_1@119663/manifest.f4m?b=500-800";
           $urlSignalHLS = $akamaiBaseUrl . "i/stch05wp_1@119663/master.m3u8?b=500-800";
   	   $dvrStreamUrl = "http://tvsawpdvr-lh.akamaihd.net/i/stch05wp_1@119663/master.m3u8";
        break;
        case "9":
           $urlSignal = $akamaiBaseUrl . "z/stch09wp_1@119664/manifest.f4m?b=500-800";
           $urlSignalHLS = $akamaiBaseUrl . "i/stch09wp_1@119664/master.m3u8?b=500-800";
	   $dvrStreamUrl = "http://tvsawpdvr-lh.akamaihd.net/i/stch09wp_1@119664/master.m3u8";
        break;
	}

	// Notificacion de mails
	$mailingList = "cindy.polin@esmas.net,gabriel.mancera@esmas.net,edgar.martinez@esmas.net,videosantafe@esmas.com";

	// *****************************************************
	// Directorios del VCMS
	// *****************************************************

    $foldertmp= "/c00nt/vcms/media/";
	$CMSHome='/c00nt/www/vcms/';

 	$HLSOut = '/c00nt/vcms/Akamai/outputs/';
	$watchfolder_base="/c00nt/vcms/watchfolder/";
	$mediaDirectory = "/c00nt/vcms/media/";



	// *****************************************************
	// Librerias
	// *****************************************************
    
    $HLSDown='/usr/bin/mono /c00nt/vcms/software/Akamai/HLSDownloader.exe -s "';
    $FFMpeg='/c00nt/vcms/software/ffmpeg';



        // Calidades
    $cal1= '_354000.mp4';
    $cal2= '_446000.mp4';
	$cal3= '_710000.mp4';
	$cal4= '_840000.mp4';
	$cal5= '_1240000.mp4';
        $cal6= '_4384000.mp4';

	// Imagen
	$IMG_1="160x90";
	$IMG_2="320x180";
	$IMG_3="854x480";	

	// CDN
	$CDNUU='uptvvid';
	$CDNUP='zHJX1jXA..';
	$CDNUS='cmflash.upload.akamai.com';

	$galaxyApiUrl = "http://galaxy.esmas.com/AJAX/";
	$videoPackagingDomain = "http://m4vhds.tvolucion.com/";
	$arrBitrates = array("354000", "446000", "710000", "840000", "1240000", "4384000");
	$arrRenditions = array("150", "235", "480", "600", "970");
?>