<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title><?= isset($pageTitle) ? $pageTitle : 'New Page Title'; ?></title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/libreria/public/backend/vendors/images/mifavicon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/libreria/public/backend/vendors/images/mifavicon.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/libreria/public/backend/vendors/images/mifavicon.png" />

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/libreria/public/backend/vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="/libreria/public/backend/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="/libreria/public/backend/vendors/styles/style.css" />
	<link rel="stylesheet" href="/libreria/public/extra-assets/ijabo/ijabo.min.css">
	<link rel="stylesheet" href="/libreria/public/extra-assets/ijaboCropTool/ijaboCropTool.min.css">
	<?= $this->renderSection('stylesheets') ?>
	<style>
		.swal2-popup {
			font-size: .87em;

		}
	</style>
</head>

<body>


	<div class="header">
		<div class="header-left">
			<div class="menu-icon bi bi-list"></div>
			<div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>

		</div>
		<?php include('inc/header.php'); ?>

		<?php include('inc/right-sidebar.php'); ?>

		<?php include('inc/left-sidebar.php'); ?>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">

					<div>
						<?= $this->renderSection('content') ?>
					</div>
				</div>
				<?php include('inc/footer.php'); ?>
			</div>
		</div>

		<!-- js -->
		<script src="/libreria/public/backend/vendors/scripts/core.js"></script>
		<script src="/libreria/public/backend/vendors/scripts/script.min.js"></script>
		<script src="/libreria/public/backend/vendors/scripts/process.js"></script>
		<script src="/libreria/public/backend/vendors/scripts/layout-settings.js"></script>
		<script src="/libreria/public/extra-assets/ijabo/ijabo.min.js"></script>
		<script src="/libreria/public/extra-assets/ijabo/jquery.ijaboViewer.min.js"></script>
		<script src="/libreria/public/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
		<?= $this->renderSection('scripts') ?>
</body>

</html>