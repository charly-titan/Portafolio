<?php

/**
 * Clase para gestionar las conexesiones y peticiones a servidores remotos
 */
class HttpConnection {
	private $curl;
	private $cookie;
	private $cookie_path="/cookies";
	private $id;

	public function __construct() {
		$this->id = time();
	}
	/**
	 * Inicializa el objeto curl con las opciones por defecto.
	 * Si es null se crea
	 * @param string $cookie a usar para la conexion
	 */
	public function init($cookie=null) {
		if($cookie)
			$this->cookie = $cookie;
		else
			$this->cookie = $this->cookie_path . $this->id;

		$this->curl=curl_init();
		curl_setopt($this->curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
		curl_setopt($this->curl, CURLOPT_HEADER, false);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE,$this->cookie);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($this->curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($this->curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($this->curl, CURLOPT_AUTOREFERER, TRUE);
}
	/**
	 * Establece en que ruta se guardan las cookies.
	 * Importante: El usuario de apache debe tener acceso de lectura y escritura
	 * @param string $path
	 */
	public function setCookiePath($path){
		$this->cookie_path = $path;
	}
	/**
	 * Envía una peticion GET a la URL especificada
	 * @param string $url
	 * @param bool $follow
	 * @return string Respuesta generada por el servidor
	 */
	public function get($url,$follow=false) {
		$this->init();
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_POST,false);
		curl_setopt($this->curl, CURLOPT_HEADER, $follow);
		curl_setopt($this->curl, CURLOPT_REFERER, '');
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
		$result=curl_exec ($this->curl);
		if($result === false){
			echo curl_error($this->curl);
		}
		$this->_close();
		return $result;
	}
	/**
	 * Envía una petición POST a la URL especificada
	 * @param string $url
	 * @param array $post_elements
	 * @param bool $follow
	 * @param bool $header
	 * @return string Respuesta generada por el servidor
	 */
	public function post($url,$post_elements,$follow=false,$header=false) {
		$this->init();
		$elements=array();
		foreach ($post_elements as $name=>$value) {
			$elements[] = "{$name}=".urlencode($value);
		}
		$elements = join("&",$elements);
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_POST,true);
		curl_setopt($this->curl, CURLOPT_REFERER, '');
		curl_setopt($this->curl, CURLOPT_HEADER, $header OR $follow);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $elements);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
		$result=curl_exec ($this->curl);
		$this->_close();
		return $result;
	}
	/**
	 * Descarga un fichero binario en el buffer
	 * @param string $url
	 * @return string
	 */
	public function getBinary($url){
		$this->init();
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_BINARYTRANSFER,1);
		$result = curl_exec ($this->curl);
		$this->_close();
		return $result;
	}
	/**
	 * Cierra la conexión
	 */
	private function _close() {
		curl_close($this->curl);
	}
	public function close(){
		if(file_exists($this->cookie))
			unlink($this->cookie);
	}
}


class LandingController extends BaseController {

	public function __construct(){
		parent::__construct();

		$this->beforeFilter('auth',array('except' => array('getIndex','postShare','getPublicado')));
		$this->beforeFilter('csrf', array('on' => 'post'));
		
	}


	protected function getUrlData($url){
		$result = false;
		
		$contents = $this->getUrlContents($url);

		if (isset($contents) && is_string($contents))
		{
			$title = null;
			$metaTags = null;
			
			preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

			if (isset($match) && is_array($match) && count($match) > 0)
			{
				$title = strip_tags($match[1]);
			}
			
			preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
			
			if (isset($match) && is_array($match) && count($match) == 3)
			{
				$originals = $match[0];
				$names = $match[1];
				$values = $match[2];
				
				if (count($originals) == count($names) && count($names) == count($values))
				{
					$metaTags = array();
					
					for ($i=0, $limiti=count($names); $i < $limiti; $i++)
					{
						$metaTags[$names[$i]] = array (
							'html' => htmlentities($originals[$i]),
							'value' => $values[$i]
						);
					}
				}
			}

			preg_match_all('/<[\s]*meta[\s]*property="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
			
			if (isset($match) && is_array($match) && count($match) == 3)
			{
				
				$originals = $match[0];
				$names = str_replace ( ":" , "_" , $match[1] );
				$values = $match[2];
				
				if (count($originals) == count($names) && count($names) == count($values))
				{
					
					
					for ($i=0, $limiti=count($names); $i < $limiti; $i++)
					{
						$metaTags[$names[$i]] = array (
							'html' => htmlentities($originals[$i]),
							'value' => $values[$i]
						);
					}
				}
			}
			
			$result = array (
				'title' => $title,
				'metaTags' => $metaTags
			);
		}
		
		
		try{
			if($result["metaTags"]["og_image"]["value"]==""){
				preg_match_all("/<img[ ]?src=\"(.*)\"[ ]?id=\"img_stage_01_IMG\"[\/]?>/", $contents, $output_array);
				
					$result["metaTags"]["og_image"]["value"]=$output_array[1][0];	
				
			}
		}catch (Exception $e) {

		}
		try{
			if($result["metaTags"]["og_image"]["value"]==""){
				preg_match_all("/src=\"(.*[0-9]{3,4}.[0-9]{1,4}.jpg)\"/", $contents, $output_array);

			
					$result["metaTags"]["og_image"]["value"]=$output_array[1][0];	
				
			}
		}catch (Exception $e) {

		}

		try{
			if(!isset($result["metaTags"]["og_image"])){
				
				preg_match_all("/<link rel=\"image_src\" href=\"(.*[0-9]{3,4}.[0-9]{1,4}.jpg)\"/", $contents, $output_array);
			
					$result["image"]=$output_array[1][0];	
				
			}
		}catch (Exception $e) {

		}



		return $result;
	}

	protected function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0){
		$result = false;
		
		$contents = @$this->readHtml($url);
		
		// Check if we need to go somewhere else
		
		if (isset($contents) && is_string($contents))
		{
			preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
			
			if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
			{
				if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
				{
					return $this->getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
				}
				
				$result = false;
			}
			else
			{
				$result = $contents;
			}
		}
		
		return $contents;
	}

	public function getIndex(){
		//echo $this->getInfo('http://espectaculos.televisa.com/farandula/fotos/kendall-y-kylie-jenner-son-el-mejor-duo-dinamico/71303/');


		//$meta_info = $this->getUrlData('http://espectaculos.televisa.com/farandula/fotos/las-famosas-que-deleitan-con-sus-encantos/71389/');

		//echo '<pre>'; print_r($result); echo '</pre>';
		//return View::make(Config::get( 'app.main_template' ).".landing.landing");
		$url = Input::get('url');
		$validator = Validator::make(
    array('url' => $url),
    array('url' => 'url')
);

		if ($validator->fails())
{
 exit("Faltan datos");
}
		
		//$url="http://espectaculos.televisa.com/farandula/fotos/las-famosas-que-deleitan-con-sus-encantos/71389/";
		$meta_info = $this->getUrlData($url);
		//var_dump($meta_info);

		$page_info	=	array(	"title" 		=>	"",
									"description"	=>	"",
									"url"			=> $url,
									"img"			=> 	""
								);
		$error=0;
		try {
			$page_info	=	array(	"title" 		=>	$meta_info["metaTags"]["og_title"]["value"],
									"description"	=>	html_entity_decode($meta_info["metaTags"]["Description"]["value"]),
									"img"			=> 	$meta_info["metaTags"]["og_image"]["value"]
								);
		} catch (Exception $e) {
			$error=1;	
		}
		if($error){
			try {
			$page_info	=	array(	"title" 		=>	$meta_info["metaTags"]["title"]["value"],
									"description"	=>	html_entity_decode($meta_info["metaTags"]["description"]["value"]),
									"img"			=> 	$meta_info["metaTags"]["og_image"]["value"]
								);
			} catch (Exception $e) {
					
			}	
		}
		if($page_info["title"]==""){
			try {
				$page_info["title"]=$meta_info["title"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["metaTags"]["image_src_192_108"]["value"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["metaTags"]["image_src"]["value"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["image"];
			} catch (Exception $e) {
					
			}
		}


		if($page_info["description"]==""){
			try {
				$page_info["description"]=$meta_info["metaTags"]["Description"]["value"];
			} catch (Exception $e) {
					
			}
		}


		$page_info["url"]=$url;
	    	
	    //	var_dump($page_info);

	    


		return View::make(Config::get( 'app.main_template' ).".landing.share_user")->with("page_info",$page_info);
	}


	public function getUrlInfo(){
		
			

			$bit 	= new Bitly();
	    	$url="http://espectaculos.televisa.com/farandula/fotos/las-famosas-que-deleitan-con-sus-encantos/71389/";
	    	$meta_info = $this->getUrlData($url);
	    	$page_info	=	array(	"title" 		=>	$meta_info["metaTags"]["og_title"]["value"],
									"description"	=>	html_entity_decode($meta_info["metaTags"]["Description"]["value"]),
									"img"			=> 	$meta_info["metaTags"]["og_image"]["value"]
								);
	    
			$page_info = array(
							 	"message" => $message,
								"picture" => $meta_info["metaTags"]["og_image"]["value"],
								"link" => $bit->createBitly("http://televisa.com/#sharedlink=".$url),
								"name" => $meta_info["metaTags"]["og_title"]["value"],
								"description" => html_entity_decode($meta_info["metaTags"]["Description"]["value"]),
								"caption" => html_entity_decode($meta_info["metaTags"]["Description"]["value"])
							);


	}


	public function postShare(){
		$bit 	= new Bitly();
		//$token = "CAABvB8oAcpEBAI0W6ZAUTCZCD0kJXcX7Xghe7gmqbNtn8zbcPLZAAxkZC0rho38qtmNnnLZC298LvNNgbNCgu4V8v0yL45RbEnehYCpHFUHe1VIj1ZCDX4FxGu2PzZBYso1RAE6ZCUZApe9QjfGgZAJzuCOYwPNdxZAPa8rbw5sVgquSOhd2fYy7KXl";
    	$token = "CAABvB8oAcpEBAGmBYIHVbZBA4nufirRvxYhbg2XVtq41rgcZCfPbZBb6c9ZChXmjqPC5ImZByljSrwUh9t9jgpfXfy3gGWGRGaOqe9Q7BgYSoGDFhZBcagrSdj77vrPXOb9ojxFV0BKsbZBq3xP6dIT9LhRGRNP35GpAZBzGZBwPHv99OBhBHwtBj";
    	$hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');
    	$hybridauth->storage()->set( "hauth_session.facebook.is_logged_in", 1 );
    	$hybridauth->storage()->set( "hauth_session.facebook.token.access_token", $token );        
    	$service = $hybridauth->authenticate("Facebook");

		$url = Input::get('url');
		$validator = Validator::make(
		    array('url' => $url),
		    array('url' => 'url')
		);

		if ($validator->fails())
		{
		 exit("Faltan datos");
		}

//print_r(Input::all());
		$message = Input::get('message');
		$validator = Validator::make(
		    array('message' => $message),
		    array('message' => 'required')
		);

		if ($validator->fails())
		{
		 exit("Faltan datos");
		}


		$meta_info = $this->getUrlData($url);
		//var_dump($meta_info);

		$page_info	=	array(	"title" 		=>	"",
									"description"	=>	"",
									"url"			=> $url,
									"img"			=> 	""
								);
		$error=0;
		try {
			$page_info	=	array(	"title" 		=>	$meta_info["metaTags"]["og_title"]["value"],
									"description"	=>	html_entity_decode($meta_info["metaTags"]["Description"]["value"]),
									"img"			=> 	$meta_info["metaTags"]["og_image"]["value"]
								);
		} catch (Exception $e) {
			$error=1;	
		}
		if($error){
			try {
			$page_info	=	array(	"title" 		=>	$meta_info["metaTags"]["title"]["value"],
									"description"	=>	html_entity_decode($meta_info["metaTags"]["description"]["value"]),
									"img"			=> 	$meta_info["metaTags"]["og_image"]["value"]
								);
			} catch (Exception $e) {
					
			}	
		}
		if($page_info["title"]==""){
			try {
				$page_info["title"]=$meta_info["title"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["metaTags"]["image_src_192_108"]["value"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["metaTags"]["image_src"]["value"];
			} catch (Exception $e) {
					
			}
		}

		if($page_info["img"]==""){
			try {
				$page_info["img"]=$meta_info["image"];
			} catch (Exception $e) {
					
			}
		}


		if($page_info["description"]==""){
			try {
				$page_info["description"]=$meta_info["metaTags"]["Description"]["value"];
			} catch (Exception $e) {
					
			}
		}


		$page_info["url"]=$url;
//var_dump($page_info);
    	

		    if ($service->isUserConnected()){
		    	$shorten = Bitly::shorten("http://televisa.com/#sharedlink=".$page_info["url"]);

	    	//var_dump($shorten["data"]);
			    //$accounts = $service->api()->api('/me/accounts');
		    	$params = array(
		    					//'access_token' => "CAABvB8oAcpEBAJ2ZCYc85aOO80LBTvpEbPLneJUxOuKWx93MiT7SlZA3kN8ZC3N5JdeDZAadVDdqeV7kQSStKK5FhFqMA7zHwGa46MTF6nrP3UgVGCpgge3KwjkVSdnVBT4yWMuEpWZCFkZBc7tEnCmaW5gMBLvAPNP8EtbiAPaZBZBZA1ZCNvHdTr",
							 	"message" => $message,
								"picture" => $page_info["img"],
								"link" => $shorten["data"]["url"],//,
								"name" => $page_info["title"],
								"description" => html_entity_decode($page_info["description"]),
								"caption" => html_entity_decode($page_info["description"])
							);
		    	
			//Para las paginas 
		    	//$page_info["access_token"]="CAABvB8oAcpEBAJ2ZCYc85aOO80LBTvpEbPLneJUxOuKWx93MiT7SlZA3kN8ZC3N5JdeDZAadVDdqeV7kQSStKK5FhFqMA7zHwGa46MTF6nrP3UgVGCpgge3KwjkVSdnVBT4yWMuEpWZCFkZBc7tEnCmaW5gMBLvAPNP8EtbiAPaZBZBZA1ZCNvHdTr";

		       // $service->api()->api( "/112085805482275/feed", 'POST', $page_info );

		    	//var_dump($params);
		    	$service->api()->api( "/me/feed", 'POST', $params );
			}

			return Redirect::to('/landing/publicado');
	}


	public function getPublicado(){

		return "Mensaje publicado";
	}

	

	protected function readHtml($url){
		$key=md5($url);
		if(Cache::has($key) && Cache::get($key)==false){
			Cache::forget($key);
		}

		if (!Cache::has($key)){
			$http = new HttpConnection();  
			$http->init();  
			$html = $http->get($url);  
			$http->close();
			Cache::add($key, $html,  10);
		}
		
		

		return  Cache::get($key);
	}


	protected function getInfo($url){
			//http://espectaculos.televisa.com/farandula/fotos/kendall-y-kylie-jenner-son-el-mejor-duo-dinamico/71303/
		$html = $this->readHtml($url);
		var_dump($this->getTitle($html,"title"));


	}



}