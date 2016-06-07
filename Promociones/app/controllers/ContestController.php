<?php

class ContestController extends BaseController {


	public function __construct()
    {
		//$this->beforeFilter('auth', array('except' => array('getIndex','postConfirmData','postSavePhrase','getConfirma','getAvisoPrivacidad','getBasesConcurso','getTerminosCondiciones','getAutorizacion','getPrueba','getPrueba1','getTest','getFoto','getGaleria','postUploadimg','getImagen','getVotacion', 'getConteo', 'postSaveQuizz')));
        $this->beforeFilter('csrf', array('on' => 'post', 'except' => array('postValidaUser','postUploadimg')));
        $this->beforeFilter('force.ssl');

    }

    

    public function postSavePhrase($short_name=""){
    	if($this->contestExist($short_name)){

    		$info=$this->contestInfo($short_name);

    		if($info->end_date >= strtotime(date('Y-m-d h:i:s'))){
    			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso
	    		$phrase = new Phrase;
	    		$phrase->user_id=Session::get("user.id");
	    		$phrase->contest_id= $info->id_contest;
	    		$phrase->phrase=Input::get('nombres');
	    		$phrase->save();
    		}
    		
    		return  Redirect::to($this->nameController($info)."/".$short_name);	
    	}
    }


    public function postConfirmData($short_name=""){

    	$op = strstr(Input::get('date'), '-');
    	if ($op)
			$d = explode("-", Input::get('date'));
		else
			$d = explode("/", Input::get('date'));

		if(strlen($d[0])>3){
			$datetem = $d[2]."/".$d[1]."/".$d[0];
		}else{
			$datetem =  Input::get('date');
		}
			
		
    	if($this->contestExist($short_name)){


    	$values = array(        
		        'nombres' 	=>  Input::get('nombres'),
		        'apellidos' =>  Input::get('apellidos'),
		        'genero'	=>  Input::get('genero'),
		        'date'		=>	$datetem,
		        'pais'		=>	Input::get('pais'),
		        'estados'	=>	Input::get('estados'),
		        'tel'		=>	Input::get('tel')
		    );
    	$format = array(
		        'nombres' 	=>  'required',
		        'apellidos' =>  'required',
		        'genero'	=>  'required',
		        'date'		=>	'required|date_format:"d/m/Y"',
		        'pais'		=>	'required',
		        'estados'	=>	'required',
		        'tel'		=>	'required'
		    );


    	if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
    		$values["email"]=Input::get('email');
    		$format["email"]='required|email';
    		
    	}

    	$validator = Validator::make(
		 	$values   ,  $format
		);
    	
    	if ($validator->fails()){
    		$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso
    		return  Redirect::to($this->nameController($info)."/".$short_name.'/confirma')->withErrors($validator);
		}
		if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
			Session::put("user.email", strtolower( trim( Input::get('email'))));
		}
		$birthdate = date("Y-m-d", strtotime(str_replace('/', '-',$datetem)));
		$tz  = new DateTimeZone(Config::get( 'app.timezone' ));
		$age= DateTime::createFromFormat('d/m/Y', $datetem, $tz)->diff(new DateTime('now', $tz))->y;
		$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

		if(isset($info->properties['gigyaOption']) && $info->properties['gigyaOption']=='1'){
    		$user_guid=Session::get("user.uid");
    	}else{
			$user_guid = sha1(Input::get("nombres").time().rand(5, 15));
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
			$user->first_name = Crypt::encrypt(Input::get("nombres"));
			$user->last_name = Crypt::encrypt(Input::get("apellidos"));
			$user->gender = Input::get("genero");
			$user->country=Input::get("pais");
			$user->state=Input::get("estados");
			$user->birthdate=$birthdate;
			$user->age=$age;
			$user->tel = Crypt::encrypt(Input::get("tel"));
			$user->contest=$info->short_name;
			$user->contest_id=$info->id_contest;
			$user->save();

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
		
		Session::put("user.firstname", Input::get("nombres"));
		Session::put("user.lastname", Input::get("apellidos"));

			return  Redirect::to($this->nameController($info)."/".$short_name);
		}
//  [user] => Array
        // (
        //     [contest] => rapidos
        //     [provider] => Twitter
        //     [email] => elgabo1@gmail.com
        //     [firstname] => esmas apps
        //     [lastname] => 
        //     [birthday] => 
        //     [birthmonth] => 
        //     [birthyear] => 
        //     [identifier] => 121895714
        // )

		// $table->increments('id');
		// 	$table->bigInteger('social_id');
		// 	$table->bigInteger('user_id');
		// 	$table->string('user_guid');
		// 	$table->bigInteger('contest_id');
		// 	$table->string('social_network');
		// 	$table->string('contest')->nullable();

		// Array ( [_token] => iTyuGo2120luFuTFPAdz9XuG5HYpxAQo4Hfm7mwU 
		// 	[email] => gabriel@gmancera.com 
		// 	[nombres] => Gabriel 
		// 	[apellidos] => Hernandez 
		// 	[genero] => male 
		// 	[date] => 13/06/1983 
		// 	[pais] => MX 
		// 	[estados] => Distrito Federal 
		// 	[tel] => (015) 5526136 
		// 	[condiciones] => 
		// 	[aviso] => 
		// 	[confirmar] => CONFIRMAR )

		// $table->increments('id');
		// 	$table->string('user_guid');
		// 	$table->string('email');
		// 	$table->string('email_hash');
		// 	$table->string('password');
		// 	$table->text('permissions')->nullable();
		// 	$table->boolean('activated')->default(0);
		// 	$table->string('activation_code')->nullable();
		// 	$table->timestamp('activated_at')->nullable();
		// 	$table->timestamp('last_login')->nullable();
		// 	$table->string('persist_code')->nullable();
		// 	$table->string('reset_password_code')->nullable();
		// 	$table->mediumText('first_name')->nullable();
		// 	$table->mediumText('last_name')->nullable();
		// 	$table->enum('gender', array('male', 'female'));
		// 	$table->string('country')->nullable();
		// 	$table->string('state')->nullable();
		// 	$table->integer('age')->nullable();
		// 	$table->date('birthdate')->nullable();
		// 	$table->string('contest')->nullable();
		// 	$table->bigInteger('contest_id')->nullable();

    }

    public function postSaveQuizz($short_name=""){
    	
    	$infoPost = Input::all();    	
    	
    	$infoContest = $this->contestInfo($short_name);
		
		$insRate = new RateController();
		return $insRate->saveDataQuizz($infoContest, $infoPost);

    }

    private function loginUser($email){

        //     [contest] => rapidos
        //     [provider] => Twitter
        //     [email] => elgabo1@gmail.com
        //     [firstname] => esmas apps
        //     [lastname] => 
        //     [birthday] => 
        //     [birthmonth] => 
        //     [birthyear] => 
        //     [identifier] => 121895714
    }

    public function getAvisoPrivacidad($short_name){
    	$info=$this->contestInfo($short_name);
    	return View::make(Config::get( 'app.main_template' ).'.avisoPrivacidad')->with(array("short_name"=>$short_name,"contentPrivacyPolicy"=>$this->contentTost($short_name,'privacyPolicy'),"info"=>$info,'adUnit'=>'avisoPrivacidad'));
    }
    
    public function getBasesConcurso($short_name){
    	$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.basesConcurso')->with(array("short_name"=>$short_name,"contentBasesConcurso"=>$this->contentTost($short_name,'contestRules'),"info"=>$info,'adUnit'=>'basesConcurso'));
    }

    public function getTerminosCondiciones($short_name){
    	$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.terminosCondiciones')->with(array("short_name"=>$short_name,"contentTerminosCond"=>$this->contentTost($short_name,'tos'),"info"=>$info,'adUnit'=>'TOS'));
	}


	public function getConfirma($short_name=""){

		if($this->contestExist($short_name)){
			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

			if($this->userIsRegister($info)){
				return  Redirect::to($this->nameController($info)."/".$short_name);
			}else{
				return View::make(Config::get( 'app.main_template' ).'.confirmacion')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'confirmacion'));	
			}
		}	
	}


	public function getFinalizada($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
	}


	public function getAutorizacion($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.permiso')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
	}


	public function getEspera($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.espera')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'espera'));
	}

	public function getGracias($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'gracias'));
	}

	public function getPregunta($short_name=""){		
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.pregunta')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'frase'));
	}

	public function getPrevio($short_name=""){
		$info=$this->contestInfo($short_name);
		return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
	}

	public function getConteo($short_name=""){
		$info=$this->contestInfo($short_name);
		$insRate = new RateController();

		$conteoData['conteo'] = $insRate->obtenerConteo($info->id_contest);
		$infoQuestion = $insRate->getInfoQuestion($info->id_contest);
		$conteoData['question'] = $infoQuestion[0];
		$options = $insRate->getOptionsQuestion($infoQuestion[0]->id);
		foreach($options as $option){
			$conteoData['options'][$option->id]=$option->text;
		}		
		return View::make(Config::get( 'app.main_template' ).'.conteo')->with(array("short_name"=>'rapidos',"info"=>$info,'conteo'=>$conteoData,'adUnit'=>'gracias'));		
	}

	public function getVotacion($short_name="", $question_id="", $option_id=""){
		$info=$this->contestInfo($short_name);
		
		$user_id = Session::get("user.id");		
		$contest_id = $info->id_contest;
		
		$insRate = new RateController();
		$result = $insRate->insertAnswerOption($contest_id, $user_id, $question_id, $option_id, 'versus');				

		return  Redirect::to($this->nameController($info)."/".$short_name."/conteo");		
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
				return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
			}


			
			// *******************************************
			// Verificar si el concurso ya inicio o esta en previo
			// *******************************************
			if(intval($info->start_date) > time()){
				return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
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
							return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'gracias'));
						}else{
							return View::make(Config::get( 'app.main_template' ).'.pregunta')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'frase'));
						}
						
					}else{
						return View::make(Config::get( 'app.main_template' ).'.espera')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'espera'));
					}



				// *******************************************
				// Pero el usuario no esta registrado
				// *******************************************
				}else{
					return  Redirect::to($this->nameController($info)."/".$short_name.'/confirma')->with(array('info'=>$info,'adUnit'=>'previo'));
				}

			}else{
				return View::make(Config::get( 'app.main_template' ).'.login')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'login'));
			}

			// if(intval($info->activation_date) >= time()){
				
			// 	exit("Activado");
			 	
			//  	if (Session::has('user.identifier'))
			// 	{
			// 		if($this->userIsRegister($info)){

			// 			if($info->start_date <= time()){
			// 				return View::make(Config::get( 'app.main_template' ).'.login')->with("short_name",$short_name);
			// 			}else{
			// 				return View::make(Config::get( 'app.main_template' ).'.pregunta')->with("short_name",$short_name);
			// 			}



			// 		}else{
							
			// 		}
					
			// 	}else{
			// 		return View::make(Config::get( 'app.main_template' ).'.espera')->with("short_name",$short_name);
			// 	}
			// }
		}else{
			App::abort(404);
		}
		

	}


	protected function hasPhrase($contest){
		$phrase = DB::table('phrase')->where('contest_id', $contest->id_contest)
		->where('user_id', Session::get("user.id"))		
		->first();
		if(is_null($phrase)){
			return 0;
		}else{
			return 1;
		}
	}

	protected function userIsRegister($contest){
		$user = DB::table('social_network')->where('contest_id', $contest->id_contest)
		->where('social_id', Session::get("user.identifier"))		
		->first();
		
		
		

		if(is_null($user)){
			if(Session::get("user.provider")!="Twitter"){
			$user_exist = DB::table('users')->where('contest_id', $contest->id_contest)
			->where('email', md5(Session::get("user.email")))		
			->first();
				if(is_null($user_exist)){
					return 0;
				}else{
					Session::put("user.id",$user_exist->id);
					return 1;
				}
			}
			
		}else{
			Session::put("user.id",$user->user_id);
			return 1;	
		}

		

		// Cache::forget('promo_info_'.$short_name);
		// if (Cache::has('promo_info_'.$short_name)){
  //   		return Cache::get('promo_info_'.$short_name);
		// }else{
		// 	$info=Contest::where("short_name",$short_name)->get();
		// 	Cache::add('promo_info_'.$short_name,$info[0], 60);
		// 	return $info[0];
		// }
	}

	
    protected function contentTost($short_name,$typeProperty){

    	if (Cache::has('contentTost_'.$short_name.'_'.$typeProperty)){
    		return Cache::get('contentTost_'.$short_name.'_'.$typeProperty);
		}else{
	    	$contentPrivacy = DB::connection('mysql2')->table('contest AS c')
													->leftJoin('contest_properties AS cp', 'c.id_contest', '=', 'cp.id_contest')
													->select('property_value')
													->where('c.short_name',$short_name)
		                            				->where('cp.property_name',$typeProperty)
													->pluck('property_value');

			(!@file_get_contents($contentPrivacy))? $contentPrivacyPolicy = "" : $contentPrivacyPolicy= file_get_contents($contentPrivacy);

			Cache::add('contentTost_'.$short_name.'_'.$typeProperty,$contentPrivacyPolicy, 180);
			return $contentPrivacyPolicy;
		}
    }



	protected function contestExist($short_name){
		if (Cache::has('promo_'.$short_name)){
    		return Cache::get('promo_'.$short_name);
		}else{
			
			$number=Contest::where("short_name",$short_name)->count();
			Cache::add('promo_'.$short_name,$number, 180);
			return $number;
		}
	}


	protected function contestInfo($short_name){
		//Cache::forget('promo_info_'.$short_name);
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

			Cache::add('promo_info_'.$short_name,$info[0], 180);
			return $info[0];
		}
	}

	protected function nameController($info){

		if (isset($info->properties['channel']))
			return $info->properties['channel'];	
		else
			return 'canal-5';
		/*if($info->id_contest != 1){
			$nameControl = 'canal-5';
		}else{
			$nameControl = 'canal5';
		}
		return $info->properties['vertical'];*/
	}


	/*************************** DEMO ****************************************/


     public function getImagen($short_name){
    	$info=$this->contestInfo($short_name);
    	return View::make(Config::get( 'app.main_template' ).'.imagen')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'avisoPrivacidad'));
    }

    public function postUploadimg(){
		
		$file = Input::file('file');

		$namefileup = md5(Session::get("user.contest").Session::get("user.email").Session::get("user.firstname"));

		$s3 = AWS::get('s3');

	       $result = $s3->putObject(array(
	           					'ACL'        	=> 'public-read',
	                            'Bucket'     	=> 'communities-dev',
	                            'Key'        	=> "/escaleta/contest/".App::environment()."/".Session::get("user.contest")."/fotos/".$namefileup.".jpg",
	                            'ContentType' 	=> 'image/jpeg',
								'Body'   		=>  fopen($file, 'r+')
	        ));   

	        $url = $result['ObjectURL'];

	       	//$arrayImg= array($typeImg=>$url);

		return $url;
	}

	public function postUploadvideo(){
		//$file = Input::file('file');
		// $path = Input::file('file')->getRealPath();
		// $name = Input::file('file')->getClientOriginalName();
		// $extension = Input::file('file')->getClientOriginalExtension();
		// $size = Input::file('file')->getSize();
		//$mime = Input::file('file')->getMimeType();
		//$salida=Input::file('file')->move('/', $name);
		//print_r($salida);
		$namefileup = md5(Session::get("user.contest").Session::get("user.email").Session::get("user.firstname"));
		$s3 = AWS::get('s3');
		$result = $s3->putObject(array(
		     				'ACL'        	=> 'public-read',
		                    'Bucket'     	=> 'communities-dev',
		                    'Key'        	=> "/escaleta/contest/".App::environment()."/".Session::get("user.contest")."/video/".$namefileup.".".Input::file('file')->getClientOriginalExtension(),
		                    'ContentType' 	=> 'video/'.Input::file('file')->getClientOriginalExtension(),
							'Body'   		=>  fopen(Input::file('file'), "r+")

		));   
		$url = $result['ObjectURL'];
		return $url;
	}


}