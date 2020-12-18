<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Perfil Estudiante | Internship Finder</title>

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
				<div class="container-boxed max parallax-content">
					<div class="page-heading-info">
						<h1 class="page-title">Perfil Estudiante</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="container-boxed max offset main-content">
					<div class="row">
						<div class="noo-main col-md-12">
							<?php $this->renderfeedbackMessages(); ?>
							<article class="resume">
								<div class="resume-candidate-profile">
									<div class="row">
										<div class="col-sm-3 profile-avatar">
											<img alt='' src="<?= Config::get('URL') . 'images/avatar/' . $this->user->avatar; ?>" height='160' width='160' />
										</div>
										<div class="col-sm-9 candidate-detail">
											<div class="candidate-title clearfix">
												<h2><?= $this->user->name; ?></h2>
											</div>
											<div class="candidate-info">
												<div class="row">
													<div class="col-sm-6">
														<i class="fa fa-info text-primary"></i>
														&nbsp;&nbsp;<?= $this->user->document; ?>
													</div>
													<div class="col-sm-6">
														<i class="fa fa-map-marker text-primary"></i>
														&nbsp;&nbsp;<?= Config::get('CITIES')[$this->user->city]; ?>, Ecuador
													</div>
													<?php if (Session::get('user_account_type') == 1) { ?>
													<div class="col-sm-6">
														<i class="fa fa-birthday-cake text-primary"></i>
														&nbsp;&nbsp;<?= date('d/m/y', $this->user->birth); ?>
													</div>
													<?php } ?>
													<div class="col-sm-6">
														<i class="fa fa-phone text-primary"></i>
														&nbsp;&nbsp;<?= $this->user->phone; ?>
													</div>
													<div class="col-sm-6">
														<a href="mailto:suresh.savliya@gmail.com">
															<i class="fa fa-envelope text-primary"></i>
															&nbsp;&nbsp;<?= $this->user->email; ?>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr/>
								<div class="resume-content">
									<div class="row">
										<div class="col-md-12">
											<div class="resume-desc">
												<div class="resume-general row mb-4">
													<div class="col-sm-3">
														<h3 class="title-general">
															<span>BIOGRAFÍA</span>
														</h3>
													</div>
													<div class="col-sm-9 text-justify">
														<p><?= $this->user->bio ?></p>
													</div>
												</div>
												<div class="resume-timeline row mb-4">
													<div class="col-md-3 col-sm-12">
														<h3 class="title-general">
															<span>Estudios</span>
														</h3>
													</div>
													<div class="col-md-9 col-sm-12">
														<div class="timeline-container education">
															<?php
																$count = 0;
																foreach ($this->studies as $study) {
																	$count++;
															?>
															<div class="timeline-wrapper <?=  $count == count($this->studies) ? 'last' : ''; ?>">
																<div class="timeline-time">
																	<span><?= $study->start_date; ?> - <?= empty($study->end_date) ? 'Act.' : $study->end_date; ?></span>
																</div>
																<dl class="timeline-series">
																	<dt class="timeline-event">
																		<a>
																			<?= Config::get('UNIVERSITIES')[$study->school_name]; ?>
																			<span><?= Config::get('CAREERS')[$study->career]; ?></span>
																			<?php if (StudentModel::isStudyCertified($this->user->document, $study->school_name)) { ?>
																			<i class="fa fa-certificate" style="color: #578523;"></i>
																			<?php } ?>
																		</a>
																	</dt>
																</dl>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div class="resume-timeline row mb-4">
													<div class="col-md-3 col-sm-12">
														<h3 class="title-general">
															<span>Habilidades</span>
														</h3>
													</div>
													<div class="col-md-9 col-sm-12">
														<div class="skill">
															<?php foreach ($this->skills as $skill) { ?>
															<div class="pregress-bar clearfix">
																<div class="progress_title">
																	<span><?= $skill->name; ?></span>
																</div>
																<div class="progress">
																	<div role="progressbar" aria-valuemax="100" aria-valuemin="0" class="progress-bar progress-bar-bg" aria-valuenow="<?= $skill->rating; ?>" style="width: <?= $skill->rating; ?>%;">
																		<div class="progress_label"><span><?= $skill->rating; ?></span>%</div>
																	</div>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<a class="btn btn-primary" href="<?= Config::get('URL') . 'offer/applications/' . $this->offer_id; ?>">Volver a Aplicaciones</a>
											</div>
										</div>
									</div>
								</div>
							</article>
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