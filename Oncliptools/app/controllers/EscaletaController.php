<?php

class EscaletaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function program_url() {
        $tipos = Feeds::all()->lists('nameFeed', 'id_feed');
        $combobox = array(0 => "Seleccione ... ") + $tipos;
        $selected = array();
        $exito = 'hola';

        return View::make("escaleta.programsUrls", compact('combobox', 'selected', 'hrs', 'tiphr', 'minust', 'exito'));
    }

    public function storeUrl() {
        $rules = array(
            'opciones' => 'required',
            'url' => 'required',
            'status' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        );
        $messages = array(
            'required' => 'Requerido',
        );

        $validation = Validator::make(Input::all(), $rules, $messages);

        if ($validation->fails()) {
            return Redirect::to('programUrl')->withErrors($validation)->withInput();
        } else {
            $programUrl = new ProgramUrl();
            $programUrl->id = Input::get('opciones');
            if ($programUrl->id == 0) {
                return Redirect::back()->with('alert_info', '' . '<i class="fa  fa fa-ban" >' . '</i> Choose a program')->withInput();
            }
            $url = $programUrl->url = Input::get('url');

//            $findme = 'www.';
//            $pos = strpos($url, $findme);
//
//            if ($pos !== false) {
//                $programUrl->url = $url;
//            } else {
//                $subcadena = "/";
//                $posicionsubcadena = strpos($url, $subcadena);
//                $rule = substr($url, ($posicionsubcadena + 2));
//                $rule;
//                $urldominio = $findme . $rule;
//                $y = $programUrl->url = $urldominio;
//            }
            $programUrl->Monday = Input::has('Monday') ? true : false;
            $programUrl->Tuesday = Input::has('Tuesday') ? true : false;
            $programUrl->Wednesday = Input::has('Wednesday') ? true : false;
            $programUrl->Thursday = Input::has('Thursday') ? true : false;
            $programUrl->Friday = Input::has('Friday') ? true : false;
            $programUrl->Saturday = Input::has('Saturday') ? true : false;
            $programUrl->Sunday = Input::has('Sunday') ? true : false;
            if ($programUrl->Monday == false &&
                    $programUrl->Tuesday == false &&
                    $programUrl->Wednesday == false &&
                    $programUrl->Thursday == false &&
                    $programUrl->Friday == false &&
                    $programUrl->Saturday == false &&
                    $programUrl->Sunday == false) {
                return Redirect::back()->with('alert_info', '' . '<i class="fa  fa fa-ban" >' . '</i> Select a day of the week')->withInput();
                ;
            }
            $x = $programUrl->inactive_date = Input::get('inactive_date');
            $dateTime = new DateTime($x);
            $converto = $dateTime->format('U');
            $programUrl->inactive_date = $converto;
            $programUrl->startTime = Input::get('startTime');
            $programUrl->endTime = Input::get('endTime');
            $programUrl->status = Input::has('status') ? true : false;
            $programUrl->Save();
//            
//            return Redirect::back()->with('registration_success', '<i class="fa  fa-check-circle" >' . '</i> Its operation has been completed successfully');

            return Redirect::to('resgitroUrls')->with('registration_success', '<i class="fa  fa-check-circle" >' . '</i> Its operation has been completed successfully');
        }
    }

    public function getUrl() {

        $queryResult = DB::table('feeds')
                ->join('programs_url', 'feeds.id_feed', '=', 'programs_url.id')
                ->select('feeds.nameFeed', 'programs_url.id', 'programs_url.startTime', 'programs_url.endTime', 'programs_url.url', 'programs_url.status', 'programs_url.statusAdvertising', 'programs_url.Monday', 'programs_url.Tuesday', 'programs_url.Wednesday', 'programs_url.Thursday', 'programs_url.Friday', 'programs_url.Saturday', 'programs_url.Sunday', 'programs_url.id_url')
                ->get();
        $exito = '<h4 style=" color: #8fbfe0;"><i class="fa  fa-check-circle" style="margin-left: 36%;"></i> Lista de Resultados </h4>';
        if ($queryResult > 0) {

            return View::make("escaleta.programsRegis", compact('queryResult', 'exito'));
        }
    }

    public function getEditprofilejvs() {

        date_default_timezone_set("Mexico/General");
        $horActual = time();

        $queryResult =DB::select("SELECT GROUP_CONCAT(Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday SEPARATOR '@@') as daysActive,GROUP_CONCAT(id_feed SEPARATOR '@@') as id_feed, GROUP_CONCAT(cl SEPARATOR '@@') as cl, GROUP_CONCAT(nameFeed SEPARATOR '@@')as nameFeed, GROUP_CONCAT(channel SEPARATOR '@@') as channel, GROUP_CONCAT(startTime SEPARATOR '@@')as startTime, GROUP_CONCAT(endTime SEPARATOR '@@')as endTime,GROUP_CONCAT(status SEPARATOR '@@') as status, GROUP_CONCAT(statusAdvertising SEPARATOR '@@') as statusAdvertising,`programs_url`.`url` from `feeds` inner join `programs_url` on `feeds`.`id_feed` = `programs_url`.`id`  where programs_url.status!=false and `programs_url`.". date('l')." =1 GROUP BY url");

        $data_json = '';
        $data = [];

        foreach ($queryResult as $resp) {

            $idfeeds    = $resp->id_feed;
            $channels   = $resp->channel;
            $url        = $resp->url;
            $cls        = $resp->cl;
            $startTimes = $resp->startTime;
            $endTimes   = $resp->endTime;
            $status     = $resp->status;
            $statusAdvertising = $resp->statusAdvertising;

            $idFeed     = explode("@@", $idfeeds);
            $channel    = explode("@@", $channels);
            $cl         = explode("@@", $cls);
            $startTime  = explode("@@", $startTimes);
            $endTime    = explode("@@", $endTimes);
            $statusDisplay = explode("@@", $status);
            $advertisingStatus = explode("@@", $statusAdvertising);

            if(count($idFeed) > 1){

                for ($i=0; $i < count($idFeed); $i++) { 
                    
                    $horaInicio = date_create($startTime[$i]);
                    $horaFin = date_create($endTime[$i]);
                    $starhours = date_format($horaInicio, 'U');
                    $endHours = date_format($horaFin, 'U');


                    if (($horActual >= $starhours) && ($horActual <= $endHours)) {

                        $dataActive[] = array(
                            "idProgram"     => $cl[$i],
                            "url"           => $url,
                            "statusPlayer"  => "Live show",
                            "serverDate"    => date("Ymd"),
                            "idChannel"     => $channel[$i],
                            "statusUrl"     => 'urlActive',
                            "statusDisplay" => $statusDisplay[$i],
                            "statusAdvertising" => $advertisingStatus[$i]
                        );

                    }else{

                        $dataInactive[] = array(
                            "idProgram"     => '',
                            "url"           => $url,
                            "statusPlayer"  => '',
                            "serverDate"    => '',
                            "idChannel"     => '',
                            "statusUrl"     => 'urlInactive',
                        );
                    }  
                } 

            }else{

                $horaInicio = date_create($startTimes);
                $horaFin = date_create($endTimes);
                $starhours = date_format($horaInicio, 'U');
                $endHours = date_format($horaFin, 'U');

                if (($horActual < $starhours) && ($horActual < $endHours)) {

                    $transmission = "Program not transmitted";

                    (date('N') == 1) ? $dateServer = date("Ymd",strtotime('-3 day')) :  $dateServer = date("Ymd",strtotime('-1 day'));
                }

                if (($horActual > $endHours)) {

                    $hours = date("H", strtotime("00:00") + $horActual - $endHours);
                    $minuts = date("i", strtotime("00:00") + $horActual - $endHours);

                    if ($hours <= 01 && $minuts <= 60) {
                        $transmission = "please wait";
                        //'Lead time...' . $hours . ':' . $minuts;
                        $dateServer = date("Ymd");
                    } else {

                        if (($horActual > $starhours) && ($horActual > $endHours)) {
                            $transmission = "Finished program";
                            $dateServer = date("Ymd");
                        }
                    }
                }

                if (($horActual >= $starhours) && ($horActual <= $endHours)) {

                    $transmission = "Live show";
                    $dateServer = date("Ymd");
                }


               isset($transmission)?$transmission:$transmission='';
               isset($dateServer)?$dateServer:$dateServer='';

                $data[] = array(
                    "idProgram" => $cls,
                    "url" => $url,
                    "statusPlayer" => $transmission,
                    "serverDate" => $dateServer,
                    "idChannel" => $resp->channel,
                    "statusUrl" =>  'urlDisplay',
                    "statusDisplay" => $status,
                    "statusAdvertising" => $statusAdvertising
                );
            }
        }

        isset($dataActive)?$dataActive:$dataActive ='';
        isset($dataInactive)?$dataInactive:$dataInactive ='';

        if($dataInactive){

            $inactive = array_map("unserialize", array_unique(array_map("serialize", $dataInactive)));
            
            $urlActive = array();

            if($dataActive){
                foreach ($dataActive as $key => $value) {
                    array_push($urlActive, $value['url']);
                }

                for ($i=0; $i <count($dataActive) ; $i++) {
                    $key = array_search($dataActive[$i]['url'], array_column($inactive, 'url'));
                    array_splice($inactive, $key, 1);
                }
            }else{
                $dataActive =[];
            }

            try {
                $data = array_merge($dataActive,$inactive,$data);  
            } catch (Exception $e) {
                echo "error";
            } 
        }

        for ($i = 0; $i < count($data); $i++) {
            $data_json.= "escaleta.customDataJson(" . json_encode($data[$i]) . ");";
        }

        $file = storage_path()."/status.js";

        File::put($file,$data_json);
                                                            
        $s3 = AWS::get('s3');

        $s3->putObject(array(
            'ACL'        => 'public-read-write',
            'Bucket'     => 'communities-dev',
            'Key'        => "/escaleta/js/status.js",
            'SourceFile' => $file
        ));

        echo "ruta /escaleta/js/status.js ".date('Ymd')."<br>";

        if (File::exists($file)) { File::delete($file); } 

    }


    public function getEditprofile($id_url) {

        $data = array();
        $tipos = Feeds::all()->lists('nameFeed', 'id_feed');
        $combobox = array(0 => "Seleccione ... ") + $tipos;
        $selected = array();
        $queryResult = DB::table('programs_url')
                ->join('feeds', 'feeds.id_feed', '=', 'programs_url.id')
                ->select('feeds.nameFeed')
                ->get();
        $programUrl = ProgramUrl::find($id_url);
        $epoch = $programUrl->inactive_date;
        $dt = new DateTime("@$epoch");
        $inactive_date = $dt->format('Y/m/d ');

        $epocha = $programUrl->active_date;
        $dta = new DateTime("@$epocha");
        $active_date = $dta->format('Y/m/d ');

        $idProgram = $programUrl->id;
        $channels = DB::table('channels')
                ->where('id', '=', $idProgram)
                ->first();
        $nameProgram = $channels->programa;
        return View::make("escaleta.updateUrls", compact('programUrl', 'combobox', 'selected', 'nameProgram','active_date', 'inactive_date', 'id_url'));
    }

    public function postEditprofile($id_url) {

        $inputs = Input::all();

        $rules = array(
            'url' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        );

        $validate = Validator::make($inputs, $rules);

        if ($validate->fails()) {

            return Redirect::back()->withInput()->withErrors($validate);
        }

        $dayCurrent = date('Y-m-d');
        $dateTimeCurrent = new DateTime($dayCurrent);
        $dateCurrent = $dateTimeCurrent->format('U');


        $inactiveDate = Input::get('inactive_date');
        $dateTimeInactive = new DateTime($inactiveDate);
        $dateInactive = $dateTimeInactive->format('U');


        $activeDate =  Input::get('active_date');
        $dateTimeActive = new DateTime($activeDate);
        $dateActive = $dateTimeActive->format('U');

        ($dateCurrent <= $dateInactive && $dateActive <=$dateInactive)? $status= true : $status=false;

        $statusAdvertising = Input::has('statusAdvertising') ? true : false;

        $programUrl = ProgramUrl::find($id_url);
        $temporal1 = $programUrl->id = Input::get('id');
        $temporal2 = $programUrl->id = Input::get('prueba');
        
        if (($temporal1 == 0) && ($temporal2 > 0)) {
            $programUrl->id = $temporal2;
            $url = $programUrl->url = Input::get('url');
//            $findme = 'www.';
//
//            $pos = strpos($url, $findme);
//            if ($pos !== false) {
//                $programUrl->url = $url;
//            } else {
//
//                $subcadena = "/";
//                $posicionsubcadena = strpos($url, $subcadena);
//                $rule = substr($url, ($posicionsubcadena + 2));
//                $rule;
//                $urldominio = $findme . $rule;
//                $programUrl->url = $urldominio;
//            }

            $programUrl->Monday = Input::has('Monday') ? true : false;
            $programUrl->Tuesday = Input::has('Tuesday') ? true : false;
            $programUrl->Wednesday = Input::has('Wednesday') ? true : false;
            $programUrl->Thursday = Input::has('Thursday') ? true : false;
            $programUrl->Friday = Input::has('Friday') ? true : false;
            $programUrl->Saturday = Input::has('Saturday') ? true : false;
            $programUrl->Sunday = Input::has('Sunday') ? true : false;
            if ($programUrl->Monday == false &&
                    $programUrl->Tuesday == false &&
                    $programUrl->Wednesday == false &&
                    $programUrl->Thursday == false &&
                    $programUrl->Friday == false &&
                    $programUrl->Saturday == false &&
                    $programUrl->Sunday == false) {
                return Redirect::back()->with('alert_info', '' . '<i class="fa  fa fa-ban" >' . '</i> Select a day of the week');
            }

            $programUrl->inactive_date = $dateInactive;
            $programUrl->active_date = $dateActive;
            $programUrl->startTime = Input::get('startTime');
            $programUrl->endTime = Input::get('endTime');
            $programUrl->status = $status;
            $programUrl->statusAdvertising = $statusAdvertising;
            $programUrl->Save();
            return Redirect::back()->with('registration_success', '<i class="fa  fa-check-circle" >' . '</i> Its operation has been completed successfully');
        }

        if ($temporal1 == 0) {
            return Redirect::back()->withInput();
        }

        $programUrl->id = $temporal1;
        $url = $programUrl->url = Input::get('url');
//          $findme = 'www.';
//          $pos = strpos($url, $findme);
//            if ($pos !== false) {
//                $programUrl->url = $url;
//            } else {
//
//                $subcadena = "/";
//                $posicionsubcadena = strpos($url, $subcadena);
//                $rule = substr($url, ($posicionsubcadena + 2));
//                $rule;
//                $urldominio = $findme . $rule;
//                $programUrl->url = $urldominio;
//            }
        $programUrl->Monday = Input::has('Monday') ? true : false;
        $programUrl->Tuesday = Input::has('Tuesday') ? true : false;
        $programUrl->Wednesday = Input::has('Wednesday') ? true : false;
        $programUrl->Thursday = Input::has('Thursday') ? true : false;
        $programUrl->Friday = Input::has('Friday') ? true : false;
        $programUrl->Saturday = Input::has('Saturday') ? true : false;
        $programUrl->Sunday = Input::has('Sunday') ? true : false;
        
        if ($programUrl->Monday == false &&
                $programUrl->Tuesday == false &&
                $programUrl->Wednesday == false &&
                $programUrl->Thursday == false &&
                $programUrl->Friday == false &&
                $programUrl->Saturday == false &&
                $programUrl->Sunday == false) {
            return Redirect::back()->with('alert_info', '<i class="fa  fa fa-ban" >' . '</i> Select a day of the week');
        }
        
        $programUrl->inactive_date = $dateInactive;
        $programUrl->active_date = $dateActive;
        $programUrl->startTime = Input::get('startTime');
        $programUrl->endTime = Input::get('endTime');
        $programUrl->status = $status;
        $programUrl->statusAdvertising = $statusAdvertising;
        $programUrl->Save();

        return Redirect::back()->with('registration_success', '<i class="fa  fa-check-circle" >' . '</i> Its operation has been completed successfully');
    }

    public function getIndex() {


        $feeds = DB::table('feeds AS f')
                ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                ->get();


        $feed = [];
        $i = 0;
        foreach ($feeds as $key) {

            $urlFeed = $key->urlFeed;

            $scheme = parse_url($urlFeed, PHP_URL_SCHEME);
            $query = parse_url($urlFeed, PHP_URL_QUERY);
            $path = parse_url($urlFeed, PHP_URL_PATH);
            $host = parse_url($urlFeed, PHP_URL_HOST);

            $vars = array();
            parse_str($query, $vars);

            $queryNew = "date=" . date('Y-m-d') . "&cl=" . $vars['cl'] . "&key=" . $vars['key'] . "&t=" . $vars['t'];

            $urlFeedNew = $scheme . "://" . $host . $path . "?" . $queryNew;

            $feedUpd = Feeds::find($key->id_feed);
            $feedUpd->urlFeed = $urlFeedNew;
            $feedUpd->save();




            $curl = curl_init(trim($key->urlFeed));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            $json = json_decode(curl_exec($curl));
            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);
            curl_close($curl);



            $hourOminute = ($key->hourOminute == 'Min') ? 'minutes' : 'hours';
            $dateInitiation = $key->dateInitiation;
            $initiationTime = $key->initiationTime;
            $timeConsultation = $key->timeConsultation;
            $proxAct = $key->nextUpdate;

            ($key->lastUpdate == '0000-00-00 00:00:00' || $key->lastUpdate == null) ? $feed[$i]['lastUpdate'] = "---" : $feed[$i]['lastUpdate'] = $key->lastUpdate;
            ($key->lastError == '0000-00-00 00:00:00' || $key->lastError == null) ? $feed[$i]['lastError'] = "---" : $feed[$i]['lastError'] = $key->lastError;
            ($key->nextUpdate == '0000-00-00 00:00:00' || $key->nextUpdate == null) ? $feed[$i]['proxAct'] = $dateInitiation . " " . $initiationTime : $feed[$i]['proxAct'] = $proxAct;

            $feed[$i]['id_feed'] = $key->id_feed;
            $feed[$i]['nameFeed'] = $key->nameFeed;



            $date = new DateTime();

            if ($curl_errno > 0) {

                $feed[$i]['estatus'] = 'error';
            } else {

                $errorJson = json_last_error_msg();

                if ($errorJson != 'No error') {

                    $feed[$i]['estatus'] = 'error';
                }

                if ($json) {

                    $feed[$i]['estatus'] = 'ok';
                }
            }
            $i++;
        }

        return View::make('escaleta.index')->with(array('nameFeed' => $feed));
    }

    public function postFeed() {



        if (Request::json()) {

            $rules = array(
                'nameFeed' => 'required',
                'urlFeed' => 'required',
                'cl' => 'required',
                'idChannel' => 'required',
                'timeConsultation' => 'required | numeric',
                'nameDays' => 'required',
                'initiationTime' => 'required',
                'endTime' => 'required',
                'dateInitiation' => 'required',
                'dateEnd' => 'required'
            );

            $dateInitiation = date("Y-m-d", strtotime(Input::get('dateInitiation')));
            $dateEnd = date("Y-m-d", strtotime(Input::get('dateEnd')));


            $validator = Validator::make(Input::all(), $rules);

// process the login
            if ($validator->fails()) {

                return Response::json([
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                $urlDateCl = Input::get('urlFeed') . "&date=" . date("Y-m-d") . "&cl=" . Input::get('cl');

                $feed = new Feeds;
                $feed->nameFeed = Input::get('nameFeed');
                $feed->urlFeed = $urlDateCl;
                $feed->cl = Input::get('cl');
                $feed->channel = Input::get('idChannel');
                $feed->save();



                $FeedProgrammed = new FeedProgrammed;
                $FeedProgrammed->id_feed = $feed->id_feed;
                $FeedProgrammed->nameDays = implode(',', Input::get('nameDays'));
                $FeedProgrammed->timeConsultation = Input::get('timeConsultation');
                $FeedProgrammed->hourOminute = Input::get('hourOminute');
                $FeedProgrammed->initiationTime = Input::get('initiationTime');
                $FeedProgrammed->endTime = Input::get('endTime');
                $FeedProgrammed->dateInitiation = $dateInitiation;
                $FeedProgrammed->dateEnd = $dateEnd;
                $FeedProgrammed->save();

                return Response::json("guardado");
            }
        }
    }

    public function postFeedupd($id) {

        if (Request::json()) {


            $inputs = Input::all();

            $rules = array(
                'nameFeed' => 'required',
                'urlFeed' => 'required',
                'cl' => 'required',
                'idChannel' => 'required',
                'timeConsultation' => 'required | numeric',
                'nameDays' => 'required',
                'initiationTime' => 'required',
                'endTime' => 'required',
                'dateInitiation' => 'required',
                'dateEnd' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

// process the login
            if ($validator->fails()) {

                return Response::json([
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {


                $dateInitiation = date("Y-m-d", strtotime(Input::get('dateInitiation')));
                $dateEnd = date("Y-m-d", strtotime(Input::get('dateEnd')));

                $feed = Feeds::find($id);
                $feed->nameFeed = Input::get('nameFeed');
                $feed->urlFeed = Input::get('urlFeed');
                $feed->cl = Input::get('cl');
                $feed->channel = Input::get('idChannel');
                $feed->save();

                $FeedProgrammed = FeedProgrammed::find($id);
                $FeedProgrammed->id_feed = $feed->id_feed;
                $FeedProgrammed->nameDays = implode(',', Input::get('nameDays'));
                $FeedProgrammed->timeConsultation = Input::get('timeConsultation');
                $FeedProgrammed->hourOminute = Input::get('hourOminute');
                $FeedProgrammed->initiationTime = Input::get('initiationTime');
                $FeedProgrammed->endTime = Input::get('endTime');
                $FeedProgrammed->dateInitiation = $dateInitiation;
                $FeedProgrammed->dateEnd = $dateEnd;
                $FeedProgrammed->save();

                return Response::json("guardado");
            }
        }
    }

    public function getNewfeed() {
        return View::make('escaleta.new_feed');
    }

    public function getActualizafeed($id) {


        $feeds = DB::table('feeds AS f')
                ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                ->where('f.id_feed', $id)
                ->get(array('f.urlFeed', 'fp.lastError'));


        $date = date("Y-m-d H:i:s");

        $feed = [];

        foreach ($feeds as $key) {

            $urlFeed = $key->urlFeed;

            $scheme = parse_url($urlFeed, PHP_URL_SCHEME);
            $query = parse_url($urlFeed, PHP_URL_QUERY);
            $path = parse_url($urlFeed, PHP_URL_PATH);
            $host = parse_url($urlFeed, PHP_URL_HOST);

            $vars = array();
            parse_str($query, $vars);

            $queryNew = "date=" . date('Y-m-d') . "&cl=" . $vars['cl'] . "&key=" . $vars['key'] . "&t=" . $vars['t'];

            $urlFeedNew = $scheme . "://" . $host . $path . "?" . $queryNew;

            $feedUpd = Feeds::find($id);
            $feedUpd->urlFeed = $urlFeedNew;
            $feedUpd->save();


            $curl = curl_init(trim($key->urlFeed));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            $json = json_decode(curl_exec($curl));
            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);
            curl_close($curl);

            if ($curl_errno > 0) {

                $feed['estatus'] = 'error';

                $feedError = FeedProgrammed::find($id);
                $feedError->lastError = $date;
                $feedError->save();
            } else {

                $errorJson = json_last_error_msg();

                if ($errorJson != 'No error') {

                    $feed['estatus'] = 'error';

                    $feedError = FeedProgrammed::find($id);
                    $feedError->lastError = $date;
                    $feedError->save();
                }

                if ($json) {

                    $feed['estatus'] = 'ok';

                    $feedUpdate = FeedProgrammed::find($id);
                    $feedUpdate->lastUpdate = $date;
                    $feedUpdate->save();

                    $jsonImg = [];
                    $jsonExtras = [];

                    $feedsprogram = DB::table('FeedsProgram')->lists('secuency');


                    if (count($json->programa) > 1) {

                        for ($i = 0; $i < count($json->programa); $i++) {

                            $secuency = $json->programa[$i]->sec;

                            //if (!in_array($secuency, $feedsprogram)) {
                            $existSecuency = DB::table('FeedsProgram')->where('secuency',$secuency)->where('programKey',$vars['cl'])->count();

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
                            //}/* if in array   
                        }

                        for ($i = 0; $i < count($json->programa); $i++) {

                            foreach ($json->programa[$i] as $key => $value) {

                                if (preg_match("/thumb/i", $key)) {

                                    $jsonImg[$json->programa[$i]->sec][$key] = $json->programa[$i]->thumb;
                                } else {

                                    if ($key != 'sec' && $key != 'titulo' && $key != 'fecha' && $key != 'inicia' && $key != 'duracion') {

                                        $jsonExtras[$json->programa[$i]->sec][$key] = $json->programa[$i]->$key;
                                    }
                                }
                            }
                        }
                    }

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

                     
                }
                $cl = $vars['cl'];
                $date = date('Y-m-d');
                $this->UpdateJsonFeeds($cl,$date);

            }
        }
        return Redirect::to('adminFeeds')->with(array('nameFeed' => $feed));
    }

    protected function UpdateJsonFeeds($cl,$date){

        $feedTableJsonp = DB::select("SELECT CONCAT(fp.id,'_',fp.secuency)as id,fp.title,fp.img,fp.startDate,fp.startTime,fp.duration,CONCAT('content_hour_',DATE_FORMAT(fp.startTime,'%h'))as contentTime,DATE_FORMAT(startTime,'%h:00')as timeRange from feeds f inner join FeedsProgram fp on f.cl = fp.programKey where fp.status!=0 and f.cl=".$cl." and fp.startDate = '".$date."' order by fp.startTime");       
       
       if(count($feedTableJsonp)>0){
            
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

            $file = storage_path()."/".$cl."_".str_replace("-", "",$date).".js";

            File::put($file,$jsonp);
                                                                                                         
            $s3 = AWS::get('s3');

            $s3->putObject(array(
                'ACL'        => 'public-read',
                'Bucket'     => 'communities-dev',
                'Key'        => "/escaleta/json/".$cl."_".str_replace("-", "",$date).".js",
                'SourceFile' => $file
            ));

            if (File::exists($file)) { File::delete($file); } 

          return 1;
       }
    } 

    public function getEdit($id) {

        $feed = DB::table('feeds as f')
                ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                ->where('f.id_feed', '=', $id)
                ->get();

        return View::make('escaleta.feed_update')->with('feed', $feed);
    }

    public function postEdit($id) {


        $feed = DB::table('feeds as f')
                ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                ->where('f.id_feed', '=', $id)
                ->get();

        return View::make('escaleta.feed_update')->with('feed', $feed);
    }

    /* -----------------------------------------------------------------------------
     *                          Escaleta Feeds
      ---------------------------------------------------------------------------- */

    /* ---------------------- getCounterFeeds ----------------------------------- */

    public function getCounterFeeds() {
        if (Request::ajax()) {
            $clave = Input::get("clave");
            $fecha = Input::get("fecha");
            $counterFeeds = DB::table('FeedsProgram')
                    ->select('img', 'title', 'startDate', 'startTime', 'duration', 'secuency')
                    ->where('programKey', '=', $clave)
                    ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                    ->count();
            echo $counterFeeds;
        }
    }

    /* ---------------------- GetItemsStart ------------------------------------- */

    public function getItemsStart($clave = '1311') {
        if (Sentry::check()) {
            $channels = DB::table('feeds')->orderBy("nameFeed", "asc")->lists('nameFeed', 'cl');

            $FeedsProgram = DB::table('FeedsProgram')
                            ->select('img', 'title', 'startDate', 'startTime', 'duration', 'secuency', 'status')
                            ->where('programKey', '=', $clave)
                            ->where('startDate', '=', date('Y-m-d'))
                            ->orderBy('secuency', 'asc')->get();
            $extra_time = 0;

            $counterFeeds = DB::table('FeedsProgram')
                    ->select('img', 'title', 'startDate', 'startTime', 'duration', 'secuency')
                    ->where('programKey', '=', $clave)
                    ->where('startDate', '=', date('Y-m-d'))
                    ->count();

            return View::make('vcms.escaleta', array('channels' => $channels, 'extra_time' => $extra_time, 'clave' => $clave, 'FeedsProgram' => $FeedsProgram, 'counterFeeds' => $counterFeeds));
        } else {
            return Redirect::to('login');
        }
    }

    /* ---------------------- GeItemsProgram ------------------------------------ */

    public function getItemsProgram() {
        if (Request::ajax()) {
            $clave = Input::get("clave");
            $fecha = Input::get("fecha");

            $FeedsProgram = DB::table('FeedsProgram')
                            ->select('img', 'title', 'startDate', 'startTime', 'duration', 'secuency', 'status')
                            ->where('programKey', '=', $clave)
                            ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                            ->orderBy('secuency', 'asc')->get();
            $extra_time = 0;
            return View::make('escaleta.display_items', array('extra_time' => $extra_time, 'FeedsProgram' => $FeedsProgram));
        }
    }

    /* ---------------------- GetDephasingVideo ------------------------------------ */

    public function getDephasingVideo() {
        if (Request::ajax()) {
            $clave = Input::get("clave");
            $fecha = Input::get("fecha");
            $path = Config::get('vcms.folder_time_offset');
            $filename = $path . date("Y-m-d", strtotime($fecha)) . "_" . $clave . "." . "txt";

            if (file_exists($filename)) {
                $value = file_get_contents($filename);
                return $value;
            } else {
                $value = 0;
                return $value;
            }
        }
    }

    /* ---------------------- SaveDephasingVideo ------------------------------------ */

    public function saveDephasingVideo() {
        if (Request::ajax()) {
            $fecha = Input::get("fecha");
            $clave = Input::get("clave");
            $dephasingVideo = Input::get('dephasingVideo');
            $path = Config::get('vcms.folder_time_offset');
            $filename = $path . '' . date("Y-m-d", strtotime($fecha)) . '_' . $clave . '.' . 'txt';
            $content = $dephasingVideo;
            $filenameWritten = File::put($filename, $content);

            if (file_exists($filename)) {
                echo "$filename Guardado.";
            } else {
                echo "El fichero $filename No se Guardo";
            }
        }
    }

    /* ---------------------- EditorVideoClips ---------------------------------- */

    public function editorVideoClips() {

        if (Request::ajax()) {

            $fecha = Input::get("fecha");
            $clave = Input::get("clave");
            $secuency = Input::get('secuency');

            $displayEditorVideo = DB::table('FeedsProgram')
                            ->select('img', 'title', 'startDate', 'startTime', 'duration', 'status')
                            ->where('programKey', '=', $clave)
                            ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                            ->where('secuency', '=', $secuency)->get();

            $titleVideoClips = $displayEditorVideo[0]->title;
            $startTimeVideo = $displayEditorVideo[0]->startTime;
            $durationVideo = $displayEditorVideo[0]->duration;
            $statusVideo = $displayEditorVideo[0]->status;

            return array('title' => $titleVideoClips, 'startTime' => $startTimeVideo, 'duration' => $durationVideo, 'status' => $statusVideo);
        }
    }

    /* ---------------------- SaveVideoClips ---------------------------------- */

    public function saveVideoClips() {
        if (Request::ajax()) {
//Get vars for query in table FeedsProgram
            $fecha = Input::get('fecha');
            $clave = Input::get('clave');
            $secuency = Input::get('secuency');
//Get vars for insert in table FeedsProgram     
            $titleVideoNew = Input::get('titleVideoClips');
            $startTimeVideoNew = Input::get('startTime');
            $durationVideoNew = Input::get('durationVideo');
            $statusVideoNew = Input::get('status');
//Query in table FeedsProgram 
            $displayEditorVideo = DB::table('FeedsProgram')
                            ->select('img', 'title', 'startDate', 'startTime', 'duration', 'status', 'created_at', 'updated_at')
                            ->where('programKey', '=', $clave)
                            ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                            ->where('secuency', '=', $secuency)->get();
//Get vars $title , $startTime , $duration and $updated_at to insert in table FeedsProgramBackup
            $titleVideoClips = $displayEditorVideo[0]->title;
            $startTimeVideo = $displayEditorVideo[0]->startTime;
            $durationVideo = $displayEditorVideo[0]->duration;
            $updateVideo = $displayEditorVideo[0]->updated_at;
//$status = $FeedsProgram[0]-> status; 
//$timestamps = '2014-09-11 08:48:02';
            $timestamps = date("Y-m-d H:i:s");
//validation in feedprogram (define var and  null var)
            if (isset($displayEditorVideo) && $displayEditorVideo != NULL) {
//echo "El registro existe en Base de Datos "; 
                echo $startTimeVideo;
//Validation of updated_at iquals to 0000-00-00 00:00:00
                if ($updateVideo == '0000-00-00 00:00:00') {
//validation updated is true Insert data in table FeedsProgramBackup
//echo 'Insertar en back' ;
//Create backup in table FeedsProgramBackup
                    $CreateBackupVideo = DB::table('FeedsProgramBackup')
                            ->insert(array('programKey' => $clave, 'startDate' => $fecha, 'secuency' => $secuency, 'title' => $titleVideoClips, 'startTime' => $startTimeVideo, 'duration' => $durationVideo));
//                  DB::table('FeedsProgramBackup')->delete();
                } else {
                    echo 'El Registro esta en backup';

                }
//update table FeedsProgram 
                $updateVideoClip = DB::table('FeedsProgram')
                        ->where('programKey', '=', $clave)
                        ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                        ->where('secuency', '=', $secuency)
                        ->update(array('title' => $titleVideoNew, 'startTime' => $startTimeVideoNew, 'duration' => $durationVideoNew, 'status' => $statusVideoNew, 'updated_at' => $timestamps));

                $date = date("Ymd", strtotime($fecha));

                echo $this->UpdateJsonFeeds($clave,$date);
                echo $clave." -- ".$date;
            
            } else {
                echo "El registro no existe en Base de Datos";
            }
        }
    }

    /* ---------------------- RestoreVideoClips ---------------------------------- */

    public function restoreVideoClips() {
        if (Request::ajax()) {
//Get vars for query in table FeedsProgram
            $fecha = Input::get('fecha');
            $clave = Input::get('clave');
            $secuency = Input::get('secuency');
//Query in table FeedsProgram 
            $displayBackupVideo = DB::table('FeedsProgramBackup')
                            ->select('img', 'title', 'startDate', 'startTime', 'duration', 'created_at', 'updated_at')
                            ->where('programKey', '=', $clave)
                            ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                            ->where('secuency', '=', $secuency)->get();
//Get vars $title , $startTime , $duration and $updated_at to insert in table FeedsProgramBackup
            $titleVideoClips = $displayBackupVideo[0]->title;
            $startDate = $displayBackupVideo[0]->startDate;
            $startTimeVideo = $displayBackupVideo[0]->startTime;
            $durationVideo = $displayBackupVideo[0]->duration;
            echo $startTimeVideo;
            $updateVideoClip = DB::table('FeedsProgram')
                    ->where('programKey', '=', $clave)
                    ->where('startDate', '=', date("Y-m-d", strtotime($fecha)))
                    ->where('secuency', '=', $secuency)
                    ->update(array('title' => $titleVideoClips, 'startDate' => $startDate, 'startTime' => $startTimeVideo, 'duration' => $durationVideo));
        }
    }

    /**  Procesar feeds anteriores * */
    public function getProcessfeedsprev() {


        $proccessFeedsPrev = Feeds::lists('nameFeed', 'id_feed');
        $proccessFeedsPrev = array('Todos') + $proccessFeedsPrev;

        return View::make('escaleta.process_feeds_prev')->with('proccessFeedsPrev', $proccessFeedsPrev);
    }

    public function postFeedsprev() {

        if (Request::ajax()) {


            $rules = array(
                'dateInitiation' => 'required',
                'dateEnd' => 'required'
            );

            $idFeeds = Input::get('idFeeds');
            $dateInitiation = date("Y-m-d", strtotime(Input::get('dateInitiation')));
            $dateEnd = date("Y-m-d", strtotime(Input::get('dateEnd')));


            $validator = Validator::make(Input::all(), $rules);

// process the login
            if ($validator->fails()) {

                return Response::json([
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                if ($idFeeds != 0) {

                    $feeds = DB::table('feeds AS f')
                            ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                            ->where('f.id_feed', $idFeeds)
                            ->get(array('f.urlFeed'));
                } else {

                    $feeds = DB::table('feeds AS f')
                            ->get(array('f.urlFeed'));
                }

                $date = date("Y-m-d H:i:s");

                $feed = [];
                $j = 0;


//ini_set('max_execution_time', 300); //300 seconds = 5 minutos
                set_time_limit(0);

                DB::table('feed_temp')->truncate();

                for ($i = $dateInitiation; $i <= $dateEnd; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {


                    foreach ($feeds as $key) {

                        $urlFeed = $key->urlFeed;

                        $scheme = parse_url($urlFeed, PHP_URL_SCHEME);
                        $query = parse_url($urlFeed, PHP_URL_QUERY);
                        $path = parse_url($urlFeed, PHP_URL_PATH);
                        $host = parse_url($urlFeed, PHP_URL_HOST);

                        $vars = array();
                        parse_str($query, $vars);

                        $queryNew = "date=" . $i . "&cl=" . $vars['cl'] . "&key=" . $vars['key'] . "&t=" . $vars['t'];

                        $urlFeedNew = $scheme . "://" . $host . $path . "?" . $queryNew;



                        $feedTemp = new FeedsTemp;
                        $feedTemp->cl = $vars['cl'];
                        $feedTemp->urlFeed = $urlFeedNew;
                        $feedTemp->save();


                        $j++;
                    }
                }

                $cl = DB::table('feed_temp')->select('cl')->distinct()->get();

                foreach ($cl as $key) {

                    $feed_temp = DB::table('feed_temp')->select('urlfeed', 'cl')->where('cl', $key->cl)->get();


                    foreach ($feed_temp as $key1) {


                        $curl = curl_init(trim($key1->urlfeed));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_ENCODING, "");
                        $json = json_decode(curl_exec($curl));
                        $curl_errno = curl_errno($curl);
                        $curl_error = curl_error($curl);
                        curl_close($curl);


                        if ($json) {

                            $jsonImg = [];
                            $jsonExtras = [];

                            $feedsprogram = DB::table('FeedsProgram')->lists('secuency');


                            if (count($json->programa) > 1) {

                                for ($i = 0; $i < count($json->programa); $i++) {

                                   $secuency = $json->programa[$i]->sec;

                                    //if (!in_array($secuency, $feedsprogram)) {
                                    $existSecuency = DB::table('FeedsProgram')->where('secuency',$secuency)->where('programKey',$key1->cl)->count();

                                        if($existSecuency == 0){

                                            try{

                                                (trim($json->programa[$i]->titulo) == 'Comerciales') ? $status = 0 :$status = 1;  
                                                                                                
                                                $feedProgram = new FeedsProgram;
                                                $feedProgram->programKey    =  $key1->cl;
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
                                    //}/* if in array   
                                }

                                for ($i = 0; $i < count($json->programa); $i++) {

                                    foreach ($json->programa[$i] as $key => $value) {

                                        if (preg_match("/thumb/i", $key)) {

                                            $jsonImg[$json->programa[$i]->sec][$key] = $json->programa[$i]->thumb;
                                        } else {

                                            if ($key != 'sec' && $key != 'titulo' && $key != 'fecha' && $key != 'inicia' && $key != 'duracion') {

                                                $jsonExtras[$json->programa[$i]->sec][$key] = $json->programa[$i]->$key;
                                            }
                                        }
                                    }
                                }
                            }

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
                        }//json     
                    }
                }

                return Response::json("terminado");
            }
        }
    }

    public function getTablefeed() {


        $dataFeeds = DB::table('feeds AS f')
                ->leftJoin('FeedsProgram as fp', 'f.cl', '=', 'fp.programKey')
                ->groupBy('f.nameFeed', 'fp.startDate')
                ->get(array('f.id_feed', 'f.nameFeed', 'fp.startDate', DB::Raw('COUNT(title) as countFeed')));



        $year = date("Y");
        $week = date("W");

        $timestamp = mktime(0, 0, 0, 1, 1, $year);

        $timestamp+=$week * 7 * 24 * 60 * 60;

        $ultimoDia = $timestamp - date("w", mktime(0, 0, 0, 1, 1, $year)) * 24 * 60 * 60;

        $primerDia = $ultimoDia - 86400 * (date('N', $ultimoDia) - 1);

        $firstDayWeek = date("d-m-Y", $primerDia);
        $lastDayWeek = date("d-m-Y", $ultimoDia);

        list($firstDay, $firstMonth, $firstYear) = explode("-", $firstDayWeek);
        list($lastDay, $lastMonth, $lastYear) = explode("-", $lastDayWeek);

        $data = array();
        $dateWeek = array();

        $dayInMonth = date("t", strtotime($firstDayWeek));

        if ($firstDay > $lastDay) {

            $weekCurrent = array();
            while ($firstDay <= $dayInMonth):
                $weeks = $firstYear . "-" . $firstMonth . "-" . str_pad($firstDay, 2, 0, STR_PAD_LEFT);
                array_push($weekCurrent, $weeks);
                $firstDay++;
            endwhile;


            $dateWeek = $weekCurrent;

            ($firstMonth >= 12) ? $firstMonthNext = 1 : $firstMonthNext = $firstMonth + 1;

            for ($j = 1; $j <= 7 - count($weekCurrent); $j++) {
                echo $weeks = $lastYear . "-" . str_pad($firstMonthNext, 2, 0, STR_PAD_LEFT) . "-" . str_pad($j, 2, 0, STR_PAD_LEFT);
                array_push($dateWeek, $weeks);
            }


            for ($i = 0; $i < count($dateWeek); $i++) {

                foreach ($dataFeeds as $key => $value) {

                    $data[$value->id_feed][$value->nameFeed][$value->startDate] = $value->countFeed;

                    if ($value->startDate != $dateWeek[$i]) {
                        $data[$value->id_feed][$value->nameFeed][$dateWeek[$i]] = 0;
                    }
                }
            }
        } else {

            for ($i = $firstDay; $i <= $lastDay; $i++) {


                $weeks = $firstYear . "-" . $firstMonth . "-" . str_pad($i, 2, 0, STR_PAD_LEFT);
                array_push($dateWeek, $weeks);


                foreach ($dataFeeds as $key => $value) {

                    $data[$value->id_feed][$value->nameFeed][$value->startDate] = $value->countFeed;

                    if ($value->startDate != $weeks) {
                        $data[$value->id_feed][$value->nameFeed][$weeks] = 0;
                    }
                }
            }
        }

        return View::make("escaleta.table_feeds")->with(array('dataFeeds' => $data, 'dateWeek' => $dateWeek, 'firstDayWeek' => $firstDayWeek, 'lastDayWeek' => $lastDayWeek));
    }

    public function getStatusweek($statusWeek, $dayWeek) {

        $dataFeeds = DB::table('feeds AS f')
                ->leftJoin('FeedsProgram as fp', 'f.cl', '=', 'fp.programKey')
                ->groupBy('f.nameFeed', 'fp.startDate')
                ->get(array('f.id_feed', 'f.nameFeed', 'fp.startDate', DB::Raw('COUNT(title) as countFeed')));

        $date = date('Y-W-m-d', $dayWeek);
        list($year, $week, $month, $day) = explode("-", $date);

        ($statusWeek == 'prev') ? $day = $day - 1 : $day = $day + 1;

        $weekDay = date("w", mktime(0, 0, 0, $month, $day, $year));

        if ($weekDay == 0)
            $weekDay = 7;

        $firstDayWeek = date("d-m-Y", mktime(0, 0, 0, $month, $day - $weekDay + 1, $year));

        $lastDayWeek = date("d-m-Y", mktime(0, 0, 0, $month, $day + (7 - $weekDay), $year));


        list($firstDay, $firstMonth, $firstYear) = explode("-", $firstDayWeek);
        list($lastDay, $lastMonth, $lastYear) = explode("-", $lastDayWeek);

        $dayInMonth = date("t", strtotime($firstDayWeek));

        $data = array();
        $dateWeek = array();

        if ($firstDay > $lastDay) {

            $weekCurrent = array();
            while ($firstDay <= $dayInMonth):
                $weeks = $firstYear . "-" . $firstMonth . "-" . str_pad($firstDay, 2, 0, STR_PAD_LEFT);
                array_push($weekCurrent, $weeks);
                $firstDay++;
            endwhile;

            $dateWeek = $weekCurrent;

            ($firstMonth >= 12) ? $firstMonthNext = 1 : $firstMonthNext = $firstMonth + 1;

            for ($j = 1; $j <= 7 - count($weekCurrent); $j++) {
                $weeks = $lastYear . "-" . str_pad($firstMonthNext, 2, 0, STR_PAD_LEFT) . "-" . str_pad($j, 2, 0, STR_PAD_LEFT);
                array_push($dateWeek, $weeks);
            }


            for ($i = 0; $i < count($dateWeek); $i++) {

                foreach ($dataFeeds as $key => $value) {

                    $data[$value->id_feed][$value->nameFeed][$value->startDate] = $value->countFeed;

                    if ($value->startDate != $dateWeek[$i]) {
                        $data[$value->id_feed][$value->nameFeed][$dateWeek[$i]] = 0;
                    }
                }
            }
        } else {

            for ($i = $firstDay; $i <= $lastDay; $i++) {

                $weeks = $firstYear . "-" . $firstMonth . "-" . str_pad($i, 2, 0, STR_PAD_LEFT);

                array_push($dateWeek, $weeks);

                foreach ($dataFeeds as $key => $value) {

                    $data[$value->id_feed][$value->nameFeed][$value->startDate] = $value->countFeed;

                    if ($value->startDate != $weeks) {
                        $data[$value->id_feed][$value->nameFeed][$weeks] = 0;
                    }
                }
            }
        }

        return View::make("escaleta.table_feeds")->with(array('dataFeeds' => $data, 'dateWeek' => $dateWeek, 'firstDayWeek' => $firstDayWeek, 'lastDayWeek' => $lastDayWeek));
    }

    public function postUpdatefeed($idFeed, $dateFeed) {

        if (Request::ajax()) {


            $feeds = DB::table('feeds AS f')
                    ->leftJoin('feeds_programmed AS fp', 'f.id_feed', '=', 'fp.id_feed')
                    ->where('f.id_feed', $idFeed)
                    ->get(array('f.urlFeed', 'fp.lastError','f.cl'));

            $date = date("Y-m-d H:i:s");

            $feed = [];

            foreach ($feeds as $key) {

                $urlFeed = $key->urlFeed;

                $scheme = parse_url($urlFeed, PHP_URL_SCHEME);
                $query = parse_url($urlFeed, PHP_URL_QUERY);
                $path = parse_url($urlFeed, PHP_URL_PATH);
                $host = parse_url($urlFeed, PHP_URL_HOST);

                $vars = array();
                parse_str($query, $vars);

                $queryNew = "date=" . $dateFeed . "&cl=" . $vars['cl'] . "&key=" . $vars['key'] . "&t=" . $vars['t'];

                $urlFeedNew = $scheme . "://" . $host . $path . "?" . $queryNew;


                $curl = curl_init(trim($urlFeedNew));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
                curl_setopt($curl, CURLOPT_ENCODING, "");
                $json = json_decode(curl_exec($curl));
                $curl_errno = curl_errno($curl);
                $curl_error = curl_error($curl);
                curl_close($curl);


                if ($json) {

                    $feedUpdate = FeedProgrammed::find($idFeed);
                    $feedUpdate->lastUpdate = $date;
                    $feedUpdate->save();

                    $jsonImg = [];
                    $jsonExtras = [];

                    $feedsprogram = DB::table('FeedsProgram')->lists('secuency');


                    if (count($json->programa) > 1) {

                        for ($i = 0; $i < count($json->programa); $i++) {

                            $secuency = $json->programa[$i]->sec;

                            //if (!in_array($secuency, $feedsprogram)) {
                            $existSecuency = DB::table('FeedsProgram')->where('secuency',$secuency)->where('programKey',$vars['cl'])->count();

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
                            //}/* if in array   
                        }
                        for ($i = 0; $i < count($json->programa); $i++) {

                            foreach ($json->programa[$i] as $key => $value) {

                                if (preg_match("/thumb/i", $key)) {

                                    $jsonImg[$json->programa[$i]->sec][$key] = $json->programa[$i]->thumb;
                                } else {

                                    if ($key != 'sec' && $key != 'titulo' && $key != 'fecha' && $key != 'inicia' && $key != 'duracion') {

                                        $jsonExtras[$json->programa[$i]->sec][$key] = $json->programa[$i]->$key;
                                    }
                                }
                            }
                        }
                    }

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
                }//json             
            }//End foreach

            $cl = $feeds[0]->cl;

            $this->UpdateJsonFeeds($cl,$dateFeed);

            return Response::json("exit");
        }
    }

}
