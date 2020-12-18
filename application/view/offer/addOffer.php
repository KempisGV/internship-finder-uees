<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Agregar Oferta | Internship Finder</title>

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
						<h1 class="page-title">Agregar Oferta</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<form class="form-horizontal" action="<?= Config::get('URL'); ?>offer/addOffer_action" method="post">
								<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
								<div class="candidate-profile-form row">
									<div class="col-sm-12">
										<?php $this->renderfeedbackMessages(); ?>
										<div class="form-group">
											<label for="city" class="col-sm-4 control-label">Tipo Oferta</label>
											<div class="col-sm-8">
												<?php if (Session::get('user_account_type') == 2) { ?>
												<input type="hidden" name="offer_type" value="1">
												<h6>Práctica Pre-Profesional</h6>
												<?php } else { ?>
										    	<select name="offer_type" class="form-control">
													<option class="text-placeholder" value="">- Seleccione una Opción -</option>
													<option value="1" <?= $this->offer_type == 1 ? 'selected' : ''; ?>>Práctica Pre-Profesional</option>
													<option value="2" <?= $this->offer_type == 2 ? 'selected' : ''; ?>>Proyecto de Vinculación</option>
												</select>
												<?php } ?>
										    </div>
										</div>
										<div class="form-group">
											<label for="name" class="col-sm-4 control-label">Título Oferta</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="name" value="<?= $this->title; ?>" name="title" placeholder="Título Oferta">
										    </div>
										</div>
										<div class="form-group">
											<label for="end_date" class="col-sm-4 control-label">Fecha Fin</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="end_date" value="<?= $this->end_date; ?>" name="end_date" placeholder="Fecha Fin" readonly>
										    </div>
										</div>
										<div class="form-group">
											<label for="city" class="col-sm-4 control-label">Ciudad</label>
											<div class="col-sm-8">
										    	<select name="city" class="form-control-chosen form-control" id="search-city">
													<option class="text-placeholder" value="">- Todas las Ciudades -</option>
													<?php foreach (Config::get('CITIES') as $key => $city) { ?>
													<option value="<?= $key; ?>" <?= $this->city == $key ? 'selected' : ''; ?>><?= $city; ?></option>
													<?php } ?>
												</select>
										    </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Carreras Afines</label>
											<div class="col-sm-8">
												<?php foreach (Config::get('CAREERS') as $key => $career) { ?>
												<div class="form-control-flat">
													<label class="checkbox pl-4">
														<input name="careers[]" type="checkbox" id="career<?= $key; ?>" value="<?= $key; ?>" <?=  in_array($key, $this->careers) ? 'checked' : ''; ?>><i></i>
														<?= $career; ?>
													</label>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Áreas de Trabajo</label>
											<div class="col-sm-8">
												<?php foreach (Config::get('WORKAREAS') as $key => $workarea) { ?>
												<div class="form-control-flat">
													<label class="checkbox pl-4">
														<input name="workareas[]" type="checkbox" id="workarea<?= $key; ?>" value="<?= $key; ?>" <?=  in_array($key, $this->workareas) ? 'checked' : ''; ?>><i></i>
														<?= $workarea; ?>
													</label>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Beneficios</label>
											<div class="col-sm-8">
												<?php foreach (Config::get('BENEFITS') as $key => $benefit) { ?>
												<div class="form-control-flat">
													<label class="checkbox pl-4">
														<input name="benefits[]" type="checkbox" id="benefit<?= $key; ?>" value="<?= $key; ?>" <?=  in_array($key, $this->benefits) ? 'checked' : ''; ?>><i></i>
														<?= $benefit; ?>
													</label>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Descripción</label>
											<div class="col-sm-8">
										    	<textarea class="form-control" rows="5" name="description" id="description" placeholder="Descripcion aquí..."><?= $this->description; ?></textarea>
										    </div>
										</div>
									</div>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-primary mb-2 white" name="publish" value="1">Guardar Oferta</button>
									<button type="submit" class="btn btn-primary mb-2 white" name="publish" value="2">Publicar Oferta</button>
								</div>
								<div class="text-center">
									<a href="<?= Config::get('URL'); ?>account">Ir a Mi Perfil</a>
								</div>
							</form>
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