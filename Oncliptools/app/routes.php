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


/* * **************************************************
 *              Programs Url
 * ************************************************** */

Route::get('programUrl', 'EscaletaController@program_url');

Route::post('storeUrl', 'EscaletaController@storeUrl');

Route::get('resgitroUrls', 'EscaletaController@getUrl');

Route::controller('controller', 'EscaletaController');

Route::get('instant-articles', function() {
    // $aws = AWS::factory(app_path() . '/config/packages/aws/aws-sdk-php-laravel/alternative.php');
        define("AWS_ACCESS_KEY_ID", "AKIAI6VJZZM745SAXBGQ");
        define("AWS_SECRET_ACCESS_KEY", "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");
        $s3 = AWS::get('s3');
        

        $s3->putObject(array(
            'ACL'        => 'public-read-write',
            'Bucket'     => 's3-tim-backend-research',
            'Key'        => "instant/futbol-mexicano",
            'ContentType' => 'text/html',
            'Body'       => 'Hello, world!'

        ));
        return "http://research-static.televisa.com/"."instant/futbol-mexicano";
    

});

Route::post('instant-articles', function() {
    
    if(isset($_POST["channel_key"]) && $_POST["channel_key"]!=""){
        define("AWS_ACCESS_KEY_ID", "AKIAI6VJZZM745SAXBGQ");
        define("AWS_SECRET_ACCESS_KEY", "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");
        $s3 = AWS::get('s3');

        $s3->putObject(array(
            'ACL'        => 'public-read-write',
            'Bucket'     => 's3-tim-backend-research',
            'Key'        => "instant/".$_POST["channel_key"],
            'ContentType' => 'text/html',
            'Body'       => View::make('instant.ad_320_50', array("ad_unit"=>$_POST["ad_unit"]))
        ));
        return "http://research-static.televisa.com/"."instant/".$_POST["channel_key"];
    }
    
    return "Error - notificar a research@televisatim.com";
});

///////////////////////////

/* Home protected with login */
Route::get('/', function() {
    return Redirect::to('welcome');
});

Route::get('welcome', function() {
    if (Sentry::check()) {
        return View::make('vcms.welcome');
    } else {
        return Redirect::to('login');
    }
});


/* * **************************************************
 *              Oncliptools
 * ************************************************** */

/* v1 Uniclip */
Route::controller('v1', 'VcmsController');
Route::get('v2', 'VcmsController@videoLive');
Route::post('v2/detalle', 'VcmsController@cutLive');
Route::post('gol', 'VcmsController@sendGol');

/*Games*/
Route::get('games', 'GamesController@getIndex');
Route::post('newGame', 'GamesController@createGame');
Route::post('goles', 'GamesController@golesGame');
Route::post('deletegol', 'GamesController@deleteGol');

/* Check the status of process id   */
Route::get('exist/{pid}', 'VcmsController@getProccess');

/* Progreso de los videos generados */
Route::get('progress', 'VcmsController@getProgress');

/* Calidades */
Route::get('quality/{vid}', 'VcmsController@showQuality');

/* info videos */
Route::get('videos', 'VcmsController@allVideos');

/* Verifica el progreso del video en curso */
Route::get('checkProgress', 'VcmsController@checkProgress');

/* Api de Brightcove */
Route::get( 'api/1/brightcove/{reference_guid?}', 'VcmsController@pushBrightcove' );
Route::post( 'api/1/brightcove/{reference_guid?}', 'VcmsController@pushBrightcove' );


Route::get('api/2/brightcove/', 'VcmsController@saveBrightcove');
Route::post('api/2/brightcove/', 'VcmsController@saveBrightcove');

/* Permite descarga de Master */
Route::get('download/master/{vid}', 'VcmsController@downloadMaster');

/* Genera el Master de un video ya generado previamente*/
Route::get('generateMaster/{vid}','VcmsController@generateMaster');

/* Genera nuevamente el video*/
Route::get('regenerateVideo/{vid}','VcmsController@regenerateVideo');

/* por el momento ya no se utiliza */
Route::get('make_short/{pid}', function($pid = null) {

    if (Session::has($pid)) {
        $data = Session::get($pid);
        //print_r($data['pid_sh']);
        return View::make('vcms.make_short', array('pid_sh' => $data['pid_sh'],
                    'lipVideoUrl' => $data['lipVideoUrl'],
                    'duration' => $data['duration'],
                    'canal' => $data['canal'],
                    'startDateCal' => $data['startDateCal'],
                    'startTime' => $data['startTime'],
                    'time' => $data['time']));
    }
    return Redirect::to('v1');
});

Route::post('progress', function() {
    $info_process=[];
    $progress = ProgressVideo::where('process_end', '=', 0)->distinct('video_id')->get();
    if(count($progress)>0){
        foreach($progress as $progressVideo){
            $vid = Video::where('id', $progressVideo->video_id)->first();
            if ($vid){
                $infoStep=Steps::where('num_step', '=', $progressVideo->step_current)->get()->first();
                $avance=$infoStep->time_estimated;
                $step=Lang::get('steps.'.$progressVideo->step_current);
                if($avance<=50){
                    $color="danger";
                }elseif($avance<=80){
                    $color="warning";
                }else{
                    $color="default";
                }
                if($avance>=100)
                    $avance=99;
                $title=$vid->title;
                $info = array(
                    'pid' => $vid->id,
                    'video_title' => $title,
                    'step' => $step,
                    'avance' => $avance,
                    'color' => $color
                 );
                $info_process[]=$info;
            }
        }
    }
    return Response::json(array('info_process' => $info_process));
});

/* Obtiene thumbnails del video */
Route::post('timelineThumb', 'VcmsController@timelineThumb');


/* Login configuration */
Route::get('login', 'HomeController@getLogin');
Route::get('logout', 'HomeController@getLogout');
Route::post('login', 'UsersController@login');

/* Language configuration */
Route::get('/locale/{locale}', 'BaseController@setLocale');

/* -----------------------------------------------------------------------------
 *                          Escaleta Feeds
  ---------------------------------------------------------------------------- */

/* ---------------------- GetCounterFeeds ----------------------------------- */
Route::get('escaleta/displayCounterFeeds', 'EscaletaController@getCounterFeeds');

/* ---------------------- GetItemsStart ------------------------------------- */
Route::get('escaleta', 'EscaletaController@getItemsStart');

/* ---------------------- GetItemsProgram ----------------------------------- */
Route::get('escaleta/displayItemsFeeds', 'EscaletaController@getItemsProgram');

/* ---------------------- GetDephasingVideo --------------------------------- */
Route::get('escaleta/displayDephasingVideo', 'EscaletaController@getDephasingVideo');

/* ---------------------- SaveDephasingVideo -------------------------------- */
Route::get('escaleta/saveDephasingVideo', 'EscaletaController@saveDephasingVideo');

/* ---------------------- EditorVideoClips --------------------------------- */
Route::get('escaleta/displayEditorVideo', 'EscaletaController@editorVideoClips');

/* ---------------------- SaveVideoClips --------------------------------- */
Route::get('escaleta/saveVideoClips', 'EscaletaController@saveVideoClips');

/* ---------------------- RestoreVideoClips --------------------------------- */
Route::get('escaleta/restoreVideoClips', 'EscaletaController@restoreVideoClips');



Route::get('escaleta/demo', function() {
    return View::make('escaleta.demo');
});

Route::get('admin/form-modify', function() {
    $selectFood = Food::order_by('name', 'asc')->get();
    $foodNames = array();
    foreach ($selectFood as $food) {
        $foodNames[] .= $food->name;
    }
    return View::make('admin.form-modify')
                    ->with('foods', $selectFood)
                    ->with('foodNames', $foodNames);
});


Route::get('queue', function() {

    $_POST = json_decode('{"_token":"tjGze9VDxQlwMmn1ZjsIwUjPa1d7SqQ1hl1M5phb","tstart":"0","tend":"60","canal":"5","startDateCal":"06\/17\/2014","startTime":"12:00","time":"1","geoblocking":"only_mex","galaxyCheck":"on","nodeGalaxy":"130102","cq5Check":"on","nodeCQ5":"alas3","program":"anecd","Titulo":"pruebaaaa"}', true);


    $signals = Config::get('vcms.signals');
    $fileName = $signals[$_POST["canal"]]["dvrStreamUrl"] . $_POST["startDateCal"] . $_POST["startTime"] . ($_POST["time"] * 60) . strval(time());
    $program = $_POST["program"];
    $path = md5($fileName);
    $Clip = substr($path, 10, 10);
    $lipVideoUrl = "/media/SHORT/" . $program . "/" . $path . "/" . $Clip . "-235-edit.mp4.fixed.mp4";
    $bitRateParam = "-b 300-400 ";
    $FINI = intval(strtotime($_POST["startDateCal"] . ' ' . $_POST["startTime"] . ':00')) - 7200 + Config::get('vcms.time_difference');
    $FFIN = $FINI + (intval($_POST["time"]) * 60);
    $trimStartTimestamp = floatval($_POST['tstart']);
    $trimEndTimestamp = floatval($_POST['tend']) - $trimStartTimestamp;



    $user_info = Session::get('cartalyst_sentry');
    $guid = md5(sha1(uniqid('', true) . microtime(true) . strval(time())));
    $video = new Videos;
    $video->reference_guid = $guid;
    $video->short_name = substr($guid, 10, 10);
    $video->user_id = $user_info[0];
    $video->title = "Titulo de prueba " . microtime(true);
    $video->pid = time();
    $video->save();
    $video_id = $video->id;


    $videoInfo = array("time_start" => "tstart",
        "time_end" => "tend",
        "channel" => "canal",
        "start_date" => "startDateCal",
        "start_time" => "startTime",
        "time" => "time",
        "geoblocking" => "geoblocking",
        "program" => "program",
        "title" => "Titulo");

    if ($_POST["galaxyCheck"] == "on") {
        $video_properties = new VideosProperties;
        $video_properties->video_id = $video_id;
        $video_properties->reference_guid = $guid;
        $video_properties->property_name = "galaxy";
        $video_properties->property_value = "on";
        $video_properties->save();
        $video_properties = new VideosProperties;
        $video_properties->video_id = $video_id;
        $video_properties->reference_guid = $guid;
        $video_properties->property_name = "galaxy_node";
        $video_properties->property_value = $_POST["nodeGalaxy"];
        $video_properties->save();
    }

    if ($_POST["cq5Check"] == "on") {
        $video_properties = new VideosProperties;
        $video_properties->video_id = $video_id;
        $video_properties->reference_guid = $guid;
        $video_properties->property_name = "cq5";
        $video_properties->property_value = "on";
        $video_properties->save();
        $video_properties = new VideosProperties;
        $video_properties->video_id = $video_id;
        $video_properties->reference_guid = $guid;
        $video_properties->property_name = "cq5";
        $video_properties->property_value = $_POST["nodeCQ5"];
        $video_properties->save();
    }


    foreach ($videoInfo as $key => $value) {
        echo $key . "\r\n";
        echo $value . "\r\n";
        $video_properties = new VideosProperties;
        $video_properties->video_id = $video_id;
        $video_properties->reference_guid = $guid;
        $video_properties->property_name = $key;
        $video_properties->property_value = $_POST[$value];
        $video_properties->save();
    }



    Queue::push('Download', array('video_id' => $video_id, 'reference_guid' => $guid));
});







Route::get('demo/ajax', function() {
    $channels = DB::table('feeds')->orderBy("nameFeed", "asc")->lists('nameFeed', 'cl');

    $FeedsProgram = DB::table('FeedsProgram')
                    ->select('img', 'title', 'startDate', 'startTime', 'duration', 'secuency')
                    ->where('programKey', '=', 1311)
                    ->where('startDate', '=', date('Y-m-d'))
                    ->orderBy('secuency', 'asc')->get();
    $extra_time = 0;

    return View::make("escaleta.display_noticieros", array('FeedsProgram' => $FeedsProgram, 'extra_time' => $extra_time));
});



Route::get('social/{action?}', array("as" => "hybridauth", function($action = "") {
if (Session::has('user')) {

    return User::validateUserGoogle();
}

// check URL segment
if ($action == "auth") {
    // process authentication
    try {
        Hybrid_Endpoint::process();
    } catch (Exception $e) {
        return Redirect::to('social');
    }
    return;
}
try {
    if (App::environment('local')) {

        $hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth.php');
    } elseif (App::environment('staging')) {

        $hybridauth = new Hybrid_Auth(app_path() . '/config/staging/hybridauth.php');
    } else {

        $hybridauth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
    }
    // create a HybridAuth object

    $adapter = $hybridauth->authenticate("Google");
    $user_profile = $adapter->getUserProfile();
    $adapter->logout();

    Session::put('user.firstname', $user_profile->firstName);
    Session::put('user.lastname', $user_profile->lastName);
    Session::put('user.gender', $user_profile->gender);
    Session::put('user.email', $user_profile->email);

    return User::validateUserGoogle();
} catch (Exception $e) {
    return $e->getMessage();
}
}));  /* social/{action?} */

Route::controller('roles', 'RolesController');
Route::controller('userPermission', 'UserPermissionController');


Route::get('email', 'VcmsController@getEmail');


Route::get('changepassword/{token}', 'VcmsController@getChangepass');


Route::controller('escaletas', 'EscaletaController');

Route::controller('emailPass', 'EmailController');

Route::get('adminFeeds/{pestana?}', function($pestana = 'adminEscaletaRes') {

    return View::make('escaleta.adminFeeds')->with('pestana', $pestana);
});


/* * **************************************************
 *              Logs Process
 * ************************************************** */

Route::get('logs/{vid}', function($vid=0) {
    
    $vid;
    //$file = 'C:\xampp\htdocs\workspace\laravel\vcms3\app\views\phpLog\a921513487_1421102397.11.log';
    $dir = "/c00nt/vcms/bash/";
    
    $dh = opendir($dir);
    
    $file = readdir($dh);
    
    $videos = DB::table('videos')
                ->select('short_name')
                ->where('id', '=', $vid)->get();

    $short_name = $videos[0]->short_name;
    
    $logsProcess = DB::table('LogsProcess')
                ->select('id','action', 'vod_id', 'unixTimeStart', 'log', 'unixTimeEnd', 'deltaUnixTime')
                ->where('vod_id', '=', $vid)->get();
    
    
    
return View::make('phpLog.logsFile',array('dir'=>$dir,'dir'=>$dir,'file'=>$file,'dh'=>$dh,'short_name'=>$short_name,'LogsProcess'=>$logsProcess,'vid'=>$vid));
    
});

Route::post('logs/process/{vid}', array('uses' => 'LogProcessController@logProcess'));


Route::get('/logsTable/{vod_id}/{UnixTimeId}', function($vod_id=0 , $UnixTimeId=0) {

    $LogsProcess = DB::table('LogsProcess')
            ->select('id','action', 'vod_id', 'unixTimeStart', 'log', 'unixTimeEnd', 'deltaUnixTime','UnixTimeId')
            ->where('vod_id', 'LIKE', "%$vod_id%")
            ->where('UnixTimeId','=', $UnixTimeId)
            ->get();

    return View::make('phpLog.logsData',array('LogsProcess'=>$LogsProcess)); 
});

Route::get('/logShow', function(){
    
    $showLogs = Input::get('idLog');
    
    $LogsProcess = DB::table('LogsProcess')
                    ->select('id','log','vod_id')
                    ->where('id', '=', $showLogs)
                    ->get();
    
    $logShow = $LogsProcess[0]->log;
    $vod_id = $LogsProcess[0]->vod_id;
    
    return View::make('phpLog.logs',array('logShow'=>$logShow,'vod_id'=>$vod_id)); 
    
});

Route::get('/logsTable',  function(){

    return Redirect::back();
    
});

Route::get('videosProperties/{vid}', function($vid=0) {
    
    $videos_properties = DB::table('videos_properties')
                           ->select('id','video_id','reference_guid','property_name','property_value')
                           ->where('video_id','=',$vid)
                           ->get();
    
    
    $videos = DB::table('videos')
                ->select('id','reference_guid','short_name','user_id','pid','title')
                ->where('id', '=', $vid)->get();
    
    $short_name = $videos[0]->short_name;
    $user_id = $videos[0]->user_id;
    $pid = $videos[0]->pid;
    $title = $videos[0]->title;
    
    return View::make('phpLog.videosProperties',array('vid'=>$vid,
                                                      'videos_properties'=>$videos_properties,
                                                      'videos'=>$videos,
                                                      'short_name'=>$short_name,
                                                      'user_id'=>$user_id,
                                                      'pid'=>$pid,
                                                      'title'=>$title));
});

/* Drop Zone */

Route::get('/dropzone', function() {
    return View::make('dropZone.dropzone');
});

Route::post('/folder_fotos', function() {
    
    $name = $_FILES['file']['name'];
    
    $bucket = 'communities-dev';
    //$contentType = 'image/png';
    $contentType = $_FILES['file']['type'];
    $key = "/escaleta/fotos/".basename($name);
    
    $filename = Config::get('dropzone.folder_fotos').basename($name);
    
    $file = File::put($filename, 'contents');
   
    if (file_exists($filename)) {
        
        $s3 = AWS::get('s3');

        $s3->putObject(array(
                    'Bucket'          =>  $bucket,
                    'ContentType'     =>  $contentType,
                    'Key'             =>  $key,
                    'ACL'             =>  'public-read',
                    'SourceFile'      =>  Config::get('dropzone.folder_fotos').basename($name),
                ));
        
        echo "$filename Guardado.";
        
        

        
    } else {
        
        echo "El fichero $filename No se Guardo";
        
    }


    
});

Route::get('/listObjects', function() {
    
    $bucket = 'communities-dev';
    $dir = '/escaleta/fotos/';
    //$client = AWS::get('S3Client');
    $client = S3Client::factory();
    
    $iterator = $client->getIterator('ListObjects',array(
        'Bucket'    => $bucket,
        'Prefix'    => $dir,
        'MaxKeys' => 1, 
    ));

    foreach ($iterator as $object) {
        echo $object['Key'] . "\n";
    }

});

/* bitly */

Route::get('/bitly', function() {
    
    return View::make('bitly.bitly_url');
    
});

Route::post('bitly/shorturl', 'bitlyController@getbitlyshorturl');

Route::get('alertEmailEscaleta',function(){


    function Email($msg,$nameFeed,$emails){

        $datos = array(
                'subject' => "Reporte de Json ".$nameFeed,
                'msg' => $msg,
            );

        Mail::send('emails.notification', $datos, function($message) use ($emails)
            {
                $message->to($emails)->subject('Oncliptools');
            });
    }


    $feeds = DB::table('feeds AS f')
        ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
        ->get();

        date_default_timezone_set("Mexico/General");
        $nameDayNow = date('l');
        $dateNow = date('Y-m-d');
        $time = date('H:i');

        foreach ($feeds as $key) {

            $curl =         curl_init(trim($key->urlFeed));
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
                                    curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
                                    curl_setopt($curl, CURLOPT_ENCODING , "");
                    $json =         json_decode(curl_exec($curl));
                    $curl_errno =   curl_errno($curl);
                    $curl_error =   curl_error($curl);
                                    curl_close($curl);
                        
            try {
           
                if($json->programa == false){

                    $nameFeed = $key->nameFeed;
                    $nameDays = $key->nameDays;
                    $dateInitiation = $key->dateInitiation;
                    $dateEnd = $key->dateEnd;
                    $nextUpdate = $key->nextUpdate;
                    $endTime = $key->endTime;
                    $initiationTime = $key->initiationTime;

                    if( (strtotime($dateNow) <= strtotime($dateEnd)) && (strtotime($dateInitiation) <= strtotime($dateEnd)) ){
                        if(in_array($nameDayNow, preg_split("/,/", $nameDays)) && (strtotime($dateNow) == strtotime(date('Y-m-d',strtotime($nextUpdate))))){
                            if((strtotime($initiationTime) <= strtotime($time)) && (strtotime($endTime) > strtotime($time))){

                                $UrlFeed =$key->urlFeed;

                                $dateTimeSecond = new DateTime(date("Y-m-d")." ".$initiationTime);
                                $dateTimeSecond->modify('+30 minutes');
                                $min20 = date_format($dateTimeSecond,"H:i");

                                if($time == $min20){

                                    $msg = 'Json de feeds vacio '.$UrlFeed;
                                    $emails = array("juan.dominguez@televisatim.com","gabriel.mancera@televisatim.com ");

                                    Email($msg,$nameFeed,$emails);
                                }
                            }
                        }
                    }
            }      
        
        } catch (Exception $e) {
            echo "no es objeto";
        }
    }
});




Route::get('JsonFeedsEscaleta2',function(){
      
    $feeds = DB::table('feeds AS f')
        ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
        ->get();


    $nameDayNow = date('l');
    $dateNow = date('Y-m-d');
    $time = date('H:i');

/*function dia programado*/
    function programDay($daysR,$nameDays,$id,$initiationTime,$time,$endTime){

            $days = preg_split("/,/", $nameDays);                        

            $dayNum = date("N");
            $nameDayNow = date('l');
            $dayProgram = [];

            if(in_array($nameDayNow, $days) && ( (strtotime($endTime) > strtotime($time)))){

                $feed = FeedProgrammed::find($id);
                $feed->nextUpdate = date('Y-m-d')." ".$initiationTime;
                $feed->save();

            }else{

                 foreach ($days as $key => $value) {

                    for ($j=$dayNum; $j < 7 ; $j++) {

                        $value == $daysR[$j] ? $dayProgram[$j] = $value : false;

                    }
                }

                $dayProgram ? $nextDayProg = array_shift($dayProgram) : $nextDayProg = array_shift($days);
                                                                        
                $nextDateProgramNew = date('Y-m-d',strtotime("next ".$nextDayProg));

                $feed = FeedProgrammed::find($id);
                $feed->nextUpdate = $nextDateProgramNew." ".$initiationTime;
                $feed->save();

            }   
    }
/************************/

            foreach ($feeds as $key) {

                    $curl =         curl_init(trim($key->urlFeed));
                    //$curl =         curl_init("file:///C:/Users/EDigitales_TI/Documents/pruebaimg");
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
                                    curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
                                    curl_setopt($curl, CURLOPT_ENCODING , "");
                    $json =         json_decode(curl_exec($curl));
                    $curl_errno =   curl_errno($curl);
                    $curl_error =   curl_error($curl);
                                    curl_close($curl);

                                
                    $hourOminute = ($key->hourOminute == 'Min') ? 'minutes' : 'hours';
                    $timeConsultation = $key->timeConsultation;

                    $id = $key->id_feed;
                    $nameFeed = $key->nameFeed;
                    $nameDays = $key->nameDays;
                    $dateInitiation = $key->dateInitiation;
                    $lastUpdate = $key->lastUpdate;
                    $timeConsultation = $key->timeConsultation;
                    $dateEnd = $key->dateEnd;
                    $nextUpdate = $key->nextUpdate;
                    $endTime = $key->endTime;
                    $days = preg_split("/,/", $nameDays);
                    $timeUpdate = date('H:i',strtotime($time));
                    $nextDay = array_shift($days);
                    $nextDateProgram = date('Y-m-d',strtotime("next ".$nextDay));
                    $initiationTime = $key->initiationTime;
                    $daysR = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');


                        if($json){

                            if($lastUpdate == '0000-00-00 00:00:00'){
                                    
                                    $feed = FeedProgrammed::find($id);
                                    $feed->nextUpdate =  $dateInitiation." ".$key->initiationTime;
                                    $feed->save();
                            }


                            if( (strtotime($dateNow) <= strtotime($dateEnd)) && (strtotime($dateInitiation) <= strtotime($dateEnd)) ){

                                        if(in_array($nameDayNow, preg_split("/,/", $nameDays)) && (strtotime($dateNow) == strtotime(date('Y-m-d',strtotime($nextUpdate))))){


                                             //compara si en tiempo final no ha pasado y si el tiempo de inicio es igual al tiempo actual para crear el feed
                                                if((strtotime($initiationTime) <= strtotime($time)) && (strtotime($endTime) > strtotime($time))){

                                                                $urlFeed = $key->urlFeed;
                                                                $scheme = parse_url($urlFeed, PHP_URL_SCHEME);
                                                                $query = parse_url($urlFeed, PHP_URL_QUERY);
                                                                $path = parse_url($urlFeed, PHP_URL_PATH);
                                                                $host = parse_url($urlFeed, PHP_URL_HOST); 

                                                                $vars = array();

                                                                parse_str($query, $vars);


                                                                $queryNew = "date=".date('Y-m-d')."&cl=".$vars['cl']."&key=".$vars['key']."&t=".$vars['t'];

                                                                $urlFeedNew = $scheme."://".$host.$path."?".$queryNew;  

                                                                $hourOminute = ($key->hourOminute == 'Min') ? 'minutes' : 'hours';
                                                                $proxAct = date("H:i:s", strtotime('+'.$timeConsultation.' '.$hourOminute, strtotime($timeUpdate)));

                                                                $jsonImg = [];
                                                                $jsonExtras = [];
                                                                $dataJsonPlayer = [];

                                                                $feedsprogram = DB::table('FeedsProgram')->lists('secuency');


                                                                if(count($json->programa) > 1){
                                                                    
                                                                    $idUpdate = DB::table('FeedsProgram')
                                                                                    ->where('programKey',$vars['cl'])
                                                                                    ->where('updated','!=',0)
                                                                                    ->lists('updated');

                                                                    for ($i=0; $i < count($json->programa); $i++) {

                                                                        $secuency = $json->programa[$i]->sec;

                                                                                //if (!in_array($secuency, $feedsprogram)) {
                                                                                $existSecuency = DB::table('FeedsProgram')->where('secuency',$secuency)->where('programKey',$key->cl)->count();

                                                                                    if($existSecuency == 0){

                                                                                        try{

                                                                                            (trim($json->programa[$i]->titulo) == 'Comerciales') ? $status = 0 :$status = 1;  
                                                                                        
                                                                                            $feedProgram = new FeedsProgram;
                                                                                            $feedProgram->programKey    =  $vars['cl'];
                                                                                            $feedProgram->secuency      =  $json->programa[$i]->sec;
                                                                                            $feedProgram->title         =  $json->programa[$i]->titulo;
                                                                                            $feedProgram->startDate     =  $json->programa[$i]->fecha;
                                                                                            $feedProgram->startTime     =  $json->programa[$i]->inicia;
                                                                                            $feedProgram->duration      =  $json->programa[$i]->duracion;
                                                                                            $feedProgram->status        =  $status;
                                                                                            $feedProgram->updated       =  $json->programa[$i]->updated;
                                                                                            $feedProgram->save(); 

                                                                                        }catch(Exception $e){}

                                                                                    }
                                                                                //}/* if in array*/   
                                                                    }

                                                                    for ($i=0; $i < count($json->programa); $i++) {

                                                                        foreach ($json->programa[$i] as $key => $value) {

                                                                            if (preg_match("/thumb/i", $key)) 
                                                                            {
                                                                                $jsonImg[$json->programa[$i]->sec][$key] = $json->programa[$i]->thumb;
                                                                                        
                                                                            }else{

                                                                                if($key!='sec' && $key!='titulo' && $key!='fecha' &&  $key!='inicia' &&  $key!='duracion'){

                                                                                    $jsonExtras[$json->programa[$i]->sec][$key] = $json->programa[$i]->$key;
                                                                                            
                                                                                }
                                                                            }
                                                                        }

                                                                              
                                                                        if($json->programa[$i]->updated){

                                                                            if(!in_array($json->programa[$i]->updated, $idUpdate)){

                                                                                (trim($json->programa[$i]->titulo) == 'Comerciales') ? $status = 0 : $status = 1; 

                                                                                $arrayParams = array($json->programa[$i]->titulo,$json->programa[$i]->fecha,$json->programa[$i]->inicia,$json->programa[$i]->duracion,$status,$json->programa[$i]->updated,$json->programa[$i]->sec);
                                                                                
                                                                                DB::update('UPDATE FeedsProgram set title = ?,startDate = ?,startTime = ?,duration = ?, status = ?, updated = ? where secuency = ?', $arrayParams);   
                                                                            }       
                                                                        }
                                                                    }/*end for*/
                                                                }/* if count*/

                                                                foreach ($jsonExtras as $keySecuency => $valueJson) {

                                                                    DB::table('FeedsProgram')
                                                                          ->where('secuency', $keySecuency)
                                                                            ->update(array('extra' => json_encode($valueJson)));
                                                                }

                                                                foreach ($jsonImg as $keySecuency => $valueJson) {

                                                                    DB::table('FeedsProgram')
                                                                          ->where('secuency', $keySecuency)
                                                                            ->update(array('img' => json_encode($valueJson)));
                                                                }


                                                                $feedUpd = Feeds::find($id);
                                                                $feedUpd->urlFeed = $urlFeedNew;
                                                                $feedUpd->save();

                                                            
                                                                $feed = FeedProgrammed::find($id);
                                                                $feed->lastUpdate =  date('Y-m-d H:i:s',strtotime($timeUpdate));
                                                                $feed->nextUpdate = date('Y-m-d')." ".$proxAct;
                                                                $feed->save();

                                                                /*Crear jsonp de table*/
                                                                
                                                                $feedTableJsonp = DB::select("SELECT CONCAT(fp.id,'_',fp.secuency)as id,fp.title,fp.img,fp.startDate,fp.startTime,fp.duration,CONCAT('content_hour_',DATE_FORMAT(fp.startTime,'%h'))as contentTime,DATE_FORMAT(startTime,'%h:00')as timeRange from feeds f inner join FeedsProgram fp on f.cl = fp.programKey where fp.status!=0 and f.cl=".$vars['cl']." and fp.startDate = '".date('Y-m-d')."' order by fp.startTime");       

                                                                foreach ($feedTableJsonp as $key => $value) {

                                                                    $id_feed = $value->id;
                                                                    $title = $value->title;
                                                                    $imgExt = (array) json_decode($value->img);
                                                                    $img = reset($imgExt);
                                                                    $stream = 1;
                                                                    $extra_time = 0;
                                                                    $startDate = $value->startDate;
                                                                    $startTime = $value->startTime;
                                                                    $inicio = (intval(strtotime(substr($startDate,0, 4)."-".substr($startDate, 5, 2)."-".substr($startDate, -2).' '.$startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time;
                                                                    $tmp = explode(":",$value->duration);
                                                                    $duracion = (intval($tmp[0]*60)+intval($tmp[1]));
                                                                    $content_time = $value->contentTime;
                                                                    $range_time = $value->timeRange;

                                                                    if(strlen($title)>=75){
                                                                        $sizeTitle = 75;
                                                                        $titleMod = substr($title, 0,$sizeTitle);
                                                                        $index = strrpos($titleMod, " ");
                                                                        $titleMod = substr($titleMod, 0,$index); $titleMod.=" ...";
                                                                    }else{
                                                                        $titleMod = $title;
                                                                    }

                                                                    $dataJsonPlayer['json'][$key]['id'] = $id_feed;
                                                                    $dataJsonPlayer['json'][$key]['title'] = $title;
                                                                    $dataJsonPlayer['json'][$key]['titleMod'] = $titleMod;
                                                                    $dataJsonPlayer['json'][$key]['img'] = $img;
                                                                    $dataJsonPlayer['json'][$key]['stream'] = $stream;
                                                                    $dataJsonPlayer['json'][$key]['inicio'] = $inicio;
                                                                    $dataJsonPlayer['json'][$key]['startTime'] = $startTime;
                                                                    $dataJsonPlayer['json'][$key]['duracion'] = $duracion;
                                                                    $dataJsonPlayer['json'][$key]['content_time'] = $content_time;
                                                                    $dataJsonPlayer['json'][$key]['range_time'] = $range_time;
                                                                }   

                                                                $jsonp = json_encode($dataJsonPlayer); 
                                                                $jsonp = 'escaleta.customDataSuccess(' . $jsonp . ');';

                                                                $file = storage_path()."/".$vars['cl']."_".date('Ymd').".js";

                                                                
                                                                File::put($file,$jsonp);
                                                            
                                                                $s3 = AWS::get('s3');

                                                                $s3->putObject(array(
                                                                    'ACL'        => 'public-read',
                                                                    'Bucket'     => 'communities-dev',
                                                                    'Key'        => "/escaleta/json/".$vars['cl']."_".date('Ymd').".js",
                                                                    'SourceFile' => $file
                                                                ));

                                                                echo "/escaleta/json/".$vars['cl']."_".date('Ymd').".js"."<br>";

                                                                if (File::exists($file)) { File::delete($file); } 
                                                }else{

                                                    programDay($daysR,$nameDays,$id,$initiationTime,$time,$endTime);

                                                }

                                        }else{

                                            programDay($daysR,$nameDays,$id,$initiationTime,$time,$endTime);

                                        }
                            }else{
                                    if(count($days) <= 0){

                                        if($id){
                                            $feed = FeedProgrammed::find($id);
                                            $feed->dateInitiation =  $nextDateProgram;
                                            $feed->save();
                                        }

                                    }else{
                                    
                                        $days = preg_split("/,/", $nameDays);
                                        
                                          $dayProgram='';

                                           if(in_array($nameDayNow,$days)){
                                                    $dayProgram = date('Y-m-d',strtotime($nameDayNow));
                                            }else{

                                                foreach ($days as $key => $value) {

                                                    $dayNum = date("N");

                                                     for ($j=$dayNum; $j < 7 ; $j++) {
                                                         
                                                         if($value == $daysR[$j]){

                                                               $dayProgram = date('Y-m-d',strtotime("next ".$value));

                                                         }

                                                     }
                                                }
                                            }

                                        $feed = FeedProgrammed::find($id);
                                        $feed->nextUpdate = $dayProgram." ".$initiationTime;
                                        $feed->save();

                                    }     
                            }

                        }               
            }

    //echo date('H:i')."<br>";
    return "terminado";

});



