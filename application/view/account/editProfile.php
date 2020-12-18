<!doctype html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<title>Editar Mi Perfil | Internship Finder</title>

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
					<div class="member-heading-avatar">
						<img alt="" src="<?= Config::get('URL') . 'images/avatar/' . Session::get('user_avatar'); ?>" height="100" width="100"/>
						<div class="page-heading-info">
						<h1 class="page-title">Editar Perfil</h1>
					</div>
					</div>
				</div>
				<div class="parallax heading" data-parallax="1" data-parallax_no_mobile="1" data-velocity="0.1"></div>
			</div>
			<div class="container-wrap">
				<div class="main-content container-boxed max offset">
					<div class="row">
						<div class="noo-main col-md-12">
							<form class="form-horizontal" enctype="multipart/form-data" action="<?= Config::get('URL'); ?>account/editProfile_action" method="post">
								<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
								<div class="candidate-profile-form row">
									<div class="col-sm-12">
										<?php $this->renderfeedbackMessages(); ?>
										<div class="form-group">
											<label for="name" class="col-sm-4 control-label">Nombres</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="name" value="<?= $this->user->name; ?>" name="name" placeholder="Nombres">
										    </div>
										</div>
										<?php if (Session::get('user_account_type') == 1) { ?>
										<div class="form-group">
											<label for="name" class="col-sm-4 control-label">Apellidos</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="name" value="<?= $this->user->lastname; ?>" name="lastname" placeholder="Apellidos">
										    </div>
										</div>
										<?php } ?>
										<div class="form-group">
											<label for="email" class="col-sm-4 control-label">Correo</label>
											<div class="col-sm-8">
										    	<input type="email" class="form-control" id="email" value="<?= $this->user->email; ?>" name="email" placeholder="Correo Electrónico">
										    </div>
										</div>
										<div class="form-group">
											<label for="document" class="col-sm-4 control-label">Identificación</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="document" value="<?= $this->user->document; ?>" name="document">
										    </div>
										</div>
										<div class="form-group">
											<label for="phone" class="col-sm-4 control-label">Teléfono</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="phone" value="<?= $this->user->phone; ?>" name="phone">
										    </div>
										</div>
										<?php if (Session::get('user_account_type') == 1) { ?>
										<div class="form-group">
											<label for="birth" class="col-sm-4 control-label">Fecha de Nacimiento</label>
											<div class="col-sm-8">
										    	<input type="text" class="form-control" id="birth" value="<?= date('d-m-Y', $this->user->birth); ?>" name="birth">
										    </div>
										</div>
										<?php } ?>
										<div class="form-group">
											<label for="city" class="col-sm-4 control-label">Ciudad</label>
											<div class="col-sm-8">
										    	<select type="text" class="form-control" id="city" name="city">
											    	<option class="text-placeholder" value="">- Selecciona una Ciudad -</option>
											    	<?php foreach (Config::get('CITIES') as $key => $city) { ?>
											    	<option value="<?= $key; ?>" <?php if ($this->user->city == $key) { echo "selected"; } ?>><?= $city; ?></option>
											    	<?php } ?>
										    	</select>
										    </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Imagen de Perfil</label>
											<div class="col-sm-9">
												<div class="col-md-1 noo_upload"></div>
												<div class="col-md-10">
													<input type="file" name="avatar">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-primary white">Guardar Perfil</button>
								</div>
								<div class="text-center">
									<a href="<?= Config::get('URL'); ?>account">Volver a Mi Perfil</a>
								</div>
							</form>
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
				$("#birth").datetimepicker({
					format: "d-m-Y",
					timepicker: false,
					startDate:"1990/01/01",
					scrollMonth: false,
					scrollTime: false,
					scrollInput: false
				});
			});
			$(document).ready(function() {
				$('.noo-messages .fa-close').on('click', function() {
					$(this).parent().remove();
				});
			});
		</script>
	</body>
</html>