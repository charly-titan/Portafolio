<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    body{font:'Open Sans'}
    </style>
  </head>
  <body>
    <div class="row">
	 
	@foreach ($qrcodes as $qrcode)
	  <div class="col-md-6">
		<div class="row" style="border:1px dotted">
		  <div class="col-md-4">
		  	<img src="https://communities-dev.s3.amazonaws.com/ventas/iab/qrcodes/{{$environment}}/{{$qrcode->keyword}}.png" alt="..." class="img-thumbnail">
		  	<p class="text-center"><small>{{$qrcode->code}}</small></p>
		  </div>
		  <div class="col-md-8">Puedes descargar tus fotografias ingresando en http://tvsa.mx/iab con el codigo:
		  	
		  	<p class="text-center">{{$qrcode->code}}</p></div>		  
		</div>
	  </div>
	  @endforeach
	  
	</div>

    <!-- 
 Array ( [0] => Qrcodes Object ( [table:protected] => flickr_register [connection:protected] => [primaryKey:protected] => id [perPage:protected] => 15 [incrementing] => 1 [timestamps] => 1 [attributes:protected] => Array ( [id] => 1 [code] => GYR30 [keyword] => eff7cf7b98d3a88bc4bc73ebc858ba70 [register_id] => 1 [photos_url] => [{"id":"2","foto_url":"https:\/\/communities-dev.s3.amazonaws.com\/escaleta\/contest\/aws\/concurso-prueba-foto\/fotos\/228a19d11299f76d60fc5b8f3dfa01b6.jpg"},{"id":"3","foto_url":"https:\/\/communities-dev.s3.amazonaws.com\/escaleta\/contest\/aws\/concurso-prueba-foto\/fotos\/fc2c854cc2e3495d12b3bd9bf1848c8c.jpg"},{"id":"4","foto_url":"https:\/\/communities-dev.s3.amazonaws.com\/escaleta\/contest\/aws\/concurso-prueba-foto\/fotos\/16aca6d14cf3886b8e3e1bac0d8536f2.jpg"},{"id":"5","foto_url":"https:\/\/communities-dev.s3.amazonaws.com\/escaleta\/contest\/aws\/concurso-prueba-foto\/fotos\/602ce9808c0328c8e492704c7cfe2eba.jpg","foto_name":"Minion","voto_url":"foto\/concurso-prueba-foto\/vota\/05acab0087bb7d32ed339a2be9ab0cdf","keyword":"05acab0087bb7d32ed339a2be9ab0cdf","status":"pending","created_at":"2015-07-29 11:44:31","updated_at":"2015-07-29 11:44:31"}] [created_at] => 2015-08-13 10:54:46 [updated_at] => 2015-08-13 11:00:49

    jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
