
<header class="page-header">
        <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li>
                        <div class="control-group">
                            <!--label class="control-label" for="default-select">Idioma</label-->
                            <div class="controls form-group">
                                <select 
                                        data-width="off"
                                        data-minimum-results-for-search="10"
                                        tabindex="-1"
                                        class="chzn-select " id="language-combo">
                                        <option value="en" {{(Session::get('locale')=="en")?"selected":""}}>Ingles</option>
                                        <option value="es" {{(Session::get('locale')=="es")?"selected":""}}>Español</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    
                        
                   
                    <li class="divider"></li>
                @if (Sentry::check())
                    <!--li class="hidden-xs dropdown">
                        <a href="#" title="Account" id="account"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul id="account-menu" class="dropdown-menu account" role="menu">
                            <li role="presentation" class="account-picture">
                                <img src="img/2.jpg" alt="">
                                Philip Daineka
                            </li>
                            <li role="presentation">
                                <a href="form_account.html" class="link">
                                    <i class="fa fa-user"></i>
                                    Profile
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="component_calendar.html" class="link">
                                    <i class="fa fa-calendar"></i>
                                    Calendar
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="link">
                                    <i class="fa fa-inbox"></i>
                                    Inbox
                                </a>
                            </li>
                        </ul>
                    </li-->
                    <li class="visible-xs">
                        <a href="#"
                           class="btn-navbar"
                           data-toggle="collapse"
                           data-target=".sidebar"
                           title="">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="hidden-xs"><a href="/logout"><i class="fa fa-sign-out"></i></a></li>
                @endif
                </ul>
        </div>
    </header>
