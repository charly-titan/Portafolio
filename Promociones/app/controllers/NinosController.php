<?php

include_once(base_path().'/vendor/gigya/GSSDK.php');

class NinosController extends BaseController {

	public $vista="";

	public function __construct()
    {
		//$this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('force.ssl');
		Config::set('app.main_template', 'promociones2');

		$name= explode("/",Route::getCurrentRoute()->getPath());
		$this->vista=$name[0];

		
        
    }


	public function getIndex($short_name)
	{
		
		if ($short_name=="") {
			Session::put('user.contest', 'versus'); 

			return View::make('promociones.test.versus')->with(array('questionAll'=>$this->questionAll(1)));

		}else{
			// *******************************************
			// Verificar si el concurso existe
			// *******************************************
			if($this->contestExist($short_name)){
				Session::forget('user');
				Session::put('user.promo_type', 'actividad');
				Session::put('user.contest', $short_name);
				Session::put('user.vista', $this->vista);
				$info=$this->contestInfo($short_name); // Obtener la inforación del concurso

				if ($info->contest_type!='versus') {
					App::abort(404);
				}

				// *******************************************
				// Verificar si el concurso ya inicio o esta en previo
				// *******************************************
				if(intval($info->start_date) > time()){
					return "Concurso no ha iniciado";
				}

				Session::put('user.versus_id', $info->id_contest); 
				$id_question= $this->idQuestion($short_name);
				$contestRwd= $this->contestRewards($short_name);
				$point=$this->pointRewards($short_name);
				$category= json_decode($point->categories);
				$UsersTop=$this->topUsers($short_name,$contestRwd->point_id,5,$category);
				
				// *******************************************
				// Verificar si el concurso ya finalizó
				// *******************************************
				if(intval($info->end_date)<= time()){

					$questionAll=$this->questionAll($id_question,$short_name);
		            $votos=$this->countVotos($info->id_contest,$id_question,$questionAll->optionsQuestion,$short_name);//ordena por ganador
		            $questionAll->optionsQuestion=$votos;

		            $option=$questionAll->optionsQuestion[0]["id"];
		        	$optionName=$questionAll->optionsQuestion[0]["text"];

					return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.cierre')
					->with(array("promo_info"=>"1",'movieSelected'=>$option,'optionName'=>$optionName,'questionAll'=>$questionAll,'info'=>$info,'contentText'=>$this->infoText($short_name), 'point'=>$point, 'category'=>$category, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'cierre', 'vista'=>$this->vista));	
	
				}

				// *******************************************
				// Mostrar versus
				// *******************************************
				if(isset($info->properties['gigyaOption']) && $info->properties['gigyaOption']=='1'){
					//"Login Gigya";
					return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.vs2')->with(array('questionAll'=>$this->questionAll($id_question,$short_name),'info'=>$info, 'UsersTop'=>$UsersTop, 'point'=>$point, 'category'=>$category, 'adUnit'=>'gracias', 'vista'=>$this->vista));
				}else{
					//"Login research";
					return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.versus')->with(array('questionAll'=>$this->questionAll($id_question,$short_name),'info'=>$info, 'UsersTop'=>$UsersTop, 'point'=>$point, 'category'=>$category, 'adUnit'=>'versus', 'vista'=>$this->vista, 'contentText'=>$this->infoText($short_name)));
				}	
				
			}else{
				App::abort(404);
			}
		}
		

	}

	public function getMovieSelected($option){
		Session::put('user.contest', 'versus'); 
		Session::put('user.versus', $option); 
		return View::make(Config::get( 'app.main_template' ).'.test.versus')->with(array("promo_info"=>"0",'movieSelected'=>$option,'questionAll'=>$this->questionAll(1)));
	}

	
	protected function questionAll($id_question, $short_name=""){

		/*if (App::environment('local'))
			Cache::forget('questionAll_'.$short_name);*/
		
		if (Cache::has('questionAll_'.$short_name)){
    		return Cache::get('questionAll_'.$short_name);
		}else{

			$question = Question::where('id',$id_question)->get();

			$questionOption = QuestionOptions::select('text','order','img','id')
							->where('question_id',$question[0]->id)
							->where('status',1)
							->orderBy('order','ASC')->get();

			$options = [];
			
			$i=0;
			foreach ($question as $item) {
				foreach ($questionOption as $key => $value) {

	                $options[$i]['text'] = $value->text;
	                $options[$i]['order'] = (int)$value->order;
	                $options[$i]['img'] = $value->img;
	                $options[$i]['id'] = $value->id;
	                $options[$i]['pos'] = (int)$value->order;//sirve solo cuando son 2 imagenes para saber que fondo poner **prueba
	                $i++;
	            }
	            $item['optionsQuestion'] = $options;
			}

			Cache::add('questionAll_'.$short_name,$question[0], 60);
			return 	$question[0];
		}

	}

	public function getGracias($short_name="", $option_id=""){

		if (!getenv("HTTP_REFERER")){
			return  Redirect::to("/".$this->vista."/".$short_name);
		}

		if(($this->contestExist($short_name)) && (in_array($option_id, $this->optionsExist($short_name)))){

			$option=$option_id;
			$info=$this->contestInfo($short_name);
			$id_contest=$info->id_contest;
			$id_question= $this->idQuestion($short_name);
			$contestRwd= $this->contestRewards($short_name);
			$point=$this->pointRewards($short_name);
				
			$category= json_decode($point->categories);
			//$category= Category::where('point_id',$point->id)->orderBy('range_ini','ASC')->get();
			$puntos_user=0;
			

			if ((Session::has('user.identifier')) && ($this->userIsRegister($info))){

				$user_id=Session::get('user.id');
				$voto_id=$this->saveVoto($option,$id_contest,$user_id,$id_question);
				$puntos_user=$this->savePoints($point->id,$user_id, $contestRwd->given_points,$category);
				$UsersTop=$this->topUsers($short_name,$contestRwd->point_id,5,$category);
				
	            Session::put('user.opSelect',$option);
	            $questionAll=$this->questionAll($id_question,$short_name);
	            $votos=$this->countVotos($id_contest,$id_question,$questionAll->optionsQuestion,$short_name);//ordena por ganador
	            $questionAll->optionsQuestion=$votos;

	            $key = array_search($option, array_column($questionAll->optionsQuestion, 'id'));
	        	$optionName=$questionAll->optionsQuestion[$key]["text"];
            
				return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.versus')
					->with(array("promo_info"=>"0",'movieSelected'=>$option,'optionName'=>$optionName,'questionAll'=>$questionAll,'info'=>$info, 'point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'gracias', 'vista'=>$this->vista, 'contentText'=>$this->infoText($short_name)));
			}

			$user_id=0;
			if (!Session::get('user.voto_id')){ 
				$voto_id=$this->saveVoto($option,$id_contest,$user_id,$id_question);
				Session::put('user.voto_id',$voto_id);
			}
			$UsersTop=$this->topUsers($short_name,$point->id,5,$category);
			
			

			if((Session::get('user.provider')=='Twitter') && Session::get("user.email")==""){
					Session::put('user.activated', 'true');
					//return Session::all();
			}

	        Session::put('user.opSelect',$option);
	        $questionAll=$this->questionAll($id_question,$short_name);
	        $votos=$this->countVotos($id_contest,$id_question,$questionAll->optionsQuestion,$short_name);//ordena por ganador
	        $questionAll->optionsQuestion=$votos;

	        $key = array_search($option, array_column($questionAll->optionsQuestion, 'id'));
	        $optionName=$questionAll->optionsQuestion[$key]["text"];
			
			if(isset($info->properties['gigyaOption']) && $info->properties['gigyaOption']=='1'){
				return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.marcador')
					->with(array("promo_info"=>"1",'movieSelected'=>$option,'optionName'=>$optionName,'questionAll'=>$questionAll,'info'=>$info, 'point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'gracias', 'vista'=>$this->vista));	
			}else{
				return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.versus')
					->with(array("promo_info"=>"1",'movieSelected'=>$option,'optionName'=>$optionName,'questionAll'=>$questionAll,'info'=>$info, 'point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'gracias', 'vista'=>$this->vista, 'contentText'=>$this->infoText($short_name)));	
			}			
				
			
		}else{
			App::abort(404);
		}
	}

	public function getResultado($short_name=""){

		if(!$this->contestExist($short_name)) 
			App::abort(404);

		if(Session::has('user.identifier') && Session::has('user.opSelect')){
				
				$option 	=	Session::get('user.opSelect');
				$info=$this->contestInfo($short_name);
				$id_contest=$info->id_contest;
				$id_question= $this->idQuestion($short_name);
				$contestRwd= $this->contestRewards($short_name);
				$point=$this->pointRewards($short_name);
				$category= json_decode($point->categories);
			
				$puntos_user=0;
				
				
				if(!($this->userIsRegister($info)))
					$this->userRegister($info);
				
				if($this->userIsRegister($info)){
						$user_id=Session::get('user.id');
						$voto_id=$this->saveVoto($option,$id_contest,$user_id,$id_question);
						$puntos_user=$this->savePoints($point->id,$user_id, $contestRwd->given_points, $category);
						$UsersTop=$this->topUsers($short_name,$point->id,5,$category);
						
			            Session::put('user.opSelect',$option);
			            $questionAll=$this->questionAll($id_question,$short_name);
			            $votos=$this->countVotos($id_contest,$id_question,$questionAll->optionsQuestion,$short_name);//ordena por ganador
	        			$questionAll->optionsQuestion=$votos;

	        			$key = array_search($option, array_column($questionAll->optionsQuestion, 'id'));
	        			$optionName=$questionAll->optionsQuestion[$key]["text"];
		            
						return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.versus')
							->with(array("promo_info"=>"0",'movieSelected'=>$option, 'optionName'=>$optionName,'questionAll'=>$questionAll,'info'=>$info, 'point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'gracias', 'vista'=>$this->vista));
				}
				
				$UsersTop=$this->topUsers($short_name,$point->id,5,$category);
				
			    Session::put('user.opSelect',$option);
			    $questionAll=$this->questionAll($id_question,$short_name);
			    $votos=$this->countVotos($id_contest,$id_question,$questionAll->optionsQuestion,$short_name);//ordena por ganador
	        	$questionAll->optionsQuestion=$votos;
		        //return Session::all();
		        if((Session::get('user.provider')=='Twitter') && Session::get("user.email")==""){
					Session::put('user.activated', 'true');
					
				}

				$key = array_search($option, array_column($questionAll->optionsQuestion, 'id'));
	        	$optionName=$questionAll->optionsQuestion[$key]["text"];

				return View::make(Config::get( 'app.main_template' ).".".$this->vista.'.versus')->with(array("promo_info"=>"1",'movieSelected'=>$option, 'optionName'=>$optionName,'questionAll'=>$this->questionAll($id_question,$short_name),'info'=>$info, 'point'=>$point, 'category'=>$category, 'puntos_user'=>$puntos_user, 'UsersTop'=>$UsersTop, 'contestRwd'=>$contestRwd, 'adUnit'=>'gracias', 'vista'=>$this->vista));

			
		}else{
			return  Redirect::to("/".$this->vista."/".$short_name);
		}
	}

	public function postConfirma($short_name=""){

		if(!$this->contestExist($short_name)) 
			App::abort(404);

		$values = array(        
	        'nombre' 	=>  Input::get('usrname'),
	        'apellido' 	=>  Input::get('lastname'),
	        'email'		=>	Input::get('email'),
	        'genero'	=>  Input::get('genero')
	    );
    	$format = array(
		        'nombre' 	=>  'required',
		        'apellido' 	=>  'required',
		        'email'		=>	'required|email',
		        'genero'	=>  'required',
		);

    	$validator = Validator::make(
		 	$values   ,  $format
		);

    	if ($validator->fails()){
    		return  Redirect::back()->withErrors($validator);
		}
		if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
			Session::put("user.email", strtolower( trim( Input::get('email'))));
			Session::put("user.firstname", Input::get('usrname'));
			Session::put("user.lastname", Input::get('lastname'));
			Session::put("user.gender", Input::get('genero'));
		}

		$info=$this->contestInfo($short_name);

		if(!($this->userIsRegister($info)))
			$this->userRegister($info);

		Session::forget('user.activated');
				
		return  Redirect::to("/".$this->vista."/".$short_name."/resultado");
		
	}

	public function postPuntosShare($short_name=""){
		
		if(!$this->contestExist($short_name)) 
			App::abort(404);

		if(Session::has("user_id") && Session::get("user_id")!=''){
			$user_id=Session::get("user_id");
			$contestRwd= $this->contestRewards($short_name);
			$point=$this->pointRewards($short_name);
			$category= json_decode($point->categories);
			$puntos_user=$this->savePoints($point->id,$user_id, $contestRwd->share_points,$category);
			return $puntos_user;
		}
		
		return 0;

	}

	public function postValidaUser($short_name=""){

		if(!$this->contestExist($short_name)) 
			App::abort(404);
		
		if(Session::has('user.opSelect')){
			//uid_user  
			$uid=Input::get('uid');

			$userInfo=$this->gigyaUser($uid);

			if (is_object($userInfo)) {
				//print_r($userInfo);
				$nickname =$userInfo->getString("nickname","");
				if($nickname=='')
					return "El usuario no está conectado";

				$this->saveUserInfo($userInfo);

				$info=$this->contestInfo($short_name);
				if(!($this->userIsRegister($info)))
					$this->userRegister($info);

				/**************************************************/
				######################################################		
				//$id_contest=$info->id_contest;
				$id_question= Question::select('id')->where('contest_id',$info->id_contest)->first();
				$contestRwd= ContestRewards::where('contest_id',$info->id_contest)->first();
				$point=Points::where('id',$contestRwd->point_id)->first();
				$category= json_decode($point->categories);
				
				$puntos_user=0;
					
				if($this->userIsRegister($info)){
					
					$option 	=	Session::get('user.opSelect');
					$user_id=Session::get('user.id');
					$voto_id=$this->saveVoto($option,$info->id_contest,$user_id,$id_question->id);
					$puntos_user=$this->savePoints($point->id,$user_id, $contestRwd->given_points,$category);
							//$UsersTop=$this->topUsers($point->id,5);
				    Session::forget('user.opSelect');
				            //$questionAll=$this->questionAll($id_question->id);
				            //$votos=$this->countVotos($info->id_contest,$id_question->id,$questionAll->optionsQuestion);//ordena por ganador
		        			//$questionAll->optionsQuestion=$votos;
			        Session::forget('user');    
					return array('point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'contestRwd'=>$contestRwd);
					//return "hola";
					
				}else{
					return "Problemas al registrar el usuario";
				}
				########################################################
				###########################################################
				
			}else{// Error
				return $userInfo;
			}
		}else{
			return "ya se registro el voto";
		}
		
	}

	public function getUserGigya($short_name=""){

		if(!$this->contestExist($short_name)) 
			App::abort(404);
		
		//if(Session::has('user.opSelect')){
			//uid_user  
			//$uid="_guid_CvwC3UAPX8_DpPcANeaQV45OUzFBmh9b83T4v1-b-yo=";//g+
			//$uid = "_guid_0ptQ-xlXNCFNA40vyX9Qxg=="; //Face
			$uid="_guid_g9GSVxoG9Dk7whbNkZdz-0Iso3Klz_sSYpYyOeI78hY=";// tw

			$userInfo=$this->gigyaUser($uid);
			print_r($userInfo);
			//echo gettype($userInfo);

			if (is_object($userInfo)) {
				//print_r($userInfo);
				$nickname =$userInfo->getString("nickname","");
				if($nickname=='')
					return "El usuario no está conectado";

				$this->saveUserInfo($userInfo);
				return Session::all();
				$info=$this->contestInfo($short_name);
				if(!($this->userIsRegister($info)))
					$this->userRegister($info);

				/**************************************************/
				######################################################		
				//$id_contest=$info->id_contest;
				$id_question= Question::select('id')->where('contest_id',$info->id_contest)->first();
				$contestRwd= ContestRewards::where('contest_id',$info->id_contest)->first();
				$point=Points::where('id',$contestRwd->point_id)->first();
				$category= json_decode($point->categories);
				
				$puntos_user=0;
					
				if($this->userIsRegister($info)){

					$option 	=	Session::get('user.opSelect');
					$user_id=Session::get('user.id');
					$voto_id=$this->saveVoto($option,$info->id_contest,$user_id,$id_question->id);
					$puntos_user=$this->savePoints($point->id,$user_id, $contestRwd->given_points,$category);
							//$UsersTop=$this->topUsers($point->id,5);
				    Session::forget('user.opSelect');
				            //$questionAll=$this->questionAll($id_question->id);
				            //$votos=$this->countVotos($info->id_contest,$id_question->id,$questionAll->optionsQuestion);//ordena por ganador
		        			//$questionAll->optionsQuestion=$votos;
			            
					return array('info'=>$info, 'point'=>$point, 'category'=>$category,'puntos_user'=>$puntos_user, 'contestRwd'=>$contestRwd);
				}
				########################################################
				###########################################################
				
			}else{// Error
				return $userInfo;
			}
		// }else{
		// 	return "ya se registro el voto";
		// } 
		 	
	}

	private function saveUserInfo($user_profile){
        Session::put('user.email', strtolower( trim($user_profile->getString("email",""))));
        if(Session::get('user.provider')=="Twitter"){
            Session::put('user.firstname', "");   
            Session::put('user.lastname', "");
        }else{
            Session::put('user.firstname', $user_profile->getString("firstName",""));   
            Session::put('user.lastname', $user_profile->getString("lastName",""));
        }
        $gender = ($user_profile->getString("gender","")=="f") ? "female" : "male" ;
        Session::put('user.gender', $gender);
        Session::put('user.country', $user_profile->getString("country",""));
        //Session::put('user.birthday', $user_profile->getString("firstName",""));
		//Session::put('user.birthmonth', $user_profile->getString("firstName",""));
		//Session::put('user.birthyear', $user_profile->getString("firstName",""));
		Session::put('user.profileURL', $user_profile->getString("profileURL",""));
        Session::put('user.photoURL', $user_profile->getString("photoURL",""));
        Session::put('user.uid', $user_profile->getString("UID",""));
        Session::put('user.identifier', $user_profile->getString("loginProviderUID",""));
		Session::put('user.provider', $user_profile->getString("loginProvider",""));
        

	}

	protected function gigyaUser($uid){
		try {
			// Define the API-Key and Secret key (the keys can be obtained from your site setup page on Gigya's website).
			$apiKey = "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF";
			$secretKey = "QONNYe+U07oGe0HfoPWgoDQrj4PLlJlWq9XdkkcOilM=";
			 
			// Step 1 - Defining the request
			$method = "socialize.getUserInfo";
			$request = new GSRequest($apiKey,$secretKey,$method);
			
			// Step 2 - Adding parameters
			$request->setParam("uid", $uid);  // set the "uid" parameter to user's ID
			 
			// Step 3 - Sending the request
			$response = $request->send();
			 
			// Step 4 - handling the request's response.
			if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
				 
				/*La primera interacción con Gigya debe ser siempre de iniciar sesión. 
				  Si el usuario no está conectado, no se puede tener acceso a su perfil social
				  ni realizar actividades sociales, tales como la definición de su estatus.*/
				return $response;
				
			}
			else{  // Error
			     //echo ("Got error on setStatus: " . $response->getErrorMessage());
			     //error_log($response->getLog());
			     return $response->getErrorMessage();
			}
			
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}




	public function saveVoto($option,$id_contest,$user_id,$id_question){

		try {
			if (!$user_id) {
				
				$versus 			= 	new Versuss;
				$versus->contest_id	=	$id_contest;
				$versus->question_id=	$id_question;
				$versus->option_id 	=	$option;
				$versus->votos 		=	1;
				$versus->ip 		=	$this->getRealIP();
				$versus->browser 	=	$this->getBrowser();
				$versus->save();

				return $versus->id;

			}elseif (Session::has('user.voto_id')){ //asignamos el voto al usuario
				
				$versus 		 = 	Versuss::where('id',Session::get('user.voto_id'))->first();
				$versus->user_id =	$user_id;
				$versus->save();

				return $versus->id;

			} else {

				$versus 			= 	new Versuss;
				$versus->contest_id	=	$id_contest;
				$versus->user_id 	=	$user_id;
				$versus->question_id=	$id_question;
				$versus->option_id 	=	$option;
				$versus->votos 		=	1;
				$versus->ip 		=	$this->getRealIP();
				$versus->browser 	=	$this->getBrowser();
				$versus->save();

				return $versus->id;
			}
		} catch (Exception $e) {
			Log::error($e);
			return 0;
			
		}
		
	}

	public function savePoints($id_point,$user_id,$points,$category){

		try{
			$rewards	=	UserRewards::where('user_id', $user_id)
							-> where('point_id', $id_point)
							->first();
						
			if(is_null($rewards) or !count($rewards)){
				$rewards 			=	new UserRewards;
				$rewards->user_id 	= 	$user_id;
				$rewards->point_id= 	$id_point;
				$rewards->points 	= 	$points;
				$rewards->save();

				return $rewards->points;

			}else{
				$puntos_user = $rewards->points + $points;
				$tope=0;
				foreach ($category as $value) {
					if (($puntos_user>=$value->range_ini) &&($puntos_user<=$value->range_fin)) {
						$tope=0;
						break;
					} else {
						$tope=$value->range_fin;
					}
				}
				if ($tope) {
					$rewards->points =	$tope;	
				}else{
					$rewards->points =	$puntos_user;	
				}
				
				$rewards->save();
				return $rewards->points;
			}
		} catch (Exception $e) {
			Log::error($e);
			return 0;	
		}

	}

	
	public function countVotos($id_contest,$id_question, $optionOrder, $short_name){

		if (Cache::has('countVotos_'.$short_name)){
    		return Cache::get('countVotos_'.$short_name);
		}else{
				$votos = DB::table('versus')
	                     ->select(DB::raw('sum(votos) as total, option_id'))
	                     ->where('contest_id', $id_contest)
	                     ->where('question_id', $id_question)
	                     ->groupBy('option_id')
	                     ->orderBy('total','desc')
	                     ->get();

	            foreach ($optionOrder as $key=>&$value) {
	            	$i=1;
	            	foreach ($votos as $pos => $ele) {
	            		if ($value['id']==$ele->option_id) {
	            			$value['order']=$i;
	            		}
	            		$i++;
	            	}            	
	            }
	            
	            usort($optionOrder, function($a, $b) {
				    return $a['order'] - $b['order'];
				});

				Cache::add('countVotos_'.$short_name,$optionOrder, 5);
				return $optionOrder;
		}

	}

	

	public function topUsers($short_name,$point_id,$num=5,$category){

		// if (App::environment('local'))
		// 	Cache::forget('topUsers_'.$short_name);

		if (Cache::has('topUsers_'.$short_name)){
    		return Cache::get('topUsers_'.$short_name);
		}else{

			$users = DB::table('user_rewards')
			            ->join('users', 'users.id', '=', 'user_rewards.user_id')
			            ->join('social_network', 'social_network.user_id', '=', 'user_rewards.user_id' )
			            ->where('point_id',$point_id)
			            ->select('email_hash', 'first_name', 'last_name', 'points', 'social_id', 'social_network','photo_url')
			            ->orderBy('points','desc')
		                ->take($num)
			            ->get();
			$data = [];
			
			$i=0;
			foreach ($users as $user) {
				$data[$i]['email'] = Crypt::decrypt($user->email_hash);
	            $data[$i]['name'] = Crypt::decrypt($user->first_name).' '.Crypt::decrypt($user->last_name);
	            $tope=0;
				foreach ($category as $value) {
					if (($user->points>=$value->range_ini) &&($user->points<=$value->range_fin)) {
						$tope=0;
						break;
					} else {
						$tope=$value->range_fin;
					}
				}
				if ($tope) {
					$data[$i]['points'] =	$tope;	
				}else{
					$data[$i]['points'] = $user->points;
				}
	            
	            $data[$i]['social_id'] = $user->social_id;
	            $data[$i]['social_network'] = $user->social_network;
	            $data[$i]['photo_url'] = $user->photo_url;
	            $i++;
	        }
	        
	        Cache::add('topUsers_'.$short_name,$data, 10);
			return 	$data;
		}

	}

	public function getRealIP() {
	    
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        return $_SERVER['HTTP_CLIENT_IP'];
	       
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	   
	    return $_SERVER['REMOTE_ADDR'];
	}

	public function getBrowser() {
	    
	    return $_SERVER['HTTP_USER_AGENT'];
	}

	protected function pointRewards($short_name){
		
		// if (App::environment('local'))
		// 	Cache::forget('pointRwd_'.$short_name);
		
		if (Cache::has('pointRwd_'.$short_name)){
    		return Cache::get('pointRwd_'.$short_name);
		}else{

			$contestRwd=$this->contestRewards($short_name);
			$point=Points::where('id',$contestRwd->point_id)->first();
			
			Cache::add('pointRwd_'.$short_name,$point, 60);
			return $point;
		}
	}
	

	protected function contestRewards($short_name){
		
		// if (App::environment('local'))
		// 	Cache::forget('contestRwd_'.$short_name);
		
		if (Cache::has('contestRwd_'.$short_name)){
    		return Cache::get('contestRwd_'.$short_name);
		}else{

			$info=$this->contestInfo($short_name);
			$contestRwd= ContestRewards::where('contest_id',$info->id_contest)->first();
			
			Cache::add('contestRwd_'.$short_name,$contestRwd, 60);
			return $contestRwd;
		}
	}

	protected function idQuestion($short_name){
		
		// if (App::environment('local'))
		// 	Cache::forget('idQuestion_'.$short_name);
		
		if (Cache::has('idQuestion_'.$short_name)){
    		return Cache::get('idQuestion_'.$short_name);
		}else{

			$info=$this->contestInfo($short_name);
			$id_question= Question::select('id')->where('contest_id',$info->id_contest)->first();
			
			Cache::add('idQuestion_'.$short_name,$id_question->id, 60);
			return $id_question->id;
		}
	}

	protected function optionsExist($short_name){
		
		// if (App::environment('local'))
		// 	Cache::forget('options_'.$short_name);

		if (Cache::has('options_'.$short_name)){
    		return Cache::get('options_'.$short_name);
		}else{

			$info=$this->contestInfo($short_name);
			$results =  DB::connection('mysql2')
						->select('SELECT qo.id FROM questions_options as qo, questions as q where qo.question_id=q.id and q.contest_id=?', array($info->id_contest));
			$options=[];
			foreach ($results as $key => $value) {
				$options[]=$value->id;
			}
			Cache::add('options_'.$short_name,$options, 60);
			return $options;
		}
	}

	protected function contestExist($short_name){
		// if (App::environment('local'))
		// 	Cache::forget('promo_'.$short_name);
		
		if (Cache::has('promo_'.$short_name)){
    		return Cache::get('promo_'.$short_name);
		}else{
			
			$number=Contest::where("short_name",$short_name)->count();
			Cache::add('promo_'.$short_name,$number, 60);
			return $number;
		}
	}

	protected function contestInfo($short_name){
		// if (App::environment('local'))
		// 	Cache::forget('promo_info_'.$short_name);
		
		if (Cache::has('promo_info_'.$short_name)){
    		return Cache::get('promo_info_'.$short_name);
		}else{
			$info=Contest::where("short_name",$short_name)->get();

			$propertie= DB::connection('mysql2')->table('contest_properties')
												->select('property_name','property_value')
												->where('id_contest',$info[0]->id_contest)
												->get();

			$urlActual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$properties = [];
                foreach($info as $item) {
                    foreach ($propertie as $key => $value) {
                    	$item['urlActual'] = $urlActual;
                        $properties[$value->property_name] = $value->property_value;
                    }
                    $item['properties'] = $properties;
                }

			Cache::add('promo_info_'.$short_name,$info[0], 60);
			return $info[0];
		}
	}

	protected function userIsRegister($contest){

		$user = DB::table('social_network')->where('contest_id', $contest->id_contest)
		->where('social_id', Session::get("user.identifier"))		
		->first();
		
		if(is_null($user)){
			//if(Session::get("user.provider")!="Twitter"){
			$user_exist = DB::table('users')->where('contest_id', $contest->id_contest)
			->where('email', md5(Session::get("user.email")))		
			->first();
				if(is_null($user_exist)){
					return 0;
				}else{
					Session::put("user.id",$user_exist->id);
					if(Session::get("user.provider")=="Twitter"){
						Session::put("user.email",Crypt::decrypt($user_exist->email_hash));
						Session::put("user.firstname",Crypt::decrypt($user_exist->first_name));
						Session::put("user.lastname",Crypt::decrypt($user_exist->last_name));
					}
					return 1;
				}
			/*}else{
				return 0;
			}*/

			
		}else{
			Session::put("user.id",$user->user_id);
			if(Session::get("user.provider")=="Twitter"){
				$user_exist = DB::table('users')->where('contest_id', $contest->id_contest)->where('id', $user->user_id)->first();
				Session::put("user.email",Crypt::decrypt($user_exist->email_hash));
				Session::put("user.firstname",Crypt::decrypt($user_exist->first_name));
				Session::put("user.lastname",Crypt::decrypt($user_exist->last_name));
			}
			return 1;	
		}
	}

	protected function userRegister($info){
		try {
			
			if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
	    		//es twiter
	    		return false; //Session::all();
	    	}

	    	if(isset($info->properties['gigyaOption']) && $info->properties['gigyaOption']=='1'){
	    		$user_guid=Session::get("user.uid");
	    	}else{
				$user_guid = sha1(Session::get("user.firstname").time().rand(5, 15));
			}
			
			$user_exist = DB::table('users')->where('contest_id', $info->id_contest)
			->where('email', md5(Session::get("user.email")))		
			->first();


			if(is_null($user_exist)){
				$user = new User;
				$user->user_guid = $user_guid;
				$user->email = md5(Session::get("user.email"));
				$user->email_hash =	Crypt::encrypt(Session::get("user.email"));
				$user->password = Hash::make(sha1(Session::get("user.email").time().rand(5, 15)));
				$user->activated = true;
				$user->first_name = Crypt::encrypt(Session::get("user.firstname"));
				$user->last_name = Crypt::encrypt(Session::get("user.lastname"));
				$user->gender = Session::get("user.gender");
				$user->country=Session::get("user.country");
				/*$user->state=Input::get("estados");
				$user->birthdate=$birthdate;
				$user->age=$age;
				$user->tel = Crypt::encrypt(Input::get("tel"));*/
				$user->contest=$info->short_name;
				$user->contest_id=$info->id_contest;
				$user->save();

				Session::put("user.id",$user->user_id);
				
				$social = new Socialnet;
				$social->social_id=Session::get("user.identifier");
				$social->user_id=$user->id;
				$social->user_guid=$user_guid;
				$social->contest_id=$info->id_contest;
				$social->contest=$info->short_name;
				$social->social_network = Session::get("user.provider");
				$social->profile_url = Session::get("user.profileURL");
				$social->photo_url = str_replace("http://", "https://", Session::get("user.photoURL"));
				$social->save();
			}else{

				$user_social = DB::table('social_network')->where('contest_id', $contest->id_contest)
						       ->where('social_id', Session::get("user.identifier"))		
						       ->first();

				if(is_null($user_social)){
					$social = new Socialnet;
					$social->social_id=Session::get("user.identifier");
					$social->user_id=$user_exist->id;
					$social->user_guid=$user_exist->user_guid;
					$social->contest_id=$info->id_contest;
					$social->contest=$info->short_name;
					$social->social_network = Session::get("user.provider");
					$social->profile_url = Session::get("user.profileURL");
					$social->photo_url = str_replace("http://", "https://", Session::get("user.photoURL"));
					$social->save();
				}

				Session::put("user.id",$user_exist->user_id);
				
			}
			
			/*Session::put("user.firstname", Input::get("nombres"));
			Session::put("user.lastname", Input::get("apellidos"));*/

				return  1;
		} catch (Exception $e) {
			Log::error($e);
			return 1;
		}
	}


	public function getKeys($short_name=""){
		//print $short_name;
		$arrayKeys = array('questionAll_','topUsers_', 'pointRwd_','contestRwd_', 'idQuestion_', 'options_', 'promo_', 'promo_info_', 'countVotos_', 'info_text_');
		
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
			Cache::add('info_text_'.$short_name,$contentText, 60);
			return $contentText;
		}
	}

	


}	