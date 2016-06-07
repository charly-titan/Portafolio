<?php
class ReportsController extends ContestController {

	public function getRegister(){ 

		$user = Sentry::getUser(); 
        $userPermission = $this->userPermission('roles');
        $pepsi = Sentry::findGroupByName('Pepsi Admin');
        $admin = Sentry::findGroupByName('Administrador');


        
        if($user->hasAccess('users.create')){
            if($user->inGroup($admin)){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('todos'), "userPermission"=>$userPermission, "reporte"=>1));
            }elseif($user->inGroup($pepsi)){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('pepsi'), "userPermission"=>$userPermission, "reporte"=>1));
            }elseif($user->hasAccess('promo.list')){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('canal-5'), "userPermission"=>$userPermission, "reporte"=>1));    
            }    
        }else{
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento ver reportes sin tener los permisos necesarios');
            App::abort(401);
        }
	}

    public function getParticipant(){ 

        $user = Sentry::getUser(); 
        $userPermission = $this->userPermission('roles');
        $pepsi = Sentry::findGroupByName('Pepsi Admin');
        $admin = Sentry::findGroupByName('Administrador');
        
        if($user->hasAccess('users.create')){
            if($user->inGroup($admin)){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('todos'), "userPermission"=>$userPermission, "reporte"=>2));
            }elseif($user->inGroup($pepsi)){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('pepsi'), "userPermission"=>$userPermission, "reporte"=>2));
            }elseif($user->hasAccess('promo.list')){
                return View::make('quiz.contest.contestReports')->with(array('dataContest'=>$this->contestTable('canal-5'), "userPermission"=>$userPermission, "reporte"=>2));    
            }    
        }else{
            Log::emergency('El usuario :'.Session::get('user.firstname')." ".Session::get('user.lastname')." ".Session::get('user.id').' intento ver reportes sin tener los permisos necesarios');
            App::abort(401);
        }
    }


    // public function allContest(){
    //     $contest= Contest::all();
    //     return $contest;
    // }

    public function postGenerate(){
        $contest_id = Input::get('contest');
        $reporte = Input::get('reporte');
        if ($reporte==1) {
            $insReg = new registeredController();
            return $insReg->getIndex($contest_id); 
        }else{
            $insPar = new participantController();
            return $insPar->getParticipants($contest_id); 
        }

    }

    



  }

  ?>
