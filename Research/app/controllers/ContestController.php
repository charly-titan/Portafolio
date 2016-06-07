<?php

class ContestController extends \BaseController {

	public function __construct(){
        parent::__construct();

        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
        
    }

	public function getIndex(){
		
		Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
		try{


			$user = Sentry::getUser();

			$admin = Sentry::findGroupByName('Administrador');
			$pepsi = Sentry::findGroupByName('Pepsi Admin');
			$television = Sentry::findGroupByName('Television Admin');
			$ninos = Sentry::findGroupByName('Ninos');

			if($user->inGroup($admin)){
				return View::make(Config::get( 'app.main_template' ).'.contest.table')->with('dataContest',$this->contestTable('todos'));
			}elseif($user->inGroup($pepsi)){
				return View::make(Config::get( 'app.main_template' ).'.contest.table')->with('dataContest',$this->contestTable('pepsi'));
			}elseif($user->inGroup($television)){
				return View::make(Config::get( 'app.main_template' ).'.contest.table')->with('dataContest',$this->contestTable('television'));
			}elseif($user->inGroup($ninos)){
				return View::make(Config::get( 'app.main_template' ).'.contest.table')->with('dataContest',$this->contestTable('ninos'));
			}elseif($user->hasAccess('promo.list')){
				return View::make(Config::get( 'app.main_template' ).'.contest.table')->with('dataContest',$this->contestTable('canal-5'));
			}else{
				Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento listar los concursos sin tener los permisos necesarios');
	            App::abort(401);
			}
		}catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){
		    Log::error($e);
	        App::abort(400);
		}
	}


	public function getCreate(){
		Session::forget('SesionID');
		Session::forget('SessionImg');

		$user = Sentry::getUser();
		
		if($user->hasAccess('promo.create')){
			
			$userPermission = $this->userPermission('promo');
			return View::make(Config::get( 'app.main_template' ).'.contest.contestDetails')->with("userPermission",$userPermission);	
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento crear un concurso sin tener los permisos necesarios');
            App::abort(401);
		}
		
	}


	public function getContestdate(){

		$userPermission = $this->userPermission('promo_date');

		$resDate = DB::table('contest')->select('start_date')->where('id_contest', $this->UserID())->pluck('start_date');

		if($resDate){

			return View::make(Config::get( 'app.main_template' ).'.contest/contestDate')->with(array('datesAll'=>$this->contestDateData($this->UserID()),'numStep'=>'step2','userPermission'=>$userPermission));
		}else{
			return View::make(Config::get( 'app.main_template' ).'.contest/contestDate')->with(array('numStep'=>'step2','userPermission'=>$userPermission));
		}
	}

	public function postUploadimg($typeImg){
		
		$file = Input::file('file');
	    $filename = $file->getClientOriginalName();

	    $s3 = AWS::get('s3');

	    $result = $s3->putObject(array(
	                'Bucket'        =>  'communities-dev',
	                'Key'           =>  "/escaleta/".$this->environment()."/contest/img/".$filename,
	                'ACL'           =>  'public-read',
	                'ContentType' 	=> 'image/jpeg',
	                'Body'   		=>  fopen($file, 'r+')
	         	));

		$url = $result['ObjectURL'];

		$arrayImg= array($typeImg=>$url);

		return $arrayImg;      
	}

	public function postContestdate(){

		$userPermission = $this->userPermission('promo_date');

		$inputs 			= Input::all();
		$titleContest 		= Input::get('titleContest');
		$nameContest 		= Input::get('nameContest');
		$descriptionContest = Input::get('descriptionContest');
		$keywordContest 	= Input::get('keywordContest');
		$urlContest 		= Input::get('urlContest');
		$shortUrlContest 	= Input::get('shortUrlContest');
		$imgUrl				= Input::get('contestImg');
		$channel			= Input::get('channel');

		$rules = array(
			'titleContest'    		=> 'required|min:3',
			'nameContest'      		=> 'required|min:3',
			//'imagecontest'      	=> 'required',
			'descriptionContest'    => 'required|min:3',
			'keywordContest'      	=> 'required|min:3',
			'urlContest'      		=> 'required|alpha_dash',
			'shortUrlContest'      	=> 'required|alpha_dash',
			'channel'				=> 'required'
		);


		$validator = Validator::make($inputs, $rules);

		$arrayFields = array('titleContest','nameContest','descriptionContest','keywordContest','urlContest','shortUrlContest','contestImg','channel');
		$arrayValueFields = array($titleContest,$nameContest,$descriptionContest,$keywordContest,$urlContest,$shortUrlContest,$imgUrl,$channel);

			if ($validator->fails()) {

				return Redirect::back()->withErrors($validator)->withInput();
			}else{

					$contestUpd = Contest::find($this->UserID());

					if($contestUpd){



						$startDate = DB::table('contest')->select('start_date')->where('id_contest', $this->UserID())->pluck('start_date');

						if($startDate){

							$this->updDetails($urlContest,$arrayFields,$arrayValueFields);

							return View::make(Config::get( 'app.main_template' ).'.contest/contestDate')->with(array('datesAll'=>$this->contestDateData($this->UserID()),'numStep'=>'step2','userPermission'=>$userPermission));
						
						}else{

							$this->updDetails($urlContest,$arrayFields,$arrayValueFields);
							return View::make(Config::get( 'app.main_template' ).'.contest/contestDate')->with(array('numStep'=>'step2','userPermission'=>$userPermission));
						}

						
					}else{

						$id = $this->lastID($urlContest,$arrayFields);
						Session::put('SesionID',$id);
						
						return View::make(Config::get( 'app.main_template' ).'.contest/contestDate')->with(array('numStep'=>'step2','userPermission'=>$userPermission));
					}

					
			}
	}

	protected function userPermission($property_name){

		$user = Sentry::getUser();
		$user_permission=array("view"=>0,"update"=>0,"create"=>0,"delete"=>0);

		if ($user->hasAccess($property_name.'.view')){
			$user_permission["view"] = 1;
		} 
		if($user->hasAccess($property_name.'.update')){
			$user_permission["update"] = 1;
		}
		if($user->hasAccess($property_name.'.create')){
			$user_permission["create"] = 1;
		}
		if($user->hasAccess($property_name.'.delete')){
			$user_permission["delete"] = 1;
		}
		return $user_permission;
	}


	public function getContestdetails($id = null){

		if($id==""){   $id=$this->UserID(); }

		$result = DB::select("SELECT GROUP_CONCAT(DISTINCT short_name SEPARATOR '@@') as shortName,GROUP_CONCAT(cp.property_name SEPARATOR '@@') as propertyName, GROUP_CONCAT(cp.property_value SEPARATOR '@@') as propertieValue from contest c inner join contest_properties cp on (c.id_contest=cp.id_contest) where c.id_contest=? and property_value!='' and property_name in('titleContest','nameContest','descriptionContest','keywordContest','urlContest','shortUrlContest','contestImg')",array($id));

			$shortName='';$propertyName = '';$propertieValue='';

			foreach ($result as $key => $value) {
				$shortName = $value->shortName;
				$propertyName =  $value->propertyName;
				$propertieValue = $value->propertieValue;
			}

			$propertyNameArray = explode("@@",$propertyName);
			$propertieValueArray = explode("@@",$propertieValue);

				$properties = new stdClass();
				for ($i=0; $i < count($propertyNameArray) ; $i++) { 
				    $properties->$propertyNameArray[$i] = $propertieValueArray[$i];
				}
				$properties->shortName = $shortName;


        $validator = Validator::make(
            array('id' => $id),
            array('id' => 'required|min:1|integer')
        );

        if ($validator->fails()){
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento acceder con un perfil no autorizado - '.$user_id);
            App::abort(409);
        }

			$userPermission = $this->userPermission('promo_info');

			($id)? Session::put('SesionID',$id) : null;

			$idContest = Contest::find($this->UserID());


			if($idContest){
				Session::put('SessionImg','loadImg');
				
				return View::make(Config::get( 'app.main_template' ).'.contest/contestDetails')->with(array('properties'=>$this->propertiesDetails($this->UserID()),'userPermission'=>$userPermission));
			}else{
				return View::make(Config::get( 'app.main_template' ).'.contest/contestDetails')->with('userPermission',$userPermission);
			}
	}


	private function updDetails($urlContest,$arrayFields,$arrayValueFields){
		//echo 1111111111;
		//exit();
		$contest = Contest::find($this->UserID());	
		$contest->short_name = $urlContest;
		$contest->save();

		for ($i=0; $i < count($arrayFields) ; $i++) {

			DB::update('UPDATE contest_properties set property_value = ? where id_contest = ? and property_name = ?', array($arrayValueFields[$i],$this->UserID(),$arrayFields[$i]));
		}	
	}


	private function propertiesDetails($id){

		$result = DB::select("SELECT GROUP_CONCAT(DISTINCT short_name SEPARATOR '@@') as shortName,GROUP_CONCAT(cp.property_name SEPARATOR '@@') as propertyName, GROUP_CONCAT(cp.property_value SEPARATOR '@@') as propertieValue,c.end_date from contest c inner join contest_properties cp on (c.id_contest=cp.id_contest) where c.id_contest=? and property_value!='' and property_name in('titleContest','nameContest','descriptionContest','keywordContest','shortUrlContest','contestImg','channel')",array($id));

		$shortName='';$propertyName = '';$propertieValue='';$end_date='';

		foreach ($result as $key => $value) {
			$shortName = $value->shortName;
			$propertyName =  $value->propertyName;
			$propertieValue = $value->propertieValue;
			$end_date = $value->end_date;
		}

		if($end_date >= time() ){
			$status_contests = 0;
		}else{
			$status_contests = 1;
		}


		$propertyNameArray = explode("@@",$propertyName);
		$propertieValueArray = explode("@@",$propertieValue);

			
		$properties = new stdClass();
			for ($i=0; $i < count($propertyNameArray) ; $i++) { 
				$properties->$propertyNameArray[$i] = $propertieValueArray[$i];
			}
			$properties->shortName = $shortName;	
			$properties->status_contests = $status_contests;	

		return $properties;
	}


	/********************************************************************************************/


	public function getContestownerinf(){

		$userPermission = $this->userPermission('promo_owner');

		$users = DB::table('users')->lists('id','first_name');

		$result = DB::select("SELECT property_name,property_value from contest_properties where id_contest=? and property_name in('ownerInformationID','autorizedPersonDatabase')",array($this->UserID()));

		if($result){
			return $this->UserAutorized($result,$users,$userPermission);
		}else{

			return View::make(Config::get( 'app.main_template' ).'.contest.contestOwnerInf')->with(array('users' => $users,'numStep'=>'step3','userPermission'=>$userPermission));
		}
	}


	public function postContestownerinf(){

		/************************* STATUS DE QUESTION DISTINTO AL VERSUS ***************************************/

	$contest = Contest::find($this->UserID());


	if($contest->contest_type != Input::get('typeContest')){
	
		$question = Question::find($contest->id_contest);

			if($question){
				$question->status= false;
				$question->save();

				$questionOptions = QuestionOptions::find($question->id);
				$questionOptions->status = false;
				$questionOptions->save();
			}
		

	}


/****************************************************************/

	  $userPermission = $this->userPermission('promo_owner');

	  $inputs = Input::all();
	  $startDate = Input::get('startDate');
	  $startTime = Input::get('startTime');
	  $closingDate = Input::get('closingDate');
	  $closingTime = Input::get('closingTime');
	  $activationDate = Input::get('activationDate');
	  $activationTime = Input::get('activationTime');

		$rules = array(
			'startDate'       	=> 'required|date',
			'closingDate'      	=> 'required|date',
			'startTime'    		=>  array('regex:/(0?\d|1[0-2]):(0\d|[0-5]\d) (AM|PM)/i'),
			//'startTime'    		=>  array('regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'),
			'closingTime'      	=>  array('regex:/(0?\d|1[0-2]):(0\d|[0-5]\d) (AM|PM)/i'),
			'activationDate'    => 'required|date',
			'activationTime'    =>  array('regex:/(0?\d|1[0-2]):(0\d|[0-5]\d) (AM|PM)/i'),
			'typeContest'      	=> 'required|in:quiz,frase,foto,video,versus'
		);


		$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {

			$contest = Contest::find($this->UserID());
			$contest->start_date = $this->datetimeStr($startDate,$startTime);
			$contest->end_date = $this->datetimeStr($closingDate,$closingTime);
			$contest->activation_date = $this->datetimeStr($activationDate,$activationTime);
			$contest->contest_type = Input::get('typeContest');
			$contest->save();


			$result = DB::select("SELECT property_name,property_value from contest_properties where id_contest=? and property_name in('ownerInformationID','autorizedPersonDatabase')",array($this->UserID()));

			$users = DB::table('users')->lists('id','first_name');

			if($result){

				return $this->UserAutorized($result,$users,$userPermission);

			}else{

				return View::make(Config::get( 'app.main_template' ).'.contest.contestOwnerInf')->with(array('users' => $users,'numStep'=>'step3','userPermission'=>$userPermission));

			}
		}
	}


	private function UserAutorized($result,$users,$userPermission){

		$ownerInformationID ='';$autorizedPersonDatabase = '';$dataAutorizedDatabase = [];$idPersonAutorized = [];;
		
		$data = [];
		foreach ($result as $key => $value) {
			$data[$value->property_name] = $value->property_value;		
		}

			$autorizedPersonDatabase = $data['autorizedPersonDatabase'];
			$ownerInformationID = $data['ownerInformationID'];

			$usersAutorizedDownload = implode(',',json_decode($autorizedPersonDatabase));

			if($usersAutorizedDownload){
				$userAutorizedDatabase = DB::select('SELECT id,first_name from users where id in ('.$usersAutorizedDownload.')');

				foreach ($userAutorizedDatabase as $key => $value) {
					$idPersonAutorized[] = $value->id;
					$dataAutorizedDatabase[$value->id] = Crypt::decrypt($value->first_name);
				}
			}

			return View::make(Config::get( 'app.main_template' ).'.contest.contestOwnerInf')->with(array('users' => $users,'ownerIDselect' => $ownerInformationID,'dataAutorizedDatabase'=>json_encode($dataAutorizedDatabase),'numStep'=>'step3','autorizedPerson'=>implode(",",$idPersonAutorized),'userPermission'=>$userPermission));
	}

	public function getTos(){

		$userPermission = $this->userPermission('promo_tos');

		$resFile = DB::select("SELECT property_name from contest_properties where id_contest=? and property_name in('privacyPolicy','tos','contestRules')",array($this->UserID()));

		if($resFile){

			$resFile = DB::select("SELECT property_name from contest_properties where id_contest=? and property_name in('privacyPolicy','tos','contestRules')",array($this->UserID()));

			foreach ($resFile as $key => $value) {
				Session::put($value->property_name,$value->property_name);
			}

			return $this->contentPages($userPermission);

		}else{
			Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
			return View::make(Config::get( 'app.main_template' ).'.contest/contestTOS')->with(array('numStep'=>'step4','userPermission'=>$userPermission));
		}
	}


	public function postTos(){

		$userPermission = $this->userPermission('promo_tos');

		$inputs = Input::all();		

		$rules = array(
			'ownerInformationID'    => 'required',
			'autorizedPerson'      	=> 'required'
		);


		$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {

			$this->contestOwnerUpd();

			$result = DB::select("SELECT property_name as propertieName ,property_value as propertieValue from contest_properties where property_name in ('privacyPolicy','contestRules','tos') and id_contest=?",array($this->UserID()));


			if($result){

				try{
					$contentPages = new StdClass();

					foreach ($result as $key => $value) {
							$propertyName = $value->propertieName;
							$propertieValue = $value->propertieValue;

							if(!@file_get_contents($propertieValue)){
								$contentPages->$propertyName = "";
								//DB::delete('DELETE from contest_properties where id_contest=? and property_name =?',array($this->UserID(),$value->propertieName));
							}else{
								$contentPages->$propertyName = file_get_contents($propertieValue);
							}
					}

					return View::make(Config::get( 'app.main_template' ).'.contest.contestTOS')->with(array('numStep'=>'step4','contentPages'=>$contentPages,'userPermission'=>$userPermission));

				}catch(\Exception $e){
					return "error file no exist";
				}
				

			}else{
				Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
				return View::make(Config::get( 'app.main_template' ).'.contest.contestTOS')->with(array('numStep'=>'step4','userPermission'=>$userPermission));
			}
		}
	}


	public function postTosupd(){

		$userPermission = $this->userPermission('promo_tos');

		$parameterService = Input::get('typeTOS');
		$description =  Input::get('descripcion');

		$dir = Config::get('app.folder');
		$handle = opendir($dir); 

		$fileCreated = $this->UserID()."_".$parameterService.".txt";
	    $rutaFileCreated = $dir.$fileCreated;

		$fileBckp = $this->UserID()."_".$parameterService."_".time().".txt";
		$rutafileBckp = $dir.$fileBckp;

		$s3 = AWS::get('s3');

		$resp = DB::table('contest_properties')->where('id_contest',$this->UserID())->where('property_name',$parameterService)->pluck('property_value');
		
		if($resp){
			if(@file_get_contents($resp)){
			$fp_bckp=fopen(Config::get('app.folder').$fileBckp,"x");
		    fwrite($fp_bckp,file_get_contents($resp));
		    fclose($fp_bckp);

		     $result = $s3->putObject(array(
           					'ACL'        => 'public-read',
                            'Bucket'     => 'communities-dev',
                            'Key'        => "/escaleta/".$this->environment()."/contest/tos/".$fileBckp,
                            'SourceFile' => $rutafileBckp
        	));

		    unlink($rutafileBckp); 
			}
		}
		

		if (file_exists($rutaFileCreated)) { unlink($rutaFileCreated); }

		$fp=fopen(Config::get('app.folder').$fileCreated,"x");
	    fwrite($fp,$description);
	    fclose($fp);

        $result = $s3->putObject(array(
           					'ACL'        => 'public-read',
                            'Bucket'     => 'communities-dev',
                            'Key'        => "/escaleta/".$this->environment()."/contest/tos/".$fileCreated,
                            'SourceFile' => $rutaFileCreated
        ));
       
        unlink($rutaFileCreated); 

        $url = $result['ObjectURL'];


	    $existos=ContestProperties::where('property_name',$parameterService)
	    							->where('id_contest',$this->UserID())
	    							->first();

	    $valResp = ContestProperties::where('id_contest',$this->UserID())->where('property_name','privacyPolicy_bck')->first();

	   if($valResp){

			$newBck = json_decode($valResp->property_value);
	   		//array_push($newBck,$fileBckp);
	   		$newBck[]=$fileBckp;
	   		$bckFile = json_encode($newBck);
	   		$valResp->property_value = $bckFile;
			$valResp->save();

	   }else{
			
			$bckFile = json_encode(array($fileBckp));
			$contestProperties = new ContestProperties;
			$contestProperties->id_contest = $this->UserID();
			$contestProperties->property_name = 'privacyPolicy_bck';
			$contestProperties->property_value = $bckFile;
			$contestProperties->save();

	   }

	    if ($existos) {
	    	$existos->property_value = $url;
			$existos->save();
	    } else { 	
		    $contestProperties = new ContestProperties;
			$contestProperties->id_contest = $this->UserID();
			$contestProperties->property_name = $parameterService;
			$contestProperties->property_value = $url;
			$contestProperties->save();
		}

		
		if(@file_get_contents($propertieValue)){
			Session::put($parameterService,$parameterService);
		}

		return $this->contentPages($userPermission);
	}



	private function contentPages($userPermission){

		$result = DB::select("SELECT property_name as propertieName ,property_value as propertieValue from contest_properties where property_name in ('privacyPolicy','contestRules','tos') and id_contest=?",array($this->UserID()));

		$contentPages = new StdClass();

			foreach ($result as $key => $value) {
					$propertyName = $value->propertieName;
					$propertieValue = $value->propertieValue;

					if(!@file_get_contents($propertieValue)){
						$contentPages->$propertyName = "";
						//DB::delete('DELETE from contest_properties where id_contest=? and property_name =?',array($this->UserID(),$value->propertieName));
					}else{
						$contentPages->$propertyName = file_get_contents($propertieValue);
					}
			}
		return View::make(Config::get( 'app.main_template' ).'.contest.contestTOS')->with(array('numStep'=>'step4','contentPages'=>$contentPages,'userPermission'=>$userPermission));
	}


	protected function contestOwnerUpd(){

		$ownerInformationID = Input::get('ownerInformationID');
		$autorizedPerson = Input::get('autorizedPerson');

		$autorizedPersonDatabase = explode(',',$autorizedPerson);

		$array = array('ownerInformationID'=>$ownerInformationID,'autorizedPersonDatabase'=> json_encode($autorizedPersonDatabase));

		foreach ($array as $propertie => $propertieValue) {
			//$ownerDB = DB::select("SELECT * from contest_properties where id_contest=? and property_name=? limit 1",array($this->UserID(),$propertie))->first();
			$ownerDB = ContestProperties::where('id_contest',$this->UserID())
										->where('property_name',$propertie)
										->first();
			if (is_null($ownerDB) or !count($ownerDB)) {

				$contestProperties = new ContestProperties;
				$contestProperties->id_contest = $this->UserID();
				$contestProperties->property_name = $propertie;
				$contestProperties->property_value = $propertieValue;
				$contestProperties->save();

			} else {
				$ownerDB->property_value = $propertieValue;
				$ownerDB->save();
				
			}
		}	

	}


	public function postNetworkservice(){

		$userPermission = $this->userPermission('promo_social');

		return View::make(Config::get( 'app.main_template' ).'.contest/contestNetworkService')->with(array('numStep'=>'step5','socialNetworkOpt'=>$this->SocialNetwork(),'userPermission'=>$userPermission,'gigyaOption'=>$this->gigyaOption()));
	}

	public function getNetworkservice(){

		$userPermission = $this->userPermission('promo_social');

		if($this->UserID()){
			return View::make(Config::get( 'app.main_template' ).'.contest/contestNetworkService')->with(array('numStep'=>'step5','socialNetworkOpt'=>$this->SocialNetwork(),'userPermission'=>$userPermission,'gigyaOption'=>$this->gigyaOption()));
		}else{
			return View::make(Config::get( 'app.main_template' ).'.contest/contestNetworkService')->with(array('numStep'=>'step5','userPermission'=>$userPermission));
		}
	}

	private function SocialNetwork(){

		$socialNetworkRes = DB::select("SELECT property_value from contest_properties where property_name = 'socialNetwork' and id_contest=? limit 1",array($this->UserID()));

		$array =  (array) $socialNetworkRes;
		$socialNetworkOpt = '';
		if (!$this->gigyaOption()) {
			foreach ($array as $key => $value) {
				$socialNetworkOpt = $value->property_value;
			}
		}

		return $socialNetworkOpt;
	}

	private function gigyaOption(){

		$gigyaOption = ContestProperties::where('property_name','gigyaOption')->where('id_contest',$this->UserID())->first();
		
		if (is_null($gigyaOption) or !count($gigyaOption))
			return 0;
		else
			return $gigyaOption->property_value;

	}



	public function postSales(){

		$userPermission = $this->userPermission('promo_ventas');

		$inputs = Input::all();

		$socialNetwork 		= Input::get('socialNetwork');
		$gigya  			= Input::get('optionGigya');

		$gigyaOption = ContestProperties::where('property_name','gigyaOption')->where('id_contest',$this->UserID())->first();
		if (isset($gigya) && $gigya==1){
			if (is_null($gigyaOption) or !count($gigyaOption)){
				$contestProperties = new ContestProperties;
				$contestProperties->id_contest = $this->UserID();
				$contestProperties->property_name = "gigyaOption";
				$contestProperties->property_value = $gigya;
				$contestProperties->save();
			}else{
				$gigyaOption->property_value = $gigya;
				$gigyaOption->save();
			}
			return View::make(Config::get( 'app.main_template' ).'.contest.contestSales')->with($this->updSales($userPermission));
		}else{
			if ($gigyaOption){
				$gigyaOption->property_value = 0;
				$gigyaOption->save();
			}
		}

		$rules = array(
			'socialNetwork'  => 'required|min:1',
		);

		$socialNetworkdb = ContestProperties::where('property_name','socialNetwork')->where('id_contest',$this->UserID())->first();

		$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {

			if (is_null($socialNetworkdb) or !count($socialNetworkdb)){
				$contestProperties = new ContestProperties;
				$contestProperties->id_contest = $this->UserID();
				$contestProperties->property_name = "socialNetwork";
				$contestProperties->property_value = json_encode($socialNetwork);
				$contestProperties->save();
			}else{
				$socialNetworkdb->property_value = json_encode($socialNetwork);
				$socialNetworkdb->save();
			}
			
			return View::make(Config::get( 'app.main_template' ).'.contest.contestSales')->with($this->updSales($userPermission));
		}
	}


	public function getSales(){

			$userPermission = $this->userPermission('promo_ventas');

			return View::make(Config::get( 'app.main_template' ).'.contest.contestSales')->with($this->updSales($userPermission));
	}

	private function updSales($userPermission){

		$result = DB::table('contest_properties')->select('property_name','property_value')->where('id_contest',$this->UserID($userPermission))->whereIn('property_name', ['advertisingOption', 'promoSales'])->get();

		$properties = new stdClass();

		foreach ($result as $key => $value) {
			$nameProperties = $value->property_name;
			$properties->$nameProperties = $value->property_value;
		}


		if($result){
			$arrayDatas = array('numStep'=>'step6','userPermission'=>$userPermission,'properties'=>$properties);
		}else{
			$arrayDatas = array('numStep'=>'step6','userPermission'=>$userPermission);
		}

		return $arrayDatas;
	}



	public function getMetric(){

		$userPermission = $this->userPermission('promo_metricas');

		return View::make(Config::get( 'app.main_template' ).'.contest/contestMetric')->with($this->updMetrica($userPermission));	
	}

	public function postMetric(){

		$userPermission = $this->userPermission('promo_metricas');

		$inputs 			= Input::all();
		$promoSales 		= Input::get('promoSales');
		$advertisingOption 	= Input::get('advertisingOption');

		($advertisingOption)?$valOption = true : $valOption = false;

		$rules = array(
			'promoSales'  => 'alpha_dash',
		);

		$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {

				return Redirect::back()->withErrors($validator)->withInput();
		}else{
			
				$array = array('promoSales'=>$promoSales,'advertisingOption'=> $valOption);

				foreach ($array as $propertie => $propertieValue) {

					$promoDB = ContestProperties::where('id_contest',$this->UserID())
										->where('property_name',$propertie)
										->first();
					if (is_null($promoDB) or !count($promoDB)) {
						$contestProperties = new ContestProperties;
						$contestProperties->id_contest = $this->UserID();
						$contestProperties->property_name = $propertie;
						$contestProperties->property_value = $propertieValue;
						$contestProperties->save();
					}else{
						$promoDB->property_value = $propertieValue;
						$promoDB->save();
					}
				}

				return View::make(Config::get( 'app.main_template' ).'.contest/contestMetric')->with($this->updMetrica($userPermission));				
		}
	}

	private function updMetrica($userPermission){

		$users = DB::table('users AS u')
		            ->join('groups_sites_profile_relationships AS gsp', 'u.id', '=', 'gsp.id_profile')
		            ->select('u.id', 'u.first_name')
		            ->where('id_group',6)
		            ->get('u.id','u.first_name');

		$resultMetrica = DB::table('contest_properties')->select('property_name','property_value')->where('id_contest',$this->UserID($userPermission))->whereIn('property_name', ['uat','vertical', 'namePromotion','nameSectionTable','ResponsibleProvidingStatistics'])->get();

		if($resultMetrica){
			$properties = new stdClass();

			foreach ($resultMetrica as $key => $value) {
				$nameProperties = $value->property_name;
				$properties->$nameProperties = $value->property_value;
			}

			$responsibleProviding = implode(',',json_decode($properties->ResponsibleProvidingStatistics));

			if($responsibleProviding){
					
				$responsibleStadistics = DB::select('SELECT id,first_name from users where id in ('.$responsibleProviding.')');

				foreach ($responsibleStadistics as $key => $value) {
					$idUserProviding[] = $value->id;
					$userProviding[$value->id] = Crypt::decrypt($value->first_name);
				}

				$arrayDatas = array('numStep'=>'step7','userPermission'=>$userPermission,'users'=>$users,'properties'=>$properties,'userProviding'=>json_encode($userProviding),'autorizedPerson'=>implode(",",$idUserProviding));

			}else{
				$arrayDatas = array('numStep'=>'step7','userPermission'=>$userPermission,'users'=>$users,'properties'=>$properties);
			}
		}else{
			$arrayDatas = array('numStep'=>'step7','userPermission'=>$userPermission,'users'=>$users);
		}

		return $arrayDatas;
	}


	public function postFinalizeform(){

		$userPermission = $this->userPermission('promo_info');

		$inputs 			= Input::all();
		$uat 				= Input::get('uat');
		$vertical 			= Input::get('vertical');
		$namePromotion 		= Input::get('namePromotion');
		$nameSectionTable 	= Input::get('nameSectionTable');
		$autorizedPerson 	= Input::get('autorizedPerson');

		$rules = array(
			'uat'				=> 'alpha_dash',
			'vertical' 	 		=> 'alpha_dash',
			'namePromotion'  	=> 'alpha_dash',
			'nameSectionTable'  => 'required'
		);

		$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {

				return Redirect::back()->withErrors($validator)->withInput();
		}else{
			
			$responsibleProvidingStatistics = explode(',',$autorizedPerson);

			$array = array('uat'=>$uat ,'vertical'=>$vertical ,'namePromotion'=> $namePromotion,'nameSectionTable'=>$nameSectionTable,'ResponsibleProvidingStatistics'=>json_encode($responsibleProvidingStatistics));

			foreach ($array as $propertie => $propertieValue) {
				$result = ContestProperties::where('id_contest',$this->UserID())
										->where('property_name',$propertie)
										->first();
				if (is_null($result) or !count($result)) {
					$contestProperties = new ContestProperties;
					$contestProperties->id_contest = $this->UserID();
					$contestProperties->property_name = $propertie;
					$contestProperties->property_value = $propertieValue;
					$contestProperties->save();
				}else{
					$result->property_value = $propertieValue;
					$result->save();
				}

			}
			$idContest = Contest::find($this->UserID());
			$cssPermission = $this->userPermission('promo_css'); 
			return View::make(Config::get( 'app.main_template' ).'.contest/contestText')->with(array('numStep'=>'step8','userPermission'=>$userPermission,'properties'=>$this->updText(),'contestType'=>$idContest->contest_type,'cssPermission'=>$cssPermission));	
		}
	}

	private function updText(){

		$arrayGen	= array('titleMechanical','titlePrevious','urlPrevious','nameUrlPrevious','titleThanks','urlThanks','nameUrlThanks','titleWaiting','urlWaiting','nameUrlWaiting','titleClosure','urlClosure','nameUrlClosure','titlePleca','UrlImgLogo','UrlImgStage','textMechanical','textPhrase','textPrevious','textThanks','textWaiting','textClosure','UrlCss','colorHeader','colorTitleHead','colorFont','colorFooter','colorStage','UrlImg1Versus','UrlImg2Versus');
		$arrayTitles = array('titleMechanical','titlePrevious','urlPrevious','nameUrlPrevious','titleThanks','urlThanks','nameUrlThanks','titleWaiting','urlWaiting','nameUrlWaiting','titleClosure','urlClosure','nameUrlClosure','titlePleca','UrlImgLogo','UrlImgStage','UrlCss','colorHeader','colorTitleHead','colorFont','colorFooter','colorStage','UrlImg1Versus','UrlImg2Versus');
		$arrayTexts = array('textMechanical','textPhrase','textPrevious','textThanks','textWaiting','textClosure');

		$result = DB::table('contest_properties')->select('property_name','property_value')->where('id_contest',$this->UserID())->whereIn('property_name',$arrayTitles)->get();
		$resultText = DB::table('contest_properties')->select('property_name','property_value')->where('id_contest',$this->UserID())->whereIn('property_name',$arrayTexts)->get();
		
		$properties = new stdClass();

			foreach ($result as $key => $value) {
				$nameProperties = $value->property_name;
				$properties->$nameProperties = $value->property_value;
			}

			$contentText = new StdClass();

			foreach ($resultText as $key => $value) {
				
				$propertyName = $value->property_name;
				$propertieValue = $value->property_value;
				try {
					if(!@file_get_contents($propertieValue)){
						$properties->$propertyName = "";
						//DB::delete('DELETE from contest_properties where id_contest=? and property_name =?',array($this->UserID(),$propertyName));
					}else{
						$properties->$propertyName = file_get_contents($propertieValue);
					}
				} catch (Exception $e) {
					$value= str_replace("https://communities-dev.s3.amazonaws.com/", "https://s3-us-west-1.amazonaws.com/communities-dev/", $propertieValue);
					if(!@file_get_contents($value)){
						$properties->$propertyName = "";
					}else{
						$properties->$propertyName = file_get_contents($value);
					}
				}
					
			}

			return $properties;
	}


	public function getText(){

		$userPermission = $this->userPermission('promo_info'); 
		$cssPermission = $this->userPermission('promo_css'); 
		$idContest = Contest::find($this->UserID());
		return View::make(Config::get( 'app.main_template' ).'.contest/contestText')->with(array('numStep'=>'step8','properties'=>$this->updText(),'userPermission'=>$userPermission,'contestType'=>$idContest->contest_type,'cssPermission'=>$cssPermission));
	}

	public function postText(){

		$file = Input::file('fileCss');

		if($file){

			$directory = Config::get('app.folder');
		    $filename = $file->getClientOriginalName();
		    $upload_success = $file->move($directory, $filename);

			$s3 = AWS::get('s3');

		    $result = $s3->putObject(array(
		                'Bucket'          =>  'communities-dev',
		                'Key'             =>  "/escaleta/".$this->environment()."/contest/css/".$this->UserID()."_".$filename,
		                'ACL'             =>  'public-read',
		                'SourceFile'      =>  $directory.$filename,
		         	));

			$urlCss = $result['ObjectURL'];

			if (file_exists($directory.$filename)) { 
					unlink($directory.$filename); 
			}

		}else{

			$urlCss = DB::table('contest_properties')->where('id_contest',$this->UserID())->where('property_name','urlCss')->pluck('property_value');

			($urlCss)?$urlCss:$urlCss='';
		}
		

		$titleMechanical 	= 	Input::get("titleMechanical");
		$textMechanical 	= 	Input::get("textMechanical");
		$textPhrase 		= 	Input::get("textPhrase");
		$titlePrevious		=	Input::get("titlePrevious");
		$textPrevious		=	Input::get("textPrevious");
		$urlPrevious 		=	Input::get("urlPrevious");
		$nameUrlPrevious	=	Input::get("nameUrlPrevious");
		$titleThanks		=	Input::get("titleThanks");
		$textThanks			=	Input::get("textThanks");
		$urlThanks 			=	Input::get("urlThanks");
		$nameUrlThanks 		=	Input::get("nameUrlThanks");
		$titleWaiting 		=	Input::get("titleWaiting");
		$textWaiting		=	Input::get("textWaiting");
		$urlWaiting 		=	Input::get("urlWaiting");
		$nameUrlWaiting		=	Input::get("nameUrlWaiting");
		$titleClosure 		=	Input::get("titleClosure");
		$textClosure		=	Input::get("textClosure");
		$urlClosure 		=	Input::get("urlClosure");
		$nameUrlClosure		=	Input::get("nameUrlClosure");
		$titlePleca			=	Input::get("titlePleca");
		$UrlImgLogo 		=	Input::get("UrlImgLogo");
		$UrlImgStage 		=	Input::get("UrlImgStage");
		$colorHeader		=	Input::get("colorHeader");
		$colorTitleHead 	= 	Input::get("colorTitleHead");
		$colorFont			= 	Input::get("colorFont");
		$colorFooter		= 	Input::get("colorFooter");
		$colorStage			= 	Input::get("colorStage");
		$UrlImg1Versus 		=	Input::get("UrlImg1Versus");
		$UrlImg2Versus 		=	Input::get("UrlImg2Versus");

		$arrayTitles = array('titleMechanical'=>$titleMechanical,'titlePrevious'=>$titlePrevious,'urlPrevious'=>$urlPrevious,'nameUrlPrevious'=>$nameUrlPrevious,'titleThanks'=>$titleThanks,'urlThanks'=>$urlThanks,'nameUrlThanks'=>$nameUrlThanks,'titleWaiting'=>$titleWaiting,'urlWaiting'=>$urlWaiting,'nameUrlWaiting'=>$nameUrlWaiting,'titleClosure'=>$titleClosure,'urlClosure'=>$urlClosure,'nameUrlClosure'=>$nameUrlClosure,'titlePleca'=>$titlePleca,'UrlImgLogo'=>$UrlImgLogo,'UrlImgStage'=>$UrlImgStage,'UrlCss'=>$urlCss,'colorHeader'=>$colorHeader,'colorTitleHead'=>$colorTitleHead,'colorFont'=>$colorFont,'colorFooter'=>$colorFooter,'colorStage'=>$colorStage,'UrlImg1Versus'=>$UrlImg1Versus,'UrlImg2Versus'=>$UrlImg2Versus);
		$arrayTexts = array('textMechanical' =>$textMechanical,'textPhrase'=>$textPhrase,'textPrevious'=>$textPrevious,'textThanks'=>$textThanks,'textWaiting'=>$textWaiting,'textClosure'=>$textClosure);
		$arrayGen	= array('titleMechanical','titlePrevious','urlPrevious','nameUrlPrevious','titleThanks','urlThanks','nameUrlThanks','titleWaiting','urlWaiting','nameUrlWaiting','titleClosure','urlClosure','nameUrlClosure','titlePleca','UrlImgLogo','UrlImgStage','textMechanical','textPhrase','textPrevious','textThanks','textWaiting','textClosure','UrlCss','colorHeader','colorTitleHead','colorFont','colorFooter','colorStage','UrlImg1Versus','UrlImg2Versus');
		
		//$result = ContestProperties::where('id_contest',$this->UserID())->whereIn('property_name',$arrayGen)->count();

		/*if($result){
					DB::table('contest_properties')->where('id_contest',$this->UserID())->whereIn('property_name', $arrayGen)->delete(); 
		}*/

		foreach ($arrayTitles as $nameProperties => $valProperties) {

			$result = ContestProperties::where('id_contest',$this->UserID())->where('property_name',$nameProperties)->first();
			if (is_null($result) or !count($result)) {
				if($valProperties){
					$contestProperties = new ContestProperties;
					$contestProperties->id_contest = $this->UserID();
					$contestProperties->property_name = $nameProperties;
					$contestProperties->property_value = $valProperties;
					$contestProperties->save();
				}
			}else{
				$result->property_value = $valProperties;
				$result->save();
			}

		}


		$dir = Config::get('app.folder');

		foreach ($arrayTexts as $nameFile => $contentFile) {

			//Cache::forget('promo_info_prueba');
			//echo 222;exit();
			$fileCreated = $this->UserID()."_".$nameFile.".txt";
		    $handle = opendir($dir); 


			if($contentFile){


				$fileCreated = $this->UserID()."_".$nameFile.".txt";
				$fileCreatedBckp = $this->UserID()."_".$nameFile."_".time().".txt";
			    
			    $handle = opendir($dir); 

			    $ruta_fichero = $dir.$fileCreated;
			    $ruta_ficheroBckp = $dir.$fileCreatedBckp;


				if (file_exists($ruta_fichero)) { 
					unlink($ruta_fichero); 
				}
				if (file_exists($ruta_ficheroBckp)) { 
					unlink($ruta_ficheroBckp); 
				}

			    $fp=fopen(Config::get('app.folder').$fileCreated,"x");
			    fwrite($fp,$contentFile);
			    fclose($fp);

			    $fpBckp=fopen(Config::get('app.folder').$fileCreatedBckp,"x");
			    fwrite($fpBckp,$contentFile);
			    fclose($fpBckp);

			    $s3 = AWS::get('s3');

		        $result = $s3->putObject(array(
		           					'ACL'        => 'public-read',
		                            'Bucket'     => 'communities-dev',
		                            'Key'        => "/escaleta/".$this->environment()."/contest/text/".$fileCreated,
		                            'SourceFile' =>  $ruta_fichero
		        ));

		        $s3->putObject(array(
		           					'ACL'        => 'public-read',
		                            'Bucket'     => 'communities-dev',
		                            'Key'        => "/escaleta/".$this->environment()."/contest/text/".$fileCreatedBckp,
		                            'SourceFile' => $ruta_ficheroBckp
		        ));
		        unlink($ruta_fichero);
		        unlink($ruta_ficheroBckp);

		        $url = $result['ObjectURL'];

		        $nfileBD = ContestProperties::where('id_contest',$this->UserID())->where('property_name',$nameFile)->first();
				if (is_null($nfileBD) or !count($nfileBD)) {
			        $contestProperties = new ContestProperties;
					$contestProperties->id_contest = $this->UserID();
					$contestProperties->property_name = $nameFile;
					$contestProperties->property_value = $url;
					$contestProperties->save();
				}


				$valResp = ContestProperties::where('id_contest',$this->UserID())->where('property_name',$nameFile."_bckp")->first();

			   	if (is_null($valResp) or !count($valResp)) {
					$bckFile = json_encode(array($fileCreatedBckp));
					$contestProperties = new ContestProperties;
					$contestProperties->id_contest = $this->UserID();
					$contestProperties->property_name = $nameFile."_bckp";
					$contestProperties->property_value = $bckFile;
					$contestProperties->save();
			   }else{
			  		$newBck = json_decode($valResp->property_value);
			   		//array_push($newBck,$fileCreatedBckp);
			   		$newBck[]=$fileCreatedBckp;
			   	 	//DB::delete("DELETE from contest_properties where property_name=? and id_contest=?",array($nameFile."_bckp",$this->UserID()));
					$bckFile = json_encode($newBck);
					$valResp->property_value = $bckFile;
					$valResp->save();
			   }
			}
			
		}

		/********************************************************/
		$userPermission = $this->userPermission('promo_date');
		$contest = Contest::find($this->UserID());


		$this->generateJSON($this->UserID());

		return View::make(Config::get( 'app.main_template' ).'/contest/quiz')->with(array('numStep'=>'step9','typeQuestion'=>$contest->contest_type,'questionAnswer'=>$this->questionAnswers($contest),'userPermission'=>$userPermission));

	}


protected function questionAnswers($contest){

		$question = Question::where('contest_id',$contest->id_contest)
							->where('status','!=',false)
							->orderBy('order')->get();


		if(count($question)>0){

			if($contest->contest_type == 'versus'){

				$questionOption = QuestionOptions::select('text','order','img')
													->where('question_id',$question[0]->id)
													->where('status','!=',false)
													->orderBy('order','ASC')
													->get();

				$options = [];
									
				$i=0;
				foreach ($question as $item) {
					foreach ($questionOption as $key => $value) {

						$options[$i]['text'] = $value->text;
						$options[$i]['img'] = $value->img;
						$i++;
					}
					$item['contest_type'] = $contest->contest_type;
					$item['optionsQuestion'] = $options;
				}
									
				$questionAnswer = $question[0];

			}else{

				$idsQuestions = array();

				for ($i=0; $i < count($question) ; $i++) { 
					array_push($idsQuestions, $question[$i]->id);
				}

				$questionOptions = DB::table('questions_options')
									->select(DB::raw('GROUP_CONCAT(text order by `order`) AS text'),DB::raw('GROUP_CONCAT(img order by `order`) as img'))
				                    ->whereIn('question_id', $idsQuestions)
				                    ->where('status','!=',false)
				                    ->groupBy('question_id')
									->get();

					
				if($questionOptions){

					$t=0;
					for ($i=0; $i < count($questionOptions) ; $i++) { 

							$text[$i] = explode(",",$questionOptions[$i]->text);
							$img[$i] = explode(",",$questionOptions[$i]->img);
									
								for ($j=0; $j <count($text[$i]) ; $j++) { 
										
									$options[$i][$t]['text'] = $text[$i][$j];
									$options[$i][$t]['img'] = $img[$i][$j];	
									$t++;
								}
						$question[$i]["contest_type"] = $contest->contest_type;
						$question[$i]["optionsQuestion"] = $options[$i];
					}
				}
					
				$questionAnswer = $question;
			}

			return $questionAnswer;

		}else{

			return null;
		}	
}




private function generateJSON($id){

		$resultContest = DB::select("SELECT c.id_contest,short_name,end_date,activation_date,contest_type,concat(property_name,'|',property_value) as properties from contest c INNER JOIN contest_properties as cp  on(c.id_contest=cp.id_contest) where c.id_contest=? and property_value!='' GROUP BY property_name",array($id));
			
			$json = [];
			foreach ($resultContest as $key => $value) {
				foreach ($value as $key1 => $value1) {
					if($key1!='properties'){
						$json[$key1]= $value1;
					}else{
						$properties = explode("|", $value1);
						$json['properties'][$properties[0]]=$properties[1];
					}
				}
			}

			$dir = Config::get('app.folder');
	    	$handle = opendir($dir);
	    	$fileCreated = $this->UserID()."-jsonContest.js";
	    	$ruta_fichero = $dir.$fileCreated;

            if (file_exists($ruta_fichero)) { 
				unlink($ruta_fichero); 
			}

			$fp=fopen(Config::get('app.folder').$fileCreated,"x");
            	fwrite($fp,json_encode($json));
            	fclose($fp);

			$s3 = AWS::get('s3');

            $s3->putObject(array(
           					'ACL'        => 'public-read',
                            'Bucket'     => 'communities-dev',
                            'Key'        => "/escaleta/".$this->environment()."/contest/js/".$fileCreated,
                            'SourceFile' => Config::get('app.folder').$fileCreated
            ));
            unlink($ruta_fichero); 

			//Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');

	}





	/*************************************** FUNCTIONS ********************************************************/

	protected function lastID($urlContest,$arrayFields){

		$contest = new Contest;
		$contest->short_name   = $urlContest;
		$contest->save();

		$lastInsertId  = DB::getPdo()->lastInsertId();

		for ($i=0; $i < count($arrayFields); $i++) { 

			$contestProperties = new ContestProperties;
			$contestProperties->id_contest = $lastInsertId;
			$contestProperties->property_name = $arrayFields[$i];
			$contestProperties->property_value = Input::get($arrayFields[$i]);
			$contestProperties->save();
		}

		return $lastInsertId;
	}



	protected function UserID(){

			return Session::get('SesionID');
	}

	protected function contestDateData($id){
		
		$result = DB::select('SELECT start_date,end_date,activation_date,contest_type from contest where id_contest=?',array($id));

		$statusRate = DB::table('contest_properties')->where('id_contest',$id)->where('property_name','statusRate' )->pluck('property_value');

				$shortDate = ''; $endDate='';$activationDate='';$contestType='';

				foreach ($result as $key => $value) {
					$shortDate = $value->start_date;
					$endDate =  $value->end_date;
					$activationDate= $value->activation_date;
					$contestType= $value->contest_type;
				}

				$datesAll = new stdClass;
				$datesAll->startDate = date('Y/m/d',$shortDate);
				$datesAll->startTime = date('h:i A',$shortDate);
				$datesAll->closingDate = date('Y/m/d',$endDate);
				$datesAll->closingTime = date('h:i A',$endDate);
				$datesAll->activationDate = date('Y/m/d',$activationDate);
				$datesAll->activationTime = date('h:i A',$activationDate);
				$datesAll->contestType = $contestType;
				$datesAll->statusRate = isset($statusRate)? $statusRate : null;

				return $datesAll;
	}



	protected function contestTable($channel=''){

		if ($channel=='todos') {
			$result = DB::select("SELECT id_contest,short_name,start_date,end_date,activation_date,contest_type from contest");
		}else{
			$result = DB::select("SELECT c.id_contest,c.short_name, c.start_date, c.end_date, c.activation_date, c.contest_type from contest as c, contest_properties as cp where c.id_contest=cp.id_contest and property_name='channel' and property_value=?",array($channel));
		}

			$dataAll = array();
			#$data= new stdClass();

			foreach ($result as $key => $value) {

				$data= new stdClass();

				if($value->start_date || $value->end_date || $value->activation_date){
					$starDate = date('Y/m/d h:i A', $value->start_date);
					$endDate = date('Y/m/d h:i A', $value->end_date);
					$activationDate = date('Y/m/d h:i A', $value->activation_date);

				}else{
					$starDate = '----/--/-- 00:00';
					$endDate = '----/--/-- 00:00';
					$activationDate = '----/--/-- 00:00';
				}

				$statusPDF = DB::table('contest_properties')
								->select('property_value')
								->where('id_contest', $value->id_contest)
								->where('property_name','statusRate')
								->pluck('property_value');

				$channel_db = DB::table('contest_properties')
								->select('property_value')
								->where('id_contest', $value->id_contest)
								->where('property_name','channel')
								->pluck('property_value');

				$data->id_contest = $value->id_contest;
				$data->short_name = $value->short_name;
				$data->start_date = $starDate;
				$data->end_date = $endDate;
				$data->activation_date = $activationDate;
				$data->contest_type = $value->contest_type;
				$data->channel = $channel_db;
				$data->statusPDF = $statusPDF;

				$dataAll[] = $data;
			}

			return $dataAll;
	}

	private function datetimeStr($dates,$times){

		$date = date_create($dates);
		$dateForm = date_format($date,"Y/m/d");
		$time = date_create($times);
		$timeForm = date_format($time,"H:i:s");

		return strtotime($dateForm." ".$timeForm);
	}

/********************************** REPORTE CSV *****************************************************/


	public function getReportCsv($id){

	$nameContest = DB::connection('mysql2')->table('users')->where('contest_id',$id)->pluck('contest');

		if($nameContest){

			Session::forget('msgCsv');

			Excel::create("Reporte_".$nameContest."_".date('d-m-Y'),function($excel) use($id){

				$excel->sheet('Sheetname',function($sheet) use($id) {

					$file = array_merge($this->usersAll($id),$this->usersService($id),$this->usersAge($id),$this->userCountry($id),$this->userState($id),$this->userHour($id),$this->usersAllPart($id),$this->usersServicePart($id),$this->usersAgePart($id),$this->userCountryPart($id),$this->userStatePart($id),$this->userHourPart($id));
					
					$sheet->fromArray($file);	

				});

			})->download('csv');


		}else{
			//Session::flash('msgCsv', "No hay Informacion para descargar");
			return Redirect::back();
		}

	}

	/********************************** REPORTE CSV *****************************************************/


	public function getReportPdf($id){

		$passwordPDF = $this->generatePasswordPDF();
    
		$pdf=new FPDF_Protection();

		$pdf->SetProtection(array(),$passwordPDF);

		$properties= DB::connection('mysql2')->table('users AS u')
												->select('u.email_hash','u.first_name','u.last_name','u.tel','u.gender','u.age','u.birthdate','u.country','u.state','s.social_network','u.contest','p.phrase','p.created_at')
												->join('social_network AS s', 'u.id', '=', 's.user_id')
												->join('phrase AS p', 's.user_id', '=', 'p.user_id')
												->where('u.contest_id',$id)
												->orderBy('p.created_at', 'asc')
												->get();

		if($properties){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			//$pdf->SetFillColor(0, 0, '255');
			//$pdf->SetDrawColor(128,0,0);
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,'Participantes', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			$paises = Config::get('paises');


			foreach ($properties as $value) {

				$pdf->Cell(70,5,'Nombre :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode(Crypt::decrypt($value->first_name))." ".utf8_decode(Crypt::decrypt($value->last_name)),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Email :',1,0,'L',0);
				$pdf->Cell(70,5,Crypt::decrypt($value->email_hash),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Gender :',1,0,'L',0);
				$pdf->Cell(70,5,$value->gender,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Telefono :',1,0,'L',0);
				$pdf->Cell(70,5,Crypt::decrypt($value->tel),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Edad :',1,0,'L',0);
				$pdf->Cell(70,5,$value->age,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de Nacimiento:',1,0,'L',0);
				$pdf->Cell(70,5,$value->birthdate,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Pais :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode(isset($paises[$value->country])?$paises[$value->country]:$value->country),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Estado :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode($value->state),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Concurso :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode($value->contest),1,0,'L',0);
				$pdf->Ln();
		        $pdf->Cell(70,5,'Red Social :',1,0,'L',0);
				$pdf->Cell(70,5,$value->social_network,1,0,'L',0);
				$pdf->Ln();
		        $pdf->Cell(70,5,'Frase :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode($value->phrase),1,0,'L',0);
				$pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de Registro :',1,0,'L',0);
				$pdf->Cell(70,5,$value->created_at,1,0,'L',0);
		        $pdf->Ln(15);
			}
			
			$pdf->Output('reportepromocion'.time().'.pdf','D');

			$this->sendEmailPassword($passwordPDF);

		}else{
			return  Redirect::to('/contest');	
		}
	}

	public function getReportPdfVersus($id){

		//$passwordPDF = $this->generatePasswordPDF();
    	$pdf=new FPDF_Protection();
		//$pdf->SetProtection(array(),$passwordPDF);

		$query = DB::select("SELECT qa.id, qa.text FROM questions q, questions_options qa WHERE q.id=qa.question_id AND q.contest_id=?",array($id));
				
		if($query){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,utf8_decode('Resultados la votación'), '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->Cell(70,5,utf8_decode('Opción'),1,0,'L',0);
			$pdf->Cell(70,5,utf8_decode('Votos'),1,0,'L',0);
			$pdf->Ln(5);
			$pdf->SetFont('helvetica', '', 10);
			
			
			foreach ($query as $value) {

				$votos= DB::connection('mysql2')->select("SELECT sum(votos) as total FROM versus WHERE contest_id=? AND option_id=?",array($id,$value->id));
				$pdf->Cell(70,5,$value->text,1,0,'L',0);
				$pdf->Cell(70,5,$votos[0]->total,1,0,'L',0);
				$pdf->Ln(5);
			}

			//TOP 5 - Users
			$pdf->Ln(20);
			$pdf->SetFont('Arial');
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,utf8_decode('Top 5'), '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			$contestRw=ContestRewards::select('point_id')
						->where('contest_id',$id)
						->first();
			$users = DB::connection('mysql2')
						->table('user_rewards')
			            ->join('users', 'users.id', '=', 'user_rewards.user_id')
			            ->join('social_network', 'social_network.user_id', '=', 'user_rewards.user_id' )
			            ->where('point_id',$contestRw->point_id)
			            ->select('email_hash', 'first_name', 'last_name', 'points','social_network')
			            ->orderBy('points','desc')
		                ->take(5)
			            ->get();

			foreach ($users as $user) {
				
				$pdf->Cell(70,5,'Nombre :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode(Crypt::decrypt($user->first_name))." ".utf8_decode(Crypt::decrypt($user->last_name)),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Email :',1,0,'L',0);
				$pdf->Cell(70,5,Crypt::decrypt($user->email_hash),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Red Social :',1,0,'L',0);
				$pdf->Cell(70,5,$user->social_network,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Puntos :',1,0,'L',0);
				$pdf->Cell(70,5,$user->points,1,0,'L',0);
		        $pdf->Ln(15);

	        }

			$pdf->Output('reportederesultados'.time().'.pdf','D');
			// $this->sendEmailPassword($passwordPDF);

		}else{
			return  Redirect::to('/contest');	
		}
	}

/* USUARIOS REGISTRADOS */

	private function usersAll($id){
		
		$query = DB::connection('mysql2')->select("SELECT count(*) as 'totalUsers',COUNT(IF(gender ='male',1,null)) as 'usersMale',COUNT(IF(gender ='female',1,null)) as 'usersFemale' from users where contest_id=?",array($id));

			$data[] = array('REGISTROS');
			$data[] = array('');
			$data[] = array('Total Usuarios','Hombre','Mujer');
			
			foreach ($query as $key => $value) {
					$data[] = array($value->totalUsers,$value->usersMale,$value->usersFemale);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function usersService($id){

			$query = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=? GROUP BY social_network",array($id));

			$data[] = array('Redes Sociales','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->social_network,$value->ageMale,$value->ageFemale,$value->ageTotal);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}


		return $data;
	}



	private function usersAge($id){

			$query = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users where age!='' and contest_id=? GROUP BY age",array($id));

			$data[] = array('Edad','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->age,$value->ageMale,$value->ageFemale,$value->ageTotal);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}


		return $data;
	}

	private function userCountry($id){

		   $query = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale', COUNT(IF(gender ='female',1,null)) as 'countryFemale',count(*) as countryTotal from users where contest_id=? GROUP BY country",array($id));
		
			$data[] = array('Pais','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->country,$value->countryMale,$value->countryFemale,$value->countryTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function userState($id){

		$query = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale', COUNT(IF(gender ='female',1,null)) as 'stateFemale',count(*) as stateTotal from users where contest_id=? GROUP BY state",array($id));

			$data[] = array('Estado','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->state,$value->stateMale,$value->stateFemale,$value->stateTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function userHour($id){

		$query = DB::connection('mysql2')->select("SELECT HOUR(created_at) as hora,COUNT(IF(gender ='male',1,null)) as 'hourMale', COUNT(IF(gender ='female',1,null)) as 'hourFemale',count(*) as hourTotal from users where contest_id=? GROUP BY HOUR(created_at)",array($id));

			$data[] = array('Hora','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->hora,$value->hourMale,$value->hourFemale,$value->hourTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

/* USUARIOS QUE PARTICIPARON */

	private function usersAllPart($id){
		
		$contest = Contest::find($id);

		if (strtolower($contest->contest_type)=='frase') {
			
			$query = DB::connection('mysql2')->select("SELECT count(*) as 'totalUsers',COUNT(IF(gender ='male',1,null)) as 'usersMale',COUNT(IF(gender ='female',1,null)) as 'usersFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=?",array($id));
		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT count(*) as 'totalUsers',COUNT(IF(gender ='male',1,null)) as 'usersMale',COUNT(IF(gender ='female',1,null)) as 'usersFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on p.user_id=u.id where u.contest_id=?",array($id, $id));
		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT count(*) as 'totalUsers',COUNT(IF(gender ='male',1,null)) as 'usersMale',COUNT(IF(gender ='female',1,null)) as 'usersFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on p.user_id=u.id where u.contest_id=?",array($id, $id));
		}



			$data[] = array('USUARIOS PARTICIPANTES');
			$data[] = array('');
			$data[] = array('Total Usuarios','Hombre','Mujer');
			
			foreach ($query as $key => $value) {
					$data[] = array($value->totalUsers,$value->usersMale,$value->usersFemale);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function usersServicePart($id){

		$contest = Contest::find($id);

		if (strtolower($contest->contest_type)=='frase') {
			
			$query = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY social_network",array($id));

		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY social_network",array($id, $id));
		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY social_network",array($id, $id));
		}


		
			$data[] = array('Redes Sociales','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->social_network,$value->ageMale,$value->ageFemale,$value->ageTotal);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}


		return $data;
	}


	private function usersAgePart($id){

		$contest = Contest::find($id);
		if (strtolower($contest->contest_type)=='frase') {
			
			$query = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY age",array($id));

		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY age
",array($id,$id));

		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY age
",array($id,$id));

		}


			$data[] = array('Edad','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->age,$value->ageMale,$value->ageFemale,$value->ageTotal);
			}

			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}


		return $data;
	}

	private function userCountryPart($id){

		$contest = Contest::find($id);
		if (strtolower($contest->contest_type)=='frase') {
			
 			$query = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale', COUNT(IF(gender ='female',1,null)) as 'countryFemale',count(*) as countryTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY country",array($id));
		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale', COUNT(IF(gender ='female',1,null)) as 'countryFemale',count(*) as countryTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY country",array($id,$id));

		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale', COUNT(IF(gender ='female',1,null)) as 'countryFemale',count(*) as countryTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY country",array($id,$id));

		}



		   
		
			$data[] = array('Pais','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->country,$value->countryMale,$value->countryFemale,$value->countryTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function userStatePart($id){

		$contest = Contest::find($id);
		if (strtolower($contest->contest_type)=='frase') {
			
	 		$query = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale', COUNT(IF(gender ='female',1,null)) as 'stateFemale',count(*) as stateTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY state",array($id));

		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale', COUNT(IF(gender ='female',1,null)) as 'stateFemale',count(*) as stateTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY state
",array($id, $id));

		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale', COUNT(IF(gender ='female',1,null)) as 'stateFemale',count(*) as stateTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY state
",array($id, $id));

		}


		
			$data[] = array('Estado','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->state,$value->stateMale,$value->stateFemale,$value->stateTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function userHourPart($id){

		$contest = Contest::find($id);
		if (strtolower($contest->contest_type)=='frase') {
			
			$query = DB::connection('mysql2')->select("SELECT HOUR(u.created_at) as hora,COUNT(IF(gender ='male',1,null)) as 'hourMale', COUNT(IF(gender ='female',1,null)) as 'hourFemale',count(*) as hourTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id)  INNER JOIN phrase p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY HOUR(u.created_at)",array($id));
		} 
		
		if ($contest->contest_type=='quiz') {
			
			$query = DB::connection('mysql2')->select("SELECT HOUR(u.created_at) as hora,COUNT(IF(gender ='male',1,null)) as 'hourMale', COUNT(IF(gender ='female',1,null)) as 'hourFemale',count(*) as hourTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa where qa.contest_id=? group by qa.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY HOUR(u.created_at)",array($id,$id));

		}

		if ($contest->contest_type=='versus') {
			
			$query = DB::connection('mysql2')->select("SELECT HOUR(u.created_at) as hora,COUNT(IF(gender ='male',1,null)) as 'hourMale', COUNT(IF(gender ='female',1,null)) as 'hourFemale',count(*) as hourTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select v.user_id from versus v where v.contest_id=? group by v.user_id) as p on (sn.user_id=p.user_id) where u.contest_id=? GROUP BY HOUR(u.created_at)",array($id,$id));

		}

			$data[] = array('Hora','Hombre','Mujer','Total');

			foreach ($query as $key => $value) {
					$data[] = array($value->hora,$value->hourMale,$value->hourFemale,$value->hourTotal);
			}
			for ($i=0; $i < 3 ; $i++) { 
				$data[] = array($i=>"",$i=>"");
			}

		return $data;
	}

	private function environment(){

		$environment = App::environment();
		($environment) ? $folderEnvironment=$environment : $folderEnvironment="tmp";
		
		return $folderEnvironment;
	}

	protected function generatePasswordPDF(){
		
		$acceptablePasswordChars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_.$@#&0123456789";
	    $randomPassword = "";

	    for($i = 0; $i < 10; $i++)
	    {
	        $randomPassword .= substr($acceptablePasswordChars, rand(0, strlen($acceptablePasswordChars) - 1), 1);  
	    }

	    return $randomPassword;
	}

	protected function sendEmailPassword($passwordPDF){

		$user = Sentry::getUser();

		$nameUser = Crypt::decrypt($user->first_name);
		$emailUser = $user->email;

			$datos = array(
                'subject' => "Password",
                'msg' => $passwordPDF,
                'user' => $nameUser
			);

		Mail::send('emails.passwordPDF', $datos, function($message) use ($emailUser)
			{
			        $message->to($emailUser)->subject('Research Televisa');
		});

	}

}
