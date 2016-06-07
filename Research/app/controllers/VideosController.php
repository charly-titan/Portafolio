<?php

require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';

class VideosController extends ContestController {

	protected $OAUTH2_CLIENT_ID;
	protected $OAUTH2_CLIENT_SECRET;

	public function __construct(){
		/*elsa.salinas*/
		// $this->OAUTH2_CLIENT_ID = '248239914241-1j6ic1u4oa6bfh373uv0bntmsjvlvjrk.apps.googleusercontent.com';
		// $this->OAUTH2_CLIENT_SECRET = 'CS905vGPoCVVoXN5SgQh6iTu';
		/*apps@esmas.com*/
		$this->OAUTH2_CLIENT_ID = '314400987411-0fcatkb5nsvpo0k4a1300ndru06prbn3.apps.googleusercontent.com';
		$this->OAUTH2_CLIENT_SECRET = 'iLuIzlbGubr0-LfO8LnIP3-S';
	}

	public function getOption($id_contest){
		$contest = Contest::find($id_contest);
		if (count($contest) && ($contest->contest_type=="foto")) {
			return View::make('fotos.opcion')->with('id_contest', $id_contest);
		}
		App::abort(404);
	}

	public function getAprobarVideos($id_contest){

		Session::put('contestID',$id_contest); 

		$videos = DB::connection('mysql2')->select("SELECT v.id, v.video_name, v.youtube_id, u.first_name, u.last_name, sn.photo_url FROM videos as v,users as u,social_network as sn WHERE v.contest_id=? and v.status='pending' and v.youtube_id<>'' and v.user_id=u.id and v.user_id=sn.user_id
",array($id_contest));
 	    
 	    return View::make('videos.aprobar')->with(array('videos'=>$videos,'id_contest'=>$id_contest,'option'=>2));
	}

	public function getRevisarFotos($id_contest){ 

		$fotos = Fotos::select('id', 'foto_url')
	            ->where('contest_id', $id_contest)
	            ->where('status', 'approved')   
	            ->get();

		return View::make('fotos.aprobar')->with(array('fotos'=>$fotos,'id_contest'=>$id_contest,'option'=>1));
	}

	public function postAuthorize($id_contest, $option){
		$datos=Input::all();

		if (isset($datos['video']) && count($datos['video'])) {
			foreach ($datos['video'] as $id_video) {
				
	            $youVideo = Videos::select('youtube_id')
	            		->where('contest_id', $id_contest)
						->where('id', $id_video)
						->first();

				$videoId=$youVideo->youtube_id;
				$client=$this->authGoogle();
				
				if (gettype($client)!='object') {
					return Redirect::back()->with('error',$client);
				}

				// Define an object that will be used to make all API requests.
				$youtube = new Google_Service_YouTube($client);
				
				$htmlBody='';
				try{

				    // Call the API's videos.list method to retrieve the video resource.
				    $listResponse = $youtube->videos->listVideos("status", array('id' => $videoId));
				   
				    // If $listResponse is empty, the specified video was not found.
				    if (empty($listResponse)) {
				      $htmlBody .= sprintf('Can\'t find a video with video id: %s', $videoId);
				    } else {
					    // Since the request specified a video ID, the response only
					    // contains one video resource.
					    $video = $listResponse[0];
					    $videoStatus = $video['status'];
					    $status = $videoStatus['privacyStatus'];
					    $status = 'public'; 
					  	
					  	// Set privacyStatus
					    $videoStatus['privacyStatus'] = $status;

					  	// Update the video resource by calling the videos.update() method.
					  	$updateResponse = $youtube->videos->update("status", $video);
					  	$responseTags = $updateResponse['status.privacyStatus'];
				    	// $htmlBody .= "Video Updated -";
				    	// $htmlBody .= sprintf('PrivacyStatus "%s" added for video %s ', $status, $videoId);
				    	$htmlBody.= "<code>Video actualizado a: ".$status."</code>";
				    	
				    	$video = Videos::where('contest_id', $id_contest)
						->where('id', $id_video)   
	            		->update(array('status' => $option));

				  	}
				  } catch (Google_Service_Exception $e) {
				      $htmlBody .= sprintf('A service error occurred: <code>%s</code> Copie pantalla y contacte al Administrador', htmlspecialchars($e->getMessage()));
				  } catch (Google_Exception $e) {
				      $htmlBody .= sprintf('An client error occurred: <code>%s</code> Copie pantalla y contacte al Administrador', htmlspecialchars($e->getMessage()));
				  }

				  return Redirect::back()->with('error',$htmlBody);
			}
		}else{
			if ($option==2){
				$msg='No existen videos seleccionados para aprobar';
			}else{
				$msg='No existen videos seleccionados para revertir aprobaci&oacute;n';
			}
			return Redirect::back()->with('error',$msg);
		}
		//return Redirect::back()->with('error',$htmlBody);
		return Redirect::back();  

	}

	// public function getTest(){
		
	// 	$client=$this->clientGoogle();

	// 	if (isset($_GET['code'])) {
	// 	  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
	// 	    die('The session state did not match.');
	// 	  }

	// 	  $client->authenticate($_GET['code']);
	// 	  $_SESSION['token'] = $client->getAccessToken();
	// 	  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . "/videos/test",FILTER_SANITIZE_URL);
	// 	  header('Location: ' . $redirect);
	// 	}

	// 	if (isset($_SESSION['token'])) {
		  
	// 	  $client->setAccessToken($_SESSION['token']);
	// 	  $token=json_decode($_SESSION['token']);
	// 	  $credenciales = ContestProperties::where('property_name','authYouTube')
	//     				->where('id_contest',Session::get('contestID'))
	//     				->first();
	//       //guarda datos del token 
	//       $OAUTH2_CLIENT_ID = '248239914241-1j6ic1u4oa6bfh373uv0bntmsjvlvjrk.apps.googleusercontent.com';
	// 	  $OAUTH2_CLIENT_SECRET = 'CS905vGPoCVVoXN5SgQh6iTu';
	//       if(is_null($credenciales) or !count($credenciales)){
	//       	$array = ['client_id' => $OAUTH2_CLIENT_ID, 'client_secret' => $OAUTH2_CLIENT_SECRET, 'token' => $token ];
	//       	$contestProperties = new ContestProperties;
	// 		$contestProperties->id_contest = Session::get('contestID');
	// 		$contestProperties->property_name = 'authYouTube';
	// 		$contestProperties->property_value = json_encode($array);
	// 		$contestProperties->save();     	
	//       }else{
	//       	$array = ['client_id' => $OAUTH2_CLIENT_ID, 'client_secret' => $OAUTH2_CLIENT_SECRET, 'token' => $token ];
	//       	$credenciales->property_value = json_encode($array);
	//       	$credenciales->save();
	//       }
	//       return Redirect::to('/videos/aprobar-videos/'.Session::get('contestID'));
	// 	}
	// 	print_r($client);
	// }

	public function getAuth(){

		$credenciales = ContestProperties::where('property_name','authYouTube')
	    				->where('id_contest',Session::get('contestID'))
	    				->first();

		if(is_null($credenciales) or !count($credenciales)){
		
			$client=$this->clientGoogle();

			if (isset($_GET['code'])) {
			  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
			    die('The session state did not match.');
			  }
			  $client->authenticate($_GET['code']);
			  $_SESSION['token'] = $client->getAccessToken();
			  $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . "/videos/auth",FILTER_SANITIZE_URL);
			  header('Location: ' . $redirect);
			}

			if (isset($_SESSION['token'])) {
			  
			  	$client->setAccessToken($_SESSION['token']);
			  	$token=json_decode($_SESSION['token']);
			  	
			  	//guarda datos del token 
		      	$array = ['client_id' => $this->OAUTH2_CLIENT_ID, 'client_secret' => $this->OAUTH2_CLIENT_SECRET, 'token' => $token ];
		      	$contestProperties = new ContestProperties;
				$contestProperties->id_contest = Session::get('contestID');
				$contestProperties->property_name = 'authYouTube';
				$contestProperties->property_value = json_encode($array);
				$contestProperties->save();     	
			}
		}
		return Redirect::to('/videos/aprobar-videos/'.Session::get('contestID'));
	}

	private function authGoogle(){

		$client=$this->clientGoogle();

		$credenciales = ContestProperties::where('property_name','authYouTube')
	    				->where('id_contest',Session::get('contestID'))
	    				->first();

	    if(is_null($credenciales) or !count($credenciales)){
	    	// If the user hasn't authorized the app, initiate the OAuth flow	
		    $state = mt_rand();
		    $client->setState($state);
		    $_SESSION['state'] = $state;

		    $authUrl = $client->createAuthUrl();
		    $msg="<strong>Authorization Required </strong> You need to <a href=".$authUrl.">authorize access</a> before proceeding.";
			
			return $msg;
	    }else{
	    	$token=json_decode($credenciales->property_value);
	    	$client->setAccessToken(json_encode($token->token));
	    	if($client->isAccessTokenExpired()){
	    		//$client->refresh_token();
	    		//refresca token caduco";
	    		$client->refreshToken($token->token->refresh_token);
	    		//Actualiza 
	    		$newToken=json_decode($client->getAccessToken());
				$array = ['client_id' => $this->OAUTH2_CLIENT_ID, 'client_secret' => $this->OAUTH2_CLIENT_SECRET, 'token' => $newToken ];
	      		$credenciales->property_value = json_encode($array);
	      		$credenciales->save();
	      		return $client;
	    	}
	    	if ($client->getAccessToken()) {
		  		return $client;	
		  	}else{
		  		//verificar respuesta y ver en que caso entra aqui
		  		$msg="No se conecto...";
	    		return $msg;
		  		
		  	}

	    }


	}

	private function clientGoogle(){
		// Call set_include_path() as needed to point to your client library.
		if(!isset($_SESSION)){
		    session_start();
		}
		/*
		 * You can acquire an OAuth 2.0 client ID and client secret from the
		 * Google Developers Console <https://console.developers.google.com/>
		 * For more information about using OAuth 2.0 to access Google APIs, please see:
		 * <https://developers.google.com/youtube/v3/guides/authentication>
		 * Please ensure that you have enabled the YouTube Data API for your project.
		 */
		
		$client = new Google_Client();
		$client->setClientId($this->OAUTH2_CLIENT_ID);
		$client->setClientSecret($this->OAUTH2_CLIENT_SECRET);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$client->setAccessType("offline");
		$client->setApprovalPrompt('force');
		$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . "/videos/auth",FILTER_SANITIZE_URL);
		$client->setRedirectUri($redirect);

		return $client;
	}



	// public function actStatus($videoId){
		

	// 	/**
	// 	 * This sample adds new tags to a YouTube video by:
	// 	 *
	// 	 * 1. Retrieving the video resource by calling the "youtube.videos.list" method
	// 	 *    and setting the "id" parameter
	// 	 * 2. Appending new tags to the video resource's snippet.tags[] list
	// 	 * 3. Updating the video resource by calling the youtube.videos.update method.
	// 	 *
	// 	 * @author Ibrahim Ulukaya
	// 	*/

	// 	// Call set_include_path() as needed to point to your client library.
	// 	require_once 'Google/Client.php';
	// 	require_once 'Google/Service/YouTube.php';
	// 	if(!isset($_SESSION)){
	// 	    session_start();
	// 	}
	// 	/*
	// 	 * You can acquire an OAuth 2.0 client ID and client secret from the
	// 	 * Google Developers Console <https://console.developers.google.com/>
	// 	 * For more information about using OAuth 2.0 to access Google APIs, please see:
	// 	 * <https://developers.google.com/youtube/v3/guides/authentication>
	// 	 * Please ensure that you have enabled the YouTube Data API for your project.
	// 	 */
	// 	$OAUTH2_CLIENT_ID = '248239914241-1j6ic1u4oa6bfh373uv0bntmsjvlvjrk.apps.googleusercontent.com';
	// 	$OAUTH2_CLIENT_SECRET = 'CS905vGPoCVVoXN5SgQh6iTu';

	// 	$client = new Google_Client();
	// 	$client->setClientId($OAUTH2_CLIENT_ID);
	// 	$client->setClientSecret($OAUTH2_CLIENT_SECRET);
	// 	$client->setScopes('https://www.googleapis.com/auth/youtube');
	// 	$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . "/videos/test",FILTER_SANITIZE_URL);
	// 	$client->setRedirectUri($redirect);

	// 	// Define an object that will be used to make all API requests.
	// 	$youtube = new Google_Service_YouTube($client);
		
	// 	if (isset($_GET['code'])) {
	// 	  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
	// 	    die('The session state did not match.');
	// 	  }

	// 	  $client->authenticate($_GET['code']);
	// 	  $_SESSION['token'] = $client->getAccessToken();
	// 	  header('Location: ' . $redirect);
	// 	}

	// 	if (isset($_SESSION['token'])) {
	// 	  $client->setAccessToken($_SESSION['token']);
	// 	}
	// 	 $htmlBody='';
	// 	// Check to ensure that the access token was successfully acquired.
	// 	if ($client->getAccessToken()) {
	// 	  try{

	// 	    // REPLACE this value with the video ID of the video being updated.
	// 	    //$videoId = "XzQ5JcckoBc";

	// 	    // Call the API's videos.list method to retrieve the video resource.
	// 	    $listResponse = $youtube->videos->listVideos("status", array('id' => $videoId));
		   
	// 	    // If $listResponse is empty, the specified video was not found.
	// 	    if (empty($listResponse)) {
	// 	      $htmlBody .= sprintf('<h3>Can\'t find a video with video id: %s</h3>', $videoId);
	// 	    } else {
	// 		    // Since the request specified a video ID, the response only
	// 		    // contains one video resource.
	// 		    $video = $listResponse[0];
	// 		    //$videoSnippet = $video['snippet'];
	// 		    $videoStatus = $video['status'];
	// 		    //$tags = $videoSnippet['tags'];
	// 		    $status = $videoStatus['privacyStatus'];
	// 		    //print_r($videoStatus);
	// 		    // Preserve any tags already associated with the video. If the video does
	// 		    // not have any tags, create a new list. Replace the values "tag1" and
	// 		    // "tag2" with the new tags you want to associate with the video.
	// 		    /*if (is_null($tags)) {
	// 		      $tags = array("tag1", "tag2");
	// 		    } else {
	// 		      array_push($tags, "tag1", "tag2");
	// 		    }*/
	// 		    $status = 'public'; 
	// 		  	// Set the tags array for the video snippet
	// 		    //$videoSnippet['tags'] = $tags;
	// 		    $videoStatus['privacyStatus'] = $status;

	// 		  	// Update the video resource by calling the videos.update() method.
	// 		  	//$updateResponse = $youtube->videos->update("snippet", $video);
	// 		    $updateResponse = $youtube->videos->update("status", $video);

	// 		  	$responseTags = $updateResponse['status.privacyStatus'];

	// 		  	$htmlBody .= "<h3>Video Updated</h3><ul>";
	// 	    	$htmlBody .= sprintf('<li>PrivacyStatus "%s" added for video %s </li>', $status, $videoId);
	// 	    	$htmlBody .= '</ul>';
	// 	  	}
	// 	  } catch (Google_Service_Exception $e) {
	// 	      $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
	// 	  } catch (Google_Exception $e) {
	// 	      $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
	// 	  }

	// 	  $_SESSION['token'] = $client->getAccessToken();
	// 	} else {
	// 	      // If the user hasn't authorized the app, initiate the OAuth flow
	// 	      $state = mt_rand();
	// 	      $client->setState($state);
	// 	      $_SESSION['state'] = $state;

	// 	      $authUrl = $client->createAuthUrl();
		      
	// 		  echo "<h3>Authorization Required</h3>";
	// 		  echo "<p>You need to <a href=".$authUrl.">authorize access</a> before proceeding.<p>";
			
	// 	}

	// 	return $htmlBody;
    
	// }


}

  ?>
