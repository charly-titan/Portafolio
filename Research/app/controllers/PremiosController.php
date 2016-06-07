<?php
class PremiosController extends ContestController {

	public function getIndex(){

        $tiendas = Premios::select(DB::raw('count(*) as premios, sitio, nombre_puntos'))
        					->groupBy('sitio')->get();
        return View::make('premios.tienda')->with('tiendas', $tiendas);
    }

	public function getNvatienda(){

        $tienda = Premios::select('sitio')->groupBy('sitio')->get();
        return View::make('premios.premios')->with('tienda', $tienda);
    }

    
	public function getShowPremios($sitio){ 
		$tienda = Premios::where('sitio',$sitio)->get();
		$sitio='';
		$puntos='';
		$allPremios = array();
		if (count($tienda)>0) {
			foreach ($tienda as $key => $premio) {
				$puntos=$premio->nombre_puntos;
				$sitio=$premio->sitio;
				$premios = array(
					'id'	=> $premio->id,
	    			'img' 	=> $premio->img,
	    			'name' 	=> $premio->nombre,
					'desc'	=> $premio->descripcion,	
					'valor'	=> $premio->valor,
					'canti'	=> $premio->cantidad
				);
				$allPremios[]=$premios;

			}
			
		}
		return Response::json(array('tienda' => $sitio,'puntos'=>$puntos,'allPremios'=>$allPremios));
	}


    public function postImgPremios(){
		
		$file = Input::file('file');
	    $filename = $file->getClientOriginalName();

		$s3 = AWS::get('s3');

	       $result = $s3->putObject(array(
	           			'ACL'        	=> 'public-read',
	                    'Bucket'     	=> 'communities-dev',
	                    'Key'        	=> "/escaleta/contest/".App::environment()."/premios/".$this->UserID()."/img/".$filename,
	                    'ContentType' 	=> 'image/jpeg',
						'Body'   		=>  fopen($file, 'r+')
	        ));   

	        $url = $result['ObjectURL'];

		return $url;
	}



	public function postPremios(){

		//$premio_id			= Input::get('point');
		$tienda  			= Input::get('tienda');
		$namePoint			= Input::get('puntos');
		$premios			= Input::get('premioImg');
    	$valor 				= Input::get('valor');
    	$cantidad 			= Input::get('cantidad');
    	// return Input::all();
    	if ($premios ) {
    		$i=0;
    		foreach ($premios as $premioUrl => $premioName) {
    			if ($premioName[0] != "") {//Actualiza
    				$premio = Premios::where('id',$premioName[0])->get()->first();
    				if ($premio) {
    					$premio->nombre 		= $premioName[1];
						$premio->descripcion 	= $premioName[2];
						$premio->valor 			= $valor[$i];
						$premio->cantidad 		= $cantidad[$i];
						$premio->nombre_puntos 	= $namePoint;
						$premio->img 			= $premioUrl;
						$premio->sitio 			= $tienda;
						$premio->stock 			= $cantidad[$i];
						$premio->save();
    				}
    			}else{
    				$premioNew 					= new Premios;
					$premioNew->nombre 			= $premioName[1];
					$premioNew->descripcion 	= $premioName[2];
					$premioNew->valor 			= $valor[$i];
					$premioNew->cantidad 		= $cantidad[$i];
					$premioNew->nombre_puntos 	= $namePoint;
					$premioNew->img 			= $premioUrl;
					$premioNew->sitio 			= $tienda;
					$premioNew->stock 			= $cantidad[$i];
					$premioNew->save();
    			}
    			$i++;
	    	}
    	}
    	
    	return Redirect::back();
	}


  }

  ?>
