<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

$env = $app->detectEnvironment(array(


	// 'local' => array('Zurg.local','sfe-08641.esmas.net','televisadotcom.esmas.net'),
	// 'staging' => array('dev-idtim','ip-10-191-16-7'),

	'local' => array('Zurg.local','sfe-08641.esmas.net', 'televisadotcom.esmas.net','SFE08752', 'sfe-08752.esmas.net','sfe08676.esmas.net','is-08717.esmas.net', 'pc07.esmas.net', 'sfe-09836.esmas.net', 'sfe-08665.esmas.net', 'SFE08752','maq98.clase7.esmas.com.mx','cha-10638.esmas.net','Zurg-2.local','sfe-12864','Zurg-3.local','sfe-02914','SFE-17115'),	
	'staging' => array('ip-10-0-0-154','dev-idtim','ip-10-252-9-7','ip-10-191-16-7','ip-10-0-0-39'),


));

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$app->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Load The Application
|--------------------------------------------------------------------------
|
| Here we will load this Illuminate application. We will keep this in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

$framework = $app['path.base'].
                 '/vendor/laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
