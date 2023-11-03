<div class="left-side-bar">
	<div class="brand-logo mb-0 pb-0">
		<a href="<?= base_url(route_to('admin.home')) ?>">
			<img src="/libreria/public/backend/vendors/images/adminpanel-logo.png" alt="" class="dark-logo" style="width: 150px; height: 30px;" />


			<img src="/libreria/public/backend/vendors/images/adminpanel-logo.png" alt="" class="light-logo" style="width: 150px; height: 30px;" />
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
						<span class="micon dw dw-home"></span><span class="mtext">Inicio</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url(route_to('categories')); ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-list"></span><span class="mtext">Categorías</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon dw dw-newspaper"></span><span class="mtext">Cómics</span>
					</a>
					<ul class="submenu">
						<li><a href="<?= base_url(route_to('all-comics')) ?>">Todos los cómics</a></li>
						<li><a href="<?= base_url(route_to('new-comic')) ?>">Añadir nuevo</a></li>
					</ul>
				</li>
				<li>
					<a href="<?= base_url(route_to('trans-info')); ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-shopping-bag"></span>
						<span class="mtext">Transacciones</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url(route_to('user-info')); ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-user-2"></span><span class="mtext">Usuarios</span>
					</a>
				</li>

				<li>
					<div class="dropdown-divider"></div>
				</li>
				<li>
					<div class="sidebar-small-cap">Ajustes</div>
				</li>

				<li>
					<a href="<?= base_url(route_to('admin.profile')); ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-user"></span>
						<span class="mtext">Perfil
						</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
</div>