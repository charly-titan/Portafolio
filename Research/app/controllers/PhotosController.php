<?php

class PhotosController extends BaseController 
{

	protected $api_key;
	protected $api_secret;
	protected $auth_token;

	public function __construct()
	{
		$flickrauth 		= Config::get('flickrauth');
		$this->api_key 		= $flickrauth['api_key'];
		$this->api_secret	= $flickrauth['secret'];
	}

	public function getCodesGenerate()
	{
		$flick_reg= FlickrRegister::all();
		if(is_null($flick_reg) or !count($flick_reg)){

			for ($i = 0; $i < 2000; $i++){
				$code 	= $this->getRandomCode(); 
				$keyword= md5($code.time().$i);
				$fickr 	= new FlickrRegister;
				$fickr->code 	= $code;
				$fickr->keyword = $keyword;
				$fickr->save();
			}
			echo "Codigos generados";
		}else{
			return $flick_reg;
		}
	}

	public function getAuth()
	{
		$perms 			= 'write';
		$api_sig 		= md5($this->api_secret."api_key".$this->api_key."perms".$perms);
		$urlAuth 		= ('http://flickr.com/services/auth/?api_key='.$this->api_key.'&perms='.$perms.'&api_sig='.$api_sig);
		header("Location: ".$urlAuth); 
		exit();
	}

	public function getFrob()
	{
		$frob = $_GET['frob'];
		Session::put('frob', $frob);
		echo '<a href= /photos/token>token</a>';
	}

	public function getToken($user_id='135436199@N02')
	{
		$perms 			= 'write';
		$urlToke		= 'https://api.flickr.com/services/rest/?method=flickr.auth.getToken';
		$format 		= 'json';
		$frob 			= Session::get('frob');
		$method 		= 'flickr.auth.getToken';
		$nojsoncallback	= '1';
		$api_sig_token 	= md5($this->api_secret.'api_key'.$this->api_key.'format'.$format.'frob'.$frob.'method'.$method.'nojsoncallback'.$nojsoncallback);
		$urlToken		= $urlToke.'&api_key='.$this->api_key.'&frob='.$frob.'&format='.$format.'&nojsoncallback='.$nojsoncallback.'&api_sig='.$api_sig_token;
		echo $urlToken, "<br>";
		
		try {
			$ch 			= curl_init(); 
			curl_setopt ($ch, CURLOPT_URL, $urlToken); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			$data 	= curl_exec ($ch); 
			curl_close($ch);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}


  //$data = file_get_contents($urlToken); 
		$tokens		= json_decode($data, true);
		echo "<br>";




		if ($tokens['stat']=='fail') {
			return $tokens['message'];
		}
		foreach ($tokens as $token) {
			if (is_array($token)){
				foreach ($token['token'] as $auth_token) {

					$flick_auth= FlickrAuth:: where('api_key', $this->api_key)
											->where('api_secret', $this->api_secret)
											->where('user_id', $user_id)
											->first();
					if(is_null($flick_auth) or !count($flick_auth)){
						$flickr_new= new FlickrAuth;
						$flickr_new->api_key	= $this->api_key;
						$flickr_new->api_secret = $this->api_secret;
						$flickr_new->user_id 	= $user_id;
						$flickr_new->frob		= $frob;
						$flickr_new->auth_token = $auth_token;
						$flickr_new->save();
					}else{
						$flick_auth->frob		= $frob;
						$flick_auth->auth_token = $auth_token;
						$flick_auth->save();
					}
				}
				echo '<a href= /photos/json-generate>json-generate</a>';
			}
		}
	}

	public function getCheckToken($user_id='135436199@N02')
	{
		$flick_auth= FlickrAuth:: where('api_key', $this->api_key)
								->where('api_secret', $this->api_secret)
								->where('user_id', $user_id)
								->first();
		if(is_null($flick_auth) or !count($flick_auth)){
			return "No existe token para esta cuenta";
		}
		$auth_token 	= $flick_auth->auth_token;
		$format 		= 'json';
		$method 		= 'flickr.auth.checkToken';
		$nojsoncallback	= '1';
		$urlToken 		= 'https://api.flickr.com/services/rest/?method=flickr.auth.checkToken';
		$api_sig 		= md5($this->api_secret.'api_key'.$this->api_key.'auth_token'.$auth_token.'format'.$format.'method'.$method.'nojsoncallback'.$nojsoncallback);
		$url			= $urlToken.'&api_key='.$this->api_key.'&format='.$format.'&nojsoncallback='.$nojsoncallback.'&auth_token='.$auth_token.'&api_sig='.$api_sig;
		try{
		$ch 			= curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		$data 	= curl_exec ($ch); 
		curl_close($ch);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		//$data 			= file_get_contents($url);
		$checktokens 	= json_decode($data, true);
		if ($checktokens['stat']=='ok') {
			return "El token sigue vigente";
		}else{
			return $data;
		}
	}

	public function getJsonGenerate($user_id='135436199@N02')
	{
		$flick_auth= FlickrAuth:: where('api_key', $this->api_key)
								->where('api_secret', $this->api_secret)
								->where('user_id', $user_id)
								->first();
		if(is_null($flick_auth) or !count($flick_auth)){
			return "No existe token para generar Json";
		}
		$path=storage_path()."/json/";
		if(!file_exists($path)){
			File::makeDirectory($path, $mode = 0777, true, true);
		}
		$urlPhoto 	= 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
		$auth_token = $flick_auth->auth_token;
		$extras 	= 'date_taken,date_upload';
		$format 	= 'json';
		$method 	= 'flickr.photos.search';
		$nojsoncallback ='1';
		$privacy_filter ='5';
		$sort 		='date-taken-asc';
		$api_sig_json 	=md5($this->api_secret.'api_key'.$this->api_key.'auth_token'.$auth_token.'extras'.$extras.'format'.$format.'method'.$method.'nojsoncallback'.$nojsoncallback.'privacy_filter'.$privacy_filter.'sort'.$sort.'user_id'.$user_id);
		$urljson	= $urlPhoto.'&api_key='.$this->api_key.'&method='.$method.'&format=json'.'&nojsoncallback='.$nojsoncallback.'&extras='.$extras.'&privacy_filter='.$privacy_filter.'&sort='.$sort.'&user_id='.$user_id.'&auth_token='.$auth_token.'&api_sig='.$api_sig_json;
		try{
		$ch 			= curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $urljson); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		$source 	= curl_exec ($ch); 
		curl_close($ch);} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}

	//$source 	= file_get_contents($urljson);
		file_put_contents($path.$user_id.'.json', $source);
		echo "Json generado";
		echo '<br>';
		echo '<a href= /photos/photos-generate>photos-generate</a>';
	}

	public function getPhotosGenerate($user_id='135436199@N02')
	{
		$path=storage_path()."/json/";
		/*$url='https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=ec9f9fc2434b52546c1e4c3d5fcb4b59&user_id=135436199%40N02&sort=date-taken-asc&privacy_filter=5&extras=date_taken%2C+date_upload&format=json&nojsoncallback=1&auth_token=72157657106657680-9304a51ab4be779e&api_sig=5c80a16e4eec45a67f156baa4f5943e5';
		$source = file_get_contents($url);
		file_put_contents($path.$user_id.'.json', $source);*/
		$data = file_get_contents($path.$user_id.'.json');
		$products = json_decode($data, true);
		try {
			foreach ($products['photos'] as $product) {
				if (is_array($product)){
					foreach ($product as $value) { 
						$flick= FlickrPhotos::where('flickr_id', $value['id'])->where('owner', $value['owner'])->first();
						if(is_null($flick) or !count($flick)){
							$flickr_new= new FlickrPhotos;
							$flickr_new->flickr_id 	= $value['id'];
							$flickr_new->owner 		= $value['owner'];
							$flickr_new->secret  	= $value['secret'];
							$flickr_new->server 	= $value['server'];
							$flickr_new->farm 		= $value['farm'];
							$flickr_new->datetaken 	= strtotime($value['datetaken']);
							$flickr_new->dateupload = $value['dateupload'];
							/***************************************************/
							$photoOri = $this->PhotoOriginal($value['id'],$value['secret'],$user_id);

							if(is_array($photoOri)){

								$flickr_new->originalsecret = $photoOri['originalsecret'];
								$flickr_new->originalformat = $photoOri['originalformat'];
							}

							/***************************************************/
							$flickr_new ->save();
						}
					}
				}
			}
			echo "Paso 1 terminado <br>";
			echo '<a href= /photos/photos-down>Siguiente paso photos-down</a>';
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function getPhotosDown($user_id='135436199@N02')
	{
		try {
			$path=storage_path()."/photos/".$user_id."/";
			if(!file_exists($path)){
				File::makeDirectory($path, $mode = 0777, true, true);
			}
			$path_ori=storage_path()."/photos/".$user_id."/original/";
			if(!file_exists($path_ori)){
				File::makeDirectory($path_ori, $mode = 0777, true, true);
			}
			$flickr= FlickrPhotos::where('download', 0)->where('owner', $user_id)->get();
			if(count($flickr)){
				foreach ($flickr as $photo) {
					$filejpg  =("https://farm".$photo->farm.".staticflickr.com/".$photo->server. "/".$photo->flickr_id."_".$photo->secret.".jpg");
					$name     =$path.$photo->flickr_id.".jpg";
					$source   = file_get_contents($filejpg);
					file_put_contents($name, $source);
					$photo_ori=("https://farm".$photo->farm.".staticflickr.com/".$photo->server. "/".$photo->flickr_id."_".$photo->originalsecret.'_o.'.$photo->originalformat);
					$original =$path_ori.$photo->flickr_id.".".$photo->originalformat;
					$source   =file_get_contents($photo_ori);
					file_put_contents($original, $source);
					$photo->download=1;
					$photo->save(); 
				}
				echo "Fotos descargadas <br>";
				echo '<a href= /photos/qr-reader>Siguiente paso qr-reader</a>';
			}else
			echo "No hay fotos nuevas";
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function getQrReader($user_id='135436199@N02')
	{
		include(base_path().'/vendor/decoder/lib/QrReader.php'); 
		$path=storage_path()."/photos/".$user_id."/";
		$last_keyword=FlickrPhotos::select('keyword', 'evento')
									->where('download', 1)
									->where('owner', $user_id)
									->where('keyword','<>','')
									->where('s3_url','<>','')
									->where('tipo','barcode')
									->orderBy('datetaken', 'DESC')
									->first();
		if(count($last_keyword)){
			$keyword =$last_keyword->keyword;
			$evento  =$last_keyword->evento;
		}else{
			$keyword ='desconocido';
			$evento  ='desconocido';
		}
		$flickr= FlickrPhotos::where('download', 1)
								->where('owner', $user_id)
								->where('keyword','')
								->orderBy('datetaken', 'ASC')
								->get();
		if(count($flickr)){
			foreach ($flickr as $photo) {
				$name=$path.$photo->flickr_id.".jpg";
				try {
					if(file_exists($name)){
						$qrcode = new QrReader($name);
						if ($qrcode->text() != ''){
							$porciones = explode("/", $qrcode->text());
							if (count($porciones)>5) {
								$evento=$porciones[4];
								$keyword=$porciones[5];
								$photo->tipo='barcode';
								$photo->keyword=$keyword;
								$photo->evento=$evento;
								$photo->save();
							}else{
								$photo->keyword=$keyword;
								$photo->evento=$evento;
								$photo->save(); 
							} 
						}else{
							$photo->keyword=$keyword;
							$photo->evento=$evento;
							$photo->save(); 
						}
					}
				}catch (Exception $e) {
					echo $e->getMessage();
				}
			}
			echo "Fotos procesadas<br>";
			echo '<a href= /photos/s3-upload>Siguiente paso s3-upload</a>';
		}else
		echo "No hay fotos nuevas";
	}

	public function getS3Upload($user_id='135436199@N02')
	{ 
		try {
			$path=storage_path()."/photos/".$user_id."/";
			$path_ori=storage_path()."/photos/".$user_id."/original/";
			$s3 = AWS::get('s3');
			$zipPhoto= array();
			$flickr=FlickrPhotos::where('download', 1)
								->where('owner', $user_id)
								->where('keyword','<>','')
								->where('s3_url','')
								->orderBy('datetaken', 'ASC')
								->get();
			if(count($flickr)){
				foreach ($flickr as $photo) {
					$name=$path.$photo->flickr_id.".jpg";
					$ruta="/ventas/".$photo->evento."/".App::environment()."/".$user_id."/".$photo->keyword."/";
					if(file_exists($name)){
						$result = $s3->putObject(array 	('Bucket'=>'communities-dev',
														 'Key' =>$ruta.$photo->flickr_id.".jpg",
														 'ACL' =>'public-read',
														 'ContentType' =>'image/jpeg',
														 'Body'=>fopen($name, 'r+')
														));
						$photo->s3_url=$result['ObjectURL'];
						//echo $result['ObjectURL'].'<br>';
					}
					$original=$path_ori.$photo->flickr_id.".".$photo->originalformat;
					$ruta_ori="/ventas/".$photo->evento."/".App::environment()."/".$user_id."/".$photo->keyword."/original/";
					$ctype='image/'.$photo->originalformat;
					if(file_exists($original)){
						$result = $s3->putObject(array 	('Bucket'=>'communities-dev',
														 'Key' =>$ruta_ori.$photo->flickr_id.".".$photo->originalformat,
														 'ACL' =>'public-read',
														 'ContentType' =>$ctype,
														 'Body'=>fopen($original, 'r+'
														)
							));
						$photo->s3_url_original=$result['ObjectURL'];
						//echo $result['ObjectURL'].'<br>';	
					}
					$photo->save();
					if (!(in_array($photo->keyword, $zipPhoto))){
						$zipPhoto[]=$photo->keyword; 
					}
				}
				//Genera zip con nuevas imgs
				foreach ($zipPhoto as $keyword) {
					//echo $flickr."<br>";
					$this->zipGenerate($user_id,$keyword);

				}
				//borrar archivos locales
				if(file_exists($path)){
					File::deleteDirectory($path);
				}
				if(file_exists($path_ori)){
					File::deleteDirectory($path_ori);
				}
				echo "Fotos enviadas a S3";
				echo "<br>Proceso terminado";
			}else
			echo "No hay fotos para enviar a S3";
		}catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	private function getRandomCode(){
		$an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$su = strlen($an) - 1;
		return substr($an, rand(0, $su), 1) .
		substr($an, rand(0, $su), 1) .
		substr($an, rand(0, $su), 1) .
		substr($an, rand(0, $su), 1) .
		substr($an, rand(0, $su), 1);
	}

	private function PhotoOriginal($photo_id,$secret,$user_id){
		$flick_auth= FlickrAuth::where('api_key', $this->api_key)
								->where('api_secret', $this->api_secret)
								->where('user_id', $user_id)
								->first();
		if(is_null($flick_auth) or !count($flick_auth)){
			//No existe token para generar original
			return 0;
		}

		$urlToken = 'https://api.flickr.com/services/rest/?method=flickr.photos.getInfo';
		$auth_token = $flick_auth->auth_token;
		$format = 'json';
		$method = 'flickr.photos.getInfo';
		$nojsoncallback = '1';
		$api_sig= md5($this->api_secret.'api_key'.$this->api_key.'auth_token'.$auth_token.'format'.$format.'method'.$method.'nojsoncallback'.$nojsoncallback.'photo_id'.$photo_id.'secret'.$secret);
		$urlInfo= $urlToken.'&api_key='.$this->api_key.'&photo_id='.$photo_id.'&secret='.$secret.'&format='.$format.'&nojsoncallback='.$nojsoncallback.'&auth_token='.$auth_token.'&api_sig='.$api_sig;
		try{
		$ch 			= curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $urlInfo); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		$data 	= curl_exec ($ch); 
		curl_close($ch);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}

		//$data = file_get_contents($urlInfo);
		$phOrig = json_decode($data, true);
		foreach ($phOrig as $PO) {
			if (is_array($PO)){
				return $PO; 
			}
		}
		return 0;
	}

	public function zipGenerate($user_id='135436199@N02',$keyword)
	{
		//$path=storage_path()."/photos/";
		$path_ori=storage_path()."/photos/".$user_id."/original/";
		if(!file_exists($path_ori)){
			File::makeDirectory($path_ori, $mode = 0777, true, true);
		}
		$archivozip=$path_ori.$keyword.'.zip';
		$evento="";
		$s3 = AWS::get('s3');
		$flickr = FlickrPhotos::where('keyword',$keyword)
								->where('owner', $user_id)
								->where('s3_url','<>','')
								->where('tipo','image')
								->orderBy('dateupload', 'ASC')
								->get();
		if(count($flickr)){
			$zip = new ZipArchive();
			$zip->open($archivozip, ZipArchive::CREATE);
			foreach ($flickr as $photo) {
				$name=$photo->flickr_id.".".$photo->originalformat;
				$original=$path_ori.$name;
				$evento=$photo->evento;
				if(!(file_exists($original))){
					//$ruta_ori="/ventas/".$evento."/".App::environment()."/".$user_id."/".$keyword."/original/".$name;
					$keyOri = explode("https://communities-dev.s3.amazonaws.com", $photo->s3_url_original);
					//echo "<br>".html_entity_decode($keyOri[1]);
					//echo '<br>'.urldecode($keyOri[1]);
					// Get the object
					$result = $s3->getObject(array 	('Bucket' => 'communities-dev',
													 'Key'=> urldecode($keyOri[1]),
													 'SaveAs' => $original
													));
				}
				$zip->addFile($original, $name);
			}
			$zip->close();
			$ruta_ori="/ventas/".$evento."/".App::environment()."/".$user_id."/".$keyword."/original/".$keyword.'.zip';
			$result = $s3->putObject(array 	('Bucket'=>'communities-dev',
											 'Key' =>$ruta_ori,
											 'ACL' =>'public-read',
											 'ContentType' =>'application/zip',
											 'Body'=>fopen($archivozip, 'r+')
											));
			$flick_reg 	= FlickrRegister::where('keyword', $keyword)->first();
			if(count($flick_reg)){
				$flick_reg->zip_url= $result['ObjectURL'];
				$flick_reg->save();
			}
		}
		/*
		$dh = opendir($path);
		while (($file = readdir($dh)) !== false) {
			if($file != "." && $file != "..") {
				$rootPath = realpath($path.$file);
				$zip = new ZipArchive();
				if(file_exists($path.$file."/".$file.".zip")){
					unlink($path.$file."/".$file.".zip");
				} 
				$zip->open($path.$file."/".$file.'.zip', ZipArchive::CREATE);
				$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
				);
				foreach ($files as $name => $file)
				{
					if (!$file->isDir())
					{
						$filePath = $file->getRealPath();
						$relativePath = substr($filePath, strlen($rootPath) + 1);
						$zip->addFile($filePath, $relativePath);
					}
				}
				$zip->close();
			}
		}
		closedir($dh); 
		*/ 
	}

	public function getGallerys()
	{
		$myarray=array();
		$paginate = FlickrPhotos::where('tipo', 'barcode')->orderBy('datetaken', 'ASC')->paginate(12);
		foreach ($paginate as $photos) {
			foreach (FlickrRegister::where('keyword', $photos->keyword)->get() as $code) {
				$myarray[] =	['keyword'	=>	$photos->keyword,
								 's3_url'	=> 	$photos->s3_url,
								 'code'		=>	$code->code
								];
			}
		}
		return View::make('flickr.index')->with('photos', $myarray)->with('paginate', $paginate);
	}

	public function getGallery($keyword)
	{
		$key		=	FlickrPhotos::where('keyword', $keyword)->where('tipo', 'image')->orderBy('datetaken', 'ASC')->get();
		$select 	= 	FlickrRegister::get();
		$code 		= 	FlickrRegister::where('keyword', $keyword)->get();
		return View::make('flickr.gallery')->with('key', $key)->with('select', $select)->with('code', $code);
	}

	public function postReasign()
	{
		$dato 	= Input::get();
		$key 	=	$dato['urlShort'];
		$rules 	=	['photo' 	=> 'required',
				 	 'urlShort' => 'required',
					];
		$messages =	['photo.required' 		=> 'Selecciona al menos una foto.',
					 'urlShort.required'	=> 'Intoroduce un codigo valido.',
					];
		$validator = Validator::make($dato, $rules, $messages);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}



		else {
			$keywor 	= FlickrRegister::where('code', $key)->first();
			$keyword 	= $keywor->keyword;
			foreach ($dato['photo'] as $names) {
				if (isset($dato['radio'])){
					$id 	= $dato['radio'];
					$flickr = FlickrPhotos::where('id', '=', $id)->where('flickr_id', '=', $names)->update(['tipo' => 'barcode']);
					$flickr = FlickrPhotos::where('flickr_id', '=', $names)->update(['keyword' => $keyword]);
				} else {
					$flickr = FlickrPhotos::where('flickr_id', '=', $names)->update(['keyword' => $keyword]);
				}
			}
			$oldcode 	=	$dato['old_code'];
			$oldkeywor	= FlickrRegister::where('code', $oldcode)->first();
			$oldkeyword = $oldkeywor->keyword;
			$user_i 	= FlickrPhotos::where('keyword', $oldkeyword)->first();
			$user_id 	= $user_i->owner;
			
			$this->zipGenerate($user_id,$oldkeyword);
			$path=storage_path()."/photos/".$user_id."/";
			if(file_exists($path)){
				File::deleteDirectory($path);
			}

			$user_i 	= FlickrPhotos::where('keyword', $keyword)->first();
			$user_id 	= $user_i->owner;
			
			$this->zipGenerate($user_id,$keyword);
			$path=storage_path()."/photos/".$user_id."/"; 		
			if(file_exists($path)){
				File::deleteDirectory($path);
			}
			Session::flash('message', 'Galeria actualizada!'); 
			return Redirect::back();
		}
	}

	public function getLoginFlickr()
	{
		$username	="tim.developers"; 
		$password	=">4HjAz32wtxU3bL8"; 
		$url 		="https://login.yahoo.com/config/login";
		$postdata 	= "username=".$username."&userpass=".$password; 
		$ch 		= curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		$result 	= curl_exec ($ch); 
		curl_close($ch);
	}
}