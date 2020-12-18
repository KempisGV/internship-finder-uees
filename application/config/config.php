<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

ini_set('session.cookie_httponly', 1);

return array(
	'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public_html', '', dirname($_SERVER['SCRIPT_NAME'])),
	'PATH_CONTROLLER' => realpath(dirname(__FILE__) . '/../../') . '/application/controller/',
	'PATH_VIEW' => realpath(dirname(__FILE__) . '/../../') . '/application/view/',
	'DEFAULT_CONTROLLER' => 'public',
	'DEFAULT_ACTION' => 'index',

	'DB_TYPE' => 'mysql',
	'DB_HOST' => '127.0.0.1',
	'DB_NAME' => 'internship',
	'DB_USER' => 'root',
	'DB_PASS' => '',
	'DB_PORT' => '3306',
	'DB_CHARSET' => 'utf8',

	'HOST' => 'localhost',

	'COOKIE_RUNTIME' => 1209600,
	'COOKIE_PATH' => '/',
	'COOKIE_DOMAIN' => "",
	'COOKIE_SECURE' => false,
	'COOKIE_HTTP' => true,
	'SESSION_RUNTIME' => 604800,

	'ENCRYPTION_KEY' => '6#x0gÊìf^25cL1f$08&',
	'HMAC_SALT' => '8qk9c^4L6d#15tM8z7n0%',

	'EMAIL_USED_MAILER' => 'phpmailer',
	'EMAIL_USE_SMTP' => true,
	'EMAIL_SMTP_HOST' => 'smtp.gmail.com',
	'EMAIL_SMTP_AUTH' => true,
	'EMAIL_SMTP_USERNAME' => 'admninternshipfinder@gmail.com',
	'EMAIL_SMTP_PASSWORD' => 'Pruebas00',
	'EMAIL_SMTP_PORT' => 465,
	'EMAIL_SMTP_ENCRYPTION' => 'ssl',

	'EMAIL_ADMIN' => 'admninternshipfinder@gmail.com',
	'EMAIL_ADMIN_NAME' => 'Internship Finder Admin',

	'EMAIL_VERIFICATION_CONTENT' => 'Bienvenido a Internship Finder, para activar tu cuenta con nosotros haz click ',
	'EMAIL_VERIFICATION_URL' => 'register/verify',
	'EMAIL_VERIFICATION_FROM_EMAIL' => 'info@internshipfinder.com',
	'EMAIL_VERIFICATION_FROM_NAME' => 'Internship Finder',
	'EMAIL_VERIFICATION_SUBJECT' => 'Internship Finder: Activación de Cuenta',

	'EMAIL_PASSWORD_RESET_CONTENT' => "Haz solicitado un reinicio de contraseña, para restablecer tu cuenta con nosotros haz click ",
	'EMAIL_PASSWORD_RESET_URL' => 'login/resetPassword',
	'EMAIL_PASSWORD_RESET_FROM_EMAIL' => 'info@internshipfinder.com',
	'EMAIL_PASSWORD_RESET_FROM_NAME' => 'Internship Finder',
	'EMAIL_PASSWORD_RESET_SUBJECT' => 'Internship Finder: Reinicio de Contraseña',

	'CITIES' => array(
		1 => 'Quito',
		2 => 'Guayaquil'
	),

	'UNIVERSITIES' => array(
		1 => 'Universidad de Especialidades Espíritu Santo',
		2 => 'Universidad Católica Santiago de Guayaquil'
	),
	'CAREERS' => array(
		1 => 'Ing. Sistemas',
		2 => 'Ing. Ambiental'
	),
	'WORKAREAS' => array(
		1 => 'Workarea1',
		2 => 'Workarea2'
	),
	'BENEFITS' => array(
		1 => 'Benefit1',
		2 => 'Benefit2'
	)
);
