<header class="noo-header" id="noo-header">
	<div class="navbar-wrapper">
		<div class="navbar navbar-default fixed-top shrinkable">
			<div class="container-boxed max">
				<div class="navbar-header">
					<h1 class="sr-only">JobMonster</h1>
					<a class="navbar-toggle collapsed" data-toggle="collapse" data-target=".noo-navbar-collapse">
						<span class="sr-only">Navigation</span>
						<i class="fa fa-bars"></i>
					</a>
					<a class="navbar-toggle member-navbar-toggle collapsed" data-toggle="collapse" data-target=".noo-user-navbar-collapse">
						<i class="fa fa-user"></i>
					</a>
					<a href="<?= Config::get('URL'); ?>" class="navbar-brand">
						<img class="noo-logo-img noo-logo-normal" src="<?= Config::get('URL'); ?>images/logo-text.png" alt="">
						<img class="noo-logo-mobile-img noo-logo-normal" src="<?= Config::get('URL'); ?>images/logo-text.png" alt="">
					</a>
				</div>
				<nav class="collapse navbar-collapse noo-user-navbar-collapse">
					<ul class="navbar-nav sf-menu">
						<?php if (Session::get('user_logged_in')) { ?>
						<li>
							<a href="<?= Config::get('URL'); ?>account"><i class="fa fa-user"></i> Mi Perfil</a>
						</li>
						<?php if (Session::get('user_account_type') == 1) { ?>
						<li>
							<a href="<?= Config::get('URL'); ?>account/myapplications"><i class="fa fa-graduation-cap"></i> Mis Postulaciones</a>
						</li>
						<?php } elseif (Session::get('user_account_type') == 2) { ?>
						<li>
							<a href="<?= Config::get('URL'); ?>offer/addoffer"><i class="fa fa-pencil-square-o"></i> Crear Oferta</a>
						</li>
						<li>
							<a href="<?= Config::get('URL'); ?>offer/myoffers"><i class="fa fa-briefcase"></i> Mis Ofertas</a>
						</li>
						<li>
							<a href="<?= Config::get('URL'); ?>account/mydeals"><i class="fa fa-certificate"></i> Mis Convenios</a>
						</li>
						<li>
							<a href="<?= Config::get('URL'); ?>account/selectedapplicants"><i class="fa fa-check-circle"></i> Postulantes Aceptados</a>
						</li>
						<?php } elseif (Session::get('user_account_type') == 3) { ?>
						<li>
							<a href="<?= Config::get('URL'); ?>offer/addoffer"><i class="fa fa-pencil-square-o"></i> Crear Oferta</a>
						</li>
						<li>
							<a href="<?= Config::get('URL'); ?>offer/myoffers"><i class="fa fa-briefcase"></i> Mis Ofertas</a>
						</li>
						<li>
							<a href="<?= Config::get('URL'); ?>account/selectedapplicants"><i class="fa fa-check-circle"></i> Estudiantes Aceptados</a>
						</li>
						<?php } elseif (Session::get('user_account_type') == 4) { ?>
						<li>
							<a href="<?= Config::get('URL'); ?>admin"><i class="fa fa-dashboard"></i> Administrador</a>
						</li>
						<?php } ?>
						<li>
							<a href="<?= Config::get('URL'); ?>login/logout"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
						</li>
						<?php } else { ?>
						<li>
							<a href="<?php echo Config::get('URL'); ?>login"><i class="fa fa-sign-in"></i> Iniciar Sesión</a>
						</li>
						<li>
							<a href="<?php echo Config::get('URL'); ?>register"><i class="fa fa-key"></i> Regístrate</a>
						</li>
						<?php } ?>
					</ul>
				</nav>
				<nav class="collapse navbar-collapse noo-navbar-collapse">
					<ul class="navbar-nav sf-menu">
						<li class="current-menu-item align-left">
							<a href="<?php echo Config::get('URL'); ?>">Inicio</a>
						</li>
						<li class="align-left">
							<a href="<?= Config::get('URL'); ?>offer">Ofertas</a>
							<ul class="sub-menu">
								<li><a href="<?php echo Config::get('URL'); ?>offer?offer_type=1">Prácticas Pre-Profesionales</a></li>
								<li><a href="<?php echo Config::get('URL'); ?>offer?offer_type=2">Proyectos de Vinculación</a></li>
							</ul>
						</li>
						<li class="align-left">
							<a href="<?php echo Config::get('URL'); ?>public/companies">Compañías</a>
						</li>
						<li class="align-left">
							<a href="<?php echo Config::get('URL'); ?>public/universities">Universidades</a>
						</li>
						<?php if (Session::get('user_logged_in')) { ?>
						<li class="nav-item-member-profile login-link align-right">
							<a href="#" class="sf-with-ul">
								<span class="profile-name"><?= Session::get('user_name'); ?></span>
								<span class="profile-avatar">
									<?php if (empty(Session::get('user_avatar'))) { ?>
									<img alt="" src="images/avatar/anonymous_big.png" height="40" width="40">
									<?php } else { ?>
									<img alt="" src="<?= Config::get('URL') . 'images/avatar/' . Session::get('user_avatar'); ?>" height="40" width="40">
									<?php } ?>
								</span>
							</a>
							<ul class="sub-menu">
								<li><a href="<?= Config::get('URL'); ?>account"><i class="fa fa-user"></i> Mi Perfil</a></li>
								<?php if (Session::get('user_account_type') == 1) { ?>
								<li><a href="<?= Config::get('URL'); ?>account/myapplications"><i class="fa fa-graduation-cap"></i> Mis Postulaciones</a></li>
								<?php } elseif (Session::get('user_account_type') == 2) { ?>
								<li><a href="<?= Config::get('URL'); ?>offer/addoffer"><i class="fa fa-pencil-square-o"></i> Crear Oferta</a></li>
								<li><a href="<?= Config::get('URL'); ?>offer/myoffers"><i class="fa fa-briefcase"></i> Mis Ofertas</a></li>
								<li><a href="<?= Config::get('URL'); ?>account/mydeals"><i class="fa fa-certificate"></i> Mis Convenios</a></li>
								<li><a href="<?= Config::get('URL'); ?>account/selectedapplicants"><i class="fa fa-check-circle"></i> Postulantes Aceptados</a></li>
								<?php } elseif (Session::get('user_account_type') == 3) { ?>
								<li><a href="<?= Config::get('URL'); ?>offer/addoffer"><i class="fa fa-pencil-square-o"></i> Crear Oferta</a></li>
								<li><a href="<?= Config::get('URL'); ?>offer/myoffers"><i class="fa fa-briefcase"></i> Mis Ofertas</a></li>
								<li><a href="<?= Config::get('URL'); ?>account/selectedapplicants"><i class="fa fa-check-circle"></i> Estudiantes Aceptados</a></li>
								<?php } elseif (Session::get('user_account_type') == 4) { ?>
								<li><a href="<?= Config::get('URL'); ?>admin"><i class="fa fa-dashboard"></i> Administrador</a></li>
								<?php } ?>
								<li><a href="<?= Config::get('URL'); ?>login/logout"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
							</ul>
						</li>
						<?php } else { ?>
						<li class="nav-item-member-profile login-link align-center">
							<a href="<?php echo Config::get('URL'); ?>login" class="member-links member-login-link">
								<i class="fa fa-sign-in"></i>&nbsp;Iniciar Sesión
							</a>
						</li>
						<li class="nav-item-member-profile register-link">
							<a class="member-links member-register-link" href="<?php echo Config::get('URL'); ?>register">
								<i class="fa fa-key"></i>&nbsp;Regístrate
							</a>
						</li>
						<?php } ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</header>