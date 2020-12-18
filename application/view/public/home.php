<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Inicio | Internship Finder</title>

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
			<div class="container-wrap">
				<div class="main-content container-fullwidth">
					<div class="row">
						<div class="noo-main col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="noo-job-search-wrapper">
										<div class="job-search-bg-image"></div>
										<div class="job-advanced-search column-4">
											<div class="job-search-info text-center">
												<p class="search-top-title">Internship Finder</p>
												<h3 class="search-main-title">Búsqueda de Ofertas</h3>
											</div>
											<div class="job-advanced-search-wrap">
												<form class="form-inline" action="<?= Config::get('URL'); ?>offer" method="get">
													<div class="job-advanced-search-form">
														<div class="form-group">
															<label class="sr-only" for="keyword">palabra clave</label>
															<input type="text" class="form-control" id="keyword" name="keyword" placeholder="Buscar..." value="">
														</div>
														<div class="form-group">
															<label class="sr-only">Ciudad</label>
															<div class="advance-search-form-control">
																<select name="city" class="form-control-chosen form-control">
																	<option class="text-placeholder" value="">Todas las Ciudades</option>
																	<?php foreach (Config::get('CITIES') as $key => $city) { ?>
																	<option value="<?= $key; ?>"><?= $city; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<div class="form-group form-action">
															<button type="submit" class="btn btn-primary btn-search-submit"><i class="fa fa-search"></i></button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row bg-primary">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12">
											<div class="noo-step-icon clearfix">
												<ul class="noo-step-icon-3">
													<li>
														<span class="noo-step-icon-item">
															<a href="<?= Config::get('URL') ?>login">
																<span class="fa fa-key noo-step-icon-class"></span>
																<span class="noo-step-icon-title">
																	1. Inicia Sesión o Regístrate
																</span>
															</a>
														</span>
													</li>
													<li>
														<span class="noo-step-icon-item">
															<a href="<?= Config::get('URL') ?>offer">
																<span class="fa fa-search-plus noo-step-icon-class"></span>
																<span class="noo-step-icon-title">
																	2. Busca tu oferta deseada
																</span>
															</a>
														</span>
													</li>
													<li>
														<span class="noo-step-icon-item">
															<a href="<?= Config::get('URL') ?>offer">
																<span class="fa fa-file-text-o noo-step-icon-class"></span>
																<span class="noo-step-icon-title">
																	3. Postulate a tú oferta deseada
																</span>
															</a>
														</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row pt-10 pb-10 bg-white">
								<div class="container-boxed max">
									<div class="col-md-12">
										<?php $this->renderFeedbackMessages(); ?>
									</div>
									<div class="col-md-12">
										<div class="noo-tabs">
											<div class="tab-control tab-control-right clearfix">
												<ul class="nav nav-tabs" role="tablist" id="noo-tabs-2">
													<li><a role="tab" data-toggle="tab" href="#tab-1">Recientes</a></li>
												</ul>
											</div>
											<div class="tab-content clearfix">
												<div class="tab-pane" id="tab-1">
													<div class="jobs posts-loop">
														<div class="posts-loop-title">
															<h3>
																Ofertas Recientes
															</h3>
														</div>
														<div class="posts-loop-content">
															<?php foreach ($this->offers as $offer) { ?>
															<article class="noo_job hentry">
																<div class="loop-item-wrap">
																	<div class="item-featured">
																		<a href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>">
																			<img width="50" height="50" src="<?= Config::get('URL') . 'images/avatar/' . $offer->avatar; ?>" alt="<?= $offer->name; ?>"/>
																		</a>
																	</div>
																	<div class="loop-item-content">
																		<h2 class="loop-item-title">
																			<a href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>"><?= $offer->title; ?></a>
																		</h2>
																		<p class="content-meta">
																			<span class="job-company">
																				<a href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>"><?= $offer->name; ?></a>
																			</span>
																			<span class="job-type <?= $offer->offer_type == 1 ? 'full-time' : 'part-time'; ?>">
																				<a href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>">
																					<i class="fa fa-bookmark"></i><?= $offer->offer_type == 1 ? 'Práctica Pre-Profesional' : 'Proyecto de Vinculación'; ?>
																				</a>
																			</span>
																			<span class="job-location">
																				<i class="fa fa-map-marker"></i>
																				<a href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>"><em><?= Config::get('CITIES')[$offer->city]; ?></em></a>
																			</span>
																			<span>
																				<time class="entry-date" datetime="2015-08-18T01:40:23+00:00">
																					<i class="fa fa-calendar"></i>
																					<?= date('d-m-Y', $offer->publication_date) . " / " . date('d-m-Y', $offer->end_date) ; ?>
																				</time>
																			</span>
																		</p>
																	</div>
																	<div class="show-view-more">
																		<a class="btn btn-primary white" href="<?= Config::get('URL') . 'offer/offerdetail/' . $offer->offer_id; ?>">Ver Oferta</a>
																	</div>
																</div>
															</article>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
<!--						<div class="row bg-gray pt-9 pb-0">
								<div class="col-md-12">
									<div class="container-boxed max">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="noo-text-block">
													<h3>Compañías Destacadas</h3>
													<p>
														Donec ut condimentum dui. Mauris vestibulum eros lacus, in ultricies nulla malesuada ac. Praesent semper leo a libero ultrices tempus.
													</p>
												</div>
												<hr class="noo-clear" />
												<div class="noo-text-block list-image-employer">
													<p>
														<a href="#">
															<img src="images/logo_1.png" alt="" width="210" height="120"/>
														</a>
														<a href="#">
															<img src="images/logo_2.png" alt="" width="210" height="120"/>
														</a>
														<a href="#">
															<img src="images/logo_3.png" alt="" width="210" height="120"/>
														</a>
														<a href="#">
															<img src="images/logo_4.png" alt="" width="210" height="120"/>
														</a>
														<a href="#">
															<img src="images/logo_5.png" alt="" width="210" height="120"/>
														</a>
														<a href="#">
															<img src="images/logo_6.png" alt="" width="210" height="120"/>
														</a>
													</p>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<img src="images/home-image.png" alt="home-image" class="noo-image">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row bg-gray-overlay bg-image bg-parallax pt-10 pb-10">
								<div class="col-md-12 parallax-content">
									<div id="noo-slider-3" class="noo-slider bottom-indicators">
										<ul class="sliders">
											<li class="slide-item">
												<div class="slide-content">
													<div class="our-customer">
														<p>
															<a class="customer-avatar" href="#">
																<img src="images/avatar/user_100x100.jpg" alt="customer" width="100" height="100"/>
															</a>
														</p>
														<div class="custom-desc">
															<h5>JOHNNY SANDERS</h5>
															<p>
																Branding Manage &#8211; Fliplist.com<br/>
																<i>“Donec sagittis et massa at rutrum. Proin eleifend nunc interdum tortor malesuada molestie. Donec dictum orci in ipsum aliquam aliquam. Nunc facilisis convallis lobortis. Phasellus erat dui, pulvinar vitae odio vel.”</i>
															</p>
														</div>
													</div>
												</div>
											</li>
											<li class="slide-item">
												<div class="slide-content">
													<div class="our-customer">
														<p>
															<a class="customer-avatar" href="#">
																<img src="images/avatar/user_100x100.jpg" alt="customer" width="100" height="100"/>
															</a>
														</p>
														<div class="custom-desc">
															<h5>JOHNNY SANDERS</h5>
															<p>
																Branding Manage &#8211; Fliplist.com<br/>
																<i>“Donec sagittis et massa at rutrum. Proin eleifend nunc interdum tortor malesuada molestie. Donec dictum orci in ipsum aliquam aliquam. Nunc facilisis convallis lobortis. Phasellus erat dui, pulvinar vitae odio vel.”</i>
															</p>
														</div>
													</div>
												</div>
											</li>
											<li class="slide-item">
												<div class="slide-content">
													<div class="our-customer">
														<p>
															<a class="customer-avatar" href="#">
																<img src="images/avatar/user_100x100.jpg" alt="customer" width="100" height="100"/>
															</a>
														</p>
														<div class="custom-desc">
															<h5>JOHNNY SANDERS</h5>
															<p>
																Branding Manage &#8211; Fliplist.com<br/>
																<i>“Donec sagittis et massa at rutrum. Proin eleifend nunc interdum tortor malesuada molestie. Donec dictum orci in ipsum aliquam aliquam. Nunc facilisis convallis lobortis. Phasellus erat dui, pulvinar vitae odio vel.”</i>
															</p>
														</div>
													</div>
												</div>
											</li>
										</ul>
										<div class="clearfix"></div>
										<div id="noo-slider-3-pagination" class="slider-indicators"></div>
									</div>
								</div>
								<div class="parallax customer" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
							</div>
							<div class="row bg-gray pt-10 pb-10">
								<div class="col-md-12">
									<div class="noo-text-block">
										<h3 class="text-center">What JobMonster Offered</h3>
										<p class="text-center text-italic">
											Integer mollis nunc et nibh sodales volutpat. Vivamus rhoncus, magna quis ultricies<br/>
											rhoncus, neque nunc laoreet dolor.
										</p>
									</div>
									<div class="container-boxed max">
										<div class="row pt-5 pb-2">
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-mobile"></i>
															</span>
														</span>
														<strong>CROSS BROWSERS</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-cog"></i>
															</span>
														</span>
														<strong>EASY CUSTOMIZATION</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-star"></i>
															</span>
														</span>
														<strong>POWERFUL FEATURES</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="container-boxed max">
										<div class="row pt-2 pb-2">
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-magic"></i>
															</span>
														</span>
														<strong>MODERN DESIGN</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-code"></i>
															</span>
														</span>
														<strong>CLEAN CODING</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="noo-text-block">
													<p>
														<span class="text-primary pr-2">
															<span class="noo-icon features-icon icon-circle">
																<i class="fa fa-thumbs-o-up"></i>
															</span>
														</span>
														<strong>QUICK SUPPORT</strong><br/>
														Donec et massa malesuada, laoreet lacus non, lacinia felis. Phasellus pretium enim tellus, et aliquet mi fringilla non. Aenean lorem libero, adipiscing.
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row bg-primary-overlay bg-image bg-parallax pt-5 pb-0">
								<div class="app-bg2"></div>
								<div class="col-md-12 parallax-content">
									<div class="container-boxed max">
										<div class="row pt-2 pb-0">
											<div class="col-md-6 col-sm-12 pull-right pt-10">
												<div class="noo-text-block">
													<div class="app-section white">
														<h3 class="white">Descarga nuestra aplicación móvil</h3>
														<p>
															<em>Encontrar la pasantía perfecta para ti nunca ha sido tan fácil. Ahora puedes encontrar la oportunidad perfecta que se ajuste a tu carrera y expectativas. Aplica a las diferentes ofertas y recibe las notificaciones directamente en tu dispositivo móvil. Descarga la aplicación de Internship Finder ahora.</em>
															<img class="mr-2 mt-3" src="images/app-googleplay.png" alt="customer"/>
															<img class="mt-3" src="images/app-appstore.png" alt="customer"/>
														</p>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12 pr-8">
												<img src="images/app-device.png" alt="app-device" class="noo-image">
											</div>
										</div>
									</div>
								</div>
								<div class="parallax app" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
							</div>
-->
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
		<script>
			jQuery("document").ready(function ($) {
				$("#noo-slider-3 .sliders").carouFredSel({
					infinite: true,
					circular: true,
					responsive: true,
					debug : false,
					items: {
					  start: 0
					},
					scroll: {
					  items: 1,
					  duration: 400,

					  fx: "scroll"
					},
					auto: {
					  timeoutDuration: 3000,

					  play: true
					},

					pagination: {
					  container: "#noo-slider-3-pagination"
					},
					swipe: {
					  onTouch: true,
					  onMouse: true
					}
				});
				$("#noo-tabs-2 a:eq(0)").tab("show");

				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>

	</body>
</html>