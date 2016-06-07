<?php

class NotificationController extends Controller {

    protected function userPermission($property_name){

        $user = Sentry::getUser();
        $user_permission=array("view"=>0,"update"=>0,"create"=>0,"delete"=>0);

        if ($user->hasAccess($property_name.'.view')){
            $user_permission["view"] = 1;
        } 
        if($user->hasAccess($property_name.'.update')){
            $user_permission["update"] = 1;
        }
        if($user->hasAccess($property_name.'.create')){
            $user_permission["create"] = 1;
        }
        if($user->hasAccess($property_name.'.delete')){
            $user_permission["delete"] = 1;
        }
        return $user_permission;
    }


    private function UsersTelegram(){
        
        $users_telegram = DB::select("SELECT u.first_name,u.last_name, u.id from profiles AS p LEFT JOIN users AS u on(p.id_users = u.id) where u.telegram=1 GROUP BY u.id");
        
        return $users_telegram;
    }


    public function getIndex(){


        return View::make(Config::get( 'app.main_template' ).'.notifications.notifications')->with(array('users'=>$this->UsersTelegram(),'userPermission' => $this->userPermission('promo_info') ));

    }


    public function getSendMessageUser(){
        
        if (Request::ajax()) {
       
            $id_user = Input::get('id_user');
            $msg_telegram = Input::get('msg_telegram');

            $data = DB::select("SELECT u.first_name,u.last_name, p.phone from profiles AS p LEFT JOIN users AS u on(p.id_users = u.id) where u.id=".$id_user." GROUP BY u.id");

            $first_name = Crypt::decrypt($data[0]->first_name);
            $last_name = Crypt::decrypt($data[0]->last_name);
            $phone = Crypt::decrypt($data[0]->phone);

            $contact = TG::contactAdd('52'.$phone,$first_name,$last_name);

            $msg_status = TG::sendMsg($contact[0]->print_name, $msg_telegram); 
           // $msg_status = TG::sendMsg('Juan_dominguez', $msg_telegram);  

            return Response::json($msg_status);
                
        }
    }

    public function getSendMessageGroup(){
        
        if (Request::ajax()) {
       
            $list_users = Input::get('list_users');
            $msg_telegram = Input::get('msg_telegram');
            
            for ($i=0; $i < count($list_users) ; $i++) { 

                $data = DB::select("SELECT u.first_name,u.last_name, p.phone from profiles AS p LEFT JOIN users AS u on(p.id_users = u.id) where u.id=".$list_users[$i]." GROUP BY u.id");

                $first_name = Crypt::decrypt($data[0]->first_name);
                $last_name = Crypt::decrypt($data[0]->last_name);
                $phone = Crypt::decrypt($data[0]->phone);

                $contact = TG::contactAdd('52'.$phone,$first_name,$last_name);

                $msg_status = TG::sendMsg($contact[0]->print_name, $msg_telegram);
                //$msg_status = TG::sendMsg('Juan_dominguez', $msg_telegram);    
            }

            return Response::json($msg_status);
                
        }
    }



}

?>