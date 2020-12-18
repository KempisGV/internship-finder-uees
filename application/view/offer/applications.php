<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Postulaciones de Estudiantes | Internship Finder</title>

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
				<div class="container-boxed max parallax-content">
					<div class="page-heading-info">
						<h1 class="page-title">Postulaciones de Estudiantes</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-8">
							<div class="jobs posts-loop">
								<?php $this->renderfeedbackMessages(); ?>
								<div class="posts-loop-title">
									<h3 id="total_title"></h3>
								</div>
							</div>
							<a class="btn btn-primary mt-2" href="<?= Config::get('URL') . 'offer/offerdetail/' . $this->offer_id; ?>">Volver a Detalle de Oferta</a>
						</div>
						<div class="noo-sidebar col-md-4">
							<div class="noo-sidebar-wrap">
								<div class="widget widget_noo_advanced_search_widget">
									<h4 class="widget-title">Filtrar</h4>
									<form class="widget-advanced-search" id="search-form" action="<?= Config::get('URL'); ?>offer/search" method="post">
										<input type="hidden" name="offer_id" id="offer_id" value="<?= $this->offer_id; ?>">
										<input type="hidden" name="page" id="page" value="<?= Request::get('page'); ?>">
										<div class="form-group">
											<label class="sr-only" for="keyword">palabra clave...</label>
											<input type="text" class="form-control" id="keyword" name="keyword" placeholder="palabra clave..." value="<?= Request::get('keyword'); ?>"/>
										</div>
										<div class="form-group">
											<label class="h5" for="start_date">Fecha de Aplicación</label>
											<input type="text" class="form-control mb-1" id="start_date" name="start_date" placeholder="Desde" value="<?= empty(Request::get('start_date')) ? '' : date('d-m-Y', Request::get('start_date')); ?>">
											<input type="text" class="form-control" id="end_date" name="end_date" placeholder="Hasta" value="<?= empty(Request::get('end_date')) ? '' : date('d-m-Y', Request::get('end_date')); ?>">
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
											<label class="h5">Estado</label>
											<select class="form-control" name="status" id="status">
												<option class="text-placeholder" value="">- Selecciona una Estado -</option>
												<option value="1" <?= Request::get('status') == 1 ? 'selected' : ''; ?>>Pendiente</option>
												<option value="2" <?= Request::get('status') == 2 ? 'selected' : ''; ?>>Aprovado</option>
												<option value="3" <?= Request::get('status') == 3 ? 'selected' : ''; ?>>Rechazado</option>
											</select>
										</div>
										<button type="submit" class="btn btn-primary btn-search-submit">Buscar</button>
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
		<script type="text/javascript" src="<?php echo Config::get('URL'); ?>js/main2.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#start_date").datetimepicker({
					format: "d-m-Y",
					timepicker: false,
					startDate:new Date(),
					scrollMonth: false,
					scrollTime: false,
					scrollInput: false
				});
				$("#end_date").datetimepicker({
					format: "d-m-Y",
					timepicker: false,
					startDate:new Date(),
					scrollMonth: false,
					scrollTime: false,
					scrollInput: false
				});
				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>

	</body>
</html>