<?php
class UsersController extends BaseController {

     public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth', array('except' => array('getLogin','postLogin','loginGoogle','postGoogleauth','getInstallgoogleauth','getLogout','getGoogleauth','getForgotpassword','postForgotpassword','getChangepass','postChangepass')));
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getGoogleauth(){
        if (Sentry::check()){
            return View::make(Config::get('app.main_template').'.users.twostepauth');
        }else{
            return  Redirect::to('/');
        }
    }

    public function getInstallgoogleauth(){
        if (Sentry::check()){
            $user = Sentry::getUser();
            $google2fa_url = Google2FA::getQRCodeGoogleUrl(
                         'Research-TIM-'.App::environment(),
                         Session::get('user.email'),
                         $user->google2fa_secret
                     );
            return View::make(Config::get( 'app.main_template' ).'.users.googleauth')->with("google2fa_url",$google2fa_url);
        }else{
            return  Redirect::to('/');
        }
    }

    public function postGoogleauth(){

        if (Sentry::check()){
            $auth2step = Input::get('auth2step');
            $secret = str_replace(" ", "", $auth2step);

            $validator = Validator::make(
                array('name' => $secret),
                array('name' => 'required|digits:6')
            );


            $user = User::find(Session::get("user.id"));



            /*  Si falla la validación del campo */
            if ($validator->fails()){
                
                $this->wrongGoogleAuth();
                if(is_null($user->activation_code)){
                    return  Redirect::to('/user/installgoogleauth')->withErrors($validator);
                }else{
                    return  Redirect::to('/user/googleauth')->withErrors($validator);
                }
            }

            if($this->checkGoogleAuth($secret)){
                if(is_null($user->activation_code)){
                    $user->activation_code =  substr(md5(sha1(rand())),0,20);
                    $user->save();
                }

                Session::put('user.authGoogle',1);

            }else{
                
                $this->wrongGoogleAuth();
                if(is_null($user->activation_code)){
                    return  Redirect::to('/user/installgoogleauth')->withErrors(array());
                }else{
                    return  Redirect::to('/user/googleauth')->withErrors(array());
                }
            }
        }
        
        return  Redirect::to('/');
        
    }



    private function wrongGoogleAuth(){
        if(Session::has('user.autherror')){
            if(intval(Config::get('app.error_tries')-1 <= intval(Session::get('user.autherror')))){
                Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' ha sido bloqueado por rebasar el numero de accesos fallidos de Google Authenticator en el sistema. ');
                $user = User::find(Session::get("user.id"));
                $dt = new DateTime;
                $user->activated_at =  $dt->format('Y-m-d H:i:s');
                $user->save();
                App::abort(406);
            }

            Session::put('user.autherror', Session::get('user.autherror')+1 );

        }else{
            Session::put('user.autherror', 1);
        }
    }

    private function checkGoogleAuth($auth2step=""){
        if (Sentry::check()){
            $user = Sentry::getUser();
            $valid = Google2FA::verifyKey($user->google2fa_secret, $auth2step);
            return $valid;
        }else{
            return false;
        }

    }

    private function userPermission($property_name){

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


    private function getUsers(){
        
        $users = DB::select("SELECT u.*,GROUP_CONCAT(DISTINCT g.name) as roles,p.phone from groups_sites_profile_relationships AS gsp LEFT JOIN sites AS s on (gsp.id_site = s.id_site)
        LEFT JOIN groups AS g on (gsp.id_group = g.id) LEFT JOIN profiles AS p on (p.id_profile = gsp.id_profile) LEFT JOIN users AS u on(p.id_users = u.id) GROUP BY u.id");
        
        return $users;
    }

    private function UsersTelegram(){
        
        $users_telegram = DB::select("SELECT u.first_name,u.last_name,p.phone from profiles AS p LEFT JOIN users AS u on(p.id_users = u.id) where u.telegram=1 GROUP BY u.id");
        
        return $users_telegram;
    }


    public function getIndex(){

        $userPermission = $this->userPermission('users');

        $users = $this->getUsers();

         return View::make(Config::get( 'app.main_template' ).'.users.list')->with(array('users'=>$users,'userPermission'=>$userPermission));
    }

   

    public function getLogout(){
        if (Sentry::check()){
            Log::notice('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." - ".Session::get('user.id').' cerró su sesión');
            Sentry::logout();
            Session::flush();
            Session::regenerate();
        }
        return  Redirect::to('/user/login');
    }

    public function getLogin()
    {
        if (Sentry::check()){
            return  Redirect::to('/');
        }else{
            echo "<!-- " . gethostname() . " -->";
            return View::make(Config::get( 'app.main_template' ).'.users.login');
        }
    }

    public function getFormaccount(){

        $userPermission = $this->userPermission('users'); 
        $userPermissionRoles = $this->userPermission('roles');
        
        $sites = Sites::all();
        $groups = Groups::all();

        $site = array(0 => 'Selecciona un sitio') + $sites->lists('name','id_site');

        $site = array('' => '') + $sites->lists('name','id_site');

        $group = $groups->lists('name','id');

        return View::make(Config::get( 'app.main_template' ).'.users.formAccount')->with(array('sites'=>$site,'groups'=>$group,'userPermission'=>$userPermission,'userPermissionRoles'=>$userPermissionRoles));

    }

    public function postFormaccount(){

        $inputs = Input::all();

        $accountPermission = Input::get('accountPerm');
        
        $rules = array(
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'gender'   => 'required|in:Male,Female',
            'password' => 'required|min:5|max:20',
            'password_repeat' => 'required|same:password',
            'birthdate' => 'required|date',
            'email' => 'required|email|min:5|max:100|unique:users,email',
            'phone' => 'required|numeric|regex:/[0-9]{10,11}/',
            'address' => 'required|max:100',
            'city' => 'required',
            'zip_code' => 'required|numeric|regex:/[0-9]{4,5}/',
            'state' => 'required',
            'country' => 'required',
            );


            $validate = Validator::make($inputs, $rules);

            if($validate->fails()){
                
                    return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..'));
                
            }else if($accountPermission==''){

                return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..'));
            
            }else{

                $user = Sentry::createUser(array(
                        'email'             => Input::get('email'),
                        'password'          => Input::get('password'),
                        'activated'         => true,
                        'first_name'        => Crypt::encrypt(Input::get('first_name')),
                        'last_name'         => Crypt::encrypt(Input::get('last_name')), 
                        'google2fa_secret'  => Google2FA::generateSecretKey()
                        ));

                $profile = new Profiles;

                        $day_old = Input::get('birthdate');
                        $new_day = date("Y-m-d", strtotime($day_old));  

                        $profile->id_users      = $user->id;
                        $profile->first_name    = Crypt::encrypt(Input::get('first_name'));
                        $profile->last_name     = Crypt::encrypt(Input::get('last_name'));
                        $profile->birthdate     = $new_day;
                        $profile->gender        = Input::get('gender');
                        $profile->phone         = Crypt::encrypt(Input::get('phone'));
                        $profile->fax           = Crypt::encrypt(Input::get('fax'));
                        $profile->save();

                
                $address = new Address;
                
                $prof = Profiles::all()->last();
                $idProfile = $prof->id_profile;
                

                            $address->address   =  Crypt::encrypt(Input::get('address'));
                            $address->city      =  Input::get('city');
                            $address->zip_code  =  Input::get('zip_code');
                            $address->state     =  Input::get('state');
                            $address->country   =  Input::get('country');
                            $address->save();

                $GroupsProfileAddressRelationships = new GroupsProfileAddressRelationships;

                            $GroupsProfileAddressRelationships->id_profile = $idProfile;
                            $GroupsProfileAddressRelationships->id_address = $address->id_address;
                            $GroupsProfileAddressRelationships->save();


                foreach ($accountPermission as $accountSite => $value) {
                    foreach ($value as $accountPermission) {

                        $GroupsSitesProfileRelationships = new GroupsSitesProfileRelationships;

                            $GroupsSitesProfileRelationships->id_site = $accountSite;
                            $GroupsSitesProfileRelationships->id_group = $accountPermission;
                            $GroupsSitesProfileRelationships->id_profile = $idProfile;
                            $GroupsSitesProfileRelationships->save();
                    }
                }

                return Redirect::to('user');
            }
    }



    public function getEditprofile($user_id=""){

        $userPermission = $this->userPermission('users');
        $userPermissionRoles = $this->userPermission('roles');
        
        if($user_id==""){   $user_id=Session::get('user.id'); }
        $validator = Validator::make(
            array('id' => $user_id),
            array('id' => 'required|min:1|integer')
        );

        if ($validator->fails()){
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento acceder con un perfil no autorizado - '.$user_id);
            App::abort(409);
        }


        $countProfile = Profiles::find($user_id);

        if($countProfile == null){

            $user = DB::select("SELECT id as id_users,first_name,last_name,'' as gender,'' as birthdate, email,'' as phone, '' as fax, '' as address, '' as city, '' as zip_code, '' as state,'' as country
                                from users where id = ".$user_id); 

                $perfiles = new stdClass();

                foreach ($user as $key) {

                    $perfiles->id_users = $key->id_users;
                    $perfiles->first_name = Crypt::encrypt($key->first_name);
                    $perfiles->last_name = Crypt::encrypt($key->last_name);
                    $perfiles->gender = $key->gender;
                    $perfiles->birthdate = $key->birthdate;
                    $perfiles->email = $key->email;
                    $perfiles->phone = Crypt::encrypt($key->phone);
                    $perfiles->fax = Crypt::encrypt($key->fax);
                    $perfiles->address = Crypt::encrypt($key->address);
                    $perfiles->city = $key->city;
                    $perfiles->zip_code = $key->zip_code;
                    $perfiles->state = $key->state;
                    $perfiles->country = $key->country;
                }

                $perfilPermission = [];

        }else{
            
                $perfil = DB::table('groups_sites_profile_relationships AS gsp')
                            ->leftJoin('groups AS g', 'gsp.id_group', '=', 'g.id')
                            ->leftJoin('profiles AS p','gsp.id_profile','=','p.id_profile')
                            ->leftJoin('users AS u','u.id','=','p.id_users')
                            ->leftJoin('groups_profile_address_relationships AS gpa','gpa.id_profile','=','p.id_profile')
                            ->leftJoin('address AS a','a.id_address','=','gpa.id_address')
                            ->where('p.id_users','=',$user_id)
                            ->groupBy('p.id_users')
                            ->get(array('p.id_users','p.first_name','p.last_name','p.gender','p.birthdate','u.email','p.phone','p.fax','a.address','a.city','a.zip_code','a.state','a.country'));

              
            $perfilPermission = DB::table('groups_sites_profile_relationships AS gsp')
                            ->leftJoin('sites AS s', 'gsp.id_site', '=', 's.id_site')
                            ->leftJoin('groups AS g','gsp.id_group','=','g.id')
                            ->leftJoin('profiles AS p','p.id_profile','=','gsp.id_profile')
                            ->where('p.id_users','=',$user_id)
                            ->groupBy('id_site')
                            ->get(array('s.id_site',DB::Raw('group_concat(distinct s.name) as nameSite'),DB::Raw('group_concat(distinct g.id) as id'),DB::Raw('group_concat(distinct g.name) as nameGroup')));
     

                        $perfiles = new stdClass();
                     

                        foreach ($perfil as $key => $value) {
                             $perfiles->id_users = $value->id_users;
                             $perfiles->first_name = Crypt::decrypt($value->first_name);
                             $perfiles->last_name = Crypt::decrypt($value->last_name);
                             $perfiles->gender = $value->gender;
                             $perfiles->birthdate = $value->birthdate;
                             $perfiles->email = $value->email;
                             $perfiles->phone = Crypt::decrypt($value->phone);
                             $perfiles->fax = Crypt::decrypt($value->fax);
                             $perfiles->address = Crypt::decrypt($value->address);
                             $perfiles->city = $value->city;
                             $perfiles->zip_code = $value->zip_code;
                             $perfiles->state = $value->state;
                             $perfiles->country = $value->country;
                        }
        }

        $sites = Sites::all();
        $groups = Groups::all();

        $site = array(0 => 'Selecciona un sitio') + $sites->lists('name','id_site');

        $site = array('' => '') + $sites->lists('name','id_site');

        $group = $groups->lists('name','id');


        return View::make(Config::get( 'app.main_template' ).'.users.formAccount')->with(array('profiles'=>$perfiles,'perfilPermission'=>json_encode($perfilPermission),'sites'=>$site,'groups'=>$group,'userPermission'=>$userPermission,'userPermissionRoles'=>$userPermissionRoles));

    }



    public function postEditprofile($id){

        $numPerm = DB::select('SELECT * from groups_sites_profile_relationships where id_profile = '.$id.' and (id_group!="" or id_site!="")');

        $inputs = Input::all();
        $accountPermission = Input::get('accountPerm');


        $day_old = Input::get('birthdate');
        $new_day = date("Y-m-d", strtotime($day_old));  

        $rules = array(
            'first_name' => 'required|min:3|max:20',
            'last_name'  => 'required|min:3|max:20',
            //'gender'        => 'required|in:male,female',
            //'birthdate'  => 'required|date',
            'email'      => 'required|email|min:5|max:100',
            //'phone'      => 'required|numeric|regex:/[0-9]{10,11}/',
            'address'    => 'required|max:100',
            'city'       => 'required',
            'zip_code'   => 'required|numeric|regex:/[0-9]{4,5}/',
            'state'      => 'required',
            'country'    => 'required',
        );


        $validate = Validator::make($inputs, $rules);

            if($validate->fails()){
                return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));

            }else if($accountPermission == null && count($numPerm) == 0){

                return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));
            }else{

                $countProfile = Profiles::find($id);

                if($countProfile == null){

                    $profile = new Profiles;

                        $profile->id_users  = $id;
                        $profile->save();

                        $prof = Profiles::all()->last();
                        $idProfile = $prof->id_profile;

                    $address = new Address;

                        $address->save();

                    $GroupsProfileAddressRelationships = new GroupsProfileAddressRelationships;

                                $GroupsProfileAddressRelationships->id_profile = $idProfile;
                                $GroupsProfileAddressRelationships->id_address = $address->id_address;
                                $GroupsProfileAddressRelationships->save();

                }else{
                        $idProfile = DB::table('profiles')->where('id_users','=',$id)->lists('id_profile');
                        $idProfile = (string) array_shift($idProfile);      
                }


                    $profile = Profiles::find($id);


                            $profile->first_name    = Crypt::encrypt(Input::get('first_name'));
                            $profile->last_name     = Crypt::encrypt(Input::get('last_name'));
                            $profile->birthdate     = $new_day;
                            $profile->gender        = Input::get('gender');
                            $profile->phone         = Crypt::encrypt(Input::get('phone'));
                            $profile->fax           = Crypt::encrypt(Input::get('fax'));
                            $profile->save();

                    $user = Sentry::findUserById($id);

                            $user->first_name    =  Crypt::encrypt(Input::get('first_name'));
                            $user->last_name     =  Crypt::encrypt(Input::get('last_name'));
                            $user->email         = Input::get('email');
                            $user->save();

                    $idAddress = DB::table('groups_profile_address_relationships')
                            ->distinct()
                            ->where('id_profile',$idProfile)
                            ->lists('id_address');


                            $idAddress = array_shift($idAddress);

                    $address = Address::find($idAddress);

                            $address->address   =  Crypt::encrypt(Input::get('address'));
                            $address->city      =  Input::get('city');
                            $address->zip_code  =  Input::get('zip_code');
                            $address->state     =  Input::get('state');
                            $address->country   =  Input::get('country');
                            $address->save();



                            if($accountPermission){


                            $numProfile = DB::table('groups_sites_profile_relationships')
                                            ->where('id_profile','=',$idProfile)
                                            ->where('id_site','=',0)
                                            ->where('id_group','=',0)
                                            ->delete();

                                foreach ($accountPermission as $accountSite => $value) {
                                    //print_r($value);

                                    for ($i=0; $i <count($value) ; $i++) { 
                                        echo $accountSite." -- ".$value[$i]." -- ".$idProfile."<br>";

                                       $count = GroupsSitesProfileRelationships::where('id_site', $accountSite)->where('id_group', $value[$i])->where('id_profile', $idProfile)->count();

                                       if($count == 0){
                                            $GroupsSitesProfileRelationships = new GroupsSitesProfileRelationships;
                                            $GroupsSitesProfileRelationships->id_site = $accountSite;
                                            $GroupsSitesProfileRelationships->id_group = $value[$i];
                                            $GroupsSitesProfileRelationships->id_profile = $idProfile;
                                            $GroupsSitesProfileRelationships->save();
                                       } 
                                    
                                    }
                                }
                            }         

                return Redirect::to('user');
            }
    }

    public function getSelectsite(){

        if (Request::ajax()) {

            $idSite = Input::get('selectSite');

            $idGroups = GroupSitesRelation::where('id_site',$idSite)->get();

            $ids = array();

            foreach($idGroups as $idGroup)
            {
                array_push($ids, $idGroup->id_group);
            }

            if(count($ids)!=0){

                $groups = DB::table('groups')
                        ->whereIn('id', $ids)->get();

                return Response::json($groups);
            }else{
                return Response::json("null");
            }
        }
    }

    public function getDeletepermission($idPermission,$idUser,$idSite){

        $idgsp = DB::table('groups_sites_profile_relationships as gsp')
                    ->leftJoin('profiles AS p', 'gsp.id_profile', '=', 'p.id_profile')
                    ->where('id_users','=',$idUser)
                    ->where('id_group','=',$idPermission)
                    ->where('id_site','=',$idSite)
                    ->lists('id_group_site_profile_relationship');

                    DB::table('groups_sites_profile_relationships')
                        ->whereIN('id_group_site_profile_relationship', $idgsp)
                        ->update(array('id_group' => '','id_site' => ''));

        try{
            // Find the user using the user id
            $user = Sentry::findUserById($idUser);
            // Find the group using the group id
            $adminGroup = Sentry::findGroupById($idPermission);
            //  remove the group to the user
            if ($user->removeGroup($adminGroup)){
                // Group removed successfully
                return Redirect::to('user/editprofile/'.$idUser);
            }
            
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e){
            echo 'User was not found.';
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){
            echo 'Group was not found.';
        }  
    }

    public function getDeleteprofile($id){

            $user = User::find($id);
            $user->activated = 0;
            $user->save();

            return Redirect::to('user');
    }


    
    // private function index() {
    //     $users = User::all();
    //     return View::make('users.index')->with('users', $users);
    // }
    // private function show($id) {
    //     $user = User::find($id);
    //     return View::make('users.show')->with('user', $user);
    // }
    // private function create() {
    //     $user = new User();
    //     return View::make('users.save')->with('user', $user);
    // }
    // private function store() {
    //     $user = new User();
    //     $user->real_name = Input::get('real_name');
    //     $user->email = Input::get('email');
    //     $user->password = Hash::make(Input::get('password'));
    //     $user->level = Input::get('level');
    //     $user->active = true;
    //     $user->save();
    //     return Redirect::to('users')->with('notice', Lang::get('users.user_created'));
    // }

    protected function loginGoogle($action=""){
        
        if (Session::has('user')){
            return User::validateUserGoogle();
        }

        if ($action == "auth") { // check URL segment
            try { // process authentication
                Hybrid_Endpoint::process();
            }catch (Exception $e) {
                
                return Redirect::to('social');
            }
            return;
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
            $adapter = $hybridauth->authenticate("Google");
            $user_profile = $adapter->getUserProfile(); 
            $adapter->logout();

            // print_r($user_profile);
            // exit("--");

            // Hybrid_User_Profile Object ( [identifier] => 106508012100958583978 [webSiteURL] => [profileURL] => https://plus.google.com/106508012100958583978 [photoURL] => https://lh3.googleusercontent.com/-BVhJMQEH-fw/AAAAAAAAAAI/AAAAAAAAAPI/3dPhMUAQJu0/photo.jpg?sz=200 [displayName] => Gabriel Mancera Hernandez [description] => [firstName] => Gabriel [lastName] => Mancera Hernandez [gender] => male [language] => [age] => [birthDay] => 0 [birthMonth] => 0 [birthYear] => 0 [email] => gabriel.mancera@televisatim.com [emailVerified] => [phone] => [address] => Mexico [country] => [region] => [city] => Mexico [zip] => ) --

            Session::put('user.email', $user_profile->email);
            Session::put('user.firstname', Crypt::encrypt($user_profile->firstName));
            Session::put('user.lastname', Crypt::encrypt($user_profile->lastName));
            Session::put('user.gender', $user_profile->gender);

            

            return User::validateUserGoogle();
        }catch(Exception $e) {

            return $e->getMessage();
        }

    }

    // private function edit($id) {
    //     $user = User::find($id);
    //     return View::make('users.save')->with('user', $user);
    // }
    // private function update($id) {
    //     $user = User::find($id);
    //     $user->real_name = Input::get('real_name');
    //     $user->email = Input::get('email');
    //     $user->level = Input::get('level');
    //     $user->save();
    //     return Redirect::to('users')->with('notice', Lang::get('users.user_updated'));
    // }


    // private function destroy($id) {
    //     $user = User::find($id);
    //     $user->delete();
    //     return Redirect::to('users')->with('notice', Lang::get('users.user_deleted'));
    // }

    public function postLogin() {
        try
            {
                // Login credentials
                echo "<!-- ".gethostname()."-->";
                $credentials = array(
                    'email'    => Input::get('email'),
                    'password' => Input::get('password'),
                );

                $inputs = Input::all();

                 $rules = array(
                    'password' => 'required|min:5|max:20',
                    'email' => 'required|email|min:5|max:100',
                    );


                $validate = Validator::make($inputs, $rules);

                if($validate->fails()){
                    
                        return Redirect::back()->withInput()->withErrors($validate);
                    
                }
                
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
                    return Redirect::to('user/login')->withErrors(array('msg'=>'User does not have access the site.'));
                }    
                $id_site=$site->id_site;
                $profile = Profiles::find($user->id);
                if(!$profile){
                    if (Sentry::check()){
                       Sentry::logout();
                    }
                    return Redirect::to('user/login')->withErrors(array('msg'=>'User does not have access or permissions the site. Please contact the administrator.'));
                }
                if($profile){
                    Session::put('user.firstname', Crypt::decrypt($profile->first_name));
                    Session::put('user.lastname', Crypt::decrypt($profile->last_name));
                    Session::put('user.gender', $profile->gender);
                    Session::put('user.email', $user->email);
                    Session::put('user.gravatar', md5(strtolower(trim($user->email))) );
                    Session::put('user.id', $user->id );
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


    public function getForgotpassword(){
         return View::make(Config::get( 'app.main_template' ).'.users.forgotPassword');
    }

    public function postForgotpassword(){
        
        $input = Input::all();

        $rule = array('email' => 'required|email|min:5|max:100');   

        $validator = Validator::make($input, $rule);

        if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
        } else { 

                    try
                        {
                            $user = Sentry::findUserByLogin(Input::get('email'));

                            $countUser = EmailToken::where('id_user','=',$user->id)->get(array('created_at',DB::raw("TIMESTAMPDIFF(MINUTE,created_at,NOW()) AS minute")))->first();
                            
                             if(count($countUser) != 0){/*Ya se envio correo ver tiempo de espera */

                                    if($countUser->minute <= 5){
                                        return Redirect::back()->with('msg','msg');
                                    }else{
                                        return Redirect::back()->with('msgAviso','msgAviso');
                                    }

                            }else{/*Si no se ha enviado correo*/


                                $token = hash('sha256',Str::random(10),false);
                                //csrf_token();
                                $correo = 'http://'.$_SERVER['SERVER_NAME'].'/user/changepass/'.$token;
                                
                                $userToken = new EmailToken;

                                        $userToken->id_user     = $user->id;
                                        $userToken->token       = $token;
                                        $userToken->save();

                                $msg=$correo;


                                $datos = array(
                                                'subject' => "Link para Generar nueva Contraseña",
                                                'msg' => $msg,
                                                'user' => Crypt::decrypt($user->first_name)
                                               // 'user' => $user->first_name

                                              );

                                Mail::send('emails.newpassword', $datos, function($message) use ($user)
                                    {
                                      $message->to($user->email)->subject('Research Televisa');
                                    });

                                return Redirect::back()->with('msgEnviado','msgEnviado');
                            }
                        }
                        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
                        {
                             return Redirect::back()->with('msgError','msgError');
                        }
        }

    }

    public function getChangepass($token){
        
        $idUser = DB::table('emailToken AS e')
                        ->select('u.id')
                        ->leftJoin('users AS u', 'e.id_user', '=', 'u.id')
                        ->where('e.token','=',$token)
                        ->lists('id');
                        
        $idUser = (int) array_shift($idUser); 

        $user = EmailToken::where('id_user','=',$idUser)->get()->first();



        if(!$user){
             return Redirect::to('login')->with('msgExpirado','msgExpirado');  
        }

        if($user->created_at->diffInDays() >= 1 ){

            $affectedRows = EmailToken::where('id_user', '=', $user->id)->delete();

            return Redirect::to('login')->with('msgExpirado','msgExpirado');  

        }else{

            return View::make(Config::get( 'app.main_template' ).'.users.changePassword')->with('idUser',json_encode($idUser));
        }
    }



    public function postChangepass($id){


        $inputs = Input::all();

        $rules = array(
            'password' => 'required|min:5|max:20',
            'password_repeat' => 'required|same:password'
            );


            $validate = Validator::make($inputs, $rules);

            if($validate->fails()){
                
                  return Redirect::back()->withInput()->withErrors($validate);
                
            }else {

                 $user = Sentry::getUserProvider()->findById($id);  
                 $user->password = Input::get('password');

                 
                 if ($user->save())
                {
                    $affectedRows = EmailToken::where('id_user', '=', $id)->delete();
                }
                return Redirect::to('user/login')->with('msg','msg');  
            }

    }


    public function getTelegram(){
        
        /*$contact_list = TG::contactList();

        foreach ($contact_list as $key => $value) {
             echo  $value->print_name."<br>";
        }*/

        foreach ($this->getUsers() as $key => $value) {
           
            $contact_add = TG::contactAdd("52".Crypt::decrypt($value->phone),Crypt::decrypt($value->first_name),Crypt::decrypt($value->last_name));
            
            if($contact_add){
                //echo $value->id." -- ".Crypt::decrypt($value->first_name)." -- ".Crypt::decrypt($value->last_name)." -- "."52".Crypt::decrypt($value->phone)." -- ".count($contact_add)."<br>";
                //DB::table('users')->where('id', $value->id)->update(array('telegram' => 1));

                $user = User::find($value->id);
                $user->telegram = 1;
                $user->save();
            }


                //DB::table('profiles')->where('id_users', $value->id)->update(array('telegram' => 0));
                
                //echo $value->id." -- ".Crypt::decrypt($value->first_name)." -- ".Crypt::decrypt($value->last_name)." -- "."52".Crypt::decrypt($value->phone)." -- ".count($contact_add)."<br>";
  
        }
            echo "Se actualiza campo de los que cuentan con telegram";
        return Redirect::back();

    }




}
