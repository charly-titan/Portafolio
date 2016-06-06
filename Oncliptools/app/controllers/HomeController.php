<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}


	public function getLogout()
    {
        if (Sentry::check()){
        	Sentry::logout();
        }
        return  Redirect::to('login');
    }

    public function getLogin()
    {
        if (Sentry::check()){
			return  Redirect::to('/');
		}else{
			echo "<!-- " . gethostname() . " -->";
			return View::make('vcms.login');
		}
    }

}
