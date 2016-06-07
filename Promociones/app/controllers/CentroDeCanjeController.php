<?php

include_once(base_path().'/vendor/gigya/GSSDK.php'); 

class CentroDeCanjeController  extends BaseController {

    protected $apiKey;
    protected $secretKey;

	public function __construct(){
        $this->apiKey = "3_9GZetLmP80BrYioan9m5WOwV477jj1OVm7GXHPIl_JiK9GDuZ_XMhqq5qJHua7tF";
        $this->secretKey = "QONNYe+U07oGe0HfoPWgoDQrj4PLlJlWq9XdkkcOilM=";
    }

    public function getPremios(){
        
        if( !isset($_GET["sitio"]) or !strlen($_GET["sitio"]) ){
            exit("/* Accion no ejecutada */");
        }

        $premios= Premios::select('id as beneficio','nombre','descripcion','nombre_puntos','valor','img','stock')
                        ->where('sitio',$_GET["sitio"])
                        ->where('stock',">",0)
                        ->get();
        
        if(is_null($premios) or !count($premios)){
            exit("/* Sin premios */");
        }
        
        echo ("try{ changecenter.premios(".$premios."); }catch(e){  }");    
        //return $premios;
        
    }

    public function getCanje(){
        
        if(!isset($_GET["sitio"]) or !isset($_GET["beneficio"]) or !isset($_GET["uid"])){
            exit("/* Accion no ejecutada */");
        }

        /*Verifica que el usuario exista y tenga email*/
        if(!$this->validaUser($_GET["uid"])){
            //No se cuenta con toda la info del usuario
            echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 105}); }catch(e){  }');
            return;

        }

        /*Verifica que el premio existe */
        $premio= Premios::where('id',$_GET["beneficio"])
                        ->where('sitio',$_GET["sitio"])
                        ->first();
        if(is_null($premio) or !count($premio)){
            //exit("/* No existe el beneficio */");
            //beneficio no disponible
            echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 102}); }catch(e){  }');
            return;

        }

        /*Premios de ese tipo asignados */
        $asignados= PremiosLog::where('premio_id',$_GET["beneficio"])
                                ->where('sitio',$_GET["sitio"])
                                ->count();
        if(($premio->stock<=0) or ($premio->cantidad<=$asignados)){
            //beneficio no disponible
            echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 102}); }catch(e){  }');
            return;  
        }

        /*Verifica que el usuario tenga solo 1 poster asignado*/
        if ($_GET["beneficio"]==6){
            $poster= PremiosLog::where('uid',$_GET["uid"])
                    ->where('premio_id','=',6)
                    ->where('sitio',$_GET["sitio"])
                    ->first();
            if ($poster or count($poster)>1){
                echo("/* Un poster ya fue asignado al usuario */");
                //beneficio no disponible"
                echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 102}); }catch(e){  }');
                return;
            }
        }

        /*Verifica que el usuario no tenga asignado algun premio, solo puede obtener 1 por promo*/
        $premioasig= PremiosLog::where('uid',$_GET["uid"])
                           ->where('premio_id','<>',6)//excepto poster
                           ->where('sitio',$_GET["sitio"])
                           ->first();


        
        if(is_null($premioasig) or !count($premioasig) or ($_GET["beneficio"]==6) ){
            // Step 1 - Defining the request
            //$method = "gm.getChallengeStatus"; //This API retrieves the current status of the user in each of the specified challenges.
            $method = "gm.redeemPoints"; //This API deducts a specified number of points from a specified user in a specified challenge.
            $request = new GSRequest($this->apiKey,$this->secretKey,$method);
            // Step 2 - Adding parameters
            $request->setParam("uid", $_GET["uid"]);  // set the "uid" parameter to user's ID
            $request->setParam("challenge","_default");  // The ID of the challenge of which to redeem points.
            $request->setParam("points", $premio->valor);  // The number of points to redeem
            // Step 3 - Sending the request
            $response = $request->send();
            // Step 4 - handling the request's response.
            if($response->getErrorCode()==0){   
                // SUCCESS! response status = OK
                $premioasigUser     = new PremiosLog;
                $premioasigUser->premio_id  = $_GET["beneficio"];
                $premioasigUser->sitio      = $_GET["sitio"];
                $premioasigUser->uid        = $_GET["uid"];
                $premioasigUser->save();

                /*Verificacion de premios asignados por si otro usuario lo preceso primero */
                $asignados= PremiosLog::where('premio_id',$_GET["beneficio"])
                                ->where('sitio',$_GET["sitio"])
                                ->where('status','received')
                                ->count(); 
                if ($asignados<$premio->cantidad) {
                    
                    $premioasigUser->status = 'received';
                    $premioasigUser->save();

                    $premio->stock= $premio->cantidad-($asignados+1);
                    $premio->save();
                    //beneficio canjeado exitosamente
                    echo ('try{ social_engage.responseRedeem({"status" : "SUCCESS", "codeResponse" : 101}); }catch(e){  }');

                    $this->pointReduce($_GET["uid"],-$premio->valor);
                    return;


                }else{
                    //beneficio canjeado por otro usuario
                    echo ('try{ social_engage.responseRedeem({"status": "ERROR", "codeResponse" : 104}); }catch(e){  }');
                    return;

                }
                
            }else{
                // Error
                echo ("/* Got error on setStatus: " . $response->getErrorMessage()."*/");
                //puntos no suficientes
                echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 103}); }catch(e){  }');
                error_log($response->getLog());
                return;

            }
            
        }else{
            echo ("/* Ya cuenta con un beneficio el usuario */");
            //beneficio no disponible
            echo ('try{ social_engage.responseRedeem({"status" : "ERROR", "codeResponse" : 102}); }catch(e){  }');
            return;
        }

        
        
    }

    private function pointReduce($uid,$points){
        $method = "gm.notifyAction";
        $request = new GSRequest($this->apiKey,$this->secretKey,$method);
        $request->setParam("uid", $uid);  
        $request->setParam("action", '_points');
        $request->setParam("points", $points);
        $request->setParam("challengeIDs","_default"); 
        $response = $request->send();
        //var_dump($response);
        if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
            //echo $response;
        }
        else{  // Error   
            error_log($response->getLog());
            echo ("/* Got error on setStatus: " . $response->getErrorMessage()."*/");
        }
    }

    private function validaUser($uid){
        $method = "socialize.getUserInfo";
        $request = new GSRequest($this->apiKey,$this->secretKey,$method);
        $request->setParam("uid", $uid);  
        $request->setParam("includeAllIdentities", true);
        $response = $request->send();
        if($response->getErrorCode()==0){   // SUCCESS! response status = OK 
            $email =$response->getString("email","");
            if($email!='')
                return 1;
            else
                return 0;
        }
        else{  // Error   
            error_log($response->getLog());
            return 0;
        }
    }



    
}