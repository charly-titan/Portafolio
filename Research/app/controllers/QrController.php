
<?php

include(base_path().'/vendor/phpqrcode/qrlib.php'); 


class QrController extends BaseController {

public function getTest(){

    //Flickering::handshake($apiKey, $apiSecret)
    Flickering::handshake();  
    $user = Flickering::getUser();
    var_dump($user);
    //return Flickering::getOpauth();
    // Get OAuth token
    // $user->getKey()

    // // Get Flickr's UID of the person
    // $user->getUid()

    // // Get an array of basic informations on the person
    // $user->getInformations()

    // // Get the whole schebang : photos, photosets, friends, and other informations made public by the user
    // $user->getPerson()

//$method = Flickering::peopleGetPhotos('135436199@N02');
// $method = Flickering::callMethod('people.getPhotos', array('user_id' => '135436199@N02'));

// $results = $method->getResults('photos');

    $results = Flickering::getResultsOf('people.getPhotos', array('user_id' => '135436199@N02'));
var_dump($results);

}

public function getGenerateCodes(){
    set_time_limit(300);
    $qrcodes=Qrcodes::all();
    $environment = App::environment();
    if($environment=='production'){
        $environment="final";
    }

    $s3 = AWS::get('s3');

        if(!file_exists(storage_path()."/qrcodes/".$environment."/")){
            File::makeDirectory(storage_path()."/qrcodes/".$environment."/", $mode = 0777, true, true);
        }
        if(!file_exists(storage_path()."/qrcodes/cache/")){
            File::makeDirectory(storage_path()."/qrcodes/cache/", $mode = 0777, true, true);
        }
    foreach($qrcodes as $qrcode){

        $codeContents = str_replace('research', 'promociones', url('ventas/iab/'.$qrcode->keyword, $parameters = array(), $secure = true));
        
        // // we need to generate filename somehow,  
        // // with md5 or with database ID used to obtains $codeContents... 
        $fileName = $qrcode->keyword.'.png'; 
         
        $pngAbsoluteFilePath = storage_path()."/qrcodes/".$environment."/".$fileName; 
        //echo $pngAbsoluteFilePath;
        $urlRelativeFilePath = "https://communities-dev.s3.amazonaws.com/ventas/iab/qrcodes/".$environment."/".$fileName; 
        
        // // generating 
        if (!file_exists($pngAbsoluteFilePath)) { 
            QRcode::png($codeContents, $pngAbsoluteFilePath); 
            
        //     echo 'File generated!'; 
        //     echo '<hr />';

             //exit();

        $result = $s3->putObject(array(
                    'Bucket'        =>  'communities-dev',
                    'Key'           =>  "/ventas/iab/qrcodes/".$environment."/".$fileName,
                    'ACL'           =>  'public-read',
                    'ContentType'   => 'image/png',
                    'Body'          =>  fopen($pngAbsoluteFilePath, 'r+')
                ));

        $urlRelativeFilePath = $result['ObjectURL'];
        

        //$arrayImg= array($typeImg=>$url); 
         } else { 
        //     echo 'File already generated! We can use this cached file to speed up site on common codes!'; 
        //     echo '<hr />'; 
         } 
         
        // echo 'Server PNG File: '.$pngAbsoluteFilePath; 
        // echo '<hr />'; 
         
        // // displaying 
         //echo '<img src="'.$urlRelativeFilePath.'" />'; 
    }// print_r($qrcodes);
    return "Codigos Generados";
}

public function getIndex(){
	
	$qrcodes=Qrcodes::all();
	$environment = App::environment();
	if($environment=='production'){
		$environment="final";
	}
	

	return View::make('quiz.qrcode.qrprint')->with(array("qrcodes"=>$qrcodes,"environment"=>$environment));
}


}