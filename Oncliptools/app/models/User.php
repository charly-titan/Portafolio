<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}


	protected function validateUserGoogle(){
		$user_info = Session::get('user');
		if ($this->isCorporate($user_info["email"])){
			if (!$this->userExist($user_info["email"])){
				$this->createFromGoogle($user_info);
			}
			if($this->logUser()){
				return  Redirect::to('/');
			}else{
				
				$msg="El Usuario ".$user_info["email"]." desea ingresar a Oncliptools pero no cuenta con permisos";
				$datos = array(
                                'subject' => "Solicitud de permisos",
                                'msg' => $msg
                );
                Mail::send('emails.notification', $datos, function($message)
                {
                    $message->to('gabriel.mancera@televisatim.com')->cc('elsa.salinas@televisatim.com')->subject('Solicitud de permisos');
                });
                return Redirect::to('welcome');
            }
		}else{
			if (Sentry::check()){
                Sentry::logout();
            }
			return Redirect::to('login')->withErrors(array('msg'=>'User does not have access the site.'));
		}
		
	}

	protected function isCorporate($email){
		$email = explode("@", $email);
		if(($email[1]=="televisatim.com")||($email[1]=="esmas.net")){
			return true;
		}else{
			return false;
		}
	}

	protected function userExist($email){
		try
			{
			    // Find the user using the user email address
			    $user = Sentry::findUserByLogin($email);
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    return false;
			}
			return true;
	}


	protected function logUser(){
		try
			{
				$user_info = Session::get('user');
			    // Find the user using the user email address
			    $user = Sentry::findUserByLogin($user_info["email"]);
			    Sentry::login($user, false);

			    //verificamos que se tenga acceso a este sitio
                $domain=$_SERVER['HTTP_HOST'];
                $sites = Sites::all();
                $pos=false;
                foreach ($sites as $site ) {
                    $pos = strpos($domain, $site->domain);
                    if ($pos) break;
                }
                if(!$pos) return false;
                
                $id_site=$site->id_site;
                $profile = Profiles::find($user->id);

                if(!$profile) return false;
                
                $allowed_sites = GroupsSitesProfileRelationships::where('id_profile', '=', $profile->id_profile)->get();
               
                $acceso=false;
                $groups=[];
                foreach ($allowed_sites as $key ) {
                    if ($id_site==$key->id_site) {
                          $groups[]=$key->id_group;
                          $acceso=true;
                    }      
                }

                if ($acceso) {
                    // Assign the group to the user
                    foreach ($groups as $key => $value) {
                        $idGroup=$value;
                        // Find the group using the group id
                        $adminGroup = Sentry::findGroupById($idGroup);
                        if ($user->addGroup($adminGroup)){
                            //echo "<br>Group assigned successfully";
                        }else{
                            //Group was not assigned";
                            if (Sentry::check()){
                               Sentry::logout();
                            }
                            return Redirect::back()->withErrors(array('msg'=>'Group was not assigned'));
                        }
                    }
                    return true;
                }else{
                    //echo "No tiene acceso";
                    if (Sentry::check()){
                       Sentry::logout();
                    }
                    return Redirect::back()->withErrors(array('msg'=>'User does not have access the site'));
                }
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e){
              	return Redirect::back()->withErrors(array('login'=>'Login field is required.'));
            }
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e){
                return Redirect::back()->withErrors(array('password'=>'Password field is required.'));
            }
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e){
                return Redirect::back()->withErrors(array('password'=>'Wrong password, try again.'));
            }
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e){
                return Redirect::back()->withErrors(array('msg'=>'User was not found.'));
            }
            catch (Cartalyst\Sentry\Users\UserNotActivatedException $e){
                return Redirect::back()->withErrors(array('msg'=>'User is not activated.'));
            }
            // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e){
                return Redirect::back()->withErrors(array('msg'=>'User is suspended.'));
            }
            catch (Cartalyst\Sentry\Throttling\UserBannedException $e){
                return Redirect::back()->withErrors(array('msg'=>'User is banned.'));
            }
            catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){
                return Redirect::back()->withErrors(array('msg'=>'Group was not found.'));
            }
			
	}



	protected function createFromGoogle($user_info){
		try
			{
			    // Create the user
			    $user = Sentry::createUser(array(
			        'email'     => $user_info["email"],
			        "first_name" => $user_info["firstname"],
    				"last_name" => $user_info["lastname"],
			        'password'  => substr(md5(sha1(rand())),0,20),
			        'activated' => true,
			    ));
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
			    echo 'Login field is required.';
			}
			catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
			{
			    echo 'Password field is required.';
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    echo 'User with this login already exists.';
			}
			catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
			    echo 'Group was not found.';
			}
	}

}
