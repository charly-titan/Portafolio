<?php
require_once(base_path()."/vendor/php-rql/rdb/rdb.php");

$data = [];

if (isset ($_GET['hub_challenge'])){
    echo  $_GET['hub_challenge'];
}


try {

	$my_string = file_get_contents('php://input');
	$data_content = json_decode($my_string);

	$data['GET'] = json_encode($_GET);
	$data['POST'] = json_encode($_POST);
	$data['file_content'] = json_encode($data_content);	


    try {

    	if(count($data_content)){

    		$conn  =  r\connect( Config::get('rethinkdb.server_db_ip') );
	        $db = r\db( Config::get('rethinkdb.name_db') );

	        try {
	           	$db->table( Config::get('rethinkdb.table_instagram') )->filter( array('id_user'=>$data_content->object_id) )->update( array('status_upd'=>1) )->run($conn);
	        } catch (Exception $e) {
	           	echo "Message: ".$e->getMessage();
	        }
    	}

        
    } catch (Exception $e) {
        echo 'Message: '.$e->getMessage();
    }

	$file = storage_path()."/subscription_instagram.js";

	File::put($file,json_encode($data));
	                                                           

	$s3 = AWS::get('s3');

	$result = $s3->putObject(array(
	    'ACL'        => 'public-read',
	    'Bucket'     => 'communities-dev',
	    'Key'        => "/instagram/subscription_instagram.js",
	    'SourceFile' =>  $file
	));

} catch (Exception $e) {
	echo 'Message: ' .$e->getMessage();
}


?>