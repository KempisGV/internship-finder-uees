<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Directorio Universidades | Internship Finder</title>

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
						<h1 class="page-title">Directorio Universidades</h1>
					</div>
				</div> 
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-8">
							<div class="form-title">
								<h3>Universidades</h3>
							</div>
							<div class="company-letters">
								<a href="#A">A</a>
								<a href="#B">B</a>
								<a href="#C">C</a>
								<a href="#D">D</a>
								<a href="#E">E</a>
								<a href="#F">F</a>
								<a href="#G">G</a>
								<a href="#H">H</a>
								<a href="#I">I</a>
								<a href="#J">J</a>
								<a href="#K">K</a>
								<a href="#L">L</a>
								<a href="#M">M</a>
								<a href="#N">N</a>
								<a href="#O">O</a>
								<a href="#P">P</a>
								<a href="#Q">Q</a>
								<a href="#R">R</a>
								<a href="#S">S</a>
								<a href="#T">T</a>
								<a href="#U">U</a>
								<a href="#V">V</a>
								<a href="#W">W</a>
								<a href="#X">X</a>
								<a href="#Y">Y</a>
								<a href="#Z">Z</a>
							</div>
							<div class="masonry">
								<ul class="companies-overview masonry-container">
									<?php
										$letter = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
										foreach ($letter as $i) {
											$universities = UniversityModel::getUniversities($i);
											if (!empty($universities[0]->user_id)) {
									?>
									<li class="company-group masonry-item">
										<div id="<?= strtoupper($i); ?>" class="company-letter text-primary"><?= strtoupper($i); ?></div>
										<ul>
											<?php foreach ($universities as $university) { ?>
											<li class="company-name"><a href="<?= Config::get('URL') . 'public/universityProfile/' . $university->user_id; ?>"><?= $university->name . ' (' . $university->offers . ')'; ?></a></li>
											<?php } ?>
										</ul>
									</li>
									<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
						<div class=" noo-sidebar col-md-4">
							<div class="noo-sidebar-wrap">
								<div class="widget noo-job-search-widget">
									<h3 class="widget-title">Buscar Oferta</h3>
									<form class="form-horizontal noo-job-search">
										<label class="sr-only" for="s">Buscar:</label>
										<input type="search" id="s" class="form-control" placeholder="palabra clave" value="" name="s" title="Search for:"/>
										<input type="submit" class="hidden"/>
									</form>
								</div>
								<div class="widget noo-job-count-widget">
									<ul>
										<li>
											<span class="h5">Universidades</span>
											<p class="jobs-count"><?= count(UniversityModel::countUniversity()); ?></p>
										</li>
										<li>
											<span class="h5">Prácticas Pre-Profesionales</span>
											<p class="jobs-count"><?= count(CompanyModel::getOffers()); ?></p>
										</li>
										<li>
											<span class="h5">Proyectos de Vinculación</span>
											<p class="jobs-count"><?= count(UniversityModel::getOffers()); ?></p>
										</li>
									</ul>
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