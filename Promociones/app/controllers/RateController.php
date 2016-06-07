<?php

class RateController extends ContestController {


	public function __construct()
    {
		parent::__construct();
		//Config::set('app.main_template', 'promociones2');
        
    }
    
	public function getContestView($info){
		/*
		echo "<br />###Info Contest <pre>";
			print_r($info);
		echo "</pre>";*/

		$id_user = Session::get("user.id");
		$reviewExist =  $this->reviewContestAnswer($id_user, $info->id_contest);
		
		if($reviewExist){
			//echo $this->nameController($info)."/".$info->short_name.'/gracias';
			if (strtolower($info->contest_type)=="quiz") {
				return Redirect::to($this->nameController($info)."/".$info->short_name.'/gracias')->with(array('info'=>$info,'contentText'=>$info->short_name,'adUnit'=>'gracias'));
			}elseif (strtolower($info->contest_type)=="video") {
				$video =  $this->reviewVideoUp($id_user, $info->id_contest);
				if($video){
					return Redirect::to($this->nameController($info)."/".$info->short_name.'/gracias')->with(array('info'=>$info,'contentText'=>$info->short_name,'adUnit'=>'gracias'));
				}else{				
					return View::make(Config::get( 'app.main_template' ).'.video.uploadvideo')->with(array("short_name"=>$info->short_name,"info"=>$info,'adUnit'=>'frase'));											
				}
			}
		}


		if(strtolower($info->short_name)=='demo'){			
			return View::make(Config::get( 'app.main_template' ).'.demo')->with(array("short_name"=>$info->short_name,"info"=>$info,'adUnit'=>'demo'));
		}else{
			switch(strtolower($info->contest_type)){
				case "frase":	
						//echo "Fraes";					
						return View::make(Config::get( 'app.main_template' ).'.pregunta')->with(array("short_name"=>$info->short_name,"info"=>$info,'adUnit'=>'frase'));							
					break;		
				case "versus":												
						//echo "versus";
						$question = $this->getInfoQuestion($info->id_contest);
						$info->question = $question[0];					
						$options = $this->getOptionsQuestion($question[0]->id);
						$info->options = $options;						

						return View::make(Config::get( 'app.main_template' ).'.versus')->with(array("short_name"=>$info->short_name,"info"=>$info,'adUnit'=>'frase'));													
					break;	
				case "quiz":
												
						//echo "quiz";

						$questions = $this->getInfoQuestion($info->id_contest);

						$data = array();						
						foreach($questions as $key => $question){
							$data[$key]['questions']= $question;

							$options = $this->getOptionsQuestion($question->id);
							$data[$key]['options']=$options;

							$selectOptions = array();							
							foreach($options as $ind => $option){								
                        		$selectOptions[($option->id)]= $option->text;    
							}

							$data[$key]['selectOptions']=$selectOptions;

						}

						return View::make(Config::get( 'app.main_template' ).'.quiz')->with(array("short_name"=>$info->short_name,"info"=>$info, 'data'=>$data,'adUnit'=>'frase'));							
					break;	
				case "foto":												
						
						$photo =  $this->reviewPhotoUp($id_user, $info->id_contest);

						if($photo){
							return View::make(Config::get( 'app.main_template' ).'.foto.detalle')->with(array("short_name"=>$info->short_name,"info"=>$info,"photo"=>$photo,'contentText'=>$this->infoText($info->short_name),'adUnit'=>'gracias'));											
						}else{				
							return View::make(Config::get( 'app.main_template' ).'.foto.uploadphoto')->with(array("short_name"=>$info->short_name,"info"=>$info,'adUnit'=>'frase'));											
						}						
					break;
				case "video":

						$questions = $this->getInfoQuestion($info->id_contest);
				
						$data = array();						
				
						foreach($questions as $key => $question){
							$data[$key]['questions']= $question;
							$options = $this->getOptionsQuestion($question->id);
							$data[$key]['options']=$options;
							$selectOptions = array();							
							foreach($options as $ind => $option){								
				         		$selectOptions[($option->id)]= $option->text;    
							}
							$data[$key]['selectOptions']=$selectOptions;
						}

						return View::make(Config::get( 'app.main_template' ).'.quiz')->with(array("short_name"=>$info->short_name,"info"=>$info, 'data'=>$data,'adUnit'=>'frase'));							
					break;	
			}	
		}	
	}

	public function saveDataQuizz($infoContest, $infoPost){				
		
		//se obtiene la informacion general de las respuestas para el quiz
		$idContest = $infoContest->id_contest;
		$user_id = Session::get("user.id");		
		$contestType = $infoContest->contest_type;	
		
		$valores = array();
		foreach($infoPost as $key => $val){
			$options = explode("_", $key);

			if(isset($options[1]) && ($options[1]== 'text' || $options[1]== 'textarea')){
				//echo "<br />validar text: ".$key." idQuestion:".$options[0];

				$validate = $this->getValidationQuestion($options[0]);

				$valores[$key]=$val;
				$validaciones[$key]=array('required', $validate->validationType);

			}		
		}	
		
		if (count($valores)>0) {
			$validator = Validator::make($valores , $validaciones);
		}
		
		
		if (isset($validator) && $validator->fails())
		{			
			return Redirect::back()->withErrors($validator)->withInput();
		}else{		  		

			//se leen las opciones recibidas y se clasifica de acuerdo al tipo de pregunta
			//el nombre del campo contiene el id de la pregunta  + _ + tipo de elemento
			foreach($infoPost as $key => $val){
				$options = explode("_", $key);
				if(count($options)==2){

					//una vez separada la cadena se recupera el id de la pregunta
					$questionId = $options[0];

					//echo "<br /><br />Key: ".$key ." QuestonId: ".$options[0]." tipoElemento: ".$options[1];
					//si es un checkbox se recorre
					if(is_array($val)){
						foreach($val as $id){
							//se guarda la opcion seleccionada
							//echo "<br />-- Guardar Check Opcion -- ".$id;
							$this->saveVoto($idContest, $user_id, $questionId, $id, $contestType);
						}
					}

					else{					
						if($options[1]=='radio' || $options[1]=='select'){
							$this->saveVoto($idContest, $user_id, $questionId, $infoPost[$key], $contestType);
						}
						else if($options[1]=='text' || $options[1]=='textarea' || $options[1]=='foto'){
							
							$this->saveVoto($idContest, $user_id, $questionId, 0, $contestType, $infoPost[$key]);						
						}
					}
				}	

			}

			if (strtolower($infoContest->contest_type)=="video") {
				return  Redirect::to($this->nameController($infoContest)."/".$infoContest->short_name);											
			}
			return  Redirect::to($this->nameController($infoContest)."/".$infoContest->short_name."/gracias");
		}	
	}


	public function obtenerConteo($id_contest){		

		$question = DB::table('questions_answers')											
											->select(DB::raw('count(*) as count, option_id'))											
											->where('contest_id', $id_contest)
											->groupBy('question_id')
											->groupBy('option_id')
											->get();		

		if(is_null($question)){
			return false;
		}			
		else{
			return $question;
		}											
												
	}

	public function saveVoto($contest_id, $user_id, $question_id, $option_id, $type, $text=""){

		$question = DB::table('questions_answers')
						->select('id')
						->where('user_id', $user_id)
						->where('contest_id', $contest_id)
						->where('question_id', $question_id)
						->first();

		if(is_null($question)){
			$resultInsert = $this->insertAnswerOption($contest_id, $user_id, $question_id, $option_id, $type, $text);
			return $resultInsert;
		}			
		else{
			return $question;
		}	

		
	}

	protected function getInfoQuestion($id_contest){
		Cache::forget('question_info_'.$id_contest);
		if (Cache::has('question_info_'.$id_contest)){
    		return Cache::get('question_info_'.$id_contest);
		}else{
			$question = DB::connection('mysql2')->table('questions')
												//->join('questions_options', 'questions.id', '=', 'questions_options.question_id')
												->select('questions.*')
												->where('contest_id', $id_contest)
												->where('status', '=', 1)
												->orderBy('order', 'ASC')->get();

			if(is_null($question)){
				return false;
			}			
			else{
				Cache::add('question_info_'.$id_contest,$question, 180);
				return $question;
			}
		}								
	}

	protected function getOptionsQuestion($id_question){
		Cache::forget('options_question_'.$id_question);
		if (Cache::has('options_question_'.$id_question)){
    		return Cache::get('options_question_'.$id_question);
		}else{
			$question = DB::connection('mysql2')->table('questions_options')
												//->join('questions_options', 'questions.id', '=', 'questions_options.question_id')
												->select('questions_options.*')
												->where('question_id', $id_question)
												->where('status', '=', 1)
												->orderBy('order', 'ASC')->get();

			if(is_null($question)){
				return false;
			}			
			else{
				Cache::add('options_question_'.$id_question,$question, 180);
				return $question;
			}
		}								
	}

	public function insertAnswerOption($contest_id, $user_id, $question_id, $option_id, $type, $text=""){

		$sqlInsert = array(	'contest_id' => $contest_id,
          					'user_id' => $user_id,
          					'question_id' => $question_id,
          					'option_id' => $option_id,
          					'type' => $type,
          					'question_text' => $text,
          					'created_at'  =>     new DateTime,
						    'updated_at'  =>     new DateTime);

		$resinsert = DB::table('questions_answers')->insert($sqlInsert);
		return $resinsert;
				
	}

	public function reviewContestAnswer($id_user, $id_contest){
		$question = DB::table('questions_answers')
						->select('id')
						->where('user_id', $id_user)
						->where('contest_id', $id_contest)
						->first();

		if(is_null($question)){
			return false;
		}			
		else{
			return $question;
		}					

	}

	public function reviewPhotoUp($id_user, $id_contest){
		$question = DB::table('fotos')
						->select('id','foto_url','foto_name','status','voto_url')
						->where('user_id', $id_user)
						->where('contest_id', $id_contest)
						->first();

		if(is_null($question)){
			return false;
		}			
		else{
			return $question;
		}					

	}

	public function reviewVideoUp($id_user, $id_contest){

		$question = DB::table('videos')
						->select('id','video_url','video_name','status','voto_url')
						->where('user_id', $id_user)
						->where('contest_id', $id_contest)
						->first();

		if(is_null($question)){
			return false;
		}else{
			return $question;
		}					
	}


	public function getValidationQuestion($id_question){
		$question = DB::connection('mysql2')->table('questions')
											//->join('questions_options', 'questions.id', '=', 'questions_options.question_id')
											->select('*')
											->where('id', $id_question)											
											->first();

		if(is_null($question)){
			return false;
		}			
		else{
			return $question;
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

}	