<?php
class AdminController extends ContestController {

	public function getIndex(){ 

		$user = Sentry::getUser(); 
		$userPermission = $this->userPermission('roles');
		
		if(($user->hasAccess('roles.create')) && (($user->email=='elsa.salinas@televisatim.com') or ($user->email=='gabriel.mancera@televisatim.com'))) {
			return View::make('admin.opciondb')->with(array('dataContest'=>$this->contestTable('todos'), "userPermission"=>$userPermission));
		}else{
			Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento borrar datos de concursos sin tener los permisos necesarios');
            App::abort(401);
		}
	}


    public function postClean(){

        $user = Sentry::getUser(); 
        $userPermission = $this->userPermission('roles');
        
        if(($user->hasAccess('roles.create')) && (($user->email=='elsa.salinas@televisatim.com') or ($user->email=='gabriel.mancera@televisatim.com'))) {

        	$contest_id	= Input::get('contest');

        	$contest_name= Contest::find($contest_id);

        	try {
        		if ($contest_name->contest_type!='versus') {
                    $queryUsers=DB::connection('mysql2')->table('users')->where('contest_id', '=', $contest_id)->delete();
                    $querySocial=DB::connection('mysql2')->table('social_network')->where('contest_id', '=', $contest_id)->delete();
                    $questionsAnswers=DB::connection('mysql2')->table('questions_answers')->where('contest_id', '=', $contest_id)->delete();
                    $queryPhrase=DB::connection('mysql2')->table('phrase')->where('contest_id', '=', $contest_id)->delete();
                    $queryFotos=DB::connection('mysql2')->table('fotos')->where('contest_id', '=', $contest_id)->delete();
                    $queryVotosFotos=DB::connection('mysql2')->table('votos_foto')->where('contest_id', '=', $contest_id)->delete();
                    Log::notice('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' borro datos de concurso con id='.$contest_id);
                    $msg='Se eliminaron los registros del concurso '.strtoupper($contest_name->short_name).' : <br>'.$queryUsers.'-Usuarios <br>'.$querySocial.'-Redes Sociales <br>'.$questionsAnswers.'-Respuestas <br>'.$queryPhrase.'-Frases <br>'.$queryFotos.'-Fotos <br>'.$queryVotosFotos.'-Votos fotos <br>';          
                    return Redirect::to('/admin')->with('msg', $msg);
                } else {
                    $point_id=ContestRewards::select('point_id')->where('contest_id',$contest_id)->first();
                    $rewardsUsers=0;
                    if ($point_id) $rewardsUsers=DB::connection('mysql2')->table('user_rewards')->where('point_id', '=', $point_id->point_id)->delete();
                    $queryUsers=DB::connection('mysql2')->table('users')->where('contest_id', '=', $contest_id)->delete();
                    $querySocial=DB::connection('mysql2')->table('social_network')->where('contest_id', '=', $contest_id)->delete();
                    $queryVotosVersus=DB::connection('mysql2')->table('versus')->where('contest_id', '=', $contest_id)->delete();
                    Log::notice('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' borro datos de concurso con id='.$contest_id);
                    $msg='Se eliminaron los registros del concurso '.strtoupper($contest_name->short_name).' : <br>'.$queryUsers.'-Usuarios <br>'.$querySocial.'-Redes Sociales <br>'.$queryVotosVersus.'-Votos Versus <br>'.$rewardsUsers.'-User Rewards <br>';          
                    return Redirect::to('/admin')->with('msg', $msg);
                }
                
        		
    			
        		
        	} catch (Exception $e) {

        		$msg='Ocurrio un error al eliminar los registros: <br>'.$e->getMessage();
    			return Redirect::to('/admin')->with('msg', $msg);
        		
        	}

        }else{
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento borrar datos de concursos sin tener los permisos necesarios');
            App::abort(401);
        }

    	
	}

    public function postQuery(){

        $user = Sentry::getUser(); 
        $userPermission = $this->userPermission('roles');
        
        if(($user->hasAccess('roles.create')) && (($user->email=='elsa.salinas@televisatim.com') or ($user->email=='gabriel.mancera@televisatim.com'))) {

            try {
                
                $connection = Input::get('conne');
                $query = Input::get('query');

                if ($connection=="1") {
                    $registros = DB::select($query);
                } else {
                    $registros = DB::connection('mysql2')->select($query);
                }
                

                Log::notice('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' realizo la consulta '.$query);
                
                return $registros;
                
                
            } catch (Exception $e) {

                $msg='Ocurrio un error al ejecutar la consulta: <br>'.$e->getMessage();
                return Redirect::to('/admin')->with('msgquery', $msg);
                
            }

        }else{
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' ejecutar una consulta sin tener los permisos necesarios');
            App::abort(401);
        }

        
    }



  }

  ?>
