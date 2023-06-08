<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

require APP . 'core/Application.php';
require APP . 'core/Auth.php';
require APP . 'core/Config.php';
require APP . 'core/Controller.php';
require APP . 'core/Csrf.php';
require APP . 'core/DatabaseFactory.php';
require APP . 'core/Encryption.php';
require APP . 'core/Filter.php';
require APP . 'core/Mail.php';
require APP . 'core/MailChimp.php';
require APP . 'core/PHPMailer.php';
require APP . 'core/Redirect.php';
require APP . 'core/Request.php';
require APP . 'core/Resize.php';
require APP . 'core/Session.php';
require APP . 'core/SMTP.php';
require APP . 'core/Text.php';
require APP . 'core/View.php';

require APP . 'model/AdminModel.php';
require APP . 'model/ApplicationModel.php';
require APP . 'model/CompanyModel.php';
require APP . 'model/LoginModel.php';
require APP . 'model/OfferModel.php';
require APP . 'model/PasswordResetModel.php';
require APP . 'model/RegistrationModel.php';
require APP . 'model/SearchModel.php';
require APP . 'model/StudentModel.php';
require APP . 'model/UniversityModel.php';
require APP . 'model/UserModel.php';
require APP . 'model/ValidationModel.php';

new Application();