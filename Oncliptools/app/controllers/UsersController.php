<?php

class UsersController extends BaseController {
    public function index() {
        $users = User::all();
        return View::make('users.index')->with('users', $users);
    }
    public function show($id) {
        $user = User::find($id);
        return View::make('users.show')->with('user', $user);
    }
    public function create() {
        $user = new User();
        return View::make('users.save')->with('user', $user);
    }
    public function store() {
        $user = new User();
        $user->real_name = Input::get('real_name');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->level = Input::get('level');
        $user->active = true;
        $user->save();
        return Redirect::to('users')->with('notice', 'El usuario ha sido creado correctamente.');
    }
    public function edit($id) {
        $user = User::find($id);
        return View::make('users.save')->with('user', $user);
    }
    public function update($id) {
        $user = User::find($id);
        $user->real_name = Input::get('real_name');
        $user->email = Input::get('email');
        $user->level = Input::get('level');
        $user->save();
        return Redirect::to('users')->with('notice', 'El usuario ha sido modificado correctamente.');
    }
    public function destroy($id) {
        $user = User::find($id);
        $user->delete();
        return Redirect::to('users')->with('notice', 'El usuario ha sido eliminado correctamente.');
    }

    public function login() {
        try
            {
                // Login credentials
                echo "<!-- ".gethostname()."-->";
                $credentials = array(
                    'email'    => Input::get('email'),
                    'password' => Input::get('password'),
                );
                
                // Authenticate the user
                $user = Sentry::authenticate($credentials, false);

                //verificamos que se tenga acceso a este sitio
                $domain=$_SERVER['HTTP_HOST'];
                $sites = Sites::all();
                foreach ($sites as $site ) {
                    $pos = strpos($domain, $site->domain);
                    if ($pos) break;
                }
                if(!$pos){
                    if (Sentry::check()){
                       Sentry::logout();
                    }
                    return Redirect::to('login')->withErrors(array('msg'=>'User does not have access the site.'));
                }    
                $id_site=$site->id_site;
                $profile = Profiles::find($user->id);
                if(!$profile){
                    if (Sentry::check()){
                       Sentry::logout();
                    }
                    return Redirect::to('login')->withErrors(array('msg'=>'User does not have access or permissions the site. Please contact the administrator.'));
                }
                
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
                            //echo "<br>Group was not assigned";
                            if (Sentry::check()){
                               Sentry::logout();
                            }
                            return Redirect::back()->withErrors(array('msg'=>'Group was not assigned'));
                        }
                    }
                    return  Redirect::to('/'); 
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
}
?>