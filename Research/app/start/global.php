<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

//Log::useFiles(storage_path().'/logs/laravel.log');
$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);



/*
|--------------------------------------------------------------------------
| Locale 
|--------------------------------------------------------------------------
|
|
*/
App::error(function(InvalidArgumentException $exception, $code)
{
	
	if ($exception->getMessage()=="Cannot redirect to an empty URL."){
		Log::debug($exception);
		return  Redirect::to('/');
	}
});


/*
|--------------------------------------------------------------------------
| Error 404 
|--------------------------------------------------------------------------
|
|
*/
// App::missing(function($exception)
// {
//     //return  var_dump($exception->getCode());
//     return View::make(Config::get( 'app.main_template' ).'.error.error',array("code"=>404));
// });
/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{

    if (App::environment('local')){
    	switch ($code){
	        case 403:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>403), 403);
	        case 401:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>401), 401);
	        case 409:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>409), 409);
	        case 406:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>406), 406);
	        case 404:
	        	Log::info("404 - ".Request::url());
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>404), 404);
	        case 502:
	        	Log::info("502 - ".Request::url());
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>502), 502);
	        //case 500:
	        //    return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>500), 500);
	        //default:
	        //    return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>0), $code);
	    }

    }else{
	 
	    switch ($code){
	        case 403:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>403), 403);
	        case 401:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>401), 401);
	        case 409:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>409), 409);
	        case 406:
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>406), 406);
	        case 404:
	        	Log::info("404 - ".Request::url());
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>404), 404);
	        case 500:
	        	Log::error($exception);
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>500), 500);
	        case 502:
	        	Log::info("502 - ".Request::url());
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>502), 502);
	        default:
	        	Log::error($exception);
	            return Response::view(Config::get( 'app.main_template' ).'.error.error', array("code"=>0), $code);
	    }

    } /* endif */
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

require app_path().'/lib/fpdf17/fpdf.php';
