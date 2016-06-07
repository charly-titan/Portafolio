<?php

session_start();

class CommentsController extends \BaseController {

	public $max=20;
		
	public function __construct(){
        parent::__construct();

        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
        
    }

	public function getIndex(){

		Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
		
		$user = Sentry::getUser();
		
		if($user->hasAccess('promo.list')){
			return View::make(Config::get( 'app.main_template' ).'.comments.urlForm');
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento listar los concursos sin tener los permisos necesarios');
            App::abort(401);
		}
	}

	public function getSite(){

		Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
		
		$user = Sentry::getUser();
		
		if($user->hasAccess('promo.list')){
			return View::make(Config::get( 'app.main_template' ).'.comments.urlFormSite');
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento listar los concursos sin tener los permisos necesarios');
            App::abort(401);
		}
	
	}

	public function postShowcomments(){
				
		$offset=0;
		$page=0;
				
		$url=trim(Input::get('url'));
		$_SESSION["url"]=$url;
		$_SESSION["is_site"]=false;
		$nota_guid=md5($url);
		$channel=$this->getChannel($_SESSION["url"]);
				
		$r1=$this->getNotesComments($channel,$nota_guid, $offset);
		
		$sons=$this->getNested($r1,$channel);
				
		return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons ));
		
	}

	public function postShowcommentssite(){
		
		$offset=0;
		$page=0;
		
		$url=trim(Input::get('url'));
		$_SESSION["url"]=$url;
		$_SESSION["is_site"]=true;
		$nota_guid=md5($url);
		$channel=$this->getChannel($_SESSION["url"]);
		
		$r1=$this->getSiteComments($_SESSION["url"],$channel,$offset);
		
		$sons=$this->getNested($r1,$channel);

		return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons, 'is_site'=>1 ));
	
	}

	public function getShowcomments(){
			
		{{{ $is_site=Input::get('is_site') or $is_site=0; }}}
		{{{ $page=Input::get('page') or $page=0; }}}
		{{{ $offset=Input::get('page')*$this->max or $offset=0; }}}
		
		$nota_guid=trim(Input::get('nota_guid'));
		$channel=trim(Input::get('channel'));
		
		if($_SESSION["is_site"]){
			$r1=$this->getSiteComments($_SESSION["url"], $channel, $offset );	
			$sons=$this->getNested($r1,$channel,$nota_guid);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons, 'is_site'=>1 ));	
		}else{
			$r1=$this->getNotesComments($channel, $nota_guid, $offset);
			$sons=$this->getNested($r1,$channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons ));
		}
		
	}

	public function getDetail(){
		
		$r2=DB::connection('comments')->select('select comment_txt, nota_guid, tx.comment_guid from '.Input::get('channel').' t, '.Input::get('channel').'_txt tx  where nota_guid=\''.Input::get('nota_guid').'\' and t.comment_guid=\''.Input::get('comment_guid').'\' and  t.comment_guid=tx.comment_guid order by comment_timestamp desc');

		Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
		
		$user = Sentry::getUser();
		
		if($user->hasAccess('promo.list')){
			return View::make(Config::get( 'app.main_template' ).'.comments/detail')->with(array('data'=>$r2, 'channel'=>Input::get('channel')));
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento listar los concursos sin tener los permisos necesarios');
            App::abort(401);
		}
	}

	public function getDelate(){
		
		$offset=0;
		$page=0;
		
		$channel=trim(Input::get('channel'));
		$comment_guid=trim(Input::get('comment_guid'));
		$comment=trim(Input::get('comment'));
		$nota_guid=trim(Input::get('nota_guid'));
			
		
		$r1=DB::connection('comments')->select('select comment_id, parent_id, level_num from '.$channel.' where comment_guid=\''.$comment_guid.'\' ');
		if (isset($r1[0]->parent_id) && $r1[0]->parent_id==0  ){

			$r2=DB::connection('comments')->select('select comment_guid from '.$channel.' where comment_id=\''.$r1[0]->parent_id.'\' ');
			
			foreach ($r2 as $tmp ){
				DB::connection('comments')->table($channel)->where('comment_guid',$tmp->comment_guid )->delete();
				DB::connection('comments')->table($channel."_txt")->where('comment_guid',$tmp->comment_guid)->delete();
			}

		}
		DB::connection('comments')->table($channel)->where('comment_guid',$comment_guid )->delete();
		DB::connection('comments')->table($channel."_txt")->where('comment_guid',$comment_guid)->delete();

		
		if($_SESSION["is_site"]){
			$r1=$this->getSiteComments($_SESSION["url"], $channel, $offset );	
			$sons=$this->getNested($r1, $channel, $nota_guid);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons, 'is_site'=>1 ));	
		}else{
			$r1=$this->getNotesComments($channel, $nota_guid, $offset);
			$sons=$this->getNested($r1,$channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons ));
		}
		
	}

	public function postSave(){
		
		$offset=0;
		$page=0;
		$channel=trim(Input::get('channel'));
		$comment_guid=trim(Input::get('comment_guid'));
		$comment=trim(Input::get('comment'));
		$nota_guid=trim(Input::get('nota_guid'));
		

		DB::connection('comments')->select('update  '.$channel.'_txt set comment_txt=\''.$comment.'\' where comment_guid=\''.$comment_guid.'\'');
		
		if($_SESSION["is_site"]){
			$r1=$this->getSiteComments($_SESSION["url"], $channel, $offset );	
			$sons=$this->getNested($r1, $channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons, 'is_site'=>1 ));	
		}else{
			$r1=$this->getNotesComments($channel, $nota_guid, $offset);
			$sons=$this->getNested($r1, $channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons ));
		}
		
	}

	public function getAnswer(){
		
		$r1=DB::connection('comments')->select('select comment_id, comment_txt, nota_guid, tx.comment_guid from '.Input::get('channel').' t, '.Input::get('channel').'_txt tx  where nota_guid=\''.Input::get('nota_guid').'\' and t.comment_guid=\''.Input::get('comment_guid').'\' and  t.comment_guid=tx.comment_guid');

		$r2=DB::connection('comments')->select('select name, email from comments_admin_users');

		$admins=array();
		foreach ($r2 as $tmp){
			$admins[$tmp->name]=$tmp->name;
		}

		Session::forget('SesionID');Session::forget('privacyPolicy');Session::forget('tos');Session::forget('contestRules');
		
		$user = Sentry::getUser();
		
		if($user->hasAccess('promo.list')){
			return View::make(Config::get( 'app.main_template' ).'.comments/answer')->with(array('data'=>$r1, 'channel'=>Input::get('channel'), 'admins'=>$admins));
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento listar los concursos sin tener los permisos necesarios');
            App::abort(401);
		}
	}

	public function postSaveanswer(){
		
		$offset=0;
		$page=0;
		
		$channel=trim(Input::get('channel'));
		$comment_id=trim(Input::get('comment_id'));
		$comment=trim(Input::get('comment'));
		$autor=trim(Input::get('autor'));
		$nota_guid=trim(Input::get('nota_guid'));
		$comment_guid=$this->generateGUID();
				
		$r0=DB::connection('comments')->select('select email from comments_admin_users where name=\''.$autor.'\'');
					
		DB::connection('comments')->table($channel)->insert(
    		array(	'nota_guid' => $nota_guid, 
    				'creation_date' => date("Y-m-d"),
    				'comment_timestamp' => time(),
    				'parent_id' => $comment_id,
    				'child_num' => 0,
    				'level_num' => 1,
    				'autor' => $autor,
    				'email' => $r0[0]->email,
    				'user_registered' => 0,
    				'positive_votes' => 0,
    				'negative_votes' => 0,
    				'comment_status' => 3,
    				'comment_guid' =>$comment_guid,
    				'notify' => 1
    		)
		);
		
		DB::connection('comments')->table($channel."_txt")->insert(
    		array(	'comment_guid' =>$comment_guid ,
    				'comment_txt' => $comment
    		)
		);
			
		if($_SESSION["is_site"]){
			$r1=$this->getSiteComments($_SESSION["url"], $channel, $offset );	
			$sons=$this->getNested($r1, $channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons, 'is_site'=>1 ));	
		}else{
			$r1=$this->getNotesComments($channel, $nota_guid, $offset);
			$sons=$this->getNested($r1, $channel);
			return View::make(Config::get( 'app.main_template' ).'.comments/show')->with(array('nota_guid'=>$nota_guid, 'data'=>$r1,'channel'=>$channel, 'page'=>$page, 'sons'=>$sons ));
		}
		
	}

	public function generateGUID(){
		$b	=	"";
		for($i=0;$i<3;$i++){
			$b .= (int)rand(0,0xff);
		}
		$result	=	DB::connection('comments')->select("Select UNIX_TIMESTAMP() as ut");
		return	$result[0]->ut.$b;
	}

	private function getSummaryTables($url){
		
		$url = str_replace("http://","",$url);
		$url = str_replace("https://","",$url);
		$url_before=$url;
		$url = explode("/",$url);
		$tmp["domain"] = $url[0];
		$tmp["domain_key"] = explode(".",$url[0]);
		
		if(count($tmp["domain_key"])==2)
			$tmp["domain_key"] = $tmp["domain_key"][0];
		else
			$tmp["domain_key"] = $tmp["domain_key"][1];
		
		$tmp["domain_key"] = str_replace("-","_",$tmp["domain_key"]);
		$tmp["domain_key"] = str_replace(" ","_",$tmp["domain_key"]);
		if(strpos(" ".$url_before,"/ipad")>0){
			$tmp["domain_key"].="_ipad";
		}
		if(strpos(" ".$url_before,"/iphone")>0){
			$tmp["domain_key"].="_iphone";
		}
		if(strpos(" ".$url_before,"/fotos/")>0){
			$tmp["domain_key"].="_fotos";
		}
		if(strpos(" ".$url_before,"/entretenimiento/")>0){
			if($tmp["domain_key"]=="esmas"){
				$tmp["domain_key"].="_entretenimiento";
			}
		}
		if(strpos(" ".$url_before,"/espectaculos/")>0){
			if($tmp["domain_key"]=="esmas"){
				$tmp["domain_key"].="_entretenimiento";
			}
		}
		if(strpos(" ".$url_before,"/noticierostelevisa")>0){
			$tmp["domain_key"].="_noticierostelevisa";
		}
		if(strpos(" ".$url_before,"/usa")>0){
			$tmp["domain_key"].="_usa";
		}
		if(strpos(" ".$url_before,"noticierostelevisa.esmas.com")>0){
			$tmp["domain_key"]="esmas_noticierostelevisa";
		}
		if(strpos(" ".$url_before,"noticieros.televisa.com")>0){
			if(strpos(" ".$url_before,"/fotos/")>0){
				$tmp["domain_key"]="noticieros2_fotos";
			}else{
				$tmp["domain_key"]="noticieros2";
			}

		}
		if(strpos(" ".$url_before,"/video/")>0){
			$tmp["domain_key"].="_video";
		}
		if($tmp["domain_key"]=="coca_cola"){
			$tmp["domain_key"].="_video";
		}
		
		if(strpos(" ".$url_before,"ninos.televisa.com")>0){
			$tmp["domain_key"]="ninos";
		}
		
		return $tmp["domain_key"];

	}

	private function getChannel($url){

		$url=trim($url);
		$tmp=explode("/", $url);
		
		if(isset($tmp[3]) && $tmp[3]!="" ){
			return $tmp[3];
		}else{
			return "notas_home";
		}
	}

	private function getUrl($url){

		$url=trim($url);
		$tmp=explode("/", $url);
		
		if(isset($tmp[4])){
			//return $tmp[4];
			return $tmp[0].'/'.$tmp[1].'/'.$tmp[2].'/'.$tmp[3].'/'.$tmp[4];
		}elseif(isset($tmp[3])) {
			//return $tmp[3];
			return $tmp[0].'/'.$tmp[1].'/'.$tmp[2].'/'.$tmp[3];
		}elseif(isset($tmp[2])) {
			//return $tmp[3];
			return $tmp[0].'/'.$tmp[1].'/'.$tmp[2].'/';
		}
	}

	private function getNested($father, $channel ){

		$sons=array();

		foreach ($father as $tmp){
			
				$j=0;
				$r1=DB::connection('comments')->select('select creation_date, autor, email, comment_txt, nota_guid, tx.comment_guid from '.$channel.' t, '.$channel.'_txt tx  where  parent_id='.$tmp->comment_id.' and t.comment_guid=tx.comment_guid order by comment_timestamp desc limit 5');		
				foreach ($r1 as $tmp2){
					$sons[$tmp->comment_id][$j]["creation_date"]=$tmp2->creation_date;
					$sons[$tmp->comment_id][$j]["autor"]=$tmp2->autor;
					$sons[$tmp->comment_id][$j]["email"]=$tmp2->email;
					$sons[$tmp->comment_id][$j]["comment_txt"]=$tmp2->comment_txt;
					$sons[$tmp->comment_id][$j]["nota_guid"]=$tmp2->nota_guid;
					$sons[$tmp->comment_id][$j]["comment_guid"]=$tmp2->comment_guid;
					$j++;
				}
			
			//echo $tmp1->parent_id;
		}

		return $sons;

	}

	private function getNotesComments($channel, $nota_guid, $offset ){
		return DB::connection('comments')->select('select comment_id, creation_date, autor, email, comment_txt, nota_guid, tx.comment_guid, parent_id, comment_id from '.$channel.' t, '.$channel.'_txt tx  where nota_guid=\''.$nota_guid.'\' and parent_id=0 and t.comment_guid=tx.comment_guid order by comment_timestamp desc limit '.$offset.','.$this->max);
	}

	private function getSiteComments($url,$channel,$offset){
		
		$summary=$this->getSummaryTables($url);
		//$site=$this->getUrl($url);
		/*
		echo 'select comment_id, s.creation_date, autor, email, comment_txt, nota_guid, tx.comment_guid, parent_id, comment_id 
			from views.summary_'.$summary.' s, comments.'.$channel.' t, comments.'.$channel.'_txt tx 
			where s.comments>0 and object_url like \''.$url.'%\' and s.object_id=t.nota_guid and t.parent_id=0 and t.comment_guid=tx.comment_guid order by t.creation_date desc limit '.$offset.','.$this->max;
		*/
		return DB::connection('comments')->select('select comment_id, s.creation_date, autor, email, comment_txt, nota_guid, tx.comment_guid, parent_id, comment_id 
			from views.summary_'.$summary.' s, comments.'.$channel.' t, comments.'.$channel.'_txt tx 
			where s.comments>0 and object_url like \''.$url.'%\' and s.object_id=t.nota_guid and t.parent_id=0 and t.comment_guid=tx.comment_guid order by t.creation_date desc limit '.$offset.','.$this->max);
	
	}

}
