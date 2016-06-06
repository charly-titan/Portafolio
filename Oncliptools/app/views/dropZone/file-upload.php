<?php

//if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $tmp = $_FILES['file']['tmp_name'];
    $ext = getExtension($name);
    
    $bucket = 'communities-dev';
    //$contentType = $_FILES["upload_file"]["name"];
    $contentType = 'image/jpg';
    //$key = "/escaleta/fotos/bk_pleca.png";
    $key = "/escaleta/fotos/".basename($name);
    //$localImage = "/escaleta/fotos/imagen.jpg";
    
//    $file_upload = fopen(Config::get('escaleta.folder_fotos').basename($name), 'x');
//    fwrite($file_upload);
//    fclose($file_upload); 
    
    
    $path = Config::get('escaleta.folder_fotos');
    $filename = $path.basename($name);
    $filenameWritten = File::put($filename);

    $s3 = AWS::get('s3');

    $s3->putObject(array(
                'Bucket'          =>  $bucket,
                'ContentType'     =>  $contentType,
                'Key'             =>  $key,
                'ACL'             =>  'public-read',
//                'SourceFile'    =>  Config::get('dropzone.folder_img') . basename($name),
                'Body'            =>  Config::get('escaleta.folder_fotos').basename($name),
                //'Body'            =>  '/img/bk_pleca.png',
//                'ContentEncoding' =>  'base64',
//                'Content-Length'  =>  '11033',
//                'Content-Width'  =>  1106,
//                'Content-Height' =>  82,
//                'CacheControl'  =>  'max-age=172800',
//                "Expires"       =>  gmdate("D, d M Y H:i:s T", strtotime("+5 years")),
//                'Metadata'      =>  array(
//                'profile'       =>  $localImage,
//                ),
            ));

//    $bucket = 'communities-dev';
//    //$contentType = $_FILES["upload_file"]["name"];
//    $contentType = 'image/jpeg';
//    $key = "/escaleta/fotos/imagen.jpg";
//    $localImage = "/escaleta/fotos/imagen.jpg";
//
//    $s3 = AWS::get('s3');
//
//    $s3->putObject(array(
//                'Bucket'        =>  $bucket,
//                'ContentType'   =>  $contentType,
//                'Key'           =>  $key,
//                'ACL'           =>  'public-read',
////                'SourceFile'    =>  Config::get('dropzone.folder_img') . basename($name),
//                //'Body'          =>  Config::get('escaleta.folder_fotos') . basename($name),
//                'Body'          =>  '/img/imagen.jpg',
////                'CacheControl'  =>  'max-age=172800',
////                "Expires"       =>  gmdate("D, d M Y H:i:s T", strtotime("+5 years")),
////                'Metadata'      =>  array(
////                'profile'       =>  $localImage,
////                ),
//            )); 
//}  





//$data[] = array(
//            "Tipo de Archivo" => 'Imagen JPEG(.jpg)',
//            "url" => 'http://noticieros.televisa.com/programas-primero-noticias/#escaleta',
//            "Tamaño" => '499 KB(511,490 bytes)',
//            "serverDate" => 20141223,
//            "idChannel" => 1
//        );

//for ($i = 0; $i < count($data); $i++) {
//    $data_json.= "dropZone.customDataImg(" . json_encode($data[$i]) . ");";
//}
//        
//$file_upload = fopen(Config::get('dropZone.folder_img') . basename($_FILES['file']['name']), 'x');
//fwrite($file_upload, $data_json);
//fclose($file_upload);
//
//$s3 = AWS::get('s3');
//
//$s3->putObject(array(
//    'ACL' => 'public-read-write',
//    'Bucket' => 'communities-dev',
//    'Key' => "/dropZone/img/".basename($_FILES['file']['name']),
//    'SourceFile' => Config::get('dropZone.folder_img') . basename($_FILES['file']['name'])
//));




// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

//$uploaddir = '/c00nt/www/oncliptools/app/config/test';

//$s3 = AWS::get('s3');
//
//$s3->putObject(array(
//   'ACL'        => 'public-read',
//   'Bucket'     => 'communities-dev',
//   'Key'        => "/escaleta/json/".$vars['cl']."_".date('Ymd').".js",
//   'SourceFile' => Config::get('escaleta.folder_json').$vars['cl']."_".date('Ymd').".js"
//));

//$path = Config::get('vcms.folder_time_offset').'/';

//$uploadfile = $path . basename($_FILES['file']['name']);

//echo '<pre>';
//
//if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
//    
//    echo "File is valid, and was successfully uploaded.\n";
//    
//} else {
//    
//    echo "Possible file upload attack!\n";
//    
//}
//
//echo 'Here is some more debugging info:';
//
//print_r($_FILES);
//
//print "</pre>";
    
//----------------------------------------------------
   
    $bucket = 'communities-dev';
    //$contentType = $_FILES["upload_file"]["name"];
    $contentType = 'image/png';
    $key = "/escaleta/fotos/bk_pleca.png";
    //$localImage = "/escaleta/fotos/imagen.jpg";

    $s3 = AWS::get('s3');

    $s3->putObject(array(
                'Bucket'          =>  $bucket,
                'ContentType'     =>  $contentType,
                'Key'             =>  $key,
                'ACL'             =>  'public-read',
//                'SourceFile'    =>  Config::get('dropzone.folder_img') . basename($name),
                //'Body'          =>  Config::get('escaleta.folder_fotos') . basename($name),
                'Body'            =>  '/img/bk_pleca.png',
                'ContentEncoding' =>  'base64',
                'Content-Length'  =>  '11033',
//                'Content-Width'  =>  1106,
//                'Content-Height' =>  82,
//                'CacheControl'  =>  'max-age=172800',
//                "Expires"       =>  gmdate("D, d M Y H:i:s T", strtotime("+5 years")),
//                'Metadata'      =>  array(
//                'profile'       =>  $localImage,
//                ),
            ));    