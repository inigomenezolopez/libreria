<div class="left-side-bar">
			<div class="brand-logo">
				<a href="index.html">
					<img src="/libreria/public/backend/vendors/images/deskapp-logo.svg" alt="" class="dark-logo" />
					<img
						src="/libreria/public/backend/vendors/images/deskapp-logo-white.svg"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
					<li>
							<a href="<?= base_url(route_to('admin.home')) ?>" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-home"></span
								><span class="mtext">Inicio</span>
							</a>
						</li>
						<li>
							<a href="" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-list"></span
								><span class="mtext">Categorías</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-newspaper"></span
								><span class="mtext">Cómics</span>
							</a>
							<ul class="submenu">
								<li><a href="">Todos los cómics</a></li>
								<li><a href="">Añadir nuevo</a></li>
							</ul>
						</li>
						
					
						<li>
							<div class="dropdown-divider"></div>
						</li>
						<li>
							<div class="sidebar-small-cap">Ajustes</div>
						</li>
						
						<li>
							<a
								href="<?= base_url(route_to('admin.profile')); ?>"
								
								class="dropdown-toggle no-arrow"
							>
								<span class="micon dw dw-user"></span>
								<span class="mtext"
									>Perfil
									</span>
							</a>
						</li>
						<li>
							<a
								href=""
								
								class="dropdown-toggle no-arrow"
							>
								<span class="micon dw dw-settings"></span>
								<span class="mtext"
									>General
									</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>