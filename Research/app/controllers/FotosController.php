<?php
class FotosController extends ContestController {

	public function getOption($id_contest){
		$contest = Contest::find($id_contest);
		if (count($contest) && ($contest->contest_type=="foto")) {
			return View::make('fotos.opcion')->with('id_contest', $id_contest);
		}
		App::abort(404);
	}

	public function getAprobarFotos($id_contest){ 

		$fotos = Fotos::select('id', 'foto_url')
	            ->where('contest_id', $id_contest)
	            ->where('status', 'pending')   
	            ->get();

		return View::make('fotos.aprobar')->with(array('fotos'=>$fotos,'id_contest'=>$id_contest,'option'=>2));
	}

	public function getRevisarFotos($id_contest){ 

		$fotos = Fotos::select('id', 'foto_url')
	            ->where('contest_id', $id_contest)
	            ->where('status', 'approved')   
	            ->get();

		return View::make('fotos.aprobar')->with(array('fotos'=>$fotos,'id_contest'=>$id_contest,'option'=>1));
	}

	public function postAuthorize($id_contest, $option){
		$datos=input::all();

		if (isset($datos['photo']) && count($datos['photo'])) {
			foreach ($datos['photo'] as $id_foto) {
				$foto = Fotos::where('contest_id', $id_contest)
						->where('id', $id_foto)   
	            		->update(array('status' => $option));
			}
		}else{
			if ($option==2){
				$msg='No existen fotos seleccionadas para aprobar';
			}else{
				$msg='No existen fotos seleccionadas para revertir aprobaci&oacute;n';
			}
			return Redirect::back()->with('error',$msg);
		}

		//Crear json
		$jsonfotos=DB::connection('mysql2')
	    		->select("SELECT f.foto_url,u.first_name,u.country from fotos f, users u where f.user_id=u.id and f.contest_id=? and f.status='approved'",array($id_contest));

	    $imgs=array();
	    $op=	['fotos' 	=> 'required'];
        if(count($jsonfotos)){
        	foreach ($jsonfotos as $foto) {
	        	$new_array  =   array(
	                "imagen"    =>$foto->foto_url,
	                "pais"      =>$foto->country,
	                "nombre"  	=>Crypt::decrypt($foto->first_name)
	            );
	            $imgs[]=$new_array;
	        }
        }
        $op['fotos']=$imgs;
       
        $jsonpar="subetufoto(".json_encode($op).")";

        $jsonfile = storage_path()."/json_fotos_".$id_contest.".json";
	    $fp=fopen($jsonfile,"w");
	    fwrite($fp,$jsonpar);
	    fclose($fp);

	    $contest = Contest::find($id_contest);
	    $ruta="/contest/fotos/".App::environment()."/".$contest->short_name."/fotos.json";
	    $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
				'ACL'        => 'public-read',
                'Bucket'     => 'communities-dev',
                'Key'        => $ruta,
                'SourceFile' => $jsonfile
        ));

        $property = ContestProperties::where('id_contest', $id_contest)
	            ->where('property_name', 'jsonfotos_url')   
	            ->first();
	    if(is_null($property) or !count($property)){
	        $contestProperties = new ContestProperties;
			$contestProperties->id_contest = $id_contest;
			$contestProperties->property_name = 'jsonfotos_url';
			$contestProperties->property_value = $result['ObjectURL'];
			$contestProperties->save();
		}else{
			$property->property_value = $result['ObjectURL'];
			$property->save();
		}
       
        unlink($jsonfile); 
		return Redirect::back();  

	}


}

  ?>
