<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Administración de Usuario | Internship Finder</title>

		<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/custom.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/font-awesome.min.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/jquery.datetimepicker.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/chosen.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:100,300,400,700,900,300italic,400italic,700italic,900italic" type="text/css" media="all"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat:100,300,400,700,900,300italic,400italic,700italic,900italic" type="text/css" media="all"/>
		<?php $this->render('_snippet/favicon'); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	</head>
	<body>
		<div class="site">
			<?php $this->render('_snippet/header'); ?>
			<div class="noo-page-heading">
 				<div class="container-boxed max text-center parallax-content">
	 				<?php $this->renderFeedbackMessages(); ?>
					<div class="page-heading-info ">
						<h1 class="page-title">Administración de Usuario</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-8">
							<div class="login-form-links mb-2">
								<a href="<?= Config::get('URL'); ?>admin">Volver a Administrador</a>
							</div>
							<div class="jobs posts-loop">
								<?php $this->renderfeedbackMessages(); ?>
								<div class="posts-loop-title">
									<h3 id="total_title"><?= $this->total; ?> Usuarios</h3>
								</div>
								<div class="posts-loop-content">
									<?php if (empty($this->users)) { ?>
									- NO HAY USUARIOS DISPONIBLES -
									<?php } else { ?>
									<?php foreach ($this->users as $user) { ?>
									<article class="noo_job hentry">
										<div class="loop-item-wrap">
											<div class="item-featured">
												<a href="#">
													<img width="50" height="50" src="<?= Config::get('URL') . 'images/avatar/' . $user->avatar; ?>">
												</a>
											</div>
											<div class="loop-item-content">
												<h2 class="loop-item-title" style="color: #741E39;"><?= $user->account_type == 1 ? $user->name . ' ' . $user->lastname : $user->name; ?></h2>
												<div class="content-meta">
													<span class="job-location">
														<i class="fa fa-map-marker"></i>
														<?= Config::get('CITIES')[$user->city]; ?>
													</span>
												</div>
											</div>
											<div class="show-view-more">
												<?php if ($user->active) { ?>
												<a class="btn btn-primary mb-2 white" href="<?= Config::get('URL') . 'admin/inactivateuser/' . $user->user_id; ?>">Desactivar Usuario</a><br>
												<?php } else { ?>
												<a class="btn btn-primary mb-2 white" href="<?= Config::get('URL') . 'admin/activateUser/' . $user->user_id; ?>">Activar Usuario</a><br>
												<?php } ?>
												<?php if ($user->deleted) { ?>
												<a class="btn btn-default white" href="<?= Config::get('URL') . 'admin/undeleteuser/' . $user->user_id; ?>">Habilitar Usuario</a>
												<?php } else { ?>
												<a class="btn btn-default white" href="<?= Config::get('URL') . 'admin/deleteuser/' . $user->user_id; ?>">Borrar Usuario</a>
												<?php } ?>
											</div>
										</div>
									</article>
									<?php } ?>
									<?php } ?>
								</div>
								<div class="pagination list-center">
									<?php
										$page = empty(Request::get('page')) ? 1 : Request::get('page');
										$prev = $page - 1;
										$next = $page + 1;
										$url = '';
										if (!empty(Request::get('keyword'))) {
											$url = $url . '&keyword=' . Request::get('keyword');
										}
										if (!empty(Request::get('city'))) {
											$url = $url . '&city=' . Request::get('city');
										}
										if (!empty(Request::get('user_type'))) {
											$url = $url . '&user_type=' . Request::get('user_type');
										}
									?>
									<?php if ($page > 1) { ?>
									<a class="page-numbers current" href="<?= Config::get('URL') . 'admin/users?page=' . $prev . $url; ?>"><i class="fa fa-long-arrow-left"></i></a>
									<?php } ?>
									<?php
										$new_total = ceil($this->total / 10);
										for ($i = 1; $i <= $new_total; $i++) { ?>
									<a class="page-numbers <?= $page == $i ? 'current' : ''; ?>" href="<?= Config::get('URL') . 'admin/users?page=' . $page . $url; ?>"><?= $i; ?></a>
									<?php } ?>
									<?php if ($page < $new_total) { ?>
									<a class="page-numbers current" href="<?= Config::get('URL') . 'admin/users?page=' . $next . $url; ?>"><i class="fa fa-long-arrow-right"></i></a>
									<?php } ?>
								</div>
							</div>
							<div class="login-form-links mb-2">
								<a href="<?= Config::get('URL'); ?>admin">Volver a Administrador</a>
							</div>
						</div>
						<div class="noo-sidebar col-md-4">
							<div class="noo-sidebar-wrap">
								<div class="widget widget_noo_advanced_search_widget">
									<h4 class="widget-title">Buscar Usuario</h4>
									<form class="widget-advanced-search" id="search-form" action="<?= Config::get('URL'); ?>admin/users" method="GET">
										<input type="hidden" name="page" id="page" value="<?= Request::get('page'); ?>">
										<div class="form-group">
											<label class="sr-only" for="keyword">Buscar...</label>
											<input type="text" class="form-control" id="keyword" name="keyword" placeholder="Buscar..." value="<?= Request::get('keyword'); ?>"/>
										</div>
										<div class="form-group">
											<label class="h5" for="city">Ciudad</label>
											<div class="advance-search-form-control">
												<select name="city" class="form-control-chosen form-control" id="city">
													<option class="text-placeholder" value="">- Todas las Ciudades -</option>
													<?php foreach (Config::get('CITIES') as $key => $city) { ?>
													<option value="<?= $key; ?>" <?= Request::get('city') == $key ? 'selected' : ''; ?>><?= $city; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="h5" for="user_type">Tipo Usuario</label>
											<div class="advance-search-form-control">
												<select name="user_type" class="form-control-chosen form-control" id="user_type">
													<option class="text-placeholder" value="">- Todos los Usuarios -</option>
													<option value="1" <?= Request::get('user_type') == 1 ? 'selected' : ''; ?>>Estudiante</option>
													<option value="2" <?= Request::get('user_type') == 2 ? 'selected' : ''; ?>>Compañía</option>
													<option value="3" <?= Request::get('user_type') == 3 ? 'selected' : ''; ?>>Universidad</option>
													<option value="4" <?= Request::get('user_type') == 4 ? 'selected' : ''; ?>>Administrador</option>
												</select>
											</div>
										</div>
										<button type="submit" class="btn btn-primary btn-search-submit white">Buscar</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->render('_snippet/footer'); ?>
		</div>
		<a href="#" class="go-to-top hidden-print"><i class="fa fa-angle-up"></i></a>

		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery-migrate.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/modernizr-2.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.cookie.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.blockUI.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/imagesloaded.pkgd.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/isotope-2.0.0.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.touchSwipe.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/hoverIntent-r7.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/superfish-1.7.4.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/script.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.parallax-1.1.3.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/jquery.carouFredSel-6.2.1-packed.js"></script>
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/custom.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>

	</body>
</html>