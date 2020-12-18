<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Agregar Convenio | Internship Finder</title>

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
						<h1 class="page-title">Agregar Convenio</h1>
					</div>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<form class="form-horizontal" enctype="multipart/form-data" action="<?= Config::get('URL'); ?>account/addDeal_action" method="post">
								<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
								<div class="candidate-profile-form row">
									<div class="col-sm-12">
										<?php $this->renderfeedbackMessages(); ?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="company_id">Compañía</label>
											<div class="col-sm-8 advance-search-form-control">
												<select name="company_id" class="form-control-chosen form-control" id="company_id">
													<option class="text-placeholder" value="">- Selecciona una Compañía -</option>
											    	<?php foreach ($this->companies as $company) { ?>
											    	<option value="<?= $company->user_id; ?>" <?php if ($this->company_id == $company->user_id) { echo "selected"; } ?>><?= $company->name; ?></option>
											    	<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="school_name" class="col-sm-4 control-label">Tipo de Convenio</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="deal_type" name="deal_type">
											    	<option class="text-placeholder" value="">- Selecciona un Tipo -</option>
											    	<option value="1" <?php if ($this->deal_type == 1) { echo "selected"; } ?>>Práctica Pre-Profesional</option>
											    	<option value="2" <?php if ($this->deal_type == 2) { echo "selected"; } ?>>Proyecto de Vinculación</option>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label for="start_date" class="col-sm-4 control-label">Fecha Inicio</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="start_date" value="<?= $this->start_date; ?>" name="start_date" placeholder="Fecha Inicio" readonly>
										    </div>
										</div>
										<div class="form-group">
											<label for="duration" class="col-sm-4 control-label">Duración</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="duration" name="duration">
											    	<option class="text-placeholder" value="">- Duración en Años -</option>
											    	<option value="1" <?php if ($this->duration == 1) { echo "selected"; } ?>>1 año</option>
											    	<option value="2" <?php if ($this->duration == 2) { echo "selected"; } ?>>2 años</option>
											    	<option value="2" <?php if ($this->duration == 3) { echo "selected"; } ?>>3 años</option>
											    	<option value="2" <?php if ($this->duration == 4) { echo "selected"; } ?>>4 años</option>
											    	<option value="2" <?php if ($this->duration == 5) { echo "selected"; } ?>>5 años</option>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label for="contact_person" class="col-sm-4 control-label">Nombre Contacto Compañía</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Nombre Contacto Compañía" value="<?= $this->contact_person; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="contact_mail" class="col-sm-4 control-label">Correo Contacto Compañía</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="contact_mail" id="contact_mail" placeholder="Correo Contacto Compañía" value="<?= $this->contact_mail; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="university_person" class="col-sm-4 control-label">Nombre Contacto Universidad</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="university_person" id="university_person" placeholder="Nombre Contacto Universidad" value="<?= $this->university_person; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="university_mail" class="col-sm-4 control-label">Correo Contacto Universidad</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="university_mail" id="university_mail" placeholder="Correo Contacto Universidad" value="<?= $this->university_mail; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="deal_extent" class="col-sm-4 control-label">Extensión del Convenio</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="deal_extent" name="deal_extent">
											    	<option class="text-placeholder" value="">- Seleccione una Opción -</option>
											    	<option value="1" <?php if ($this->deal_extent == 1) { echo "selected"; } ?>>Marco</option>
											    	<option value="2" <?php if ($this->deal_extent == 2) { echo "selected"; } ?>>Específico</option>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Autorenovable</label>
											<div class="col-sm-8">
												<label for="deal_autorenewable_yes" style="margin-right: 15px;">
													<input type="radio" name="deal_autorenewable" id="deal_autorenewable_yes" value="1" <?= $this->deal_autorenewable ? 'checked' : ''; ?>> Si
												</label>
												<label for="deal_autorenewable_no">
													<input type="radio" name="deal_autorenewable" id="deal_autorenewable_no" value="0" <?= !$this->deal_autorenewable ? 'checked' : ''; ?>> No
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for"document">Archivo Convenio</label>
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
									<button type="submit" class="btn btn-primary white">Guardar Convenio</button>
								</div>
								<div class="text-center">
									<a href="<?= Config::get('URL'); ?>account">Volver a Mi Perfil</a>
								</div>
							</form>
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
				$("#start_date").datetimepicker({
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
