<?php
class TelevisionController extends ContestController {


	public function __construct()
    {
		parent::__construct();
		Config::set('app.main_template', 'television');
        
    }


	public function getFinalizada($short_name=""){

		$info=$this->contestInfo($short_name);

		$resRedirect = $this->changeRedirect($info, 'finalizada');			

		if($resRedirect){
			return  Redirect::to($resRedirect);
		}else{
			return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'cierre'));
		}

	}	

	public function getEspera($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.espera')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'espera'));
	}

	public function getGracias($short_name=""){

		$info=$this->contestInfo($short_name);

		$resRedirect = $this->changeRedirect($info, 'gracias');			

		if($resRedirect){
			return  Redirect::to($resRedirect);
		}else{
			return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'gracias'));	
		}
			
	}

	public function getPrevio($short_name=""){
			
		$info=$this->contestInfo($short_name);

		$resRedirect = $this->changeRedirect($info, 'previo');		
		//se hace el redirect si la funcion regresa la url para redirigir
		//caso contrario se muestra la vista
		if($resRedirect){
			return  Redirect::to($resRedirect);
		}else{
			return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
		}	

	}

	public function getConfirma($short_name=""){
		
		$info=$this->contestInfo($short_name);

		$resRedirect = $this->changeRedirect($info, 'confirma');		

		if($resRedirect){
			return  Redirect::to($resRedirect);
		}else{
			return View::make(Config::get( 'app.main_template' ).'.confirmacion')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'confirmacion'));	
		}

	}

	public function getConcurso($short_name=""){
		
		$info=$this->contestInfo($short_name);

		$resRedirect = $this->changeRedirect($info, 'concurso');		

		if($resRedirect){
			return  Redirect::to($resRedirect);
		}else{

			$insRate = new RateController();
			return $insRate->getContestView($info);		
			//return View::make(Config::get( 'app.main_template' ).'.confirmacion')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'confirmacion'));	
		}

	}

	public function getTest($short_name){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.test')->with(array("short_name"=>$short_name,'contentText'=>$short_name,"info"=>$info,'adUnit'=>'login'));
	}

	public function getFoto($short_name){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.imagen')->with(array("short_name"=>$short_name,'contentText'=>$short_name,"info"=>$info,'adUnit'=>'login'));
	}

	public function getGaleria($short_name){
		echo "Galeria";
	}

	public function getIndex ($short_name=""){

		// var_dump(Session::all());
		// *******************************************
		// Verificar si el concurso existe
		// *******************************************
		if($this->contestExist($short_name)){
			Session::put('user.contest', $short_name); // Establecer el concurso para la sesión
			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

			// *******************************************
			// Verificar si el concurso ya finalizó
			// *******************************************
			if(intval($info->end_date)<= time()){
				return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'cierre'));
			}


			
			// *******************************************
			// Verificar si el concurso ya inicio o esta en previo
			// *******************************************
			if(intval($info->start_date) > time()){
				return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'previo'));
				
			}


			// *******************************************
			// Verificamos si el usuario ya inicio sesión
			// *******************************************
			if (Session::has('user.identifier')){
				// *******************************************
				// El concurso ya inicio 
				// Verificamos si el usuario ya esta registrado
				// *******************************************
				if($this->userIsRegister($info)){
					

					if(intval($info->activation_date) <= time()){
						if ($this->hasPhrase($info)) {
							return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'gracias'));
						}else{
							$insRate = new RateController();
							return $insRate->getContestView($info);
							//return View::make(Config::get( 'app.main_template' ).'.pregunta')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'frase'));
						}
						
					}else{
						return View::make(Config::get( 'app.main_template' ).'.espera')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'espera'));
					}



				// *******************************************
				// Pero el usuario no esta registrado
				// *******************************************
				}else{
					return  Redirect::to($this->nameController($info)."/".$short_name.'/confirma')->with(array('info'=>$info,'contentText'=>$this->infoText($short_name),'adUnit'=>'previo'));
				}

			}else{
				if(isset($info->properties['gigyaOption']) && $info->properties['gigyaOption']=='1'){
					//"Login Gigya";
					return View::make(Config::get( 'app.main_template' ).'.login_gigya')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'login'));
				} else{
					//"Login research";
					return View::make(Config::get( 'app.main_template' ).'.login')->with(array("short_name"=>$short_name,'contentText'=>$this->infoText($short_name),"info"=>$info,'adUnit'=>'login'));
				}
			}


		}else{
			App::abort(404);
		}
		

	}

	private function infoText($short_name){

		if (Cache::has('info_text_'.$short_name)){
    		return Cache::get('info_text_'.$short_name);
		}else{

			$info=$this->contestInfo($short_name);

			$arrayTexts = array('textMechanical','textPhrase','textPrevious','textThanks','textWaiting','textClosure');

			$contentText = new StdClass();

			for ($i=0; $i < count($arrayTexts); $i++) { 
				if (array_key_exists($arrayTexts[$i], $info->properties)) {

				   if(!@file_get_contents($info->properties[$arrayTexts[$i]])){
						$contentText->$arrayTexts[$i] = "";
					}else{
						$contentText->$arrayTexts[$i] = file_get_contents($info->properties[$arrayTexts[$i]]);
					}
				}
			}
			Cache::add('info_text_'.$short_name,$contentText, 180);
			return $contentText;
		}
	}

	protected function changeRedirect($info, $vista){		
		$redirect = '';
		switch($vista){
			case "confirma":				
				if (Session::has('user.identifier')){				
					if($this->userIsRegister($info)){					
						return  $this->nameController($info)."/".$info->short_name.'/';			
					}else{					
						return false;
					}
				}else{
					return  $this->nameController($info)."/".$info->short_name."/";
				}		
				break;
			case"gracias":				
				if (Session::has('user.identifier')){				
					if($this->userIsRegister($info)){					
						if(intval($info->activation_date) <= time()){

							$id_user = Session::get("user.id");
							$insRate = new RateController();
							if (strtolower($info->contest_type)=="foto"){
								$reviewExist =  $insRate->reviewPhotoUp($id_user, $info->id_contest);
							}else{
								$reviewExist =  $insRate->reviewContestAnswer($id_user, $info->id_contest);
							}

							if ($this->hasPhrase($info)==1 || $reviewExist != false) {							
								return false;
							}
							else{
								return $this->nameController($info)."/".$info->short_name."/concurso";
							}
						}else{
							return  $this->nameController($info)."/".$info->short_name.'/espera';				
						}
					}else{					
						return  $this->nameController($info)."/".$info->short_name.'/confirma';			
					}
				}else{
					return  $this->nameController($info)."/".$info->short_name."/";
				}			
				break;

			case "finalizada":
				if(intval($info->end_date)<= time()){
					return false;
				}else{
					return $this->nameController($info)."/".$info->short_name."/";
				}
				break;	

			case "previo":
				if(intval($info->start_date) > time()){		
					return false;						
				}else{
					return $this->nameController($info)."/".$info->short_name."/";
				}

				break;
			case "concurso":
				if (Session::has('user.identifier')){				
					if($this->userIsRegister($info)){					
						if(intval($info->activation_date) <= time()){

							$id_user = Session::get("user.id");
							$insRate = new RateController();
							$reviewExist =  $insRate->reviewContestAnswer($id_user, $info->id_contest);

							if ($this->hasPhrase($info)==1 || $reviewExist != false) {								
								return $this->nameController($info)."/".$info->short_name."/gracias";	
							}
							else{
								return false;
							}
						}else{
							return  $this->nameController($info)."/".$info->short_name.'/espera';				
						}
					}else{					
						return  $this->nameController($info)."/".$info->short_name.'/confirma';			
					}
				}else{
					return  $this->nameController($info)."/".$info->short_name."/";
				}
				break;	

			 default:
			 		return  $this->nameController($info)."/".$info->short_name."/";			 	
			 	break;
		}
		
	}

	public function getKeys($short_name=""){
		//print $short_name;
		$arrayKeys = array('info_text_','promo_', 'promo_info_');
		$tos = array('privacyPolicy','contestRules', 'tos');
		foreach ($arrayKeys as $sukey) {
			$key=$sukey.$short_name;
			echo "<br>".$key."<br>";	
			if (Cache::has($key)){
	    		Cache::forget($key);
	    		echo "key encontrada";
			}else{
				echo "key no existe";
			}
		}
		foreach ($tos as $sukey) {
			$key='contentTost_'.$short_name.'_'.$sukey;
			echo "<br>".$key."<br>";	
			if (Cache::has($key)){
	    		Cache::forget($key);
	    		echo "key encontrada";
			}else{
				echo "key no existe";
			}
		}

	}

	public function postSaveFoto($short_name=""){

		if($this->contestExist($short_name) && Input::get("urlImage")!="" && Input::get("nameImage")!=""){
			$info 	 =	$this->contestInfo($short_name);	// Obtener la inforación del concurso
			$keyword = 	md5(Session::get("user.contest").Session::get("user.email").Session::get("user.firstname").time());
			$urlVoto = 	"foto/".$info->short_name."/vota/".$keyword;
			
			$foto 			= 	new Fotos;
			$foto->user_id		=	Session::get("user.id");
			$foto->contest_id	=	$info->id_contest;
			$foto->foto_url		=	Input::get("urlImage");
			$foto->foto_name	=	Input::get("nameImage");
			$foto->voto_url		=	$urlVoto;
			$foto->keyword		=	$keyword;
			$foto->status		=	1;
			$foto->save();

		    return  Redirect::back();

		}else{
			App::abort(404);
		}
    }

    public function postSaveVideo($short_name=""){

    	if($this->contestExist($short_name) && Input::get("urlVideo")!="" && Input::get("nameVideo")!=""){
	    	$info 	 =	$this->contestInfo($short_name);	// Obtener la inforación del concurso
	    	$keyword = 	md5(Session::get("user.contest").Session::get("user.email").Session::get("user.firstname").time());
	    	$urlVoto = 	"video/".$info->short_name."/vota/".$keyword;

	    	$video 			= 	new Videos;
	    	$video->user_id		=	Session::get("user.id");
	    	$video->contest_id	=	$info->id_contest;
	    	$video->video_url	=	Input::get("urlVideo");
	    	$video->video_name	=	Input::get("nameVideo");
	    	$video->voto_url	=	$urlVoto;
	    	$video->keyword		=	$keyword;
	    	$video->status		=	1;
	    	$video->save();

	    	return  Redirect::back();

	    }else{
	    	App::abort(404);
	    }

	}

	public function postValidaUser($short_name=""){
		if(!$this->contestExist($short_name)) 
			App::abort(404);

		$uid=Input::get('uid');
		
		if(!isset($uid) or $uid=="")
			App::abort(404);

		$userInfo=$this->gigyaUser($uid);
		if (is_object($userInfo)) {
			$this->saveUserInfo($userInfo);
			return 1;
		}else{
			return $userInfo;
		}
		
	}

	private function saveUserInfo($user_profile){
			Session::put('user.uid', $user_profile->getString("UID",""));
			Session::put('user.email', strtolower( trim($user_profile->getString("email",""))));
		    Session::put('user.firstname', $user_profile->getString("firstName",""));   
		    Session::put('user.lastname', $user_profile->getString("lastName",""));
		    $gender = ($user_profile->getString("gender","")=="f") ? "female" : "male" ;
		    Session::put('user.gender', $gender);
		    Session::put('user.country', $user_profile->getString("country",""));
		    Session::put('user.birthday', $user_profile->getString("birthDay",""));
			Session::put('user.birthmonth', $user_profile->getString("birthMonth",""));
			Session::put('user.birthyear', $user_profile->getString("birthYear",""));
			Session::put('user.profileURL', $user_profile->getString("profileURL",""));
		    Session::put('user.photoURL', $user_profile->getString("photoURL",""));
		    Session::put('user.identifier', $user_profile->getString("loginProviderUID",""));
			Session::put('user.provider', $user_profile->getString("loginProvider",""));
			/*Verifica que campos estan vacios y los obtiene del login provider */
			$datos=Session::get('user');
			$user_identities=json_decode($user_profile->getString("identities",""));
			if ($user_identities) {
				foreach ($user_identities as $identity) {
					if ($identity->provider != "site"){
						$provider=$identity;
					}
				}
				if($provider){
					foreach ($datos as $key => $value) {
						if ($value==""){
							foreach ($provider as $clave => $valor) {
								if ($key==strtolower($clave)) {
									Session::put('user.'.$key, $valor);
									break;
								}elseif($key=="identifier" && $clave=="providerUID"){
									Session::put('user.'.$key, $valor);
									break;
								}
							}
						}
					}	
				}
			}

	}

	protected function gigyaUser($uid){
		try {

			$gigyauth 	= Config::get('gigyauth');
			$apiKey 	= $gigyauth["televisa"]["apiKey"];
			$secretKey	= $gigyauth["televisa"]["secretKey"];
			
			// Step 1 - Defining the request
			$method = "socialize.getUserInfo";
			$request = new GSRequest($apiKey,$secretKey,$method);
			
			// Step 2 - Adding parameters
			$request->setParam("uid", $uid);  // set the "uid" parameter to user's ID
			$request->setParam("includeAllIdentities", true); 
			// Step 3 - Sending the request
			$response = $request->send();
			 
			// Step 4 - handling the request's response.
			if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
				return $response;
			}
			else{  // Error
			     log::error("Error on Gigya: " . $response->getErrorMessage());
			     return $response->getErrorMessage();
			}		
		} catch (Exception $e) {
			Log::error("Error on Gigya: " . $e->getMessage());
			return $e->getMessage();
		}
	}

	public function getUser(){
		try {
			
			// Define the API-Key and Secret key (the keys can be obtained from your site setup page on Gigya's website).
			$gigyauth 	= Config::get('gigyauth');
			$apiKey 	= $gigyauth["televisa"]["apiKey"];
			$secretKey	= $gigyauth["televisa"]["secretKey"];
			
			
			// Step 1 - Defining the request
			$method = "socialize.getUserInfo";
			$request = new GSRequest($apiKey,$secretKey,$method);
			
			// Step 2 - Adding parameters
			$uid=Input::get("uid");
			$request->setParam("uid", $uid);  // set the "uid" parameter to user's ID
			$request->setParam("includeAllIdentities", true); 
			// Step 3 - Sending the request
			$response = $request->send();
			
			// Step 4 - handling the request's response.
			if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
				//print_r($response);
				// $user_profile=$response;
				// Session::put('user.email', strtolower( trim($user_profile->getString("email",""))));
		  //       Session::put('user.firstname', $user_profile->getString("firstName",""));   
		  //       Session::put('user.lastname', $user_profile->getString("lastName",""));
		  //       $gender = ($user_profile->getString("gender","")=="f") ? "female" : "male" ;
		  //       Session::put('user.gender', $gender);
		  //       Session::put('user.country', $user_profile->getString("country",""));
		  //       Session::put('user.birthday', $user_profile->getString("birthDay",""));
				// Session::put('user.birthmonth', $user_profile->getString("birthMonth",""));
				// Session::put('user.birthyear', $user_profile->getString("birthYear",""));
				// Session::put('user.profileURL', $user_profile->getString("profileURL",""));
		  //       Session::put('user.photoURL', $user_profile->getString("photoURL",""));
		  //       Session::put('user.uid', $user_profile->getString("UID",""));
		  //       Session::put('user.identifier', $user_profile->getString("loginProviderUID",""));
				// Session::put('user.provider', $user_profile->getString("loginProvider",""));
				// Metodo 1
				// $identities=$user_profile->getArray("identities");
				// for ($i=0; $i < $identities->length(); $i++) { 
				// 	$provider=$identities->getArray($i);
				// 	if($provider->getString("provider")!="site"){
				// 		$loginProvider=json_decode($provider);						
				// 		foreach ($loginProvider as $key => $value) {
				// 			print($key);
				// 		}
				// 	}
				// }
				
				
				// return Session::get('user'); 

				
				return $response;
					}
					else{  // Error
					     log::error("Error on Gigya: " . $response->getErrorMessage());
					     return $response->getErrorMessage();
					}

			
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}




}    