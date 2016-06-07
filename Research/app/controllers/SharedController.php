<?php

class SharedController extends BaseController {

	public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	 public function getIndex(){
	 	$user = Sentry::getUser();
		if($user->hasAccess('generateurl.view')){
			return View::make('sharedlink.create');
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento acceder al Generador de Urls sin tener los permisos necesarios');
            App::abort(401);
		}
	}


}

