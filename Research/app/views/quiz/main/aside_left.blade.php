
@section('aside_left')
	@if (Sentry::check())
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						<img src="http://www.gravatar.com/avatar/{{Session::get('user.gravatar')}}" alt="me" class="online" />
						<span>
							{{Session::get('user.firstname')}} {{Session::get('user.lastname')}}
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive-->
			<nav>
				<ul>
					@if ($user = Sentry::getUser())
					<li class="active">
						<a href="/" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
					</li>

					@if ($user->hasAccess('users.update'))
						<li><a href="#" title="Forms">
						<i class="fa fa-lg fa-fw fa-user"></i>
						<span class="menu-item-parent">Administrador</span></a>
							<ul>
								<li>
									<a href="/roles"><i class="fa fa-share-alt"></i> <span class="menu-item-parent">Roles</span></a>
								</li>
								<li>
										<a href="/user"><i class="fa fa-lg fa-fw fa-group"></i> <span class="menu-item-parent">Usuarios</span></a>
								</li>
								<li>
									<a href="/ultima-hora/users"><i class="fa fa-lg fa-fw fa-group"></i> <span class="menu-item-parent">Ultima Hora</span></a>
								</li>
								@if ($user->hasAccess('users.create'))
								<li>
									<a href="/logviewer"><i class="fa fa-lg fa-fw fa-folder"></i> <span class="menu-item-parent">Logs</span></a>
								</li>
								<li>
									<a href="/notifications"><i class="fa fa-lg fa-fw fa-mobile"></i> <span class="menu-item-parent">Notificaciones</span></a>
								</li>
								@if ((Session::get('user.email')=='elsa.salinas@televisatim.com')||(Session::get('user.email')=='gabriel.mancera@televisatim.com'))
								<li>
									<a href="/admin"><i class="fa fa-lg fa-fw fa-magic"></i> <span class="menu-item-parent">Admin</span></a>
								</li>
								@endif
								@endif
							</ul>
						</li>
					@endif



					@if ($user->hasAccess('promo.list'))
					<li><a href="#">
						<i class="fa fa-lg fa-fw fa-puzzle-piece"></i>
						<span class="menu-item-parent">Concursos</span></a>
						<ul>
							<li>
								<a href="/contest"><i class="fa fa-lg fa-stack-overflow"></i> <span class="menu-item-parent">Listado de Concursos</span></a>
							</li>
							@if ($user->hasAccess('users.create'))
							<li><a href="#"><i class="fa fa-lg fa-bar-chart-o"></i> <span class="menu-item-parent">Reportes</span></a>
								<ul>
									<li>
										<a href="/report/register"><i class="fa fa-group"></i> <span class="menu-item-parent">Registros</span></a>
									</li>
									<li>
										<a href="/report/participant"><i class="fa fa-thumbs-up"></i> <span class="menu-item-parent">Participantes</span></a>
									</li>
								</ul>
							</li>
							@endif
						</ul>		 
					</li>
					@endif

					@if ($user->hasAccess('users.create'))
					<li><a href="#" title="Forms">
						<i class="fa fa-lg fa-fw fa-trophy"></i>
						<span class="menu-item-parent">Gigya</span></a>
							<ul>
								<li>
									<a href="/premios"><i class="fa fa-lg fa-fw fa-gift"></i> <span class="menu-item-parent">Programa de Lealtad</span></a>
								</li>
								<li>
			                        <a href="/admin-stickers"><i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Admin Albums</span></a>
			                    </li>
							</ul>
						</li>
					@endif

					

					@if ($user->hasAccess('generateurl.view'))
					<li>
						<a href="/links-share"><i class="fa fa-lg fa-fw fa-magic"></i> <span class="menu-item-parent">Generador de Urls</span></a>
					</li>
					@endif

					@if ($user->hasAccess('users.create'))
					<li>
						<a href="/photos/gallerys"><i class="fa-lg fa-fw glyphicon glyphicon-picture"></i> <span class="menu-item-parent">Photoadmin</span></a>
					</li>
					@endif

					@if ($user->hasAccess('users.create'))
					<li>
						<a href="/ultima-hora"><i class="fa fa-lg fa-fw fa-list-alt"></i> <span class="menu-item-parent">Ultima hora</span></a>
					</li>
					@endif

					@if ($user->hasAccess('twitter.list') or $user->hasAccess('users.create'))
						<li><a href="#" title="Forms">
							<i class="fa fa-lg fa-fw fa-wechat"></i>
							<span class="menu-item-parent">Redes Sociales</span></a>
							<ul>
								<li>
									<a href="/social-hub/"><i class="fa fa-lg fa-fw fa-twitter"></i> <span class="menu-item-parent">Social Hub</span></a>
								</li>
								<li>
			                        <a href="/social-hub/versus"><i class="fa fa-lg fa-fw fa-sliders"></i> <span class="menu-item-parent">Versus</span></a>
			                    </li>
			                </ul>
						</li>
                    @endif

                    
					@if ($user->hasAccess('users.create'))
                    <li>
                        <a href="/timeline"><i class="fa fa-lg fa-fw fa-clock-o"></i> <span class="menu-item-parent">Timeline</span></a>
                    </li>
                    @endif	

					@if ($user->hasAccess('users.create'))
					<li><a href="#" title="Forms">
						<i class="fa fa-lg fa-fw fa-comments-o"></i>
						<span class="menu-item-parent">Comentarios</span></a>
							<ul>
								<li>
									<a href="/comments"> Comentarios Notas</a>
								</li>
								<li>
									<a href="/comments/site"> Comentarios Sitio</a>
								</li>
							</ul>
					</li>
					@endif

					




					@endif
				</ul>
			</nav>
			<span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>

		</aside>
		<!-- END NAVIGATION -->
	@endif
@show
