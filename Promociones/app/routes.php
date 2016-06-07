<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::match(['get', 'post'],'instagram_callback',function(){
	return View::make("instagram_callback");
});


Route::get('instagram',function(){

	$url = "https://api.instagram.com/v1/subscriptions/";
	$callback_url = "http://promociones.televisa.com/*";

	$client_id = "*";
	$client_secret = "*";
	$token = "*.965dd72.*";

	$data = array(
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'object' => 'user',
				'aspect' => 'media',
				'verify_token' => $token,
				'client_id' => $client_id,
				'callback_url' => $callback_url
				);
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);
	print_r($result);

});

Route::controller('cklass',"CklassController");

Route::get('home',function(){
	return View::make('homeNoticieros');
});

Route::get('loret',function(){
	return View::make('homeNoticieros');
});

Route::get('logs/{fecha?}',function($fecha=""){
		
		if ($fecha=="")
			$log=date("Y-m-d").'.log';
		else
			$log=$fecha.'.log';

		$path=storage_path() . '/logs/laravel-'.$log;
		if (file_exists($path)) {
		    $s3 = AWS::get('s3');
			$result = $s3->putObject(array(
			     				// 'ACL'        	=> 'public-read',
			                    'Bucket'     	=> 'communities-dev',
			                    'Key'        	=> "/contest/".App::environment()."/logs/".gethostname()."_".$log,
			                    //'ContentType' 	=> 'video/'.Input::file('file')->getClientOriginalExtension(),
								'Body'   		=>  fopen($path, "r+")

			));
			return "Carga exitosa";
		} else {
		    return "$fecha no existe";
		}
});

Route::get('/', array('before' => array('force.ssl'), function()
{
    if(Session::has('user.contest')){

		return Redirect::to('canal-5/'.shortName(Session::has('user.contest')));

	}else{
		App::abort(404);
	}

}));

Route::controller('versus/{short_name}', 'VersusController');
Route::controller('cinematch/{short_name}', 'VersusController');
Route::controller('ninos/{short_name}', 'NinosController');
Route::controller('versus-canal-5', 'VersusCanal5Controller');
Route::controller('foto/{short_name}', 'FotoController');
Route::controller('ventas', 'IabController');
//Route::controller('ventas/{short_name}/{key}', 'IabController');
// Route::get('/versus-canal-5', array('before' => array('force.ssl'), function()
// {
//  //    if(Session::has('user.contest')){

// 	// 	return Redirect::to('canal5/'.shortName(Session::has('user.contest')));

// 	// }else{
// 	// 	App::abort(404);
// 	// }

// 	return View::make(Config::get( 'app.main_template' ).'.test.versus2');

// }));

Route::get('/versus2', array('before' => array('force.ssl'), function()
{
 //    if(Session::has('versus')){

	// 	return Redirect::to('canal5/'.shortName(Session::has('user.contest')));

	// }else{
	// 	App::abort(404);
	// }

	Session::put('versus', "1");

	return View::make(Config::get( 'app.main_template' ).'.test.versus')->with("promo_info","0");

}));



Route::get('/versus3', array('before' => array('force.ssl'), function()
{
 //    if(Session::has('versus')){

	// 	return Redirect::to('canal5/'.shortName(Session::has('user.contest')));

	// }else{
	// 	App::abort(404);
	// }

	Session::put('versus', "1");

	return View::make(Config::get( 'app.main_template' ).'.test.versus')->with("promo_info","1");

}));




Route::get('/{canal}', array('before' => array('force.ssl'), function(){

	if(Session::has('user.contest')){
		if(Session::get('user.contest')=="versus"){
			return Redirect::to('/'.shortName(Session::has('user.contest')));
		}
		if(Session::get('user.contest')=="foto"){
			return Redirect::to('canal-2/'.shortName(Session::has('user.contest')));
		}
		return Redirect::to('canal-5/'.shortName(Session::has('user.contest')));

	}else{
		App::abort(404);
	}
}));


function  shortName($id){

	$shortName = DB::table('users')
    				->where('contest_id', $id)
					->pluck('contest');

	return $shortName;
}

// Controller for users and roles
//Route::controller('canal5/{short_name}', 'Canal5Controller');
Route::controller('canal-5/{short_name}', 'Canal5Controller');
Route::controller('canal-2/{short_name}', 'Canal5Controller');
Route::controller('amqlichita/{short_name?}', 'AmqlController');
Route::controller('deportes/{short_name}', 'DeportesController');
Route::controller('bandamax/{short_name}', 'Canal5Controller');
Route::controller('pepsi/{short_name}', 'Canal5Controller');
Route::controller('lichipuntos', 'LichipuntosController');
Route::controller('changecenter', 'CentroDeCanjeController');
Route::controller('television/{short_name}', 'TelevisionController');

Route::get('social/{action?}', array('as' => 'hybridauth', 'uses' => 'BaseController@getSocial'));
//Route::resource('canal5', 'ContestController');



// public function getSocial($action=""){

// 		exit("YYYYY");


//         if (Session::has('user')){
//             return User::validateUserGoogle();
//         }

//         if ($action == "auth") { // check URL segment
//             try { // process authentication
//                 Hybrid_Endpoint::process();
//             }catch (Exception $e) {

//                 return Redirect::to('social');
//             }
//             return;
//         }

//         try {
//             if (App::environment('local')){
//                 $hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');
//             }elseif (App::environment('staging')) {
//                 $hybridauth = new Hybrid_Auth(app_path() . '/config/staging/hybridauth.php');
//             }else{
//                 $hybridauth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
//             }

//             // create a HybridAuth object
//             $adapter = $hybridauth->authenticate("Google");
//             $user_profile = $adapter->getUserProfile();
//             $adapter->logout();

//              Session::put('user.email', $user_profile->email);

//             return User::validateUserGoogle();
//         }catch(Exception $e) {

//             return $e->getMessage();
//         }

//     }

    Route::controller('stickers', 'StickersController');
