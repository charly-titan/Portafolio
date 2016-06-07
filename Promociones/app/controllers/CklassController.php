<?php

class CklassController  extends BaseController {


	public function __construct()
    {
		//$this->beforeFilter('auth', array('except' => array('getIndex','postConfirmData','postSavePhrase','getConfirma','getAvisoPrivacidad','getBasesConcurso','getTerminosCondiciones','getAutorizacion','getPrueba','getPrueba1','getTest','getFoto','getGaleria','postUploadimg','getImagen','getVotacion', 'getConteo', 'postSaveQuizz')));
        //$this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('force.ssl');
    }

    public function getIndex(){

    	return View::make('cklass.main');
    }

    public function getTest(){
    	//return  Redirect::away("http://amp.televisa.com/embed/embed.php?id=315763&amp;canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&amp;subcanal=0000&amp;w=624&amp;h=351&amp;autoplay=true&amp;c3=",302, array('HTTP_REFERER' => 'https://promo.televisa.com'));
    	return "<html><<head></head><body><iframe src='http://amp.televisa.com/embed/embed.php?id=315763&amp;canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&amp;subcanal=0000&amp;w=624&amp;h=351&amp;autoplay=true&amp;c3='></body>";
    }

    public function postCheck(){
    	//var_dump($_POST);


    	$codigo=strtolower(trim($_POST["codigo"]));


    	if($codigo=="calzado"){
    		// return "<html><<head></head><body><script>document.location.href='http://amp.televisa.com/embed/embed.php?id=315763&amp;canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&amp;subcanal=0000&amp;w=624&amp;h=351&amp;autoplay=true&amp;c3=';</script></body>";
//  HEAD
//     		return  Redirect::away("http://amp.televisa.com/embed/embed.php?id=315763&amp;canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&amp;subcanal=0000&amp;w=624&amp;h=351&amp;autoplay=true&amp;c3=",302, ['HTTP_REFERER' => 'https://promo.televisa.com']);
// =======
//     		return  Redirect::away("http://amp.televisa.com/embed/embed.php?id=315763&amp;canal=es.televisa.television.video|telenovelas|antes-muerta-que-lichita|videos&amp;subcanal=0000&amp;w=624&amp;h=351&amp;autoplay=true&amp;c3=",302, ['HTTP_REFERER' => 'https://promociones.televisa.com']);
//  425d9e427db1e86ed837bc367122eca0355a6ab5
            return View::make('cklass.loading')->with("videoId","321560");
    	}else{
    		return Redirect::to('cklass')->withErrors('codigo');
    	}



// LOS
// MEJORES
// CATÁLOGOS
// DE
// MÉXICO
// EL
// CALZADO
// Y
// VESTUARIO
// DE
// LAS
// ESTRELLAS
// MODA
// ROPA
// BOLSOS
// TENDENCIA
// ESTILO
// CABALLERO
// URBAN
// CONFORT
// GALA
// GLAMOUR
// BOTAS
// KIDS
    }

}