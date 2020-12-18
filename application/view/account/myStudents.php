<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title> Estudiantes Seleccionados | Internship Finder</title>

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
						<h1 class="page-title">Estudiantes Seleccionados</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="container-boxed max offset main-content single-noo_job">
					<div class="row">
						<div class="noo-main col-md-8">
							<div class="job-listing">
								<div class="jobs posts-loop">
									<div class="posts-loop-content">
										<?php if (empty($this->students)) { ?>
										- NO HAY ESTUDIANTES SELECCIONADOS -
										<?php } else { ?>
										<?php foreach ($this->students as $student) { ?>
										<article class="noo_job hentry">
											<div class="loop-item-wrap">
												<div class="item-featured">
													<a href="#">
														<img width="50" height="50" src="<?= Config::get('URL') . 'images/avatar/' . $student->avatar; ?>" alt="<?= $student->name; ?>"/>
													</a>
												</div>
												<div class="loop-item-content">
													<h2 class="loop-item-title">
														<a href="<?= Config::get('URL') . 'account/studentprofile/' . $student->student_id; ?>"><?= $student->name . ' ' . $student->lastname; ?></a>
													</h2>
													<p class="content-meta">
														<span>
															<i class="fa fa-map-marker"></i>
															<?= Config::get('CITIES')[$student->user_city]; ?>
														</span>
														<span>
															<time class="entry-date">
																<i class="fa fa-birthday-cake"></i>
																<?= date('d-m-Y', $student->birth); ?>
															</time>
														</span>
													</p>
												</div>
												<div class="show-view-more">
													<a class="btn btn-primary white" href="<?= Config::get('URL') . 'account/studentprofile/' . $student->student_id; ?>">Ver Perfil</a>
												</div>
											</div>
										</article>
										<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="noo-sidebar col-md-4">
							<div class="noo-sidebar-wrap">
								<div class="company-desc">
									<div class="company-header">
										<div class="company-featured">
											<a href="#">
												<img width="110" height="110" src="<?= Config::get('URL') . 'images/avatar/' . Session::get('user_avatar'); ?>" alt="<?= Session::get('user_name'); ?>"/>
											</a>
										</div>
										<h3 class="company-title">
											<a href="#"><?= Session::get('user_name'); ?></a>
										</h3>
									</div>
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