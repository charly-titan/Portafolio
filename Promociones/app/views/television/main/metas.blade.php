	@section('basicas')
                <!-- Básicas -->
        	<meta name="title" content="{{(isset($info->properties['nameContest']))?$info->properties['nameContest']:''}}" />
                <meta name="Description" content="{{(isset($info->properties['descriptionContest']))?$info->properties['descriptionContest']:''}}" />
                <meta name="Keywords" content="{{(isset($info->properties['keywordContest']))?$info->properties['keywordContest']:''}}" />
                <meta name="author" content="Televisa Televisión" />
                <!--meta charset="iso-8859-1" /-->
                <meta charset="utf-8" >
                <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1" />
                <meta name="HandheldFriendly" content="True" />
                <meta name="MobileOptimized" content="320" />
                <meta name="robots" content="noindex, nofollow">
        		
	@show




	@section('faceboook')
		 <!-- Facebook / Open Graph -->
		<meta property="og:title" content="{{(isset($info->properties['nameContest']))?$info->properties['nameContest']:''}}" />
                <meta property="og:site_name" content="Televisa Televisión" />
                <meta property="og:url" content="{{(isset($info->urlActual))?$info->urlActual:''}}" />
                <meta property="og:description" content="{{(isset($info->properties['descriptionContest']))?$info->properties['descriptionContest']:''}}" />
                <meta property="og:image" content="{{(isset($info->properties['contestImg']))?$info->properties['contestImg']:''}}" />
                <meta property="og:type" content="website" />
                <meta property="fb:app_id" content="122079244481169" />
                <meta name="robots" content="noindex, nofollow">
	@show


	@section('twiter')
        	<!-- Twitter -->
        	<meta property="twitter:site" content="@TelevisaDotCom" />
                <meta property="twitter:title" content="{{(isset($info->properties['nameContest']))?$info->properties['nameContest']:''}}" />
                <meta property="twitter:description" content="{{(isset($info->properties['descriptionContest']))?$info->properties['descriptionContest']:''}}" />
                <meta property="twitter:image" content="{{(isset($info->properties['contestImg']))?$info->properties['contestImg']:''}}" />
                <meta name="robots" content="noindex, nofollow">
	@show

	@section('google')
		<!-- Google -->
        	<meta itemprop="url" content="{{(isset($info->urlActual))?$info->urlActual:''}}" />
                <meta itemprop="name" content="{{(isset($info->properties['nameContest']))?$info->properties['nameContest']:''}}" />
                <meta itemprop="description" content="{{(isset($info->properties['descriptionContest']))?$info->properties['descriptionContest']:''}}" />
                <meta itemprop="image" content="{{(isset($info->properties['contestImg']))?$info->properties['contestImg']:''}}" />
                <link rel="canonical" href="http://television.televisa.com" />
                <meta http-equiv="Cache-Control" content="no-store" />
                <meta http-equiv="Expires" content="0" />
                <meta http-equiv="Pragma" content="no-cache, must-revalidate, no-store" />
                <meta name="generator" content="Televisa TIM" />
                <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
                <meta name="robots" content="noindex, nofollow">
                <link rel="shortcut icon" href="/img/favicon.ico" />
                <link rel="apple-touch-icon" href="/img/favicon_tlvsa_24.png" />
                <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon_tlvsa_76.png" />
                <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon_tlvsa_120.png" />
                <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon_tlvsa_152.png" />
	@show

	@section('css')
                @if ($info->contest_type!="versus") 
		          {{HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'css/promociones/canal-5-promociones-global.css')}}
                @else
                        {{ HTML::style(isset($info->properties['UrlCss'])?$info->properties['UrlCss']:'/versus/css/versus.css') }}
                        {{ HTML::style('/versus/css/c5-versus-fonts.css') }}
                        
                @endif

                <script>
                        var customTitle = '{{str_replace("'","",(isset($info->properties["nameContest"]))?$info->properties["nameContest"]:"")}}';
                        var customUrl ='http://tvsa.mx/{{str_replace("'","",(isset($info->properties["shortUrlContest"]))?$info->properties["shortUrlContest"]:Request::path())}}';
                </script>
		
	@show