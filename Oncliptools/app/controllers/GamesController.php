<?php

class GamesController extends BaseController {

    
    public function getIndex() {
        $teems = Equipos::all();
        return View::make('games.new')->with('teems', $teems);
    }

    public function createGame() {
        if (Sentry::check()){
            if(isset($_POST["teem_local"])&&($_POST["teem_local"]!="")&&isset($_POST["teem_visit"])&&($_POST["teem_visit"]!="")&&isset($_POST["date_game"])&&($_POST["date_game"]!="")){
                
                $game                    =   new Partidos;
                $game->equipo_local      =   $_POST["teem_local"];
                $game->equipo_visitante  =   $_POST["teem_visit"];
                $game->fecha_partido     =   $_POST["date_game"];
                $game->hora_partido      =   $_POST["time_game"];
                $game->save();
                return Redirect::to('v2');
                
            }
            return App::abort(404);
        }else{
            return  Redirect::to('login');
        }
    }

    public function golesGame() {
        if (Sentry::check()){
            if(isset($_POST["partido"])&&($_POST["partido"]!="")){
                //$timezone = Config::get('app.timezone');
                date_default_timezone_set('America/Mexico_City');
                $info_goles=[];
                $goles = Goles::where('id_partido', '=', $_POST["partido"])->get();
                if(count($goles)>0){
                    foreach($goles as $gol){
                            
                            $equipo     = Equipos::where('id', '=', $gol->id_equipo)->get()->first();
                            $parametros = json_decode($gol->parametros);
                            $time_gol   = date("Y-m-d H:i:s",$parametros->param2);
                            
                            $info = array(
                                'id' => $gol->id,
                                'equipo' => $equipo->nombre,
                                'time'   => $time_gol
                             );

                            $info_goles[]=$info;
                    }
                }
                return Response::json(array('info_goles' => $info_goles));
            }       
        }
    }

    public function deleteGol(){
        if (Sentry::check()){
            if(isset($_POST["id_gol"])&&($_POST["id_gol"]!="")){
                $gol = Goles::where('id', '=', $_POST["id_gol"])->get()->first();
                if(count($gol)>0){  
                    $parametros = json_decode($gol->parametros);
                    $parametros->accion="delete";
                    $url = "http://54.183.187.23:8080/videoPlayer.php";
                    $fields_string ='';
                    foreach($parametros as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
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
                   
                    
                    $gol->delete();

                    return $fields_string;
                }
            }       
        }
        
        
        
    }


   
}
?>