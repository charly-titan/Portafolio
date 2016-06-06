@if (Sentry::check())

    @if ($user = Sentry::getUser())
    
        <nav id="sidebar" class="sidebar nav-collapse collapse">
            
            <ul id="side-nav" class="side-nav">
                    <li class="active">
                        <a href="/welcome"><i class="fa fa-home"></i> <span class="name">{{Lang::get('vcms.home_label')}}</span></a>
                    </li>
                    @if ($user->hasAccess('video.create'))
                        <li class="panel">
                            <a class="accordion-toggle collapsed" data-toggle="collapse"
							   data-parent="#side-nav" href="#create"><i class="fa fa-play"></i><span class="name">{{Lang::get('vcms.create_video')}}</span></a>
							<ul id="create" class="panel-collapse collapse">
								<li><a href="/v1">{{Lang::get('vcms.video_preview')}}</a></li>
								<li><a href="/v2">{{Lang::get('vcms.video_live')}}</a></li>
							</ul>
                        </li>
                    @endif

                    @if ($user->hasAccess('video.view'))
                        <li class="panel">
                            <a href="/progress"><i class="fa fa fa-sort-amount-asc"></i> <span class="name">{{Lang::get('vcms.video_generate')}}</span></a>
                        </li>
                    @endif

                    @if ($user->hasAccess('video.create'))

                    @endif

                    @if ($user->hasAnyAccess(array('users.create','roles.create')))
                        <li class="panel">
                            <a class="accordion-toggle collapsed" data-toggle="collapse"
                               data-parent="#side-nav" href="#forms-collapse"><i class="fa fa-users"></i><span class="name">{{Lang::get('vcms.admin_label')}}</span></a>
                            <ul id="forms-collapse" class="panel-collapse collapse">
                                @if ($user->hasAccess('users.create'))
                                <li><a href="/userPermission">{{Lang::get('roles.title_homePermission')}}</a></li>
                                @endif
                                @if ($user->hasAccess('roles.create'))
                                <li><a href="/roles">{{Lang::get('roles.title_homeRol')}}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    <li class="panel">
                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                           data-parent="#side-nav" href="#escaletas"><i class="fa fa-th-list"></i><span class="name">{{Lang::get('vcms.video_playlist')}}</span></a>
                        <ul id="escaletas" class="panel-collapse collapse">

                            <li><a href="/escaleta">{{Lang::get('vcms.adjust_playlist')}}</a></li>
                            <li><a href="/adminFeeds">{{Lang::get('vcms.admin_feeds')}}</a></li>
                            <li><a href="/resgitroUrls">{{Lang::get('vcms.opening_signal')}}</a></li>
                            <li><a href="/demo/primero.html" target="_blank">demo</a></li>
                        </ul>
                    </li>
                    
            </ul>
            
        </nav>
    
    @endif
    
@endif