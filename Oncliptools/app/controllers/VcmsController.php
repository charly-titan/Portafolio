<?php
use Carbon\Carbon;

class VcmsController extends BaseController {

    public function __construct(){
        $this->beforeFilter('csrf', ['on' => 'post','except' => array('sendToVideoNotification','timelineThumb','pushBrightcove','sendGol','saveBrightcove')]);
        $this->beforeFilter('hasAccess:video.create',['except'=>array('checkProgress','pushBrightcove','saveBrightcove')]);
        $this -> configureLocale();             
    }

    private function readSignals(){
        return DB::select("SELECT name,short_name,concat(concat(url_signal,'?b=',quality_range),'$$',concat(url_signal_hds,'?b=',quality_range))as url_signal from signals group by short_name");
    }

    private function getArraySignals(){
        $signal = $this->readSignals();
        $arraySignal = array();
            foreach ($signal as $key) {
                $data = new stdClass();
                $data->name = $key->name;
                $data->short_name = $key->short_name;
                $data->url_signal = $key->url_signal;
                $arraySignal[] = $data;
            }
        return $arraySignal;
    }

    public function getIndex(){         
        if (Sentry::check()){
            $signals = $this->getArraySignals();
            return View::make('vcms.preview')->with('signals',$signals);
        }else{
            return  Redirect::to('login');
        }
    }

    public function videoLive(){         
        if (Sentry::check()){
            $games =array();
            $signals = $this->getArraySignals();
            $partidos= Partidos::all()->take(30);
            if (count($partidos)>0) {
                foreach($partidos as $partido){
                    $local = Equipos::where('id', '=', $partido->equipo_local)->get()->first();
                    $visitante = Equipos::where('id', '=', $partido->equipo_visitante)->get()->first();
                    $info = array(
                            'game'      => $partido,
                            'local'     => $local,
                            'visitante' => $visitante
                     );
                    $games[]=$info;
                }
            }
            return View::make('vcms.videoLive')->with('signals',$signals)->with('games',$games);
        }else{
            return  Redirect::to('login');
        }
    }

    public function cutLive(){
        if (Sentry::check()){
            //echo "<!-- ".print_r($_POST)."-->";
            if(isset($_POST["canal"])&&($_POST["canal"]!="")&&isset($_POST["start"])&&($_POST["start"]!="")&&isset($_POST["end"])&&($_POST["end"]!="")){
                $signal = Signals::where('short_name', '=', $_POST["canal"])->get()->first();
                $time=$_POST["end"]-$_POST["start"];
                $fecha = date("Y/m/d H:i:s",$_POST["start"]);
                $cad=explode(" ",$fecha);
                //echo "<!-- ".$fecha."-->";
                if ($signal && $time>0){
                    $info = array(
                            'signal'        => $signal->url_signal."?b=150-970",
                            'channel'       => $signal->short_name,
                            'start'         => $_POST["start"],
                            'end'           => $_POST["end"],
                            'time'          => $time,
                            'startDateCal'  => $cad[0],
                            'startTime'     => $cad[1],
                            'src'           => $signal->url_signal."?b=150-970&start=".$_POST["start"]."&end=".$_POST["end"]
                    );
                    sleep(10);
                    return View::make('vcms.previewLive')->with('info',$info);
                }
            }
            return App::abort(404);
        }else{
            return  Redirect::to('login');
        }

    }

    public function sendGol(){
        //print_r($_POST);
        switch ($_POST["canal"]) {
            case "2":
                $canal=1;
                break;
            case "ForoTV": 
                $canal=2;
                break;
            case "5": 
                $canal=3;
                break;
            case "9": 
                $canal=4;
                break;
            default: 
                $canal=1;
        }
        
        $url = "http://54.183.187.23:8080/videoPlayer.php";
        $array=array('param1'   =>  $canal,
                'param2'        =>  $_POST["time"],
                'param3'        =>  '60',
                'image'         =>  'http://lorempixel.com/120/90/people',
                'text'          =>  'Gol',
                'accion'        =>  'insert',
                'id'            =>  $_POST["time"],
                'idGalaxy'       => '',
                'type'          =>  'DVR' );
        
        $fields_string ='';
        foreach($array as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'& ');

        $ch = curl_init(); //open connection
        curl_setopt($ch,CURLOPT_URL, $url); //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_POST, count($array));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);//execute post
        curl_close($ch); //close connection
        $partido = Partidos::where('id', '=', $_POST["partido"])->get()->first();
        if ($_POST["equipo"]=="local") {
            $equipo = $partido->equipo_local;
        } else {
            $equipo = $partido->equipo_visitante;
        }
        
        $gol= new Goles();
        $gol->id_partido=$_POST["partido"];
        $gol->id_equipo=$equipo;
        $gol->parametros=json_encode($array);;
        $gol->save();

        return $fields_string;

    }

    public function getLog(){
        if (Sentry::check()){
            $this->checkStatus();
        }else{
            return  Redirect::to('/');
        }
    }

    public function getProgress(){
        if (Sentry::check()){
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
            return View::make('vcms.progress_video')->with('info_process', $info_process);
        }else{
            return  Redirect::to('login');
        }
    }

    public function checkProgress(){
        $notifications = Notifications::where('mail', '=', 0)->where('msg', '=', 0)->get();
        echo $notifications;
        if($notifications){
            foreach ($notifications as $notifica)
            {
                $video = Video::where('id', '=', $notifica->video_id)->get()->first();
                $user  = User::where('id', '=', $video->user_id)->get()->first();
                /*Se envian notificaciones*/
                if (App::environment('local')){
                        //No envia notificaciones debido a que son solo pruebas
                }else if ($video && $user){
                    $url="http://".$_SERVER['HTTP_HOST']."/quality/".$video->id;
                    $msg="Su video: ". $video->title." ha sido creado con exito <br> ver en: ".$url;
                    $datos = array(
                            'subject' => "Video Generado",
                            'msg' => $msg
                    );
                    Mail::send('emails.notification', $datos, function($message) use ($user)
                    {
                        $message->to($user->email)->subject('Oncliptools');
                    });
                    
                    $file = app_path()."/storage/logs/sms_telegram.log";
                    $fh   = fopen($file, 'a');
                    try {
                        $contacto = trim(Crypt::decrypt($user->first_name)." ".Crypt::decrypt($user->last_name));
                    } catch (Exception $e) {
                        $contacto = trim($user->first_name." ".$user->last_name);    
                    }
                    $contacto = str_replace(" ", "_", $contacto);
                    $linea    = array(
                                'video_id' => $video->id,
                                'contacto' => $contacto,
                                'msg'=>$msg
                    );
                    fwrite($fh,json_encode($linea)."\n");
                    fclose($fh);
                    $notifica->mail= 1;
                    $notifica->msg = 1;
                    $notifica->save();       
                }
            }
        }   
    }

    public function showQuality($vid=0){
        $video = Video::where('id', $vid)->first();
        if($video){
            $path = $video->reference_guid;
            $Clip = $video->short_name;
            $pid_sh = $video->pid;
            $video_properties = VideosProperties::where('video_id', '=', $vid)
                              ->where('property_name', 'program')->get();
            $program = ($video_properties && count($video_properties)>0)?$video_properties[0]->property_value:"";
            $video_properties = VideosProperties::where('video_id', '=', $vid)
                              ->where('property_name', 'master')->get();
            $master = ($video_properties && count($video_properties)>0)?$video_properties[0]->property_value:"";
            $video_properties = VideosProperties::where('video_id', '=', $vid)
                              ->where('property_name', 'onlyMaster')->get();
            $onlyMaster = ($video_properties && count($video_properties)>0)?$video_properties[0]->property_value:"";
            
            return View::make('vcms.precisson',array('vid'=>$vid,'pid_sh'=>$pid_sh, 'program' => $program, 'path' => $path, 'Clip' => $Clip, 'master'=>$master, 'onlyMaster'=>$onlyMaster));
        }
    }


    public function downloadMaster($vid=0){
        $video = Video::where('id', $vid)->first();
        if($video){
            $path=$video->reference_guid;
            $Clip=$video->short_name;
            $video_properties=VideosProperties::where('video_id', '=', $vid)->where('property_name', 'program')->get();
            $program=($video_properties && count($video_properties)>0)?$video_properties[0]->property_value:"";
            $pathToFile="/c00nt/vcms/master/".$program."/".$path."/".$Clip."-0.mp4";
            if (file_exists($pathToFile)){
                $headers = array(
                    'Content-Type' => 'application/download',
                );
                return Response::download($pathToFile,$Clip."-0.mp4",$headers);    
            }
            else
                return "No se puede descargar el archivo";
        }
    }

    public function generateMaster($vid=0){
        $video = Video::where('id', $vid)->first();
        if($video){
            /*Insertamos propiedad al video */
            $path=$video->reference_guid;
            $this->saveProperty($vid,$path,"generateMaster","on");
            /*Actualizamos */
            $progressVideo = ProgressVideo::where('id', $video->pid)->first();
            $progressVideo->step_current = 0;
            $progressVideo->host = '';
            $progressVideo->process_start = time();
            $progressVideo->process_end = 0;
            $progressVideo->save();

            return  Redirect::to('/progress');
        }
    }

    public function regenerateVideo($vid=0){
        $video = Video::where('id', $vid)->first();
        if($video){
            /*Eliminar la propiedad si ya se mando a generar master, "por si las dudas" genere todas las calidades*/
            $delete_property=VideosProperties::where('video_id', '=', $vid)->where('property_name', 'generateMaster')->delete();
            if ($delete_property)
                $delete_property=VideosProperties::where('video_id', '=', $vid)->where('property_name', 'master')->delete();
            /*Actualizamos */
            $progressVideo = ProgressVideo::where('id', $video->pid)->first();
            $progressVideo->step_current = 0;
            $progressVideo->host = '';
            $progressVideo->process_start = time();
            $progressVideo->process_end = 0;
            $progressVideo->save();

            return  Redirect::to('/progress');
        }
    }

    public function allVideos(){
        $videos = DB::table('progress_video')
            ->join('videos', function($join)
            {
                $join->on('progress_video.video_id', '=', 'videos.id')
                     ->where('progress_video.process_end', '<>', 0);
            })
            ->distinct('progress_video.video_id')
            ->select('videos.id', 'videos.title', 'videos.user_id')
            ->orderBy('videos.id', 'desc')
            ->take(100)
            ->get();
            //print_r($videos);
        if(count($videos)>0){
            foreach($videos as $video){
                $start_date="";
                $start_time="";
                $canal="";
                $vid=$video->id;
                $title= $video->title;
                $video_properties = DB::table('videos_properties')->where('video_id', '=', $vid)
                ->whereIn('property_name', array('channel','start_date','start_time'))
                ->select('property_value')
                ->get();
                $canal=($video_properties && count($video_properties)>0)?$video_properties[0]->property_value:"";
                $start_date=($video_properties && count($video_properties)>1)?$video_properties[1]->property_value:"";
                $start_time=($video_properties && count($video_properties)>2)?$video_properties[2]->property_value:"";
                $usuario = User::where('id', $video->user_id)->first();
                
                try {
                    $user_name=Crypt::decrypt($usuario->first_name)." ".Crypt::decrypt($usuario->last_name);
                } catch (Exception $e) {
                    $user_name=$usuario?$usuario->first_name." ".$usuario->last_name:"";
                }
                
                $info = array(
                        'id' => $vid,
                        'user_name' =>$user_name,
                        'title' => $title,
                        'channel' => $canal,
                        'start_date' => $start_date,
                        'start_time' => $start_time
                 );
                $info_video[]=$info;
            }
            $entries=count($videos);
            $pages=round($entries/10);

            $paginacion=array(
                    'page' => 1,
                    'per_page' => 10,
                    'total_entries' => $entries,
                    'total_pages' => $pages
            );
            
            return Response::json(array($paginacion,$info_video));
        }

    }
    /************************************************************************/
    /****************VERIFICAR SI ESTA FUNCION ESTA EN USO*******************/
    public function getProccess($pid=""){
        $validator = Validator::make(
            array('pid' => $pid ),
            array('pid' => 'digits_between:1,8589934588')
        );
        if ($validator) { /* check if pid is digit */
            if (Sentry::check()){ /* if user is logged then check for the pid */
                if (App::environment('local')){ /* if env is local we add some wait time to simulate production env  */
                      $result = ((intval($pid) + Config::get('vcms.waiting')) < time() )?1:0;
                }else{
                    exec(" ps aux | grep ".$pid." | grep .py | grep -v grep", $output, $result);
                }
                echo "/* ".time()." */";

                /*Consultamos la información del proceso en la BD*/
                $avance=0;
                $proceso = Process::where('process_id', $pid)->first();
                if(($result == 0)&&($proceso)){
                    $actual=time();
                    $star= $proceso->start_time;
                    $system=$proceso->system_time;
                    $total=$system-$star;
                    $total=$total==0?1:$total;
                    $avance=round((($actual-$star)*100)/$total);
                    if($avance>=100)
                        $avance=99;                    
                    
                }elseif($proceso){
                    $proceso->end_time = time();
                    $proceso->save();
                }
                /***********************************************/
                return  ($result == 0)? " check_pid($avance)":" start_video()";
               
            } /* Sentry */
        }
        return "";
    }
    /************************************************************************/
    /************************************************************************/

    public function postPrecission(){
        $input = Input::all();
        if(isset($_POST["cuts"])&&($_POST["cuts"]!="")){
                $cuts=json_decode($_POST["cuts"]);
                $cortes=array();
                foreach ($cuts as $cut) {
                    if (array_key_exists('title', $cut)) {
                        /*Manda a generar el video independiente*/
                        $param = $input;
                        $param['Titulo'] = $cut->title;
                        $param['tstart'] = $cut->time_start;
                        $param['tend']   = $cut->time_end;
                        $param['cuts']   = "";
                        $this->generateVideo($param);
                    }else{
                        $cortes[]= $cut;
                    }
                }
                if (count($cortes)>1){
                    $param = $input;
                    $param['cuts'] = json_encode($cortes);
                    $this->generateVideo($param);
                }elseif(count($cortes)==1){
                    /*Manda a generar el video independiente*/
                    $param = $input;
                    $param['tstart'] = $cortes[0]->time_start;
                    $param['tend']   = $cortes[0]->time_end;
                    $param['cuts']   = "";
                    $this->generateVideo($param);
                }
        }else{
            $this->generateVideo($input);
        }
        /*Borra imagenes temporales del video
        if(isset($_POST["carThumb"])&&($_POST["carThumb"]!="")){
            $carpeta="/media/".$_POST["carThumb"];
            if (file_exists($carpeta)) {
                foreach (glob($carpeta) as $filename){
                    unlink($filename);
                }
                rmdir($carpeta);
            } 
        }*/
        return  Redirect::to('/progress');
        
    }

    protected function generateVideo($inputs){

        $signals = Config::get('vcms.signals');
        $fileName= $signals[$inputs["canal"]]["dvrStreamUrl"]. $inputs["startDateCal"] . $inputs["startTime"] . ($inputs["time"] * 60) . strval( time() ) . md5( sha1 (uniqid('', true).microtime(true). strval( time() ) ) );
        $program=$inputs["program"];
        $path = md5(  $fileName );
        $Clip = substr( $path , 10, 10 );
        $lipVideoUrl = "/media/SHORT/" . $program . "/" . $path . "/" . $Clip . "-235-edit.mp4.fixed.mp4";
        $bitRateParam = "-b 300-400 ";    
        /*echo "<!-- ".json_encode($inputs)."-->";*/
        if (strlen($inputs["startTime"])==5){
            $FINI=intval(strtotime($inputs["startDateCal"].' '.$inputs["startTime"].":00"))-7200+Config::get('vcms.time_difference');
        }else{
            $FINI=intval(strtotime($inputs["startDateCal"].' '.$inputs["startTime"]))-7200+Config::get('vcms.time_difference');    
        }
        $FFIN=$FINI+(intval($inputs["time"])*60);

        if(isset($inputs["FINI"])&&($inputs["FINI"]!="")&&isset($inputs["FFIN"])&&($inputs["FFIN"]!="")){
            $FINI=intval($inputs["FINI"]);
            $FFIN=intval($inputs["FFIN"]);
        }
        
        $trimStartTimestamp = floatval($_REQUEST['tstart']);
        $trimEndTimestamp = floatval($_REQUEST['tend']) - $trimStartTimestamp;

        /*Guardamos la información del Video en la BD*/

        $user_info = Session::get('cartalyst_sentry');

        $video                  =   new Videos;
        $video->reference_guid  =   $path;
        $video->short_name      =   $Clip;
        $video->user_id         =   $user_info[0];
        $video->title           =   $inputs["Titulo"];
        $video->pid             =   "";
        $video->save();
        $video_id = $video->id;


        $videoInfo = array( "time_start"    =>  "tstart",
                            "time_end"      =>  "tend",
                            "channel"       =>  "canal",
                            "start_date"    =>  "startDateCal",
                            "start_time"    =>  "startTime",
                            "time"          =>  "time",
                            "geoblocking"   =>  "geoblocking",
                            "program"       =>  "program",
                            "title"         =>  "Titulo");

        if(isset($inputs["galaxyCheck"])){
            if($inputs["galaxyCheck"]=="on"){
                $this->saveProperty($video_id,$path,"galaxy","on");
                $this->saveProperty($video_id,$path,"galaxy_node",$inputs["nodeGalaxy"]);
            }
        }

        if(isset($inputs["cq5Check"])){
            if($inputs["cq5Check"]=="on"){
                $this->saveProperty($video_id,$path,"cq5","on");
                $this->saveProperty($video_id,$path,"cq5_node",$inputs["nodeCQ5"]);
            }
        }

        if(isset($inputs["cq5deportesCheck"])){
            if($inputs["cq5deportesCheck"]=="on"){
                $this->saveProperty($video_id,$path,"cq5deportes","on");
                $this->saveProperty($video_id,$path,"cq5deportes_node",$inputs["nodeCQ5deportes"]);
            }
        }

        if(isset($inputs["addMaster"])){
            if($inputs["addMaster"]=="on"){
                $this->saveProperty($video_id,$path,"master","on");
            }
        }
        
        if(isset($inputs["onlyMaster"])){
            if($inputs["onlyMaster"]=="on"){
                $this->saveProperty($video_id,$path,"onlyMaster","on");
            }
        }

        foreach ($videoInfo as $key => $value) {
            $this->saveProperty($video_id,$path,$key,$inputs[$value]);
        }

        if($FINI&&$FFIN){
            $this->saveProperty($video_id,$path,"trimStartTimestamp",$FINI);
            $this->saveProperty($video_id,$path,"trimEndTimestamp",$FFIN);
        }

        if(isset($inputs["cuts"])&&($inputs["cuts"]!="")){
                $this->saveProperty($video_id,$path,"cuts","on");
                $this->saveProperty($video_id,$path,"cuts_values",$inputs["cuts"]);
        }

        Queue::push('Download', array('video_id'=>$video_id, 'reference_guid'=>$path));

        
        $progressVideo = new ProgressVideo();
        $progressVideo->video_id = $video_id;
        $progressVideo->step_current = 0;
        $progressVideo->host = '';
        $progressVideo->process_start = time();
        $progressVideo->save();

        /*Actualizamos */
        $video->pid=$progressVideo->id;
        $video->save();
    }

    
    public function timelineThumb(){

        if (strlen($_POST["startTime"])==5){
            $FINI=intval(strtotime($_POST["startDateCal"].' '.$_POST["startTime"].":00"))-7200+Config::get('vcms.time_difference');
        }else{
            $FINI=intval(strtotime($_POST["startDateCal"].' '.$_POST["startTime"]))-7200+Config::get('vcms.time_difference');
        }
        $FFIN=$FINI+(intval($_POST["time"])*60)-1;
        
        if(isset($_POST["FINI"])&&($_POST["FINI"]!="")&&isset($_POST["FFIN"])&&($_POST["FFIN"]!="")){
            $FINI=intval($_POST["FINI"]);
            $FFIN=intval($_POST["FFIN"])-1;
        }
       
        $signals = Signals::where('short_name', '=', $_POST["canal"])->get();
        $ids_signals="";
        foreach ($signals as $signal) { $ids_signals .= $signal->id.","; }
        $ids_signals=rtrim($ids_signals,',');
       
        if (App::environment('local')){
            $result=DB::select("SELECT time_created,thumb_urls FROM images WHERE signal_id IN (".$ids_signals.") AND time_created BETWEEN 1425422580 AND 1425422700 ORDER BY time_created");
        }else{
            $result=DB::select("SELECT time_created,thumb_urls FROM images WHERE signal_id IN (".$ids_signals.") AND time_created BETWEEN ".strval($FINI)." AND ".strval($FFIN)." ORDER BY time_created");
        }
        
        $imgs=array();
        $thumb=array();
        foreach ($result as $urls) {
            $imgsTime=json_decode($urls->thumb_urls);
            if (count($imgsTime)>0){
                sort($imgsTime);
                foreach ($imgsTime as $imgThumb) {
                    $thumb  =   array(
                            'name' =>$imgThumb->name,
                            'url'  =>$imgThumb->url
                    );
                    $imgs[]=$thumb;
                }
            }else{
                for ($i=1; $i <8 ; $i++) { 
                    $thumb  =   array(
                            'name' =>$urls->time_created.'_00'.$i.'.png',//1425564060_001.png
                            'url'  =>'http://mxm-v2.s3.amazonaws.com/oncliptools/noImages.png'
                    );
                    $imgs[]=$thumb;
                }
            }
        }   
        return Response::json(array('thumbnails'=>$imgs));    
    }
	
	protected function readValues(){
		$elements=array();
		foreach($_REQUEST as $fieldName => $fieldValue){
			if($fieldName != "action" && $fieldName != "referenceId"){
				array_push($elements, array(	"fieldValue"	=>	"'".$fieldValue."'"
											   ,"fieldName"		=>	"'".$fieldName."'"
				));
			}
		}	
		return $elements;
	}
    
    public function saveBrightcove(){


        $elements=$this->readValues();
                $data=file_get_contents("php://input");
                $data=$data."\r\n".json_encode($elements)."\r\n\r\n\r\n";
                $fichero = '/tmp/brigthcove.txt';
                file_put_contents($fichero, $data, FILE_APPEND);

echo date('h:i:s') . "\n";
    if($_REQUEST["entity"]!="VIDEO"){
        exit();
    }
    //sleep(10);

    echo date('h:i:s') . "\n";
    $brightcove_id=$_REQUEST["id"];
    $url = "http://api.brightcove.com/services/library?command=find_video_by_id&video_id=".$brightcove_id."&token=Wyts7AraMt8vDWBrEoqqI0b8DY1AGKzGek66aPdaLAnYQ2oPVxQMWA..&custom_fields=geofilter";



    $options[CURLOPT_URL] = $url;
    $options[CURLOPT_PORT] = 80;
    $options[CURLOPT_FRESH_CONNECT] = true;
    $options[CURLOPT_FOLLOWLOCATION] = false;
    $options[CURLOPT_FAILONERROR] = true;
    $options[CURLOPT_RETURNTRANSFER] = true; // curl_exec will not return true if you use this, it will instead return the request body
    $options[CURLOPT_TIMEOUT] = 10;

    // Preset $response var to false and output
    $fb = "";
    $response = false;// don't quote booleans
    // echo '<p class="response1">'.$response.'</p>';

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    // If curl request returns a value, I set it to the var here. 
    // If the file isn't found (server offline), the try/catch fails and var should stay as false.
    $fb = curl_exec($curl);
    curl_close($curl);

    if($fb !== false) {
        // echo '<p class="response2">'.$fb.'</p>';
        $response = $fb;
    }
    
    if ($response==NULL){
        exit("Error");
    }

    if($response!== false){
        $json_info = json_decode($response,true);
        $deportes=false;
        $fast_goal=false;
        // var_dump($json_info);
        // exit();
        $fichero = '/tmp/brigthcove.txt';
        file_put_contents($fichero, $response, FILE_APPEND);
        foreach ($json_info["tags"] as $tag) {
            
             if ($tag=="deportes"){
                $deportes=true;
             }
             if ($tag=="banamex"){
                $fast_goal=true;
             }
        }


        if($deportes){
            $title      =$json_info["name"];
            $thumb      =$json_info["thumbnailURL"];
            $duration   =$json_info["length"];
            $mmedia     =$json_info["referenceId"];
            if(!isset($json_info["customFields"]["geofilter"])){
                $geo_filter = "ONLY_MEX";
            }else{
                $geo_filter = $json_info["customFields"]["geofilter"];
            }

            $video_150="";
            $video_235="";
            $video_480="";
            $video_600="";
            $video_970="";

            foreach ($json_info["renditions"] as $video) {
                print_r($video);
                switch ($video["encodingRate"]) {
                    case 235000:
                       $video_235=$video["remoteUrl"];
                        break;
                    case 480000:
                        $video_480=$video["remoteUrl"];
                        break;
                    case 599000:
                        $video_600=$video["remoteUrl"];
                        break;
                    case 970000:
                        $video_970=$video["remoteUrl"];
                        break;
                    case 150000:
                        $video_150=$video["remoteUrl"];
                        break;
                }

            }





            $fields_string ="";
            //set POST variables
            $url = 'http://galaxy.esmas.com/AJAX/api_bright.php';
            // $fields = array(
            //                      'node' => urlencode('13630202'),
            //                      'url' => urlencode($video_600),
            //                      'title' => urlencode($title),
            //                      'thumb' => urlencode($thumb),
            //                      'geo_filter' => urlencode($geo_filter),
            //                      'mmedia' => urlencode($mmedia),
            //                      'site' => urlencode('CHA'),
            //                      'duration' => urlencode($duration),
            //                      'origin' => urlencode('14')
            //              );
            $fields=array('modification_datetime'   =>  date("Y-m-d H:i:s"),
                        'referenceId'   =>  md5($mmedia).':13630203',
                        'id'            =>  $brightcove_id, /* brightcove 3693320744001 */
                        'entity'        =>  "VIDEO",
                        'action'        =>  "CREATE",
                        'from_syndicaster' => '1',
                        'status'        =>  "SUCCESS");
            
            if($fast_goal){
                $fields["fast_goal"] = "banamex";
            }
            
            //url-ify the data for the POST
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            $fields_string= rtrim($fields_string, '&');

            // echo $fields_string;
            


            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            //execute post
            $result = curl_exec($ch);


            // var_dump($result);
            //close connection
            curl_close($ch);

            
        }
                //set POST variables
        // $url = 'http://galaxy.esmas.com/AJAX/api_video.php';
        // $fields = array(
        //                      'node' => urlencode('13630202'),
        //                      'url' => urlencode($video_600),
        //                      'title' => urlencode($title),
        //                      'thumb' => urlencode($thumb),
        //                      'geo_filter' => urlencode($geo_filter),
        //                      'mmedia' => urlencode($mmedia),
        //                      'site' => urlencode('CHA'),
        //                      'duration' => urlencode($duration),
        //                      'origin' => urlencode('14'),
        //              );

        // //url-ify the data for the POST
        // foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        // rtrim($fields_string, '&');

        // //open connection
        // $ch = curl_init();

        // //set the url, number of POST vars, POST data
        // curl_setopt($ch,CURLOPT_URL, $url);
        // curl_setopt($ch,CURLOPT_POST, count($fields));
        // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        // //execute post
        // $result = curl_exec($ch);

        // //close connection
        // curl_close($ch);



    }

    }


    public function pushBrightcove($reference_guid=""){
        $validator = Validator::make(
            array('reference_guid' => $reference_guid),
            array('reference_guid' => array('required', 'size:32', 'alpha_num'))
        );
        echo $reference_guid;
        if ($validator->fails()){ return "Error: The reference_guid is not valid"; }
        
        $video = $this->getVideoInfo($reference_guid);
      

        if ($this->brightcoveExist($reference_guid)==0){
            $video = $this->getVideoInfo($reference_guid,"");
            //$_POST["id"]=3641698709001;
            if(isset($_POST["id"])&&isset($_POST["referenceId"])){
                if(strstr($_POST["referenceId"], $reference_guid)){
                    $this->saveProperty($video->id,$video->reference_guid,"brightcove",$_POST["id"]);
                    $video->params = array_add($video->params,"brightcove",$_POST["id"]);
                    if(isset($video->params["cq5"]) && $video->params["cq5"]=="on"){
                        $this->sendToVideoNotification($video);
                    }
                    if (isset($video->params["cq5deportes"]) && $video->params["cq5deportes"]=="on") {
                        $this->sendToCQ5Deportes($video,"insert");
                        $this->sendToCQ5Deportes($video,"update");
                    }
                }
            }
         }
         return "OK";
    }

    protected function sendToVideoNotification($video){
        $url = Config::get( 'vcms.video_notification_url' );
        $array=array('referenceId'   =>  $video->reference_guid,
                'domain'        =>  'm4vhds.tvolucion.com',
                'duration'      =>  '7780',
                'gbr'           =>  $video->params["geoblocking"], /* GEOFILTER NOT_USA */
                'id'            =>  $video->params["brightcove"], /* brightcove 3693320744001 */
                'name'          =>  "oncliptools-".$video->title, /* name lolit-c_23072014_noticieroconlolitaayala_noticierocompleto */
                'node'          =>  $video->params["cq5_node"], /* nodo de cq5 programas-noticiero-con-lolita-ayala */
                'path'          =>  Config::get( 'vcms.video_prefix' ) . $video->params["program"] . "/" . $video->reference_guid . "/" . $video->short_name  , /* path /m4v/not/lolit/fa181c4a032363c5cc16f9c3f549e9a8/2363c5cc16 */
                'program'       =>  $video->params["program"], /* program lolit */
                'server'        =>  'oncliptool',
                'type'          =>  'full-episode' );
        
        $fields_string ='';
        foreach($array as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'& ');

        $ch = curl_init(); //open connection
        curl_setopt($ch,CURLOPT_URL, $url); //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_POST, count($array));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);//execute post
        curl_close($ch); //close connection
        return 1;
    }

    protected function sendToCQ5Deportes($video, $opt=""){
        if ($opt=="insert"){
            $url = "http://galaxy.esmas.com/AJAX/api_bright.php";
            $array=array('modification_datetime'   =>  date("Y-m-d H:i:s"),
                    'referenceId'   =>  $video->reference_guid.':'.$video->params["cq5deportes_node"],
                    'id'            =>  $video->params["brightcove"], /* brightcove 3693320744001 */
                    'entity'        =>  "VIDEO",
                    'action'        =>  "CREATE",
                    'status'        =>  "SUCCESS");
            
            $fields_string ='';
            foreach($array as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string,'& ');

            $ch = curl_init(); //open connection
            curl_setopt($ch,CURLOPT_URL, $url); //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_POST, count($array));
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);//execute post
            curl_close($ch); //close connection
            
        }
        elseif($opt=="update"){
            //self.galaxy_config["GALAXYEXTRAS"]+"?mmedia="+"-"+video["title"]+"&profile=m3u8&url_stream="+self.galaxy_config["AKAMAI_m3u8"]+video["directory"] + "/" + video["fileName"] + "-,150,235,480,600,970,.mp4.csmil/master.m3u8&format=m3u8&geo_filter="+video["geoblocking"]+"&site=CHA"
            $url = "http://galaxy.esmas.com/AJAX/api_video_extras.php?mmedia=".$video->reference_guid."&profile=m3u8&url_stream=http://m4vhds.tvolucion.com/i/m4v/tst/".$video->params['program']."/".$video->reference_guid."/".$video->short_name."-,150,235,480,600,970,.mp4.csmil/master.m3u8&format=m3u8&site=CHA";
            Log::info('GM URL_m3u8: '.$url);
            $ch = curl_init(); 
            curl_setopt($ch,CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            Log::info('GM result: '.$result);
            curl_close($ch); 
            $url_hds = str_replace("profile=m3u8","profile=hds",$url);
            $url_hds = str_replace("master.m3u8&format=m3u8","manifest.f4m&format=f4m",$url_hds);
            $url_hds = str_replace("/i/m4v","/z/m4v",$url_hds);
            $ch = curl_init(); 
            curl_setopt($ch,CURLOPT_URL, $url_hds); 
            Log::info('GM URL_hds: '.$url_hds);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            Log::info('GM result: '.$result);
            curl_close($ch); 
            
        }
        return 1;
    }



    protected function brightcoveExist($reference_guid){
        $video_data = DB::table('videos_properties')
                     ->select('property_value')
                     ->where('reference_guid','=',$reference_guid)
                     ->where('property_name','=',"brightcove")
                     ->count();
        if($video_data==0){
            return 0;
        }else{
            return 1;
        }
    }

    protected function saveProperty($video_id,$reference_guid,$property_name,$property_value){
        $video_properties                   =   new VideosProperties;
        $video_properties->video_id         =   $video_id;
        $video_properties->reference_guid   =   $reference_guid;      
        $video_properties->property_name    =   $property_name;
        $video_properties->property_value   =   $property_value;
        $video_properties->save();
    }

    protected function videoExist($reference_guid="",$video_id=""){
        if($reference_guid!=""){
            $video = DB::table('videos')
                ->select('id','reference_guid', 'short_name','title','created_at')
                ->where('reference_guid','=',$reference_guid)
                ->count();    
        }
        if($video_id!=""){
            $video = DB::table('videos')
                ->select('id','reference_guid', 'short_name','title','created_at')
                ->where('video_id','=',$video_id)
                ->count();    
        }
        if($video==0){
            return 0;
        }else{
            return 1;
        }
    }

    protected function getVideoInfo($reference_guid="",$video_id=""){
        if($this->videoExist($reference_guid,$video_id)){
            if($reference_guid!=""){
                $video = DB::table('videos')
                        ->select('id','reference_guid', 'short_name','title','created_at')
                        ->where('reference_guid','=',$reference_guid)
                        ->get();    
            }
            if($video_id!=""){
                $video = DB::table('videos')
                        ->select('id','reference_guid', 'short_name','title','created_at')
                        ->where('video_id','=',$video_id)
                        ->get();    
            }
            $video_data = DB::table('videos_properties')
                         ->select('property_name', 'property_value')
                         ->where('video_id','=',$video[0]->id)
                         ->get();
            $video_info = $video[0];
            $video_info->params = array();
            foreach ($video_data as $video_param) {            
                 $video_info->params = array_add($video_info->params,$video_param->property_name,$video_param->property_value);
            }
            return $video_info;
        }else{
            return array();
        }
    }

    protected function checkStatus(){
        echo app_path() . "/tests/alas3-prueba001_short.log";
        $handle = fopen(app_path() . "/tests/alas3-prueba001_short.log", "r");
        $info =array();
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                if (preg_match("/\[\[.*\]\]/", $line)) {
                    $process_info=$this->cleanLog($line);
                    if($process_info["action_type"]=="S" && !isset($info[$process_info["action_name"]])){
                        $info[$process_info["action_name"]]["start_time"]=$process_info["action_time"];
                        $info[$process_info["action_name"]]["log"]="";
                        $writing_log=$process_info["action_name"];
                    }
                    if($process_info["action_type"]=="E"){
                        $info[$process_info["action_name"]]["end_time"]=$process_info["action_time"];   
                    }
                }else{
                    if(trim($line)!=""){
                        $info["PROCESANDO VOD"]["log"].=$line;
                        if(isset($writing_log) && $writing_log!=""){
                            $info[$writing_log]["log"].=$line;
                        }
                    }
                }
            }
        } else {
            // error opening the file.
        } 
        fclose($handle);
        print_r($info);
    }


    protected function runInBackground($command,$log="/tmp/gabo.log",$priority=0){
        if (App::environment('local')){
            $PID=shell_exec("$command > $log 2>&1 & echo $!");
        }else{
            if($priority)
               $PID=shell_exec("nohup nice -n $priority $command > $log 2>&1 & echo $!");
            else
               $PID=shell_exec("nohup $command > $log 2>&1 & echo $!");
            $PID = trim(preg_replace('/\s\s+/', ' ', $PID));
        }
        
        return($PID);
    }

    protected function cleanLog($line){
        $line=str_replace("[", "", $line);
        $line=str_replace("[", "", $line);
        $line=trim($line);
        $process_info=explode(":",$line);
        if(count($process_info)==3){
            return array("action_type"=>$process_info[0],"action_time"=>$process_info[2],"action_name"=>$process_info[1]);    
        }else{
            return array("action_type"=>$process_info[0],"action_time"=>$process_info[1],"action_name"=>"Tiempo total");
        }
    }

    private function configureLocale()
    {
        // Set default locale.
        $mLocale = Config::get( 'app.locale' );

        // Has a session locale already been set?
        if ( !Session::has( 'locale' ) )
        {
            // No, a session locale hasn't been set.
            // Was there a cookie set from a previous visit?
            $mFromCookie = Cookie::get( 'locale', null );
            if ( $mFromCookie != null && in_array( $mFromCookie, Config::get( 'app.locales' ) ) )
            {
                // Cookie was previously set and it's a supported locale.
                $mLocale = $mFromCookie;
            }
            else
            {
                // No cookie was set.
                // Attempt to get local from current URI.
                $mFromURI = Request::segment( 1 );
                if ( $mFromURI != null && in_array( $mFromURI, Config::get( 'app.locales' ) ) )
                {
                    // supported locale
                    $mLocale = $mFromURI;
                }
                else
                {
                    // attempt to detect locale from browser.
                    $mFromBrowser = substr( Request::server( 'http_accept_language' ), 0, 2 );
                    if ( $mFromBrowser != null && in_array( $mFromBrowser, Config::get( 'app.locales' ) ) )
                    {
                        // browser lang is supported, use it.
                        $mLocale = $mFromBrowser;
                    } // $mFromBrowser
                } // $mFromURI
            } // $mFromCookie

            Session::put( 'locale', $mLocale );
            Cookie::forever( 'locale', $mLocale );
        } // Session?
        else
        {
            // session locale is available, use it.
            $mLocale = Session::get( 'locale' );
        } // Session?

        // set application locale for current session.
        App::setLocale( $mLocale );

    }

}