<div class="header-right">
	<div class="dashboard-setting user-notification">
		<div class="dropdown">
			<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
				<i class="dw dw-settings2"></i>
			</a>
		</div>
	</div>
	<div class="user-notification">

	</div>
	<div class="user-info-dropdown">
		<div class="dropdown">
			<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
				<span class="user-icon">
					<img src="<?= base_url(get_user()->picture == null ? '/images/users/default-avatar.png' : '/images/users/' . get_user()->picture) ?>" alt="" class="ci-avatar-photo" />
				</span>
				<span class="user-name ci-user-name"><?= get_user()->name ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
				<a class="dropdown-item" href="<?= base_url(route_to('admin.profile')); ?>"><i class="dw dw-user1"></i> Perfil</a>


				<a class="dropdown-item" href="<?= base_url(route_to('admin.logout')); ?>"><i class="dw dw-logout"></i> Cerrar sesión</a>
			</div>
		</div>
	</div>

</div>
</div>