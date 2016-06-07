<?php
class RewardsController extends ContestController {

	public function getShowRewards(){ 

		//print_r(Session::all());
   		$id_contest = Session::get('SesionID');
   		$rewards = ContestRewards::where('contest_id',$id_contest)->get()->first();
		$point=null;

		if (count($rewards)>0) {
			$point = Points::where('id',$rewards->point_id)->get()->first();
		}

		Session::forget('IdQuestion');
		$contest = Contest::find($this->UserID());
		return Response::json(array('typeContest' => $contest->contest_type,'infoPoint'=>$point,'infoRewards'=>$rewards));
	}


    public function postImgRewards(){
		
		$file = Input::file('file');
	    $filename = $file->getClientOriginalName();

		$s3 = AWS::get('s3');

	       $result = $s3->putObject(array(
	           			'ACL'        	=> 'public-read',
	                    'Bucket'     	=> 'communities-dev',
	                    'Key'        	=> "/escaleta/contest/".App::environment()."/versus/".$this->UserID()."/rewards/img/".$filename,
	                    'ContentType' 	=> 'image/jpeg',
						'Body'   		=>  fopen($file, 'r+')
	        ));   

	        $url = $result['ObjectURL'];

		return $url;
	}



	public function postReward(){

		$point_id			= Input::get('point');
		$namePoint			= Input::get('puntos');
		$givenPoints 		= Input::get('givenPoints');
		$sharePoints 		= Input::get('sharePoints');
		$categories			= Input::get('categoryImg');
    	$rangeIni 			= Input::get('rangeIni');
    	$rangeFin 			= Input::get('rangeFin');

    	$id_contest = Session::get('SesionID');

    	$allCategories = array();
    	if ($categories ) {
    		$i=0;
    		foreach ($categories as $categoryUrl => $categoryName) {
    			$categoryNew = array(
	    			'name' 		=> $categoryName[0],
					'img' 		=> $categoryUrl,
					'range_ini' => $rangeIni[$i],
					'range_fin' => $rangeFin[$i]
				);
				$allCategories[]=$categoryNew;
				$i++;
	    	}
    	}

		if ($point_id != "") {//Actualiza
			
			$point = Points::where('id',$point_id)->get()->first();
			$point 	->name 		 = $namePoint;
			$point 	->categories = json_encode($allCategories);
			$point 	->save();

		}else{//New
			$pointNew 				= new Points;
			$pointNew->name 		= $namePoint;
			$pointNew->categories 	= json_encode($allCategories);
			$pointNew->save();
			$point_id=$pointNew->id;
		}

		$rewards = ContestRewards::where('contest_id',$id_contest)->get()->first();

		if (count($rewards)>0) {
			$rewards->point_id 		= $point_id;
			$rewards->given_points	=	$givenPoints;
			$rewards->share_points	= 	$sharePoints;
			$rewards->save();

		} else {
			$rewardsNew 				=	new ContestRewards;
			$rewardsNew->contest_id		= 	$id_contest;
			$rewardsNew->point_id 		= 	$point_id;
			$rewardsNew->given_points	=	$givenPoints;
			$rewardsNew->share_points	= 	$sharePoints;
			$rewardsNew->save();
		}
		
		return Redirect::back();
	}


  }

  ?>
