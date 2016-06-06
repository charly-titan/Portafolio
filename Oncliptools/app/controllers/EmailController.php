<?php

class EmailController extends BaseController {

   

    public function getIndex(){

        return view::make('vcms.email');

    }



    public function postConfirmemail(){

        $input = Input::all();

        $rule = array('email' => 'required|email|min:5|max:100');   

        $validator = Validator::make($input, $rule);

        if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
        } else { 

                    try
                        {
                            $user = Sentry::findUserByLogin(Input::get('email'));

                            $countUser = EmailToken::where('id_user','=',$user->id)->get(array('created_at',DB::raw("TIMESTAMPDIFF(MINUTE,created_at,NOW()) AS minute")))->first();
                            
                             if(count($countUser) != 0){/*Ya se envio correo ver tiempo de espera */

                                    if($countUser->minute <= 5){
                                        return Redirect::back()->with('msg','msg');
                                    }else{
                                        return Redirect::back()->with('msgAviso','msgAviso');
                                    }

                            }else{/*Si no se ha enviado correo*/


                                $token = hash('sha256',Str::random(10),false);
                                //csrf_token();
                                $correo = 'http://'.$_SERVER['SERVER_NAME'].'/emailPass/changepass/'.$token;
                                
                                $userToken = new EmailToken;

                                        $userToken->id_user     = $user->id;
                                        $userToken->token       = $token;
                                        $userToken->save();

                                $msg=$correo;

                                $datos = array(
                                                'subject' => "Link para Generar nueva ContraseÃ±a",
                                                'msg' => $msg,
                                                'user' => Crypt::decrypt($user->first_name)
                                               // 'user' => $user->first_name

                                              );

                                Mail::send('emails.newpassword', $datos, function($message) use ($user)
                                    {
                                      $message->to($user->email)->subject('Oncliptools');
                                    });

                                return Redirect::back()->with('msgEnviado','msgEnviado');
                            }
                        }
                        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
                        {
                             return Redirect::back()->with('msgError','msgError');
                        }
        }

    }


    public function getChangepass($token){
        
        $idUser = DB::table('emailToken AS e')
                        ->select('u.id')
                        ->leftJoin('users AS u', 'e.id_user', '=', 'u.id')
                        ->where('e.token','=',$token)
                        ->lists('id');
                        
        $idUser = (int) array_shift($idUser); 

        $user = EmailToken::where('id_user','=',$idUser)->get()->first();



        if(!$user){
             return Redirect::to('login')->with('msgExpirado','msgExpirado');  
        }

        if($user->created_at->diffInDays() >= 1 ){

            $affectedRows = EmailToken::where('id_user', '=', $user->id)->delete();

            return Redirect::to('login')->with('msgExpirado','msgExpirado');  

        }else{

            return View::make('vcms.change_password')->with('idUser',json_encode($idUser));
        }
    }



    public function postChangepass($id){


        $inputs = Input::all();

        $rules = array(
            'password' => 'required|min:5|max:20',
            'password_repeat' => 'required|same:password'
            );


            $validate = Validator::make($inputs, $rules);

            if($validate->fails()){
                
                  return Redirect::back()->withInput()->withErrors($validate);
                
            }else {

                 $user = Sentry::getUserProvider()->findById($id);  
                 $user->password = Input::get('password');



                
                 
                 if ($user->save())
                {
                    $affectedRows = EmailToken::where('id_user', '=', $id)->delete();
                }
                return Redirect::to('login')->with('msg','msg');  
            }

    }

}