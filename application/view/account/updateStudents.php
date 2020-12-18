<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Actualizar Estudiantes | Internship Finder</title>

		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/style.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/custom.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/font-awesome.min.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/jquery.datetimepicker.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/chosen.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:100,300,400,700,900,300italic,400italic,700italic,900italic" type="text/css" media="all"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat:100,300,400,700,900,300italic,400italic,700italic,900italic" type="text/css" media="all"/>
		<?php $this->render("_snippet/favicon"); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	</head>
	<body>
		<div class="site">
			<?php $this->render("_snippet/header"); ?>
			<div class="noo-page-heading">
				<div class="container-boxed max text-center parallax-content">
					<div class="member-heading-avatar">
						<img alt="" src="<?= Config::get('URL') . 'images/avatar/' . Session::get('user_avatar'); ?>" height="100" width="100"/>
						<div class="page-heading-info">
						<h1 class="page-title">Actualizar Estudiantes</h1>
					</div>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<form class="form-horizontal" enctype="multipart/form-data" action="<?= Config::get('URL'); ?>account/updateStudents_action" method="post">
								<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
								<div class="candidate-profile-form row">
									<div class="col-sm-12">
										<?php $this->renderfeedbackMessages(); ?>
										<div class="form-group text-center">
											<h5>El archivo debe de contener las cédulas de los estudiantes una por línea, debe ser de extensión TXT. Como el <a href="<?= Config::get('URL'); ?>files/estudiantes.txt">archivo de ejemplo</a>.</h5>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for"document">Archivo de Texto</label>
											<div class="col-sm-9">
												<div class="col-md-1 noo_upload"></div>
												<div class="col-md-10">
													<input type="file" id="document" name="document">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-primary white">Actualizar Estudiantes</button>
								</div>
								<div class="text-center">
									<a href="<?= Config::get('URL'); ?>account">Volver a Mi Perfil</a>
								</div>
							</form>
						</div>
						<div class="jobs posts-loop col-xs-12">
							<div class="posts-loop-title">
								<h3 id="total_title"><?= count($this->students); ?> Estudiantes</h3>
							</div>
							<div class="posts-loop-content">
								<?php foreach ($this->students as $student) { ?>
								<?php if (empty($student->name)) { ?>
								<article class="noo_job hentry">
									<div class="loop-item-wrap">
										<div class="item-featured">
											<a href="#">
												<img width="50" height="50" src="<?= Config::get('URL'); ?>images/avatar/anonymous_big.png" alt="Antonio Cevallos Gamboa">
											</a>
										</div>
										<div class="loop-item-content">
											<h2 class="loop-item-title">
												<a href="#">Usuario No Registrado</a>
											</h2>
											<p class="content-meta">
												<span class="job-location">
													<i class="fa fa-info"></i>
													<a href="#">
														<em><?= $student->student; ?></em>
													</a>
												</span>
												<span class="job-location">
													<i class="fa fa-envelope"></i>
													<a href="#">
														<em>No Aplica</em>
													</a>
												</span>
												<span class="job-location">
													<i class="fa fa-map-marker"></i>
													<a href="#">
														<em>No Aplica</em>
													</a>
												</span>
											</p>
										</div>
									</div>
								</article>
								<?php } else { ?>
								<article class="noo_job hentry">
									<div class="loop-item-wrap">
										<div class="item-featured">
											<a href="<?= Config::get('URL') .'account/studentprofile/' . $student->user_id; ?>">
												<img width="50" height="50" src="<?= Config::get('URL') . 'images/avatar/' . $student->avatar; ?>" alt="Antonio Cevallos Gamboa">
											</a>
										</div>
										<div class="loop-item-content">
											<h2 class="loop-item-title">
												<a href="<?= Config::get('URL') .'account/studentprofile/' . $student->user_id; ?>"><?= $student->name . ' ' . $student->lastname; ?></a>
											</h2>
											<p class="content-meta">
												<span class="job-location">
													<i class="fa fa-info"></i>
													<a href="<?= Config::get('URL') .'account/studentprofile/' . $student->user_id; ?>">
														<em><?= $student->student; ?></em>
													</a>
												</span>
												<span class="job-location">
													<i class="fa fa-envelope"></i>
													<a href="<?= Config::get('URL') .'account/studentprofile/' . $student->user_id; ?>">
														<em><?= $student->email; ?></em>
													</a>
												</span>
												<span class="job-location">
													<i class="fa fa-map-marker"></i>
													<a href="<?= Config::get('URL') .'account/studentprofile/' . $student->user_id; ?>">
														<em><?= Config::get('CITIES')[$student->city]; ?></em>
													</a>
												</span>
											</p>
										</div>
									</div>
								</article>
								<?php } ?>
								<?php }; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->render("_snippet/footer"); ?>
		</div>
		<a href="#" class="go-to-top hidden-print"><i class="fa fa-angle-up"></i></a>

		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery-migrate.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/modernizr-2.7.1.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.cookie.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.blockUI.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/imagesloaded.pkgd.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/isotope-2.0.0.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.touchSwipe.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/hoverIntent-r7.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/superfish-1.7.4.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/script.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.parallax-1.1.3.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/jquery.carouFredSel-6.2.1-packed.js"></script>
		<script type="text/javascript" src="<?= Config::get('URL'); ?>js/custom.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>
	</body>
</html>
