<?php

require_once(base_path()."/vendor/php-rql/rdb/rdb.php");

class SocialHubController extends ContestController {

    protected $conn;
    protected $DB;

    public function __construct() 
    {

        try {

            $this->connect_db();
            $dbList = r\dbList()->contains(Config::get('rethinkdb.name_db'))->run($this->conn);

            if(!$dbList){
                r\dbCreate( Config::get('rethinkdb.name_db') )->run($this->conn);
            }
            $this->DB = r\db( Config::get('rethinkdb.name_db') ); 
                
        } catch (Exception $e) {
            
            App::abort(502);
            
        }
        

    }

    protected function connect_db(){
        if(is_null($this->conn)){
            $this->conn  =  r\connect( Config::get('rethinkdb.server_db_ip') );
        }
        return 1;
    }

    protected function create_table($name_table){

        $existTable = $this->DB->tableList()->contains($name_table)->run($this->conn);

        if(!$existTable){
            $this->DB->tableCreate($name_table)->run( $this->conn);  
        }

    }

    protected function all_services_settings(){

        try {
            $services = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->pluck(array('id','name_service','status-service','last_update'))->orderBy(r\asc('name_service'))->run($this->conn);
        
        } catch (Exception $e) {
            $services = [];
        }

        return $services;

    }

    public function getIndex(){ 

        return View::make(Config::get( 'app.main_template' ).'.twitter.tableServicesTwitter')->with(array("services"=>$this->all_services_settings()));
    }

    public function getVerificarNombreServicio(){

        if (Request::ajax()) {

            $ServiceName = Input::get('ServiceName');

            try {
                $existName = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->getField('name_service')->contains($ServiceName)->run($this->conn);
            } catch (Exception $e) {
                $existName = false;
            }

            return Response::json($existName);
        }
    }

    public function getNewService(){
        return View::make(Config::get( 'app.main_template' ).'.twitter.servicesTwitter');
    }
    

    public function postSaveService(){

        $this->create_table(Config::get('rethinkdb.table_configured_services_social_hub'));

        $ServiceSettings = Input::get('ServiceSettings');

        $name_service = $ServiceSettings['name_service'];
        $num_tweets = intval($ServiceSettings['num_tweets']);
        $status_service = intval($ServiceSettings['status-service']);
        $type_services = $ServiceSettings['type_services'];
        $activeDate =   $ServiceSettings['dateFrom']; 
        $inactiveDate    =  $ServiceSettings['dateTo'];

        $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->insert( array('name_service'=>$name_service,'status-service'=>$status_service,'active_date'=>$activeDate,'inactive_date'=>$inactiveDate,'num_tweets'=>$num_tweets,'type_services' => $type_services))->run($this->conn);

        return Redirect::action('SocialHubController@getIndex');

    }

    public function postUpdateService($id){
        
        if($id){


            $ServiceSettings = Input::get('ServiceSettings');
                
            $status_service = (int)$ServiceSettings['status-service'];
            $num_tweets = (int)$ServiceSettings['num_tweets'];
            $activeDate =   $ServiceSettings['dateFrom']; 
            $inactiveDate    =  $ServiceSettings['dateTo'];
            $type_services = $ServiceSettings['type_services'];

            //return $ServiceSettings ;

            $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($id)->update(array( 'status-service' => r\literal($status_service),'active_date'=>r\literal($activeDate),'inactive_date'=>r\literal($inactiveDate),'num_tweets' => r\literal($num_tweets),'type_services' => r\literal($type_services ) ))->run($this->conn);
            $this->backup_twitter(); 
            return Redirect::action('SocialHubController@getIndex');
        }
        
    }

    public function getEditService($id){

        $service = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($id)->run($this->conn);

        
        $idService =  $this->DB->table(Config::get('rethinkdb.table_tweets_service'))->filter(array('id_service' => $id))->pluck('id')->run($this->conn)->toArray();

        $num_tweets = (int)$service['num_tweets']*2;
        $tweets = [];
        foreach ($idService as $id) {

            $tweets = $this->DB->table(Config::get('rethinkdb.table_tweets_service'))->filter(array('id' => $id['id'] ))->mapMultiple( array(r\expr(array($num_tweets))),function ($post,$num_tweets){
                    return array(
                            'data' => $post("data")->orderBy(r\desc('created_at'))->limit($num_tweets)
                            );
                })->run($this->conn);
        }

        try {
            $tweets;
            $paramethers = ["service"=>$service,"tweets"=>$tweets];
        } catch (Exception $e) {
            $paramethers = ["service"=>$service];
        }

        return View::make(Config::get( 'app.main_template' ).'.twitter.servicesTwitter')->with($paramethers);

    }

    public function getVerificarPerfil(){

        if (Request::ajax()) {

            $perfil = Input::get('perfil');

            try{
                $user = Twitter::muteUser(array('screen_name' => $perfil, 'format' => 'array'));
                    
            }catch(Exception $e) {
                $user=[];
            }

            return Response::json($user);

        }

    }
    
    public function getVerificarHashtag(){

        if (Request::ajax()) {

            #$hashtag = Input::get('hashtag');
            #$hash = Twitter::getSearch(array('q' => '#'.$hashtag));

            return Response::json(true);
        }
    }

    public function getVerificarLista(){

        if (Request::ajax()) {

            $screen_name = Input::get('lista');

            try{
                $user = Twitter::getLists(array('screen_name' => $screen_name));
            }catch(Exception $e) {
                $user=[];
            }

            $lists = array();

            if (count($user) == 0){
                $lists = false;
            }else{
                foreach ($user as $key => $value) {
                    $lists[$value->user->screen_name][$value->slug] = $value->name;
                }
            }

            return Response::json($lists);
        }
    }

    public function getChangeStatus(){

        if (Request::ajax()) {

            $status = Input::get('status');
            $id = Input::get('id');

            try {
               $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($id)->update(array('status-service' => (int)$status))->run($this->conn);
                $data = true;
            } catch (Exception $e) {
                $data = false;
            }
            
            return Response::json($status);

        }

    }

    public function getHideTweet(){

        if(Request::ajax()){

            $idService = Input::get('idService');
            $idTweet = Input::get('idTweet');
            $statusTweet = (Input::get('statusTweet') == 'true')? 1 : 0;

            
            try {
                $this->DB->table(Config::get('rethinkdb.table_tweets_service'))->filter(array('id_service'=>$idService))
                ->update( array( 
                        'data' => r\row('data')->map(function ($tweet) USE ($idTweet,$statusTweet){    
                            return r\branch( $tweet('id_item')->eq($idTweet), $tweet->merge( array('status_tweet'=>$statusTweet)), $tweet );
                        }) 
                ))->run($this->conn);

                $num_tweets = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($idService)->pluck('num_tweets')->run($this->conn);
                $num = (int)$num_tweets['num_tweets'];

                $tweets = $this->DB->table(Config::get('rethinkdb.table_tweets_service'))->filter(array('id_service' => $idService ))->mapMultiple( array(r\expr(array($num))),function ($post,$num){
                        return array(
                                    'data' => $post("data")->filter(array("status_tweet"=> 1))->orderBy(r\desc('created_at'))->limit($num)
                                    );
                    })->run($this->conn);

                $s3 = AWS::get('s3');

                foreach ($tweets as $key => $value) {

                    $s3->putObject(array(
                                    'ACL'        => Config::get('bucket_twitter.ACL'),
                                    'Bucket'     => Config::get('bucket_twitter.Bucket'),
                                    'contentType' => Config::get('bucket_twitter.contentType'),
                                    'Key'        => Config::get('bucket_twitter.name_bucket').$idService.'.json',
                                    'Body'       => json_encode($value['data'])
                    ));
                } 

                return Response::json(  'Finalizado' );
            } catch (Exception $e) {
                return Response::json( "mal" );
                
            }
        }
    }

    public function getUpdateConfigSocial(){
        
        if(Request::ajax()){

            $idConfigureService = Input::get('idConfigureService');

            $table_update_social_hub = Config::get('rethinkdb.table_update_social_hub');
            $table_configured_services_social_hub = Config::get('rethinkdb.table_configured_services_social_hub');

            $existTable = $this->DB->tableList()->contains( $table_update_social_hub )->run($this->conn);

            if(!$existTable){
                $this->DB->tableCreate( $table_update_social_hub  )->run($this->conn);  
            }

            $existRegister = $this->DB->table( $table_update_social_hub )->count()->run($this->conn);

            $current_configuration = $this->DB->table($table_configured_services_social_hub)->get($idConfigureService)->getField('type_services')->run($this->conn);

            $current_configuration_upd = []; 


            foreach ($current_configuration as $type_service => $value) {
                for ($i=0; $i < count($value) ; $i++) { 
                    $current_configuration_upd[$type_service][ltrim($value[$i],'@')]['status_upd'] = 1;
                }
            }

            if($existRegister){

                $listDataSocial = $this->DB->table( $table_update_social_hub )->limit(1)->run($this->conn)->toArray();

                $data = json_decode(json_encode($listDataSocial), true);
                $id = $data[0]['id'];
                unset($data[0]['id']);

                $newDataUpd = array_replace_recursive($data[0],$current_configuration_upd);

                $this->DB->table($table_update_social_hub)->get($id)->update($newDataUpd)->run($this->conn);

            }else{

                $this->DB->table($table_update_social_hub)->insert($current_configuration_upd)->run($this->conn);
                $last_id = $this->DB->table($table_update_social_hub)->getField('id')->limit(1)->run($this->conn)->toArray();
                $id = $last_id[0];
            }

            $data = array("idConfigureService"=>$idConfigureService,"idUpdateProfiles"=>$id);

            return Response::json($data);
        }
    }

    public function getStatusConfigSocial(){

        if(Request::ajax()){

            $data = Input::get('data');

            $idConfigureService = $data['idConfigureService'];
            $idUpdateProfiles = $data['idUpdateProfiles'];


            try {
                
                $UpdConfigService = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($idConfigureService)->getField('type_services')->run($this->conn);
                
                foreach ($UpdConfigService as $typeService => $value) {   
                    for ($i=0; $i < count($value); $i++) { 
                        
                        try {
                            $valUpdate = $this->DB->table(Config::get('rethinkdb.table_update_social_hub'))->get( $idUpdateProfiles )->getField( $typeService )->getField(ltrim($value[$i],'@'))->getField('status_upd')->run($this->conn);
                        
                            if($valUpdate == 1){
                                $status = "Updating";
                                break;
                            }else{
                                $status = "Finish";
                                break;
                            }

                        } catch (Exception $e) {
                            echo $e;
                        }
                    }
                }

                return Response::json($status);
                
            } catch (Exception $e) {

                return Response::json($e);
                
            }
            
            
        }

    }

    protected function backup_twitter(){
        
        date_default_timezone_set('America/Mexico_City');
        $fecha = new DateTime();

        $configuration = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->run($this->conn)->toArray();

         $s3 = AWS::get('s3');

            
           $s3->putObject(array(
                'ACL'        => 'public-read',
                'Bucket'     => 'communities-dev',
                'contentType' => "text/html",
                'Key'        => "/twitter_backup/configure_services_twitter_".$fecha->getTimestamp().".json",
                'Body'       => json_encode($configuration)
            ));

           return "exitoso";
    }

    public function getBackup(){

        if( Request::ajax() ){

            $x = $this->backup_twitter(); 

            return Response::json($x);

        }
    }



    public function getTelehit(){
        return View::make(Config::get( 'app.main_template' ).'.twitter.telehit');
    }

      public function getVerificarInstagram(){

        if (Request::ajax()) {

            $screen_name = $this->DB->table(Config::get('rethinkdb.table_instagram'))->getField('screen_name')->run($this->conn)->toArray();

            return Response::json($screen_name);
        }
    }


    public function getVersus(){


        try {

            $table_twitter_versus = Config::get('rethinkdb.table_configured_services_social_hub_versus');
            $this->create_table($table_twitter_versus);

            $services = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->pluck(array('id','name_service'))->orderBy(array('name_service'))->run($this->conn);

            $exist_register =  $this->DB->table($table_twitter_versus)->count()->run($this->conn);

            $versus_configured  = '';

            if($exist_register){
                $versus_configured =  $this->DB->table($table_twitter_versus)->orderBy(array('name_service'))->run($this->conn);
            }

        } catch (Exception $e) {
            echo "Message: ".$e;
        }

        return View::make(Config::get( 'app.main_template' ).'.twitter.versus.versus')->with( array('services'=>$services,'versus_configured'=>$versus_configured ));
    }

    public function getSaveServiceVersus(){

        if (Request::ajax()) {

            $table_twitter_versus = Config::get('rethinkdb.table_configured_services_social_hub_versus');

            $this->create_table($table_twitter_versus);

            $service_versus = Input::all();

            $exist_register =  $this->DB->table($table_twitter_versus)->filter( array('id_service'=>$service_versus['id']))->count()->run($this->conn);

            if(!$exist_register){
                $this->DB->table($table_twitter_versus)->insert( array('id_service'=>$service_versus['id'],'name_service'=>$service_versus['name_service'],'status'=>intval($service_versus['status']) ))->run($this->conn);
                
                $versus_configured =  $this->DB->table($table_twitter_versus)->orderBy(array('name_service'))->run($this->conn);

                return Response::json($versus_configured);
            }else{
                return Response::json('exists');
            }
        }

    }

    public function getChangeStatusVersus(){

        if (Request::ajax()) {

            $table_twitter_versus = Config::get('rethinkdb.table_configured_services_social_hub_versus');
            $service_versus = Input::all();

            $this->DB->table($table_twitter_versus)->filter( array('id'=>$service_versus['id']))->update( array( 'status'=>intval($service_versus['status']) ) )->run($this->conn);
            
            return Response::json('saved');
        
        }

    }


    public function getVerificarFacebookFeeds(){

        if (Request::ajax()) {

            #$hashtag = Input::get('hashtag');
            #$hash = Twitter::getSearch(array('q' => '#'.$hashtag));

            return Response::json("ajax with facebook");
        }
    }

    public function getVerificarFacebookVideos(){

        if (Request::ajax()) {

            #$hashtag = Input::get('hashtag');
            #$hash = Twitter::getSearch(array('q' => '#'.$hashtag));

            return Response::json("ajax with facebook videos");
        }
    }
    public function getVerificarYoutubeVideos(){

        if (Request::ajax()) {

            #$hashtag = Input::get('hashtag');
            #$hash = Twitter::getSearch(array('q' => '#'.$hashtag));

            return Response::json("ajax with youtube videos");
        }
    }

    public function getVerificarPlaylistsVideos(){
        
        if (Request::ajax()) {

            $search_channel_name = Input::get('playlists-videos');


            $client = new Google_Client();
            $client->setApplicationName("youtube");
            $client->setDeveloperKey("AIzaSyDv1IilRqboOEPdALbNNMCalki71xVhxGY");

            $youtube = new Google_Service_YouTube($client);

            $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
              'forUsername'=> $search_channel_name,
              'part'=>"snippet,contentDetails"
            ));

            $data = [];

            foreach ($channelsResponse['items'] as $channel) {

                $results = $youtube->playlists->listPlaylists('snippet', array(
                    'channelId' => $channel['id'],
                    'maxResults' => 50
                  ));

                foreach ($results['items'] as $result) {
                    $data[$result['id']] = $result['snippet']['title'];
                }
            }

            natcasesort($data);

            return Response::json($data);
        }
    }

    public function getGenerateJson(){
        if(Request::ajax()){

            $idService = Input::get('id');

            $num_tweets = $this->DB->table(Config::get('rethinkdb.table_configured_services_social_hub'))->get($idService)->pluck('num_tweets')->run($this->conn);
            $num = (int)$num_tweets['num_tweets'];

            $tweets = $this->DB->table(Config::get('rethinkdb.table_tweets_service'))->filter(array('id_service' => $idService))->mapMultiple( array(r\expr(array($num))),function ($post,$num){
                            return array(
                                        'data' => $post("data")->filter(array("status_tweet"=> 1))->orderBy(r\desc('created_at'))->limit($num)
                                        );
                        })->run($this->conn);
            
            $s3 = AWS::get('s3');

            foreach ($tweets as $key => $value) {

                $s3->putObject(array(
                                    'ACL'        => Config::get('bucket_twitter.ACL'),
                                    'Bucket'     => Config::get('bucket_twitter.Bucket'),
                                    'contentType' => Config::get('bucket_twitter.contentType'),
                                    'Key'        => Config::get('bucket_twitter.name_bucket').$idService.'.json',
                                    'Body'       => json_encode($value['data'])
                ));
            } 

            return Response::json('Generado');
        }
    }


    public function getPrueba(){


        $client = new Google_Client();
        $client->setApplicationName("youtube");
        $client->setDeveloperKey("AIzaSyDv1IilRqboOEPdALbNNMCalki71xVhxGY");

        $youtube = new Google_Service_YouTube($client);

        $search_channel_name = 'televisadeportes';

        $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
          'forUsername'=> $search_channel_name,
          'part'=>"snippet,contentDetails"
        ));

        $data = [];

        foreach ($channelsResponse['items'] as $channel) {

            $results = $youtube->playlists->listPlaylists('snippet', array(
                'channelId' => $channel['id'],
                'maxResults' => 50
              ));

            foreach ($results['items'] as $result) {
                $data[$result['id']] = $result['snippet']['title'];
            }
        }


        //asort($data);
        natcasesort($data);

        print_r($data);

        #return View::make('salida')->with(array('lists'=>$data));
    }




}
?>
