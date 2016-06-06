@if (Sentry::check())

@if ($user = Sentry::getUser())
<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="active">
            <a href="/"><i class="fa fa-home"></i> <span class="name">{{Lang::get('vcms.home_label')}}</span></a>
        </li>
        <li class="active">
            <a href="/escaleta"> <span class="name">{{Lang::get('vcms.escaleta_label')}}</span></a>
        </li>
        <li class="active">
            <a href="/progress"> <span class="name">{{Lang::get('vcms.video_generate')}}</span></a>
        </li>
        @if ($user->hasAccess('users.create'))
        <li class="active">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#forms-collapse"><span class="name">{{Lang::get('vcms.admin_label')}}</span></a>
            <ul id="forms-collapse" class="panel-collapse collapse">
                <li><a href="/userPermission">{{Lang::get('roles.title_homePermission')}}</a></li>
                <li><a href="/roles">{{Lang::get('roles.title_homeRol')}}</a></li>
            </ul>
        </li>
        @endif
        <li class="active">
            <a href="/escaletas"> <span class="name">Feeds</span></a>
        </li>
       
    </ul>
</nav>
@endif
@endif