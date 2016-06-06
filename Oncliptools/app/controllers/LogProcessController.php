<?php

class LogProcessController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function logProcess($vid=0)
	{
            $getfile = Input::get('archivo');
            $file = '/c00nt/vcms/bash/'.$getfile;
          //$file = '/c00nt/vcms/bash/5f5a82c2a6_1421785757.83.log';
            $explodFile = explode('_', $getfile);
            $vod_id = $explodFile[0];
            $UnixTimeId = $explodFile[1];
            $typeFile = explode('.',$explodFile[1]);
            $log = 0;  
            $fileSize = filesize($file);
            
            $LogsIndictedQuery = DB::table('LogsIndicted')
                               ->select('logsFile','size')
                               ->where('logsFile', '=', $getfile)
                               ->get();
            
            if($typeFile[0] != 'full' and $typeFile[0] != 'regenerate'){
                
                if($LogsIndictedQuery != TRUE){

                    $LogsIndictedCreate = DB::table('LogsIndicted')
                                        ->insert(array('logsFile' => $getfile,'size'=>$fileSize));

                    function rLine( $file, $line_number ){
                        /*** read the file into the iterator ***/
                        $file_obj = new SplFileObject( $file );
                        /*** seek to the line number ***/
                        $file_obj->seek( $line_number );
                        /*** return the current line ***/
                        return $file_obj->current();
                    }

                    if (file_exists($file)) {

                        echo '<div style="background-color:white; height:64px; width:100%; color:black; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 18px; font-family: sans-serif; font-weight: bold;"><br> El archivo existe, procesando información ...</div><br>';
                        $fopen = fopen($file,"r");

                        if($fopen){

                            $file_obj = new SplFileObject($file);

                            $findEnd = array();

                            $findStart = array();

                            foreach ($file_obj as $k => $line) {

                                $line_number = ($file_obj->key() + 1);

                                $rl = rLine( $file, $line_number);

                                if(strpos($rl,'[[ S') != false){

                                    //echo '<div style="color:red;"><br> Buscando [[ S :'.$line_number. ': ' . $file_obj->current().'<br><br></div>';

                                    if($line_number >= 1 ){

                                        $rstart = rLine($file, $line_number );
                                        //echo $rstart; 

                                        $explodStart = explode('[[ S', $rstart);
                                        $arrayStart = explode(':',$explodStart[1]);
                                        $unixTimeStart[] = str_replace(']]','',$arrayStart[2]); 


                                    }

                                    if($line_number >= 1 ){

                                        $findStart[] = $line_number + 1;

                                    }

                                }

                                if(strpos($rl,'[[ E') != false){

                                    //echo '<div style="color:red;"><br> Buscando [[ E :'.$line_number. ': ' . $file_obj->current().'<br><br></div>';

                                    $findEnd[] = $line_number;

                                }

                            }



                            foreach ($file_obj as $k => $line) {

                                $line_number = ($file_obj->key() + 1); 
                                $rl = rLine( $file, $line_number);

                                if(strpos($rl,'S') == false || strpos($rl,'E') == false){

                                    $count = count($findEnd);

                                    for($j=0; $j< $count; $j++){

                                        if($line_number == $findStart[$j]){

                                            $total = $findEnd[$j] - $findStart[$j];

                                            for($i=0; $i < $total; $i++){

                                                $rn = rLine( $file, $line_number + $i);

                                                if(strpos($rn,'S') == false && strpos($rn,'E') == false){

                                                    $search = array("'");
                                                    $reg = str_replace($search,"",$rn);

                                                    $log .= $reg.'<br>';  
                                                }

                                            }

                                            echo  $log;

                                            $rend = rLine($file, $findEnd[$j]);
                                            //echo $rend;
                                            $explodEnd = explode('[[ E', $rend);
                                            $arrayEnd  = explode(':',$explodEnd[1]);
                                            $action = $arrayEnd[1]; 

                                            $unixTimeEnd = str_replace(']]','',$arrayEnd[2]);

                                            $deltaUnixTime = str_replace(']]','',$arrayEnd[2]) - $unixTimeStart[$j];

                                            $servername = "laravel-devtim.cjczjvx3sd7d.us-west-1.rds.amazonaws.com";
                                            $username = "laravel";
                                            $password = "Televisa2010..";
                                            $dbname = "vcms2";

                                            $conn = new mysqli($servername, $username, $password, $dbname);

                                            // Check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            } 
                                            echo '<div style="background-color:rgba(0, 128, 0, 0.5); height:18px; width:100%; color:white; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 14px; font-family: sans-serif; font-weight: bold;">'."Conectado con éxito".'<br></div>';

                                            $sql = DB::insert("INSERT INTO LogsProcess (action, vod_id, UnixTimeId, unixTimeStart, log, unixTimeEnd, deltaUnixTime) VALUES ('$action','$vod_id','$UnixTimeId','$unixTimeStart[$j]','$log','$unixTimeEnd','$deltaUnixTime')");
                                            //$sql  = "INSERT INTO log (action,vod_id,unixTimeStart,log,unixTimeEnd) VALUES ('.$action.','.$vod_id.','.$unixTimeStart.','.$log.','.$unixTimeEnd.')";

                                            if ($sql === TRUE) {
                                                echo '<div style="background-color:rgba(0, 128, 0, 0.5); height:18px; width:100%; color:white; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 14px; font-family: sans-serif; font-weight: bold;"> Registro creado correctamente..<br></div>';


                                            } else {
                                                echo "Error: " . $sql . "<br>" . $conn->error;
                                            }

                                            $conn->close(); 

                                            $log = '';
                                            $unixTimeEnd = '';
                                            $unixTimeDelta = '';

                                        }

                                    }

                                }
            //                    
                            }       
                        }else {
                        // error opening the file.
                            echo 'Error para Abrir Archivo';
                        } 

                        fclose($fopen);


                    }else{
                        echo '<p>El archivo No existe ...</p>'.'<br>';
                    }

                    return Redirect::to('/logsTable/'.$vod_id.'/'.$UnixTimeId)->with(array('vod_id' => $vod_id,'UnixTimeId'=>$UnixTimeId));

                }else{

                    $size = $LogsIndictedQuery[0]->size;

                    if($fileSize >= $size ){

                           $LogsIndictedCreate = DB::table('LogsIndicted')
                                                ->update(array('logsFile' => $getfile,'size'=>$fileSize));

                            function rLine( $file, $line_number ){
                                /*** read the file into the iterator ***/
                                $file_obj = new SplFileObject( $file );
                                /*** seek to the line number ***/
                                $file_obj->seek( $line_number );
                                /*** return the current line ***/
                                return $file_obj->current();
                            }

                            if (file_exists($file)) {

                                echo '<div style="background-color:white; height:64px; width:100%; color:black; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 18px; font-family: sans-serif; font-weight: bold;"><br> El archivo existe, procesando información ...</div><br>';
                                $fopen = fopen($file,"r");

                                if($fopen){

                                    $file_obj = new SplFileObject($file);

                                    $findEnd = array();

                                    $findStart = array();

                                    foreach ($file_obj as $k => $line) {

                                        $line_number = ($file_obj->key() + 1);

                                        $rl = rLine( $file, $line_number);

                                        if(strpos($rl,'[[ S') != false){

                                            //echo '<div style="color:red;"><br> Buscando [[ S :'.$line_number. ': ' . $file_obj->current().'<br><br></div>';

                                            if($line_number >= 1 ){

                                                $rstart = rLine($file, $line_number );
                                                //echo $rstart; 

                                                $explodStart = explode('[[ S', $rstart);
                                                $arrayStart = explode(':',$explodStart[1]);
                                                $unixTimeStart[] = str_replace(']]','',$arrayStart[2]); 


                                            }

                                            if($line_number >= 1 ){

                                                $findStart[] = $line_number + 1;

                                            }

                                        }

                                        if(strpos($rl,'[[ E') != false){

                                            //echo '<div style="color:red;"><br> Buscando [[ E :'.$line_number. ': ' . $file_obj->current().'<br><br></div>';

                                            $findEnd[] = $line_number;

                                        }

                                    }



                                    foreach ($file_obj as $k => $line) {

                                        $line_number = ($file_obj->key() + 1); 
                                        $rl = rLine( $file, $line_number);

                                        if(strpos($rl,'S') == false || strpos($rl,'E') == false){

                                            $count = count($findEnd);

                                            for($j=0; $j< $count; $j++){

                                                if($line_number == $findStart[$j]){

                                                    $total = $findEnd[$j] - $findStart[$j];

                                                    for($i=0; $i < $total; $i++){

                                                        $rn = rLine( $file, $line_number + $i);

                                                        if(strpos($rn,'S') == false && strpos($rn,'E') == false){

                                                            $search = array("'");
                                                            $reg = str_replace($search,"",$rn);

                                                            $log .= $reg;  
                                                        }

                                                    }

                                                    echo  $log;

                                                    $rend = rLine($file, $findEnd[$j]);
                                                    //echo $rend;
                                                    $explodEnd = explode('[[ E', $rend);
                                                    $arrayEnd  = explode(':',$explodEnd[1]);
                                                    $action = $arrayEnd[1]; 

                                                    $unixTimeEnd = str_replace(']]','',$arrayEnd[2]);

                                                    $deltaUnixTime = str_replace(']]','',$arrayEnd[2]) - $unixTimeStart[$j];

                                                    $servername = "laravel-devtim.cjczjvx3sd7d.us-west-1.rds.amazonaws.com";
                                                    $username = "laravel";
                                                    $password = "Televisa2010..";
                                                    $dbname = "vcms2";

                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    // Check connection
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    } 
                                                    echo '<div style="background-color:rgba(0, 128, 0, 0.5); height:18px; width:100%; color:white; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 14px; font-family: sans-serif; font-weight: bold;">'."Conectado con éxito".'<br></div>';

                                                    $sql = 'UPDATE LogsProcess SET action $action, vod_id $vod_id, UnixTimeId $UnixTimeId, unixTimeStart $unixTimeStart[$j],log $log,unixTimeEnd $unixTimeEnd, deltaUnixTime $deltaUnixTime,WHERE id = $i;'; 
                                                    //$sql = DB::update("UPDATE  LogsProcess (action, vod_id, unixTimeStart, log, unixTimeEnd, deltaUnixTime) VALUES ('$action','$vod_id','$unixTimeStart[$j]','$log','$unixTimeEnd','$deltaUnixTime')");
                                                    //$sql  = "INSERT INTO log (action,vod_id,unixTimeStart,log,unixTimeEnd) VALUES ('.$action.','.$vod_id.','.$unixTimeStart.','.$log.','.$unixTimeEnd.')";

                                                    if ($sql === TRUE) {
                                                        echo '<div style="background-color:rgba(0, 128, 0, 0.5); height:18px; width:100%; color:white; text-align: center; border: 1px solid black; margin: 5px 0px; font-size: 14px; font-family: sans-serif; font-weight: bold;"> Registro creado correctamente..<br></div>';


                                                    } else {
                                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                                    }

                                                    $conn->close(); 

                                                    $log = '';
                                                    $unixTimeEnd = '';
                                                    $unixTimeDelta = '';

                                                }

                                            }

                                        }
                    //                    
                                    }       
                                }else {
                                // error opening the file.
                                    echo 'Error para Abrir Archivo';
                                } 

                                fclose($fopen);


                            }else{
                                echo '<p>El archivo No existe ...</p>'.'<br>';
                            }

                            return Redirect::to('/logsTable/'.$vod_id.'/'.$UnixTimeId)->with(array('vod_id' => $vod_id,'UnixTimeId'=>$UnixTimeId));                    


                    }else{

                        $msg = '<div class="error">' . 'Archivo' . '</div>';

                        return Redirect::back()->with(array('msg' => $msg));
                    //return Redirect::back()->with('msg', 'The Message');  
                    }

                }                
            } 
            
            if($typeFile[0] == 'full' || $typeFile[0] == 'regenerate'){
                
                function rLine( $file, $line_number ){
                    /*** read the file into the iterator ***/
                    $file_obj = new SplFileObject( $file );
                    /*** seek to the line number ***/
                    $file_obj->seek( $line_number );
                    /*** return the current line ***/
                    return $file_obj->current();
                }
                
                if (file_exists($file)) {

                        $fopen = fopen($file,"r");

                        if($fopen){
                            
                            $file_obj = new SplFileObject($file);
                            
                            return View::make('phpLog.typeFile',array('file_obj'=>$file_obj,'vid' => $vid));
   
                        }
                        
                }          
                
            }

	}

}
