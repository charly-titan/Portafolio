<?php
class QuestionController extends ContestController {


    public function postImgQuiz(){
		
		$file = Input::file('file');
	    $filename = $file->getClientOriginalName();

		$s3 = AWS::get('s3');

	       $result = $s3->putObject(array(
	           			'ACL'        	=> 'public-read',
	                    'Bucket'     	=> 'communities-dev',
	                    'Key'        	=> "/escaleta/contest/".App::environment()."/quiz/img/".$filename,
	                    'ContentType' 	=> 'image/jpeg',
						'Body'   		=>  fopen($file, 'r+')
	        ));   

	        $url = $result['ObjectURL'];

		return $url;
	}

	public function getQuiz(){

		$userPermission = $this->userPermission('promo_date');
		$contest = Contest::find($this->UserID());

		return View::make(Config::get( 'app.main_template' ).'/contest/quiz')->with(array('numStep'=>'step9','typeQuestion'=>$contest->contest_type,'questionAnswer'=>$this->questionAnswers($contest),'userPermission'=>$userPermission));
	
	}


	public function postQuiz(){

		//return Input::all();

		$question 			= Input::get('question');
		$typeQuestion 		= Input::get('typeQuestion');
		$maxElemntsSel 		= Input::get('maxElemntsSel');
    	$helpText 			= Input::get('helpText');
    	$errorText 			= Input::get('errorText');
    	$placeholder 		= Input::get('placeholder');
    	$required 			= Input::get('required');
    	$optionsQuestion 	= Input::get('optionsQuestion');
    	$titleImg 			= Input::get('titleImg');
    	$imgQuestion		= Input::get('imgQuestion');

    	$rules = array(
			'question'    	=> 'required',
			'typeQuestion'  => 'required',
			'helpText'    	=> 'required',
			'errorText'     => 'required',
			'required'		=> 'required'
		);
		$inputs = Input::all();


		if(Session::get('IdQuestion')){

			$idQuestion = Session::get('IdQuestion');

			$affectedRows = Question::where('id', '=', $idQuestion)
								->update(array('questionText' => $question,
												'questionType' => strtolower($typeQuestion),
												'numElemetMaxSel'=> $maxElemntsSel+1,
												'helpText'=>$helpText,
												'errorText'=>$errorText,
												'placeholder'=>$placeholder,
												'request'=>($required)?$required:false,
												'img' => isset($imgQuestion)?$imgQuestion:''));

			$questionOptUpd =  QuestionOptions::find($idQuestion);
					
					if($questionOptUpd)
						$questionOptUpd->delete();

			if($titleImg){

	    		$i=0;
				foreach ($titleImg as $imgUrl => $imgTitle) {

		    			$questionOptionNew = new QuestionOptions;
				    	$questionOptionNew->question_id = $idQuestion;
				    	$questionOptionNew->text 		= $imgTitle[0]; 
				    	$questionOptionNew->img 		= trim($imgUrl, "\r\n");
				    	$questionOptionNew->order 		= $i;
				    	$questionOptionNew->status 		= 1;
				    	$questionOptionNew->save();
				    $i++;
		    	}

	    	}else{

	    		if($optionsQuestion){
	    			foreach ($optionsQuestion as $order => $text) {
		    		
		    			$questionOptionNew = new QuestionOptions;
				    	$questionOptionNew->question_id = $idQuestion;
				    	$questionOptionNew->text 		= $text;
				    	$questionOptionNew->order 		= $order;//menos 1
				    	$questionOptionNew->status 		= 1;
				    	$questionOptionNew->save();
		    		}
	    		}
	    	}					
	    	Session::forget('IdQuestion');
			return Redirect::back();

		}else{

			$validator = Validator::make($inputs, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}else{

				$questionUpd = Question::find($this->UserID());
				$questionOpt = Contest::find($this->UserID());

				if($questionUpd && $questionOpt->contest_type=='versus'){

					$questionUpd->delete();

					$questionOptUpd =  QuestionOptions::find($questionUpd->id);
						
						if($questionOptUpd)
							$questionOptUpd->delete();

				}

					$questionNew = new Question;
			    	$questionNew->contest_id 		= $this->UserID();
			    	$questionNew->questionText 		= $question;
			    	$questionNew->questionType 		= strtolower($typeQuestion);
			    	$questionNew->numElemetMaxSel 	= $maxElemntsSel;
			    	$questionNew->helpText 			= $helpText;
			    	$questionNew->errorText 		= $errorText;
			    	$questionNew->placeholder 		= $placeholder;
			    	$questionNew->request 			= ($required)?$required:false;
			    	$questionNew->status 			= 1;
			    	$questionNew->img 				= isset($imgQuestion)?$imgQuestion:'';
			    	$questionNew->save();

			    	$lastInsertId = DB::getPdo()->lastInsertId();

		    	if($titleImg){

		    		$i=0;
					foreach ($titleImg as $imgUrl => $imgTitle) {

			    			$questionOptionNew = new QuestionOptions;
					    	$questionOptionNew->question_id = $lastInsertId;
					    	$questionOptionNew->text 		= $imgTitle[0]; 
					    	$questionOptionNew->img 		= $imgUrl;
					    	$questionOptionNew->order 		= $i;
					    	$questionOptionNew->status 		= 1;
					    	$questionOptionNew->save();
					    $i++;
			    	}

		    	}else{

		    		if($optionsQuestion){
		    			foreach ($optionsQuestion as $order => $text) {
			    		
			    			$questionOptionNew = new QuestionOptions;
					    	$questionOptionNew->question_id = $lastInsertId;
					    	$questionOptionNew->text 		= $text;
					    	$questionOptionNew->order 		= $order;//menos 1
					    	$questionOptionNew->status 		= 1;
					    	$questionOptionNew->save();
			    		}
		    		}
		    	}
			return Redirect::back();
			}
		}
	}


	public function getEditQuestion($id){

		$contest = Contest::find($this->UserID());

		$question = Question::where('id',$id)->get();

		$questionOption = QuestionOptions::select('text','img')
											->where('question_id',$question[0]->id)
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

		$Answers = $question[0];

		Session::put('IdQuestion',$id);

		return Response::json($Answers);
	}


	public function getTypeContest(){

		Session::forget('IdQuestion');
		$contest = Contest::find($this->UserID());

		return Response::json(array('typeContest' => $contest->contest_type));
	}

	public function getDeleteQuestion($id){

		DB::table('questions')
            ->where('id', $id)
            ->update(array('status' => false));

		return Response::json("eliminado");
	}

	public function postPositionQuestion(){

		$i=0;
		foreach (Input::get('positionQuestion') as $id => $value) {

			DB::table('questions')
            	->where('id', $id)
            	->where('contest_id',$this->UserID())
            	->update(array('order' => $i));
			$i++;
		}

		return Redirect::back();
	}



	/* Responses values */

	public function getResponsesValue($id){

		$question = Question::select('id','contest_id','questionText','questionType','order')
								->where('contest_id',$id)
								->where('status','!=',false)
								->orderBy('order')->get();

		$statusRatePDF = DB::table('contest_properties')->select('property_value')->where('id_contest', $id)->where('property_name','statusRatePDF')->pluck('property_value');

		$options = [];
		
		$y=0;

		for ($i=0; $i < count($question) ; $i++) { 

				if($question[$i]->questionType!='text' && $question[$i]->questionType!='abierta'){

					$questionOption = QuestionOptions::select('id','text','img','value')->where('question_id',$question[$i]->id)->where('status','!=',false)->orderBy('order')->get();

					for ($j=0; $j < count($questionOption); $j++) { 

						$options[$j]['id_option'] = $questionOption[$j]->id;
						$options[$j]['text'] = $questionOption[$j]->text;
						$options[$j]['img'] = $questionOption[$j]->img;
						$options[$j]['value'] = $questionOption[$j]->value;
						$y++;
					}

					$question[$i]['answers'] =$options;
					$question[$i]['statusRatePDF'] = isset($statusRatePDF)?$statusRatePDF:null;
				}
			
		}
		return View::make(Config::get( 'app.main_template' ).'/contest/responsesValue')->with(array('questions' => $question));

	}

	public function postResponsesValue($idContest){

	$contest = Contest::find($idContest);

		if($contest->end_date < strtotime(date('Y/m/d h:i A'))){

			$valueOption = Input::get('valueOption');

				$rules = array(
							'valueOption'  => 'min:1'
							);

				$inputs = Input::all();

				$validator = Validator::make($inputs, $rules);


				if ($validator->fails()) {
					return Redirect::back()->withErrors($validator)->withInput();
				}else{

					$valOpt = '';

					foreach ($valueOption as $idQuestion => $arrayVal) {
						foreach ($arrayVal as $idOption => $valueOption) {
							
							isset($valueOption)? $valOpt = $valueOption: $valOpt = 0;

								DB::table('questions_options')
					            	->where('id', $idOption)
					            	->update(array('value' => $valOpt));

					            DB::connection('mysql2')->table('questions_answers')
					            	//->where('question_id',$idQuestion)
					            	->where('option_id',$idOption)
					            	->update(array('value' => $valOpt));	
						}
					}

					$query = DB::select("SELECT property_value from contest_properties where property_name='statusRate' and id_contest=? ",array($idContest));

					if($query){
						 DB::delete("DELETE from contest_properties where property_name=? and id_contest=? ",array('statusRate',$idContest));
					}

					$contestProperties = new ContestProperties;
					$contestProperties->id_contest = $idContest;
					$contestProperties->property_name = 'statusRate';
					$contestProperties->property_value = true;
					$contestProperties->save();

				}
		}

		return Redirect::to('contest');

   }


   public function getPdfContestPoints($id){	

		$passwordPDF = $this->generatePasswordPDF();

   		$pdf=new FPDF_Protection();

   		$pdf->SetProtection(array(),$passwordPDF);

		/*$properties= DB::connection('mysql2')->table('users AS u')
												->select('u.first_name','u.last_name','u.email_hash','u.tel','u.gender','u.age','u.birthdate','u.country','u.state','qa.created_at',DB::RAW('sum(qa.`value`) As TotalPoints'))
												->leftJoin('questions_answers AS qa', 'u.id', '=', 'qa.user_id')
												->where('u.contest_id',$id)
												->groupBy('qa.user_id')
												->orderBy('TotalPoints', 'desc')
												->orderBy('qa.created_at', 'asc')
												->get();
		*/
		$properties = DB::connection('mysql2')->select("SELECT u.id, u.first_name, u.last_name, u.email_hash, u.tel, u.gender, u.age, u.birthdate, u.country, u.state, qa.created_at, qa.total as 'TotalPoints' from users u INNER JOIN (Select sum(res.value) as 'total', res.created_at, res.user_id from questions_answers res where res.contest_id=? group by res.user_id, res.created_at) as qa on(u.id=qa.user_id) where u.contest_id=? group by qa.user_id order by TotalPoints DESC, qa.created_at ASC",array($id,$id));
		
		/******VERIFICAR SI TIENE PREGUNTAS TEXT O ABIERTAS*******************/
		$textQuestion= Question::select('id','questionText')->where('contest_id',$id)->whereIn('questionType',array('text','abierta'))->where('status',1)->get();

		if($properties){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			//$pdf->SetFillColor(0, 0, '255');
			//$pdf->SetDrawColor(128,0,0);
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,'Puntuaciones', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			$paises = Config::get('paises');

			foreach ($properties as $value) {

				$points=$value->TotalPoints;
				
				$pdf->Cell(70,5,'Puntos :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode($points),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Nombre :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode(Crypt::decrypt($value->first_name))." ".utf8_decode(Crypt::decrypt($value->last_name)),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Email :',1,0,'L',0);
				$pdf->Cell(0,5,Crypt::decrypt($value->email_hash),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Genero :',1,0,'L',0);
				$pdf->Cell(0,5,($value->gender=='male')?'masculino':'femenino',1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Telefono :',1,0,'L',0);
				$pdf->Cell(0,5,Crypt::decrypt($value->tel),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Edad :',1,0,'L',0);
				$pdf->Cell(0,5,$value->age,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de Nacimiento:',1,0,'L',0);
				$pdf->Cell(0,5,$value->birthdate,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Pais :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode(isset($paises[$value->country])?$paises[$value->country]:$value->country),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Estado :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode($value->state),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de participacion :',1,0,'L',0);
				$pdf->Cell(0,5,$value->created_at,1,0,'L',0);
		        $pdf->Ln();
		        if ($textQuestion) {
					foreach ($textQuestion as $option) {
						$res=  DB::connection('mysql2')->select("SELECT question_text FROM `questions_answers` where contest_id=? and user_id=? and question_id=? limit 1", array($id,$value->id,$option->id));
						if($res){
							$pdf->Cell(0,5,utf8_decode($option->questionText),1,0,'L',0);
							$pdf->Ln();
							$pdf->MultiCell(0,5,utf8_decode($res[0]->question_text),1,'L',0);
				       	}
					}
				}
				$pdf->Ln(15);
			}
			
			$pdf->Output('reporteQuestionPoints'.time().'.pdf','D');

			$query = DB::select("SELECT * from contest_properties where property_name='statusRatePDF' and id_contest=? ",array($id));

			if($query){
				 DB::delete("DELETE from contest_properties where property_name=? and id_contest=? ",array('statusRatePDF',$id));
			}

			$contestProperties = new ContestProperties;
			$contestProperties->id_contest = $id;
			$contestProperties->property_name = 'statusRatePDF';
			$contestProperties->property_value = true;
			$contestProperties->save();

			$this->sendEmailPassword($passwordPDF);

		}

   }

   public function getPdfContestVideo($id){	

		$passwordPDF = $this->generatePasswordPDF();

   		$pdf=new FPDF_Protection();

   		//$pdf->SetProtection(array(),$passwordPDF);

		$properties = DB::connection('mysql2')->select("SELECT u.id, u.first_name, u.last_name, u.email_hash, u.tel, u.gender, u.age, u.birthdate, u.country, u.state, qa.created_at, qa.total as 'TotalPoints' from users u INNER JOIN (Select sum(res.value) as 'total', res.created_at, res.user_id from questions_answers res where res.contest_id=? group by res.user_id, res.created_at) as qa on(u.id=qa.user_id) where u.contest_id=? group by qa.user_id order by TotalPoints DESC, qa.created_at ASC",array($id,$id));
		
		$question = Question::where('contest_id',$id)->where('status',1)->get();

		$questionsOptions= DB::select("SELECT qa.id,qa.text FROM questions_options qa, questions q WHERE q.id=question_id and q.contest_id=?",array($id));	
		$optionsQ = [];
		foreach ($questionsOptions as $option) {
			$optionsQ[]=(array)$option;
		}

		if($properties){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			//$pdf->SetFillColor(0, 0, '255');
			//$pdf->SetDrawColor(128,0,0);
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,'Puntuaciones', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			$paises = Config::get('paises');

			$dir = Config::get('app.folder');
			// $handle = opendir($dir);
			$arrContextOptions=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			); 

			foreach ($properties as $value) {

				$points=$value->TotalPoints;
				// load the dynamically created file into a variable
				$userPhoto = DB::connection('mysql2')->select("SELECT photo_url from social_network where user_id=? limit 1",array($value->id));
				if ($userPhoto) {
					try { 
						if (count($userPhoto)==0) {
							throw new Exception('Existio un error, provocado',0); 
						}
						
						$photo = $value->id.'.jpeg';
						$photoBckp = $dir.$photo;
						$generatedfile = file_get_contents(utf8_decode($userPhoto[0]->photo_url),false, stream_context_create($arrContextOptions));
						//save the created image to a temporary file 
						file_put_contents($photoBckp, $generatedfile);
						$pdf->Cell( 70, 5, $pdf->Image($photoBckp, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 0, false );
						$pdf->Ln(35);
						unlink($photoBckp);
					} catch (Exception $e) {
						$photoBckp = public_path()."/img/descarga.png";
			    		//$pdf->Image($photoBckp,60,30,90,0,'PNG');
			    		$pdf->Cell( 70, 5, $pdf->Image($photoBckp, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 0, false );
						$pdf->Ln(35);
					}
				}
			    
				// $pdf->Cell(70,5,'Puntos :',1,0,'L',0);
				// $pdf->Cell(70,5,utf8_decode($points),1,0,'L',0);
				// $pdf->Ln();
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
		        $pdf->Cell(70,5,'Fecha de Nacimiento :',1,0,'L',0);
				$pdf->Cell(70,5,$value->birthdate,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Pais :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode(isset($paises[$value->country])?$paises[$value->country]:$value->country),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Estado :',1,0,'L',0);
				$pdf->Cell(70,5,utf8_decode($value->state),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de participacion :',1,0,'L',0);
				$pdf->Cell(70,5,$value->created_at,1,0,'L',0);
				$pdf->Ln();
		        if ($question) {
					foreach ($question as $option) {
						$res = DB::connection('mysql2')->select("SELECT option_id,question_text FROM questions_answers where contest_id=? and user_id=? and question_id=?", array($id,$value->id,$option->id));
						if($res){
							foreach ($res as $respuesta) {	
								if (($option->questionText=='text')||($option->questionText=='abierta')){
									$pdf->Cell(70,5,utf8_decode($option->questionText),1,0,'L',0);
									$pdf->Cell(70,5,utf8_decode($respuesta->question_text),1,0,'L',0);
				        			$pdf->Ln();
								}else{
									$key=array_search($respuesta->option_id, array_column($optionsQ, 'id'));
									$pdf->Cell(70,5,utf8_decode($option->questionText),1,0,'L',0);
									$pdf->Cell(70,5,utf8_decode($optionsQ[$key]["text"]),1,0,'L',0);
				        			$pdf->Ln();
								}
							}
			        	}
					}
				}
				$video = DB::connection('mysql2')->select("SELECT video_url FROM videos where contest_id=? and user_id=? limit 1", array($id,$value->id));
				$pdf->SetFont('helvetica', '', 8);
				$urlvideo=$video?$video[0]->video_url:'Sin video';
				$pdf->Cell(70,5,'Video: '.$urlvideo,0,0,'L',0);
				$pdf->Ln(15);
				$pdf->SetFont('helvetica', '', 10);
			}
			
			$pdf->Output('reporteQuestionPoints'.time().'.pdf','D');

			$query = DB::select("SELECT * from contest_properties where property_name='statusRatePDF' and id_contest=? ",array($id));

			if($query){
				 DB::delete("DELETE from contest_properties where property_name=? and id_contest=? ",array('statusRatePDF',$id));
			}

			$contestProperties = new ContestProperties;
			$contestProperties->id_contest = $id;
			$contestProperties->property_name = 'statusRatePDF';
			$contestProperties->property_value = true;
			$contestProperties->save();

			//$this->sendEmailPassword($passwordPDF);

		}

   }

   public function getPdfContestTelevision($id){	

		$passwordPDF = $this->generatePasswordPDF();

   		$pdf=new FPDF_Protection();

   		$pdf->SetProtection(array(),$passwordPDF);

		$properties = DB::connection('mysql2')->select("SELECT u.id, u.first_name, u.last_name, u.email_hash, u.tel, u.gender, u.age, u.birthdate, u.country, u.state, qa.created_at, qa.total as 'TotalPoints' from users u INNER JOIN (Select sum(res.value) as 'total', res.created_at, res.user_id from questions_answers res where res.contest_id=? group by res.user_id, res.created_at) as qa on(u.id=qa.user_id) where u.contest_id=? group by qa.user_id order by TotalPoints DESC, qa.created_at ASC",array($id,$id));
		
		/******VERIFICAR SI TIENE PREGUNTAS TEXT O ABIERTAS*******************/
		$textQuestion= Question::select('id','questionText')->where('contest_id',$id)->whereIn('questionType',array('text','abierta','foto'))->where('status',1)->get();

		if($properties){

			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetFont('Arial');
			//$pdf->SetFillColor(0, 0, '255');
			//$pdf->SetDrawColor(128,0,0);
			$pdf->setFont('Times','B',20);
			$pdf->Write(10,'Puntuaciones', '', 0, 'L', true, 0, false, false, 0);
			$pdf->Ln(20);
			$pdf->SetFont('helvetica', '', 10);

			$paises = Config::get('paises');

			foreach ($properties as $value) {

				$points=$value->TotalPoints;
				
				// $pdf->Cell(70,5,'Puntos :',1,0,'L',0);
				// $pdf->Cell(0,5,utf8_decode($points),1,0,'L',0);
				// $pdf->Ln();
				$pdf->Cell(70,5,'Nombre :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode(Crypt::decrypt($value->first_name))." ".utf8_decode(Crypt::decrypt($value->last_name)),1,0,'L',0);
				$pdf->Ln();
				$pdf->Cell(70,5,'Email :',1,0,'L',0);
				$pdf->Cell(0,5,Crypt::decrypt($value->email_hash),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Genero :',1,0,'L',0);
				$pdf->Cell(0,5,($value->gender=='male')?'masculino':'femenino',1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Telefono :',1,0,'L',0);
				$pdf->Cell(0,5,Crypt::decrypt($value->tel),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Edad :',1,0,'L',0);
				$pdf->Cell(0,5,$value->age,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de Nacimiento:',1,0,'L',0);
				$pdf->Cell(0,5,$value->birthdate,1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Pais :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode(isset($paises[$value->country])?$paises[$value->country]:$value->country),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Estado :',1,0,'L',0);
				$pdf->Cell(0,5,utf8_decode($value->state),1,0,'L',0);
		        $pdf->Ln();
		        $pdf->Cell(70,5,'Fecha de participacion :',1,0,'L',0);
				$pdf->Cell(0,5,$value->created_at,1,0,'L',0);
		        $pdf->Ln();
		        if ($textQuestion) {
					foreach ($textQuestion as $option) {
						$res=  DB::connection('mysql2')->select("SELECT question_text FROM `questions_answers` where contest_id=? and user_id=? and question_id=? limit 1", array($id,$value->id,$option->id));
						if($res){
							$pdf->Cell(0,5,utf8_decode($option->questionText),1,0,'L',0);
							$pdf->Ln();
							$pdf->MultiCell(0,5,utf8_decode($res[0]->question_text),1,'L',0);
				       	}
					}
				}
				$pdf->Ln(15);
			}
			
			$pdf->Output('reporteQuestionTelevision'.time().'.pdf','D');

			// $query = DB::select("SELECT * from contest_properties where property_name='statusRatePDF' and id_contest=? ",array($id));

			// if($query){
			// 	 DB::delete("DELETE from contest_properties where property_name=? and id_contest=? ",array('statusRatePDF',$id));
			// }

			// $contestProperties = new ContestProperties;
			// $contestProperties->id_contest = $id;
			// $contestProperties->property_name = 'statusRatePDF';
			// $contestProperties->property_value = true;
			// $contestProperties->save();

			$this->sendEmailPassword($passwordPDF);

		}

   }

  }

  ?>
