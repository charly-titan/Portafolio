<?php



class ShareController extends BaseController {

	protected function loginFacebook($action=""){
 		


		$token = "CAABvB8oAcpEBACxZBz01mLG1mRG4o7qGZCcLU2nhyZCrtItAFZAqneCDa8g6QubU3TsS4ns3SE8WcWvGzv180G5RSRlFIPoQqOWn42ZCZBgbVdUw7FUngZARoGKqJHbdaTXtTxNIgnnSZBNfK7zTkVfygue0joD5tuxTnVMPif6LFgxksC0tzJb5heLoMq8VExwZD";
    	$hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');

    	//$this->load->library('HybridAuthLib');
    	$hybridauth->storage()->set( "hauth_session.facebook.is_logged_in", 1 );
    	$hybridauth->storage()->set( "hauth_session.facebook.token.access_token", $token );        
    	//$service = $this->hybridauthlib->authenticate('Facebook');
    	$service = $hybridauth->authenticate("Facebook");

    if ($service->isUserConnected()){

    	// $facebook = $hybridauth->authenticate( "Facebook" );
 
 //   // ask facebook api for the user accounts
    $accounts = $service->api()->api('/me/accounts');
 
    // post "hello word!" to every pages for the current user
    // foreach( $accounts['data'] as $account ){

    // 	var_dump($account);
      
    // }

    $params = array(
        'access_token' => "CAABvB8oAcpEBAJ2ZCYc85aOO80LBTvpEbPLneJUxOuKWx93MiT7SlZA3kN8ZC3N5JdeDZAadVDdqeV7kQSStKK5FhFqMA7zHwGa46MTF6nrP3UgVGCpgge3KwjkVSdnVBT4yWMuEpWZCFkZBc7tEnCmaW5gMBLvAPNP8EtbiAPaZBZBZA1ZCNvHdTr",
        'message' => "hello word! 2 pruebs numero 1 ".time()
      );
 
 //      // ask facebook api to post the message to the selected account
       $service->api()->api( "/112085805482275/feed", 'POST', $params );

        // $user_profile = $service->getUserProfile();
        // $contacts = $service->getUserContacts();
        // $access_token = $service->getAccessToken();

        // var_dump($user_profile);
        // var_dump($contacts);
        // var_dump($access_token);
    }

		// $token = "CAABvB8oAcpEBACxZBz01mLG1mRG4o7qGZCcLU2nhyZCrtItAFZAqneCDa8g6QubU3TsS4ns3SE8WcWvGzv180G5RSRlFIPoQqOWn42ZCZBgbVdUw7FUngZARoGKqJHbdaTXtTxNIgnnSZBNfK7zTkVfygue0joD5tuxTnVMPif6LFgxksC0tzJb5heLoMq8VExwZD";
  //       foreach( $accounts['data'] as $account ){
	 //      $params = array(
	 //        'access_token' => $token,
	 //        'message' => "hello word!"
	 //      );
 
      // ask facebook api to post the message to the selected account
      // $facebook->api()->api( "/" . $account['id'] . "/feed", 'POST', $params );
   }
        

    //     if ($action == "auth") { // check URL segment
    //         try { // process authentication
    //             Hybrid_Endpoint::process();
    //         }catch (Exception $e) {
                
    //             return Redirect::to('social');
    //         }
    //         return;
    //     }

    //     try {
    //         if (App::environment('local')){
    //             $hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');
    //         }elseif (App::environment('staging')) {
    //             $hybridauth = new Hybrid_Auth(app_path() . '/config/staging/hybridauth.php');
    //         }elseif (App::environment('aws')) {
    //             $hybridauth = new Hybrid_Auth(app_path() . '/config/aws/hybridauth.php');
    //         }else{
    //             $hybridauth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
    //         }
            
    //         // create a HybridAuth object
    //         $adapter = $hybridauth->authenticate("Facebook");
    //         $user_profile = $adapter->getUserProfile(); 
    //         var_dump($user_profile);
    //         //$adapter->logout();

    //         // print_r($user_profile);
    //         // exit("--");

    //         // Hybrid_User_Profile Object ( [identifier] => 106508012100958583978 [webSiteURL] => [profileURL] => https://plus.google.com/106508012100958583978 [photoURL] => https://lh3.googleusercontent.com/-BVhJMQEH-fw/AAAAAAAAAAI/AAAAAAAAAPI/3dPhMUAQJu0/photo.jpg?sz=200 [displayName] => Gabriel Mancera Hernandez [description] => [firstName] => Gabriel [lastName] => Mancera Hernandez [gender] => male [language] => [age] => [birthDay] => 0 [birthMonth] => 0 [birthYear] => 0 [email] => gabriel.mancera@televisatim.com [emailVerified] => [phone] => [address] => Mexico [country] => [region] => [city] => Mexico [zip] => ) --

    //         // Session::put('user.email', $user_profile->email);
    //         // Session::put('user.firstname', Crypt::encrypt($user_profile->firstName));
    //         // Session::put('user.lastname', Crypt::encrypt($user_profile->lastName));
    //         // Session::put('user.gender', $user_profile->gender);

            

    //         //return User::validateUserGoogle();
    //     }catch(Exception $e) {

    //         return $e->getMessage();
    //     }

    // }
}
 // $facebook = $hybridauth->authenticate( "Facebook" );
 
 //   // ask facebook api for the user accounts
 //   $accounts = $facebook->api()->api('/me/accounts');
 
 //   // post "hello word!" to every pages for the current user
 //   foreach( $accounts['data'] as $account ){
 //      $params = array(
 //        'access_token' => $account['access_token'],
 //        'message' => "hello word!"
 //      );
 
 //      // ask facebook api to post the message to the selected account
 //      $facebook->api()->api( "/" . $account['id'] . "/feed", 'POST', $params );
 //   }



 //    $token = "CAABvB8oAcpEBACxZBz01mLG1mRG4o7qGZCcLU2nhyZCrtItAFZAqneCDa8g6QubU3TsS4ns3SE8WcWvGzv180G5RSRlFIPoQqOWn42ZCZBgbVdUw7FUngZARoGKqJHbdaTXtTxNIgnnSZBNfK7zTkVfygue0joD5tuxTnVMPif6LFgxksC0tzJb5heLoMq8VExwZD";
 //    $this->load->library('HybridAuthLib');
 //    $this->hybridauthlib->storage()->set( "hauth_session.facebook.is_logged_in", 1 );
 //    $this->hybridauthlib->storage()->set( "hauth_session.facebook.token.access_token", $token );        
 //    $service = $this->hybridauthlib->authenticate('Facebook');

 //    if ($service->isUserConnected()){

 //        $user_profile = $service->getUserProfile();
 //        $contacts = $service->getUserContacts();
 //        $access_token = $service->getAccessToken();

 //        var_dump($user_profile);
 //        var_dump($contacts);
 //        var_dump($access_token);

 //    }else{
 //        echo "something went wrong";
 //    }



 //    // call Hybrid_Auth::getSessionData() to get stored data
 //       $hybridauth_session_data = $hybridauth->getSessionData();
 
 //       // then store it on your database or something
 //       store_hybridauth_session( $current_user_id, $hybridauth_session_data );