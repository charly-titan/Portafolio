	@section('basicas')
		 <!-- Básicas -->
		<meta name="title" content="" />
        <meta name="Description" content="Televisión: Descripción de la página" />
        <meta name="Keywords" content="Keywords, palabras clave, de, la, página" />
        <meta name="author" content="Televisa Televisión" />
        <meta charset="iso-8859-1" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1" />
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
		
	@show




	@section('faceboook')
		 <!-- Facebook / Open Graph -->
		<meta property="og:title" content="" />
        <meta property="og:site_name" content="Televisa Televisión" />
        <meta property="og:url" content="http://televisa.com" />
        <meta property="og:description" content="Televisión: Descripción de la página" />
        <meta property="og:image" content="Televisa Televisión" />
        <meta property="og:type" content="website" />
        <meta property="fb:app_id" content="122079244481169" />
	@show


	@section('twiter')
		<!-- Twitter -->
		<meta property="twitter:site" content="@TelevisaDotCom" />
        <meta property="twitter:title" content="" />
        <meta property="twitter:description" content="Televisión: Descripción de la página" />
        <meta property="twitter:image" content="Televisa Televisión" />
	@show

	@section('google')
		<!-- Google -->
		<meta itemprop="url" content="http://televisa.com" />
        <meta itemprop="name" content="" />
        <meta itemprop="description" content="Televisión: Descripción de la página" />
        <meta itemprop="image" content="Televisa Televisión" />
        <link rel="canonical" href="http://television.televisa.com" />
        <meta http-equiv="Cache-Control" content="no-store" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="Pragma" content="no-cache, must-revalidate, no-store" />
        <meta name="generator" content="Televisa TIM" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <link rel="shortcut icon" href="http://i2.esmas.com/finalpage/favicon/favicon.ico" />
        <link rel="apple-touch-icon" href="http://i2.esmas.com/finalpage/favicon/favicon_tlvsa_24.png" />
        <link rel="apple-touch-icon" sizes="76x76" href="http://i2.esmas.com/finalpage/favicon/favicon_tlvsa_76.png" />
        <link rel="apple-touch-icon" sizes="120x120" href="http://i2.esmas.com/finalpage/favicon/favicon_tlvsa_120.png" />
        <link rel="apple-touch-icon" sizes="152x152" href="http://i2.esmas.com/finalpage/favicon/favicon_tlvsa_152.png" />
	@show

	@section('css')
		
		{{ HTML::style('css/promociones/canal-5-promociones-global.css') }}
		
	@show