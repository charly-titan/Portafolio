<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> Promociones</title>
		<meta name="description" content="">
		<meta name="author" content="">
		
</head>
	<body class="smart-style-0">



			<!-- row -->
				<div class="row">
				
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
						<div class="row">
							<div class="col-sm-12">
								<div class="text-center error-box">
									<h1 class="error-text-2 bounceInDown animated"> Error {{$code}} <span class="particle particle--c"></span><span class="particle particle--a"></span><span class="particle particle--b"></span></h1>
									<h2 class="font-xl"><strong><i class="fa fa-fw fa-warning fa-lg text-warning"></i> {{Lang::get('app.'.$code.'_description')}}</strong></h2>
									<br />
									<p class="lead">
										{{Lang::get('app.'.$code.'_explanation')}}
									</p>
									<br>

								</div>
				
							</div>
				
						</div>
				
					</div>

				<!-- end row -->

</body>
</html>