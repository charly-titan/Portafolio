<?php

// Load the driver
require_once(base_path()."/vendor/php-rql/rdb/rdb.php");

class escaletaController extends \BaseController {

	protected $conn;

	public function __construct(){
        parent::__construct();
        //$this->beforeFilter('auth');
        //$this->beforeFilter('csrf', array('on' => 'post'));    
    }

    protected function connect_db(){
    	if(is_null($this->conn)){
    		$this->conn 	=	 r\connect('localhost');
    	}
		return 1;
    }

    public function getIndex(){
    	$programs = $this->readPrograms();
    	return View::make(Config::get( 'app.main_template' ).'.escaleta.programs')->with("programs",$programs);
    }

    public function getEdit($program_id){
    	$this->readProgramInfo($program_id);
    	return $this->readProgramInfo($program_id);
    }

    protected function readPrograms(){
		$this->connect_db();
		$result = r\db("escaleta")->table("programs")->withFields(array('program_name', 'program_id', 'information_schedule','broadcast_schedule','id'))->run($this->conn);
		return $result;
    }

     protected function readProgramInfo($program_id){

		$this->connect_db();
		$result = r\db("escaleta")->table("programs")->get($program_id)->run($this->conn);
		return $result;
    }



 }