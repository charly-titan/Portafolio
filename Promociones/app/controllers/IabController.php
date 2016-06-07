<?php

class IabController extends ContestController {

	public function __construct()
    {
		Config::set('app.main_template', 'promociones2');
        
    }

	public function getIab ($keyword=""){

		if ($keyword=="") {
			return View::make(Config::get( 'app.main_template' ).'.iab.ingreso');
		}else{
			
			$flick	=	FlickrRegister::where('keyword', $keyword)->first();
			if(is_null($flick) or !count($flick)){
				//App::abort(404);
				return View::make(Config::get( 'app.main_template' ).'.iab.error');
			}else{
				if ($flick->register_id){
					$fotos=json_decode($this->json_photos($keyword));
					return View::make(Config::get( 'app.main_template' ).'.iab.detalle')->with(array("fotos"=>$fotos,"zip"=>$flick->zip_url));
				}else{
					$codigo=$flick->code;
					return View::make(Config::get( 'app.main_template' ).'.iab.registro')->with("codigo",$codigo);
				}
			}
		}
                
	}

	public function postCode(){
        
        $codigo=strtoupper(Input::get('codigo'));

        /*Buscamos si existe el codigo proporcionado*/

        $fick	=	FlickrRegister::where('code', $codigo)->first();
					
		if(is_null($fick) or !count($fick)){
			$error='El código '.$codigo.' no existe';
			return  Redirect::back()->with('error',$error);

		}else{
			
				if ($fick->register_id){
					return  Redirect::to("ventas/iab/".$fick->keyword);
				}else{
					Session::put("user.code", $codigo);
					return View::make(Config::get( 'app.main_template' ).'.iab.registro')->with("codigo",$codigo);
				}
		}
	    
    }

    public function postRegistro($short_name=""){

    	$values = array(        
            'nombre'    =>  Input::get('usrname'),
            'email'     =>  Input::get('email'),
            'cargo'  	=>  Input::get('cargo'),
            'empresa'  	=>  Input::get('empresa'),
                
        );
        $format = array(
            'nombre'    =>  'required',
            'email'     =>  'required|email',
            'cargo'  	=>  'required',
            'empresa'    =>  'required',
        );

        $validator = Validator::make(
            $values   ,  $format
        );

        if ($validator->fails()){
            return  Redirect::back()->withErrors($validator);
        }
        
        

        
        $registro	=	new RegisterIab;
        $registro->name 	= Input::get('usrname');
        $registro->email    = Input::get('email');
        $registro->position = Input::get('cargo');  
        $registro->company  = Input::get('empresa');
        $registro->save();
        
        $codigo=Input::get('codigo');
        
        $fick =	 FlickrRegister::where('code', $codigo)->first();

        $fick ->register_id   = 	$registro->id;
        $fick ->save();
        return  Redirect::to("ventas/iab/".$fick->keyword);
        
    }

    private function json_photos($keyword){

    	$flickr = FlickrPhotos::select('id','flickr_id','s3_url','s3_url_original','originalformat')
    			  	->where('keyword',$keyword)
    			  	->where('s3_url','<>','')
    			  	->where('tipo','image')
    			  	->orderBy('dateupload', 'ASC')
    			  	->get();
        
        $imgs=array();
        if(count($flickr)){
        	foreach ($flickr as $photo) {
	        	$new_array  =   array(
	                'id'        =>$photo->id,
	                'name'      =>$photo->flickr_id,
	                'foto_url'  =>$photo->s3_url,
                    's3_url_original'=>$photo->s3_url_original,
                    'originalformat'=>$photo->originalformat
	            );
	            $imgs[]=$new_array;
	        }
        }
        return json_encode($imgs);   	
    	
    }

    /*public function getDownPhotos($keyword){

    	$fichero = 'prueba.jpg';

    	if ($keyword!='') {
    		$flick	=	FlickrRegister::where('keyword', $keyword)->first();
			if(isset($flick) or count($flick)){	
				$s3 = AWS::get('s3');
				

    			$headers = array(
                	    'Content-Type' => 'application/download',
            	);

            	try {
            		$fichero=storage_path().$keyword.'.zip';
				    // Get the object
				    $result = $s3->getObject(array(
				        'Bucket' => 'communities-dev',
				        'Key'    => "/ventas/iab/".App::environment()."/".$keyword."/".$keyword.".zip",
				        'SaveAs' => $fichero
				    ));

				    // Display the object in the browser
				    //header("Content-Type: {$result['ContentType']}");
				    //echo $result['Body'];
				    return Response::download($fichero,$headers); 
				} catch (S3Exception $e) {
				    echo $e->getMessage() . "\n";
				}
            	//return Response::download($fichero,$headers); 
            }
    	}
    	App::abort(404);
 
    }*/



}	
