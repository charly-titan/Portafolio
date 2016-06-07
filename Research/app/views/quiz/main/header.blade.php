	
	@section('head')
		

				<!-- HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> <img src="/img/logo.png" alt="SmartAdmin"> </span>
				<!-- END LOGO PLACEHOLDER -->

			</div>

			@if (Sentry::check())
			<!-- skins dropdown -->
			<div class="project-context hidden-xs">

				<span class="label">{{Lang::get("app.skin_selector")}}:</span>
				<span class="project-selector dropdown-toggle" data-toggle="dropdown">{{Lang::get("app.skins.0")}} <i class="fa fa-angle-down"></i></span>

				<!-- Suggestion: populate this list with fetch and push technique -->
				<ul class="dropdown-menu" id="smart-styles">
					<?php $skin_id=0;?>
					@foreach (Lang::get("app.skins") as $skin)
					<li>
						<a href="javascript:void(0);" id="smart-style-{{$skin_id}}">{{$skin}}</a>
					</li>
					<?php $skin_id++;?>
					@endforeach
				</ul>
				<!-- end dropdown-menu-->

			</div>
			<!-- end skins dropdown -->
			@endif

			<!-- pulled right: nav area -->
			<div class="pull-right">
				

				@if (Sentry::check()) 
					<!-- logout button -->
					<div id="logout" class="btn-header transparent pull-right">
						<span> <a href="/user/logout" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
					</div>
					<!-- end logout button -->


				@endif



				

				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->
				


				<!-- multiple lang dropdown : find all flags in the flags page -->
				<ul class="header-dropdown-list ">
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="/img/blank.gif" class="flag flag-{{ (Config::get( 'app.locale' )=='es')?'mx':'us' }}" alt="United States"> <span> {{ (Config::get( 'app.locale' )=="es")?" Español (MX)":" English (US)" }}</span> <i class="fa fa-angle-down"></i> </a>
						<ul class="dropdown-menu pull-right">

							<li class="active">
								<a href="/locale/en"><img src="/img/blank.gif" class="flag flag-us" alt="United States"> English (US)</a>
							</li>
							<li>
								<a href="/locale/es"><img src="/img/blank.gif" class="flag flag-mx" alt="México"> Español (MX)</a>
							</li>
						</ul>
					</li>
				</ul>
				<!-- end multiple lang -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->
	@show