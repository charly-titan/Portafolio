<?php

class FotoController extends ContestController {

	public function __construct()
    {
		//parent::__construct();
		Config::set('app.main_template', 'promociones2');
        
    }

	public function getIndex ($short_name=""){

		// *******************************************
		// Verificar si el concurso existe
		// *******************************************
		if($this->contestExist($short_name)){

			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

			// *******************************************
			// Verificar si el concurso ya finalizó
			// *******************************************
			if(intval($info->end_date)<= time()){
				return "ya finalizó concurso";
				//return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
			}

			// *******************************************
			// Verificar si el concurso ya inicio o esta en previo
			// *******************************************
			
			if(intval($info->start_date) > time()){
				return "Concurso no ha iniciado";
				//return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
			}

			// *******************************************
			// Mostrar listado de fotos mas votadas
			// *******************************************
			$fotos=$this->listFotos($info);
			return View::make(Config::get( 'app.main_template' ).'.foto.listado')->with(array("short_name"=>$short_name,"info"=>$info,"fotos"=>$fotos,"adUnit"=>''));
			
						
		}else{
			App::abort(404);
		}

		

	}

	public function getVota($short_name="", $keyword=0){

		/*Se elimina por si viene del registro de su foto*/
		Session::forget('user');
		
		// *******************************************
		// Verificar si el concurso existe
		// *******************************************
		if($this->contestExist($short_name)){

			Session::put('user.contest', $short_name); // Establecer el concurso para la sesión
			Session::put('user.promo_type', 'actividad'); //Establecer el tipo de concurso
			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

			// *******************************************
			// Verificar si el concurso ya finalizó
			// *******************************************
			if(intval($info->end_date)<= time()){
				return "ya finalizó concurso";
				//return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
			}

			// *******************************************
			// Verificar si el concurso ya inicio o esta en previo
			// *******************************************
			
			if(intval($info->start_date) > time()){
				return "Concurso no ha iniciado";
				//return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
			}

			// *******************************************
			// Verificar si la foto existe
			// *******************************************
			$info_foto=$this->keywordExist($info->id_contest,$keyword);
			if(!$info_foto){
				return "La foto por la que quieres votar no existe";
			}
			
			Session::put('user.foto_keyword', $keyword); // Guarda la foto para asignar voto
			
			$user_foto= User::select('first_name', 'last_name')->where('id',$info_foto->user_id)->first();
			$sugeridos= Fotos::select('id', 'foto_url', 'foto_name', 'voto_url')
	            				->where('contest_id', $info_foto->contest_id)
	            				->limit("4")   
	            				->get();
			$info_foto->user_name="";
			if( $user_foto ){
				$info_foto->user_name = Crypt::decrypt($user_foto->first_name).' '.Crypt::decrypt($user_foto->last_name);
			}


			/*/ *******************************************
			// Verificamos si el usuario ya inicio sesión
			// *******************************************
			if (Session::has('user.identifier')){
				// *******************************************
				// El concurso ya inicio 
				// Verificamos si el usuario ya esta registrado
				// *******************************************
				if($this->userIsRegister($info)){
					

					if(intval($info->activation_date) <= time()){
						if ($this->hasVoto($info, $info_foto)) {
							return "Ya votaste por esta foto";
							//return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'gracias'));
						}else{

							//return $info_foto;

							return View::make(Config::get( 'app.main_template' ).'.foto.votar')->with(array("short_name"=>$short_name,"info"=>$info,"info_foto"=>$info_foto));

						}
						
					}else{
						return "Espera para votar";
					}



				// *******************************************
				// Pero el usuario no esta registrado
				// *******************************************
				}else{
					return  "Registrate";
				}

			}else{*/
				return View::make(Config::get( 'app.main_template' ).'.foto.votar')->with(array("short_name"=>$short_name,"info"=>$info,"info_foto"=>$info_foto,"sugeridos"=>$sugeridos,"adUnit"=>''));
			//}

			
		}else{
			App::abort(404);
		}						
	}

	public function getGracias ($short_name=""){

		//echo "Gracias por votar <br>";

		if(!$this->contestExist($short_name)) 
			App::abort(404);

		if(Session::has('user.identifier') && Session::has('user.foto_keyword')){

			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso
			$info_foto=$this->keywordExist($info->id_contest,Session::get('user.foto_keyword'));// Verificar si la foto existe
			
			if(!$info_foto)
				return  Redirect::to("/foto/".$short_name);

			$user_foto= User::select('first_name', 'last_name')->where('id',$info_foto->user_id)->first();

			$info_foto->user_name="";
			if( $user_foto ){
				$info_foto->user_name = Crypt::decrypt($user_foto->first_name).' '.Crypt::decrypt($user_foto->last_name);
			}

			$sugeridos= Fotos::select('id', 'foto_url', 'foto_name', 'voto_url')
	            				->where('contest_id', $info_foto->contest_id)
	            				->limit("4")   
	            				->get();

			if(!($this->userIsRegister($info)))
				if(!$this->userRegister($info))
					return "User Twiter";
			
			$votoRegister=False;
			if(Session::has('user.id')){ 
				if ($this->hasVoto($info)) {
					//echo "El usuario ya voto por este concurso";
					$votoRegister=False;
				}else{//Guardar Voto

					$this->saveVotoFoto($info, $info_foto->id);
					$votoRegister=True;

				}
				return View::make(Config::get( 'app.main_template' ).'.foto.votar')->with(array("short_name"=>$short_name,"info"=>$info,"info_foto"=>$info_foto,"votoRegister"=>$votoRegister,"sugeridos"=>$sugeridos,"adUnit"=>''));
			}
		}else{
			return  Redirect::to("/foto/".$short_name);	
		}


	}

	private function listFotos($contest){

		// $fotos = DB::table('votos_foto')
		// 		->join('fotos', 'fotos.id', '=', 'votos_foto.foto_id')
	 //            ->select(DB::raw('count(votos_foto.id) as votos, fotos.id, fotos.foto_url, fotos.foto_name'))
	 //            ->where('fotos.contest_id', $contest->id_contest)
	 //            ->where('fotos.status', 'approved')
	 //            ->groupBy('fotos.id')
	 //            ->orderBy('votos','desc')
	 //            ->get();
		$fotos = Fotos::select('id', 'foto_url', 'foto_name', 'voto_url')
	            ->where('contest_id', $contest->id_contest)   
	            ->get();

		if(is_null($fotos) or !count($fotos)){
			return 0;
		}else{
			return $fotos;
		}
		
	}

	private function keywordExist($id_contest,$keyword){

		$foto= Fotos::where('contest_id',$id_contest)->where('keyword',$keyword)->first();

		if(is_null($foto) or !count($foto)){
			return false;
		}else{
			return $foto;
		}
		
	}

	protected function saveVotoFoto($contest, $foto_id){

			$voto 			  	= 	new VotosFoto;
			$voto->contest_id	=	$contest->id_contest;
			$voto->user_id 		=	Session::get("user.id");
			$voto->foto_id 		=	$foto_id;
			$voto->ip 			=	$this->getRealIP();
			$voto->browser 		=	$this->getBrowser();
			$voto->save();
			return $voto->id;
	}

	protected function hasVoto($contest){

		$voto= VotosFoto::where('contest_id',$contest->id_contest)
				->where('user_id',Session::get("user.id"))
				->first();
		if(is_null($voto)){
			return 0;
		}else{
			return 1;
		}
	}

	protected function userRegister($info){

		if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
    		//es twiter
    		return false; //Session::all();
    	}
		$user_guid = sha1(Session::get("user.firstname").time().rand(5, 15));

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


	       $result = $s3->putObject(array(
	           					'ACL'        	=> 'public-read',
	                            'Bucket'     	=> 'communities-dev',
	                            'Key'        	=> "/escaleta/contest/demo/img/".time()."-".md5(time()).".jpg",
	                            'ContentType' 	=> 'image/jpeg',
								'Body'   		=>  fopen($file, 'r+')
	        ));   

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

			Session::put("user.id",$user_exist->user_id);

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



}	
