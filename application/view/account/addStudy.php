<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Agregar Estudios | Internship Finder</title>

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
						<h1 class="page-title">Agregar Estudios</h1>
					</div>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<form class="form-horizontal" action="<?= Config::get('URL'); ?>account/addStudy_action" method="post">
								<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
								<div class="candidate-profile-form row">
									<div class="col-sm-12">
										<?php $this->renderfeedbackMessages(); ?>
										<div class="form-group">
											<label for="start_date" class="col-sm-4 control-label">Inicio - Fin</label>
											<div class="col-sm-8">
												<div class="col-sm-6">
											    	<select type="text" class="form-control" id="start_date" name="start_date">
												    	<option class="text-placeholder" value="">- Inicio -</option>
												    	<?php for ($i = 2005; $i <= 2016; $i++) { ?>
												    	<option value="<?= $i; ?>" <?php if ($this->start_date == $i) { echo "selected"; } ?>><?= $i; ?></option>
												    	<?php } ?>
											    	</select>
												</div>
												<div class="col-sm-6">
											    	<select type="text" class="form-control" id="end_date" name="end_date">
												    	<option class="text-placeholder" value="">- Fin (Opcional) -</option>
												    	<?php for ($i=2006; $i<=2016; $i++) { ?>
												    	<option value="<?= $i; ?>" <?php if ($this->end_date == $i) { echo "selected"; } ?>><?= $i; ?></option>
												    	<?php } ?>
											    	</select>
												</div>
										    </div>
										</div>
										<div class="form-group">
											<label for="school_name" class="col-sm-4 control-label">Universidad</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="school_name" name="school_name">
											    	<option class="text-placeholder" value="">- Selecciona una Universidad -</option>
											    	<?php foreach (Config::get('UNIVERSITIES') as $key => $university) { ?>
											    	<option value="<?= $key; ?>" <?php if ($this->school_name == $key) { echo "selected"; } ?>><?= $university; ?></option>
											    	<?php } ?>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label for="career" class="col-sm-4 control-label">Carrera</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="career" name="career">
											    	<option class="text-placeholder" value="">- Selecciona una Carrera -</option>
											    	<?php foreach (Config::get('CAREERS') as $key => $career) { ?>
											    	<option value="<?= $key; ?>" <?php if ($this->career == $key) { echo "selected"; } ?>><?= $career; ?></option>
											    	<?php } ?>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label for="credits" class="col-sm-4 control-label">Número de Créditos</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="credits" value="<?= $this->credits; ?>" name="credits" placeholder="Número de Créditos">
										    </div>
										</div>
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Descripción</label>
											<div class="col-sm-8">
										    	<textarea class="form-control" id="description" name="description" rows="5" placeholder="Escribe la descripción de tus estudios aquí..."><?= $this->description; ?></textarea>
										    </div>
										</div>
									</div>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-primary white">Guardar Estudio</button>
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
				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>
	</body>
</html>
