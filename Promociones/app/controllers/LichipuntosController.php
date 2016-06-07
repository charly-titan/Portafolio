<?php

include_once(base_path().'/vendor/gigya/GSSDK.php'); 

class LichipuntosController  extends BaseController {

	public function __construct(){
    }

    public function getValida(){
        $apiKey = "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF";
        $secretKey = "QONNYe+U07oGe0HfoPWgoDQrj4PLlJlWq9XdkkcOilM=";
         
        // Step 1 - Defining the request
        $method = "gm.notifyAction";
        //$method = "gm.getActionsLog";
        $request = new GSRequest($apiKey,$secretKey,$method);
         

        $actions=array("CapNovAMQL","ResCapAMQL","CorEnam","ExpSec","DosEnc","Gumarada","Elsa","DetrasCam","AvanceFoto","ResSemFoto");
        $points=array("250","100","250","100","100","100","100","100","100","100");

        if(!isset($_GET["action"]) or !isset($_GET["url"]) or !isset($_GET["embed"]) or !isset($_GET["uid"])){
            exit("/* Puntos no acumulados */");
        }

        if(!in_array($_GET["action"], $actions)){
            exit("/* Puntos no acumulados */");
        }

        if (!strlen($_GET["embed"]) or $_GET["embed"]=="undefined") { 
            exit("/* Puntos no acumulados */");
        }

        $embed=$_GET["embed"];
        $posId = strpos($embed, 'id=');
        $registro=null;
        $videoId=0;
        if ($posId === false) {
            $registro= Lichipuntos::where('uid',$_GET["uid"])
                              ->where('action',$_GET["action"])
                              ->where('url',$_GET["url"])
                              ->get();
        }else{
            $videoId = substr($embed, $posId+3, 6); 
            $registro= Lichipuntos::where('uid',$_GET["uid"])
                              ->where('action',$_GET["action"])
                              ->where('video_id',$videoId)
                              ->get();
        }

        if(is_null($registro) or !count($registro)){

            // Step 2 - Adding parameters
            $request->setParam("uid", $_GET["uid"]);  // set the "uid" parameter to user's ID
            $request->setParam("action", $_GET["action"]);  // set the "status" parameter to "I feel great"
             

            // CapNovAMQL
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/capitulos/
            // 250

            // ResCapAMQL
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/capitulos/2015-09-01/
            // 100

            // CorEnam
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/corazon-enamorado/
            // 250

            // ExpSec
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/expedientes-secretos/
            // 100

            // DosEnc
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/doslados-Encontrados/
            // 100

            // Gumarada
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/gumaradas/
            // 100


            // Elsa
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/tutoriales/
            // 100

            // DetrasCam
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/detras-de-camaras/
            // 100

            // AvanceFoto
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/fotos/especiales/


            // ResSemFoto
            // http://television.televisa.com/telenovelas/antes-muerta-que-lichita/fotos/resumen-semanal/
            //    


            // Step 3 - Sending the request
            $response = $request->send();
             

             //var_dump($response);
            // Step 4 - handling the request's response.
            if($response->getErrorCode()==0)             
            {    // SUCCESS! response status = OK  
                $lichipuntos        = new Lichipuntos;
                $lichipuntos->uid   = $_GET["uid"];
                $lichipuntos->action= $_GET["action"];
                $lichipuntos->url   = $_GET["url"];
                $lichipuntos->embed = $_GET["embed"];
                $lichipuntos->video_id= $videoId;
                $lichipuntos->save();   

                echo "/*Success in setStatus operation.*/"; 

                $clave = array_search($_GET["action"], $actions); 
                $puntos= $points[$clave];

                // if($_GET["action"]=="CapNovAMQL" or  $_GET["action"]=="CorEnam"){
                //    $points=250;
                // }else{
                //    $points=100;
                // }
                echo ("try{ lichiPuntosGigya.notifyPoints({'status':'OK','points':".$puntos."}); }catch(e){  }");
            }
            else       
            {  // Error
                echo ("/* Got error on setStatus: " . $response->getErrorMessage()."*/");
                echo ("try{ lichiPuntosGigya.notifyPoints({'status':'ERROR'}); }catch(e){  }");
                error_log($response->getLog());
                try{
                    $texto=$this->s3Read("/amqlichipuntos_err/error.txt");
                    $this->S3Write("/amqlichipuntos_err/error.txt",$texto.$response->getLog()."\n".$response->getErrorMessage()."\n".json_encode($_GET)."\n\n\n\n\n");
                }catch (Exception $e) {

                }
            }




            try{
                $texto=$this->s3Read("/amqlichipuntos/".$_GET["uid"]);
                $this->S3Write("/amqlichipuntos/".$_GET["uid"],$texto.json_encode($_GET)."\n");
            }catch (Exception $e) {

            }

        }else{
            echo("/* Puntos ya acumulados */");
        }
    }



    private function s3Read($key){
        try {
            $s3 = AWS::get('s3');
            $result = $s3->getObject(array(
                'Bucket'        => 'communities-dev',
                'Key'           => $key
            ));   
            return "".$result['Body'];           
        } catch (Exception $e) {
            return "";
        }
    }

    private function s3Write($key, $text){
        try {
            $s3 = AWS::get('s3');
            $result = $s3->putObject(array(
                'Bucket'    => 'communities-dev',
                'Key'       => $key,
                'Body'      =>  $text
            ));   
            return 1;
        } catch (Exception $e) {
            return "";
        }
    }

    
}