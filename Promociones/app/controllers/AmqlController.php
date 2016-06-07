<?php
class AmqlController extends Canal5Controller {


	public function __construct()
    {
		parent::__construct();
		Config::set('app.main_template', 'promociones2.amqlichita');
        
    }



	public function getIndex($short_name=""){
        /*Se elimina Sessiones anteriores, probando...*/
        //Session::forget('user');

        if($short_name!=""){
            Session::put('user.contest', 'amqlichita'); // Establecer el concurso para la sesión
            Session::put('user.promo_type', 'login'); //Establecer el tipo de concurso
            $this->saveBackUrl();
            switch ($short_name) {
                case 'login':
                    return View::make(Config::get( 'app.main_template' ).'.login.main');    
                    break;
                case 'facebook':
                    return Redirect::to('/social/Facebook');    
                    break;
                case 'twitter':
                    return Redirect::to('/social/Twitter');
                    break;
                case 'google':
                    return Redirect::to('/social/Google');
                    break;
                case 'user':
                    return $this->checkLogin();
                    break;
            }
            parent::getIndex();
        }
    }

    public function getPuntos($short_name=""){
        //return Session::all();
        if(Session::has('user.identifier')){

            $info=$this->contestInfo('amqlichita');

            if(!($this->userIsRegister($info->id_contest)))
                if(!$this->userRegister($info))
                    return "Error al registrar";

            
            //obtenemos los puntos del usuario
            $rewards   =  UserRewards::where('user_id', Session::get("user.id"))
                        ->where('point_id', 1) //para este caso sera con id_point=1 que se ingresa manualmente a la db
                        ->first();
                    
            if(is_null($rewards) or !count($rewards)){
                $puntos=0;
                $rewards            =   new UserRewards;
                $rewards->user_id   =   Session::get("user.id");
                $rewards->point_id  =   1;
                $rewards->points    =   100;//Inicialmente se agregan 100 puntos al usuario por registrarse
                $rewards->save();
            }else{
                $puntos=$rewards->points;
            }
            Session::put("user.points",$puntos);

            //Se crea la cookie
            setcookie("user[name]", Session::get("user.firstname"));
            setcookie("user[photoURL]", Session::get("user.photoURL"));
            setcookie("user[puntos]", $puntos);
            
            return Redirect::to(Session::get("USER_REFERER"));
            //return View::make(Config::get( 'app.main_template' ).'.puntos')->with(array("puntos"=>$puntos));
            
        }
        App::abort(404);

    }


    
    public function getConfirma($short_name=""){
        
        if(Session::has('user.identifier')){

            $info=$this->contestInfo('amqlichita');
            
            if(!($this->userIsRegister($info->id_contest)))
                return View::make(Config::get( 'app.main_template' ).'.confirma');
            else
                return Redirect::to('/amqlichita/1/puntos/');
        }
        App::abort(404);
    } 

    protected function checkLogin() {
        try {
            if(Session::has('user.identifier')){

                $info=$this->contestInfo('amqlichita');
                
                if(!($this->userIsRegister($info->id_contest))){
                    $userdata = array();
                }
                else{
                    
                    /*obtenemos los puntos del usuario
                    $rewards   =  UserRewards::where('user_id', Session::get("user.id"))
                                //-> where('point_id', $id_point) //por el momento obtenemos un solo registro porq no tenemos los id de los puntos
                                ->first();
                    if(is_null($rewards))
                        $puntos=0;
                    else
                        $puntos=$rewards->points;*/

                    $userdata = array( 'name'     =>Session::get("user.firstname"),
                                       'photoURL' =>Session::get("user.photoURL"),
                                       'puntos'   =>Session::get("user.points")
                                );
                    
                    
                }

                return "social_engage.userdata(".json_encode($userdata).")";
            }
            return "social_engage.userdata({})";
            
        } catch (Exception $e) {
            Log::error($e);
            return "social_engage.userdata({})";
        }
        
    }         

    
    protected function userIsRegister($contest){

        $user = DB::table('social_network')->where('contest_id', $contest)
        ->where('social_id', Session::get("user.identifier"))       
        ->first();
        
        if(is_null($user)){
            
            $user_exist = DB::table('users')->where('contest_id', $contest)
                            ->where('email', md5(Session::get("user.email")))       
                            ->first();
            if(is_null($user_exist)){
                return 0;
            }else{
                Session::put("user.id",$user_exist->id);
                if(Session::get("user.provider")=="Twitter"){
                    Session::put("user.email",Crypt::decrypt($user_exist->email_hash));
                    Session::put("user.firstname",Crypt::decrypt($user_exist->first_name));
                    Session::put("user.lastname",Crypt::decrypt($user_exist->last_name));
                }
                return 1;
            }
            
            
        }else{
            Session::put("user.id",$user->user_id);
            if(Session::get("user.provider")=="Twitter"){
                $user_exist = DB::table('users')//->where('contest_id', $contest)
                              ->where('id', $user->user_id)
                              ->first();
                Session::put("user.email",Crypt::decrypt($user_exist->email_hash));
                Session::put("user.firstname",Crypt::decrypt($user_exist->first_name));
                Session::put("user.lastname",Crypt::decrypt($user_exist->last_name));
            }
            return 1;   
        }
    }

    
    protected function userRegister($info){

        if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
            //es twiter
            return false; //Session::all();
        }

        $user_guid = sha1(Session::get("user.firstname").time().rand(5, 15));

        $user_exist = DB::table('users')->where('contest_id', $info->id_contest)
                        ->where('email', md5(Session::get("user.email")))       
                        ->first();


        if(is_null($user_exist)){

            $birthdate = date("Y-m-d", strtotime(str_replace('/', '-',Session::get("user.birthdate"))));
            $tz  = new DateTimeZone(Config::get( 'app.timezone' ));
            $age= DateTime::createFromFormat('d/m/Y', Session::get("user.birthdate"), $tz)->diff(new DateTime('now', $tz))->y;
        

            $user = new User;
            $user->user_guid = $user_guid;
            $user->email = md5(Session::get("user.email"));
            $user->email_hash = Crypt::encrypt(Session::get("user.email"));
            $user->password = Hash::make(sha1(Session::get("user.email").time().rand(5, 15)));
            $user->activated = true;
            $user->first_name = Crypt::encrypt(Session::get("user.firstname"));
            $user->last_name = Crypt::encrypt(Session::get("user.lastname"));
            $user->gender = Session::get("user.gender");
            $user->country=Session::get("user.country");
            /*$user->state=Input::get("estados");*/
            $user->birthdate=$birthdate;
            $user->age=$age;
            $user->contest="amqlichita";
            $user->contest_id=$info->id_contest;
            $user->save();

            Session::put("user.id",$user->user_id);

            $social = new Socialnet;
            $social->social_id=Session::get("user.identifier");
            $social->user_id=$user->id;
            $social->user_guid=$user_guid;
            $social->contest_id=$info->id_contest;
            $social->contest="amqlichita";
            $social->social_network = Session::get("user.provider");
            $social->profile_url = Session::get("user.profileURL");
            $social->photo_url = str_replace("http://", "https://", Session::get("user.photoURL"));
            $social->save();
        }else{
            $social = new Socialnet;
            $social->social_id=Session::get("user.identifier");
            $social->user_id=$user_exist->id;
            $social->user_guid=$user_exist->user_guid;
            $social->contest_id=$info->id_contest;
            $social->contest="amqlichita";
            $social->social_network = Session::get("user.provider");
            $social->profile_url = Session::get("user.profileURL");
            $social->photo_url = str_replace("http://", "https://", Session::get("user.photoURL"));
            $social->save();

            Session::put("user.id",$user_exist->user_id);

        }
        
        /*Session::put("user.firstname", Input::get("nombres"));
        Session::put("user.lastname", Input::get("apellidos"));*/

            return  1;
    }

    
    public function getRealIP() {
        
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }

    
    public function getBrowser() {
        
        return $_SERVER['HTTP_USER_AGENT'];
    }

    
    public function postConfirma($short_name=""){
        
        /*if(!$this->contestExist($short_name)) 
            App::abort(404);*/
        if (Session::get('user.provider')=="Twitter"){
            $values = array(        
                'nombre'    =>  Input::get('usrname'),
                'apellido'  =>  Input::get('lastname'),
                'email'     =>  Input::get('email'),
                'genero'    =>  Input::get('genero')
            );
            $format = array(
                    'nombre'    =>  'required',
                    'apellido'  =>  'required',
                    'email'     =>  'required|email',
                    'genero'    =>  'required',
            );

            $validator = Validator::make(
                $values   ,  $format
            );

            if ($validator->fails()){
                return  Redirect::back()->withErrors($validator);
            }

            if(is_null(Session::get("user.email")) || Session::get("user.email")==""){
                Session::put("user.email", strtolower( trim( Input::get('email'))));
                Session::put("user.firstname", Input::get('usrname'));
                Session::put("user.lastname", Input::get('lastname'));
                Session::put("user.gender", Input::get('genero'));
            }
        }

        /********Validacion de fecha*****/
        $op = strstr(Input::get('date'), '-');
        if ($op)
            $d = explode("-", Input::get('date'));
        else
            $d = explode("/", Input::get('date'));
        
        if(count($d)>2){
            if(strlen($d[0])>3){
                $datetem = $d[2]."/".$d[1]."/".$d[0];
            }else{
                $datetem =  Input::get('date');
            }
        }else
            $datetem =  Input::get('date');

        
        $values = array(        
                'date'      =>  $datetem,
        );
        $format = array(
                'date'      =>  'required|date_format:"d/m/Y"',
        );
        $validator = Validator::make(
            $values   ,  $format
        );
        if ($validator->fails()){
            return  Redirect::back()->withErrors($validator);
        }
        Session::put("user.birthdate", $datetem);
        /**************************************/

        $info=$this->contestInfo('amqlichita');

        if(!($this->userIsRegister($info->id_contest)))
            $this->userRegister($info);

        //Session::forget('user.activated');
                
        return Redirect::to('/amqlichita/1/puntos/');
        
    }

    public function getCaja($short_name=""){

        $UsersTop=$this->topUsers(2,5);//1er. parametro el id de los puntos, 2do. parametro: número de user a traer en la lista

        return View::make(Config::get( 'app.main_template' ).'.cajita')->with(array('UsersTop'=>$UsersTop));
            

    }

    public function topUsers($point_id,$num=5){


        $users = DB::table('user_rewards')
                    ->join('users', 'users.id', '=', 'user_rewards.user_id')
                    ->join('social_network', 'social_network.user_id', '=', 'user_rewards.user_id' )
                    ->where('point_id',$point_id)
                    ->select('email_hash', 'first_name', 'last_name', 'points', 'social_id', 'social_network','photo_url')
                    ->orderBy('points','desc')
                    ->take($num)
                    ->get();
        $data = [];
        
        $i=0;
        foreach ($users as $user) {
            $data[$i]['email'] = Crypt::decrypt($user->email_hash);
            $data[$i]['name'] = Crypt::decrypt($user->first_name).' '.Crypt::decrypt($user->last_name);
            $data[$i]['points'] = $user->points;
            $data[$i]['social_id'] = $user->social_id;
            $data[$i]['social_network'] = $user->social_network;
            $data[$i]['photo_url'] = $user->photo_url;
            $i++;
        }
        
        return  $data;

    }






}    