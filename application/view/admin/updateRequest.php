<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Editar Solicitud | Internship Finder</title>

		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/style.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/custom.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/font-awesome.min.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/jquery.datetimepicker.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= Config::get('URL'); ?>css/chosen.css" type="text/css" media="all"/>
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
					<div class="page-heading-info ">
						<h1 class="page-title">Editar Solicitud</h1>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<div class="account-form show-login-form-links">
								<div class="account-log-form">
									<form class="form-horizontal" action="<?= Config::get('URL'); ?>admin/updaterequest_action" method="post">
										<?php $this->renderfeedbackMessages(); ?>
										<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>" />
										<input type="hidden" name="request_id" value="<?= $this->request_id; ?>">
										<div class="form-group row">
											<div class="col-xs-12">
												<div class="form-control-flat">
													<select class="user_role" name="request_type" id="request_type">
														<option value="">-Selecciona un tipo de institución-</option>
														<option value="2" <?php if ($this->request_type == 2) { echo "selected"; } ?>>Compañía</option>
														<option value="3" <?php if ($this->request_type == 3) { echo "selected"; } ?>>Universidad</option>
													</select>
													<i class="fa fa-caret-down"></i>
												</div>
											</div>
										</div>
										<div class="form-group" id="university_field">
											<div class="advance-search-form-control">
												<select name="university" class="form-control-chosen form-control" id="university">
													<option class="text-placeholder" value="">- Nombre Universidad -</option>
													<?php foreach (Config::get('UNIVERSITIES') as $key => $university) { ?>
													<option value="<?= $key; ?>" <?= $this->university == $key ? 'selected' : ''; ?>><?= $university; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<input type="text" class="log form-control" name="institution_name" id="institution_name" placeholder="Nombre de la Institución" value="<?= $this->institution_name; ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<input type="text" class="log form-control" name="name" placeholder="Nombre del Contacto" value="<?= $this->name; ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<input type="text" class="log form-control" name="lastname" placeholder="Apellidos del Contacto" value="<?= $this->lastname; ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<input type="text" class="log form-control" name="email" placeholder="Correo Electrónico" value="<?= $this->email; ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<input type="text" class="log form-control" name="document" placeholder="Cédula / RUC" value="<?= $this->document ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
												<div class="form-control-flat">
													<select class="user_role" name="city">
														<option value="">-Selecciona una Ciudad-</option>
														<?php foreach (Config::get('CITIES') as $key => $city) { ?>
														<option value="<?= $key; ?>" <?php if ($this->city == $key) { echo "selected"; } ?>><?= $city; ?></option>
														<?php } ?>
													</select>
													<i class="fa fa-caret-down"></i>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-xs-12">
										    	<input type="text" class="log form-control" name="phone" id="phone" placeholder="Teléfono" value="<?= $this->phone ?>">
										    </div>
										</div>
										<div class="form-group text-center">
											<button type="submit" class="btn btn-primary">Guardar Solicitud</button>
										</div>
										<div class="login-form-links">
											<a href="<?= Config::get('URL'); ?>admin/requests">Volver a Solicitudes</a>
										</div>
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
				
				if ($('#request_type').val() != 3) {
					$('#university_field').hide();
				}
				
				$('#request_type').on('change', function() {
					if ($(this).val() == 3) {
						$('#institution_name').prop('disabled', true);
						$('#institution_name').val($('#university_field option:selected').text());
						$('#university_field').show();
					} else {
						$('#institution_name').prop('disabled', false);
						$('#institution_name').val('');
						$('#university_field').hide();
					}
				});
				
				$('#university_field').on('change', function() {
					$('#institution_name').val($('#university_field option:selected').text());
				});
			});
		</script>
	</body>
</html>