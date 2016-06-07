<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


    
    
    
    protected function saveBackUrl($ref=""){
        try{
                if($ref==""){   $ref = getenv("HTTP_REFERER"); }
                if($ref==""){   $ref=URL::previous(); }
                if($ref==""){   $ref=URL::current();  }
        }catch (Exception $e){

        }
        Session::put('USER_REFERER', $ref);
        return $ref;
    }

    protected function forgetBackUrl(){
        try{
            Session::forget('USER_REFERER');
        }catch (Exception $e){

        }
        return 1;
    }    



	public function getSocial($action=""){
		
        $ins = new ContestController();
        if(Session::get('user.contest')!="" && Session::get('user.contest')!="foto" && Session::get('user.contest')!="versus-canal-5" && Session::get('user.contest')!="login"){
            $info =  $ins->contestInfo(Session::get('user.contest'));    
        }   
        
        $provider="";
		if($action=="Twitter"){
			$provider="Twitter";
			$action="";
		}elseif($action=="Facebook"){
			$provider="Facebook";
			$action="";
		}elseif($action=="Google"){
			$provider="Google";
			$action="";
		}

        
		//return Session::all();
        
        if (Session::has('user.identifier')){

                

            if(Session::has('user.contest')){ 
                //exit(Session::get('user.contest'));
                if(Session::get('user.contest')=="amqlichita" && Session::get('user.promo_type')=="login"){
                    //if(Session::get('user.provider')=="Twitter")
                        return Redirect::to('/amqlichita/1/confirma/');
                    //else
                    //    return Redirect::to('/amqlichita/1/puntos/');    
                }

                /*if(Session::get('user.contest')=="versus"){
                    return Redirect::to('/versus/movie-selected/'.Session::get('user.versus'));     
                }*/

                if(Session::get('user.contest')=="tecate"){
                    return Redirect::to('/deportes/'.Session::get('user.contest'));     
                }

                if(Session::get('user.contest')=="versus-canal-5"){
                    return Redirect::to('/versus-canal-5/movie-selected/'.Session::get('user.versus'));     
                }                
                if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="versus")){
                    return Redirect::to('/'.Session::get('user.vista').'/'.Session::get('user.contest')."/resultado");     
                }
                if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="foto")){
                    return Redirect::to('/foto/'.Session::get('user.contest')."/gracias");     
                }
            	return Redirect::to('/'.$this->nameController($info).'/'.Session::get('user.contest')); 	
             }else{
             	return Redirect::to('/');
             }
        }

        if ($action == "auth") { // check URL segment
            try { // process authentication
                Hybrid_Endpoint::process();
            }catch (Exception $e) {
                return Redirect::to('social/'.$provider);
            }
            return;
        }

        if($provider==""){exit("NO PROVIDER");}
        if($provider!=""){
        	Session::put('user.provider', $provider);
        }
        
        try {
            if (App::environment('local')){
                $hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');
            }elseif (App::environment('staging')) {
                $hybridauth = new Hybrid_Auth(app_path() . '/config/staging/hybridauth.php');
            
            }elseif (App::environment('aws')) {
                $hybridauth = new Hybrid_Auth(app_path() . '/config/aws/hybridauth.php');
            }else{
                $hybridauth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
            }
            
            // create a HybridAuth object
            $adapter = $hybridauth->authenticate($provider);
            $user_profile = $adapter->getUserProfile(); 
            $adapter->logout();

             $this->saveUserInfo($user_profile);
             
             
           

             if(Session::has('user.contest')){
                
                if(Session::get('user.contest')=="amqlichita" && Session::get('user.promo_type')=="login"){
                    //if(Session::get('user.provider')=="Twitter")
                        return Redirect::to('/amqlichita/1/confirma/');
                    //else
                    //    return Redirect::to('/amqlichita/1/puntos/');     
                }

                /*if(Session::get('user.contest')=="versus"){
                    return Redirect::to('/versus/movie-selected/'.Session::get('user.versus'));     
                }*/

                if(Session::get('user.contest')=="tecate"){
                    return Redirect::to('/deportes/'.Session::get('user.contest'));     
                }

                if(Session::get('user.contest')=="versus-canal-5"){
                    return Redirect::to('/versus-canal-5/movie-selected/'.Session::get('user.versus'));     
                } 
                if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="versus")){
                    return Redirect::to('/'.Session::get('user.vista').'/'.Session::get('user.contest')."/resultado");     
                }
                if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="foto")){
                    return Redirect::to('/foto/'.Session::get('user.contest')."/gracias");     
                }
            	return Redirect::to('/'.$this->nameController($info).'/'.Session::get('user.contest')); 	
             }else{
             	return Redirect::to('/');
             }
            
        }catch(Exception $e) {
            Log::error($e);
            if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="versus"))
                return  Redirect::to("/".Session::get('user.vista')."/".Session::get('user.contest'));
            if((Session::get('user.promo_type')=="actividad") && ($info->contest_type=="foto"))    
                return  Redirect::to("/foto/".Session::get('user.contest'));
            return  Redirect::to($this->nameController($info)."/".Session::get('user.contest')."/autorizacion");
            //return $e->getMessage();
        }

    }



    private function saveUserInfo($user_profile){
        Session::put('user.email', strtolower( trim($user_profile->email)));
        if(Session::get('user.provider')=="Twitter"){
            Session::put('user.firstname', "");   
            Session::put('user.lastname', "");
        }else{
            Session::put('user.firstname', $user_profile->firstName);   
            Session::put('user.lastname', $user_profile->lastName);
        }
        
        Session::put('user.gender', $user_profile->gender);
        Session::put('user.country', $user_profile->country);
        Session::put('user.birthday', $user_profile->birthDay);
		Session::put('user.birthmonth', $user_profile->birthMonth);
		Session::put('user.birthyear', $user_profile->birthYear);
		Session::put('user.identifier', $user_profile->identifier);
        Session::put('user.profileURL', $user_profile->profileURL);
        Session::put('user.photoURL', $user_profile->photoURL);
	}

    protected function nameController($info){

        if (isset($info->properties['channel']))
            return $info->properties['channel'];    
        else
            return 'canal-5';
        
    }

}
