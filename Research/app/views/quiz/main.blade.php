<!DOCTYPE html>
<html lang="en-us" id="{{{ isset($page_id) ? $page_id : '' }}}">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> {{Lang::get('research.app_name')}} - {{Config::get('app.app_version')}}</title>
		<meta name="description" content="">
		<meta name="author" content="Devtim">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		@include(Config::get( 'app.main_template' ).'.main.metas')

		

	</head>
	
	<body class="smart-style-0">

		@include(Config::get( 'app.main_template' ).'.main.header')


		@include(Config::get( 'app.main_template' ).'.main.aside_left')

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			@if(isset($page_id) && $page_id=="lock-page")
				@yield('content')
			@else
				<div id="content" class="{{ isset($page_id) ? 'container' : '' }}" > 
					@yield('content')
				</div>
			@endif

		</div>

		<!--================================================== -->	
		@include(Config::get( 'app.main_template' ).'.main.scripts')
		
	</body>
</html>