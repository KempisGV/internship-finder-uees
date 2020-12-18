<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Detalle Oferta | Internship Finder</title>

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
						<h1 class="page-title"><?= $this->offer->title; ?></h1>
					</div>
					<div class="page-sub-heading-info">
						<p class="content-meta">
							<span class="job-type <?= $this->offer->offer_type == 1 ? 'full-time' : 'part-time'?>">
								<a href="#"><i class="fa fa-bookmark"></i><?= $this->offer->offer_type == 1 ? 'Práctica Pre-Profesional' : 'Proyecto de Vinculación'; ?></a>
							</span>
							<span class="job-location">
								<i class="fa fa-map-marker"></i>
								<a href="#"><em><?= Config::get('CITIES')[$this->offer->city]; ?></em></a>
							</span>
							<span>
								<time class="entry-date" datetime="2015-08-10T09:46:53+00:00">
									<i class="fa fa-calendar"></i>
									<?= date('d-m-Y', $this->offer->publication_date) . ' / ' . date('d-m-Y', $this->offer->end_date); ?>
								</time>
							</span>
						</p>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="container-boxed max offset main-content single-noo_job">
					<div class="row">
						<div class="col-xs-12">
							<?php $this->renderFeedbackMessages(); ?>
						</div>
						<div class="noo-main col-md-8">
							<div class="job-desc">
								<h3>Descripción de la Oferta</h3>
								<p><?= $this->offer->description; ?></p>
								<h3>Carreras</h3>
								<ul>
									<?php foreach ($this->careers as $career) { ?>
									<li><?= Config::get('CAREERS')[$career->career]; ?></li>
									<?php } ?>
								</ul>
								<h3>Áreas de Trabajo</h3>
								<ul>
									<?php foreach ($this->workareas as $workarea) { ?>
									<li><?= Config::get('WORKAREAS')[$workarea->workarea]; ?></li>
									<?php } ?>
								</ul>
								<h3>Beneficios</h3>
								<ul>
									<?php foreach ($this->benefits as $benefit) { ?>
									<li><?= Config::get('BENEFITS')[$benefit->benefit]; ?></li>
									<?php } ?>
								</ul>
								<h3>Estado</h3>
								<?php
									if (empty($this->offer->publication_date)) {
										echo 'Borrador';
									}
									if (!empty($this->offer->publication_date) AND empty($this->offer->close_date) AND $this->offer->end_date <= time()) {
										echo 'Recibiendo Postulaciones';
									}
									if (!empty($this->offer->publication_date) AND empty($this->offer->close_date) AND $this->offer->end_date > time()) {
										echo 'Proceso de Selección';
									}
									if (!empty($this->offer->close_date)) {
										echo 'Proceso Finalizado';
									}
								?>
							</div>
							<div class="job-action">
								<?php if (empty(Session::get('user_logged_in'))){ ?>
								<a class="btn btn-primary mb-2 white" href="#" data-target="#login_alert" data-toggle="modal">
									Postúlate
								</a>
								<?php } ?>
								<?php if (Session::get('user_account_type') == 1 AND empty($this->offer->close_date)) { ?>
								<?php if (ApplicationModel::hasUserApplied($this->offer->offer_id)) { ?>
								<a class="btn btn-default mb-2" href="<?= Config::get('URL') . 'offer/removeapplication/' . $this->offer->offer_id; ?>">
									Cancelar Postulación
								</a>
								<?php } else { ?>
								<?php if (StudentModel::checkFilledProfile()) { ?>
								<a class="btn btn-primary mb-2 white" href="<?= Config::get('URL') . 'offer/applyoffer/' . $this->offer->offer_id; ?>">
									Postúlate
								</a>
								<?php } else { ?>
								<a class="btn btn-primary mb-2 white" href="#" data-target="#profile_incomplete" data-toggle="modal">
									Postúlate
								</a>
								<div id="profile_incomplete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
												<h4 class="modal-title" id="applyJobModalLabel">ADVERTENCIA</h4>
											</div>
											<div class="modal-body">
												<p>Para poder postularte, por favor completa tu <a style="color: #811435;" href="<?= Config::get('URL'); ?>account">perfil</a>. Debes ingresar tu biografía y al menos un estudio y habilidad.</p>
											</div>
											<div class="modal-footer">
												<a class="btn btn-default" href="#" data-dismiss="modal">OK</a>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php if ($this->offer->user_id == Session::get('user_id')) { ?>
								<?php if (empty($this->offer->close_date)) { ?>
								<a class="btn btn-primary mb-2 white" href="<?= Config::get('URL') . 'offer/editoffer/' . $this->offer->offer_id; ?>">
									Editar Oferta
								</a>
								<?php } ?>
								<?php if (empty($this->offer->publication_date)) { ?>
								<a class="btn btn-default mb-2" href="#" data-target="#publish_offer" data-toggle="modal">
									Publicar Oferta
								</a>
								<a class="btn btn-default mb-2" style="background: #ebccd1" href="#" data-target="#delete_offer" data-toggle="modal">
									Borrar Oferta
								</a>
								<?php } elseif (!empty($this->offer->publication_date)) {?>
								<?php if (empty($this->offer->close_date)) { ?>
								<a class="btn btn-default mb-2" href="#" data-target="#close_offer" data-toggle="modal">
									Cerrar Oferta
								</a>
								<?php } ?>
								<a class="btn btn-default mb-2" href="<?= Config::get('URL') . 'offer/applications/' . $this->offer->offer_id; ?>">
									Ver Postulaciones
								</a>
								<?php } ?>
								<?php } ?>
							</div>
						</div>
						<div class="noo-sidebar col-md-4">
							<div class="noo-sidebar-wrap">
								<div class="job-social clearfix">
									<span class="noo-social-title">
										Comparte esta oferta
									</span>
									<a href="#share" class="noo-icon fa fa-facebook" title="Share on Facebook"></a>
									<a href="#share" class="noo-icon fa fa-twitter" title="Share on Twitter"></a>
									<a href="#share" class="noo-icon fa fa-google-plus" title="Share on Google+"></a>
									<a href="#share" class="noo-icon fa fa-linkedin" title="Share on LinkedIn"></a>
								</div>
								<div class="company-desc">
									<div class="company-header">
										<div class="company-featured">
											<a href="#">
												<img width="110" height="110" src="<?= Config::get('URL') . 'images/avatar/' . $this->offer->avatar; ?>" alt="<?= $this->offer->name; ?>"/>
											</a>
										</div>
										<h3 class="company-title">
											<a href="#"><?= $this->offer->name; ?></a>
										</h3>
									</div>
									<div class="company-info">
										<?= $this->offer->bio; ?>
										<div class="job-social mb-0 pb-0 clearfix">
											<strong>Convenios</strong>
											<?php foreach($this->deals as $deal) { ?>
											<div class="mb-2"><a href="<?= Config::get('URL') . 'files/' . $deal->file_name; ?>" target="_blank"><?= $deal->university_name; ?></a></div>
											<?php } ?>
										</div>
										<div class="job-social clearfix">
											<span class="noo-social-title">Connect with us</span>
											<a href="#" class="company_website" target="_blank">
												<span>link de empresa</span>
											</a>
											<a class="noo-icon fa fa-facebook" href="#" target="_blank"></a>
											<a class="noo-icon fa fa-twitter" href="#" target="_blank"></a>
											<a class="noo-icon fa fa-google-plus" href="#" target="_blank"></a>
											<a class="noo-icon fa fa-linkedin" href="#" target="_blank"></a>
											<a class="noo-icon fa fa-instagram" href="#" target="_blank"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->render('_snippet/footer'); ?>

			<?php if (empty(Session::get('user_logged_in'))) { ?>
			<div id="login_alert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="applyJobModalLabel">ADVERTENCIA</h4>
						</div>
						<div class="modal-body">
							<p>Para postularte a una oferta debes <a style="color: #811435;" href="<?= Config::get('URL'); ?>login">iniciar sesión</a> o <a style="color: #811435;" href="<?= Config::get('URL'); ?>register">registrarte</a>.</p>
						</div>
						<div class="modal-footer">
							<a class="btn btn-default" href="#" data-dismiss="modal">OK</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if (empty($this->offer->publication_date)) { ?>
			<div id="publish_offer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="applyJobModalLabel">ADVERTENCIA</h4>
						</div>
						<div class="modal-body">
							<p>Está seguro de publicar esta oferta?</p>
						</div>
						<div class="modal-footer">
							<a class="btn btn-primary" href="<?= Config::get('URL') . 'offer/publishoffer_action/' . $this->offer->offer_id   . '/' . Session::get('user_id'); ?>">SI</a>
							<a class="btn btn-default" href="#" data-dismiss="modal">NO</a>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_offer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="applyJobModalLabel">ADVERTENCIA</h4>
						</div>
						<div class="modal-body">
							<p>Está seguro de borrar esta oferta?</p>
						</div>
						<div class="modal-footer">
							<a class="btn btn-primary" href="<?= Config::get('URL') . 'offer/deleteoffer_action/' . $this->offer->offer_id . '/' . Session::get('user_id'); ?>">SI</a>
							<a class="btn btn-default" href="#" data-dismiss="modal">NO</a>
						</div>
					</div>
				</div>
			</div>
			<?php } elseif (!empty($this->offer->publication_date) AND empty($this->offer->close_date)) { ?>
			<div id="close_offer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="applyJobModalLabel">ADVERTENCIA</h4>
						</div>
						<div class="modal-body">
							<?php if (!ApplicationModel::hasSelected($this->offer->offer_id)) { ?>
							<p>No ha seleccionado ningún estudiante.</p>
							<?php } ?>
							<p>Está seguro de cerrar esta oferta?</p>
						</div>
						<div class="modal-footer">
							<a class="btn btn-primary" href="<?= Config::get('URL') . 'offer/closeoffer_action/' . $this->offer->offer_id  . '/' . Session::get('user_id'); ?>">SI</a>
							<a class="btn btn-default" href="#" data-dismiss="modal">NO</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
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