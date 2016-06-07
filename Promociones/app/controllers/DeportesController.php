<?php
class DeportesController extends ContestController {

	public function __construct()
    {
		parent::__construct();
		Config::set('app.main_template', 'promociones2');
        
    }

	public function getIndex ($short_name=""){

		// var_dump(Session::all());
		// *******************************************
		// Verificar si el concurso existe
		// *******************************************
		if($this->contestExist($short_name)){
			Session::put('user.contest', $short_name); // Establecer el concurso para la sesión
			$info=$this->contestInfo($short_name);	// Obtener la inforación del concurso

			// *******************************************
			// Verificar si el concurso ya finalizó
			// *******************************************
			if(intval($info->end_date)<= time()){
				return View::make(Config::get( 'app.main_template' ).'.cierre')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'cierre'));
			}


			
			// *******************************************
			// Verificar si el concurso ya inicio o esta en previo
			// *******************************************
			if(intval($info->start_date) > time()){
				return View::make(Config::get( 'app.main_template' ).'.previo')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'previo'));
			}


			// *******************************************
			// Verificamos si el usuario ya inicio sesión
			// *******************************************
			if (Session::has('user.identifier')){
				// *******************************************
				// El concurso ya inicio 
				// Verificamos si el usuario ya esta registrado
				// *******************************************
				if($this->userIsRegister($info)){
					

					if(intval($info->activation_date) <= time()){
						if ($this->hasPhrase($info)) {
							return View::make(Config::get( 'app.main_template' ).'.gracias')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'gracias'));
						}else{

//							return View::make(Config::get( 'app.main_template' ).'.pregunta')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'frase'));

							return View::make(Config::get( 'app.main_template' ).'.foto')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'frase'));

						}
						
					}else{
						return View::make(Config::get( 'app.main_template' ).'.espera')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'espera'));
					}



				// *******************************************
				// Pero el usuario no esta registrado
				// *******************************************
				}else{
					return  Redirect::to($this->nameController($info)."/".$short_name.'/confirma')->with(array('info'=>$info,'adUnit'=>'previo'));
				}

			}else{
				return View::make(Config::get( 'app.main_template' ).'.login')->with(array("short_name"=>$short_name,"info"=>$info,'adUnit'=>'login'));
			}

			// if(intval($info->activation_date) >= time()){
				
			// 	exit("Activado");
			 	
			//  	if (Session::has('user.identifier'))
			// 	{
			// 		if($this->userIsRegister($info)){

			// 			if($info->start_date <= time()){
			// 				return View::make(Config::get( 'app.main_template' ).'.login')->with("short_name",$short_name);
			// 			}else{
			// 				return View::make(Config::get( 'app.main_template' ).'.pregunta')->with("short_name",$short_name);
			// 			}



			// 		}else{
							
			// 		}
					
			// 	}else{
			// 		return View::make(Config::get( 'app.main_template' ).'.espera')->with("short_name",$short_name);
			// 	}
			// }
		}else{
			App::abort(404);
		}
		

	}


}