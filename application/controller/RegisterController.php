<?php

class RegisterController extends Controller {

	public function __construct() {
		parent::__construct();
		Session::init();
	}

	public function index() {
		$data = Session::get('data_register');
		if (empty($data)) {
			$data = array(
				'name' => '',
				'lastname' => '',
		        'document' => '',
		        'phone' => '',
		        'birthday' => '',
		        'city' => '',
		        'email'=> '',
		        'terms' => 0
			);
		}
		$this->View->render('register/index', $data);
	}

	public function register_action() {

		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = RegistrationModel::registerNewUser();

		if ($result) {
			Redirect::to('login');
		} else {
			Redirect::to('register');
		}
	}

	public function verify($user_id, $activation_verification_code) {
		$user_account_type = UserModel::getUserDataById($user_id)->account_type;
		if ($user_account_type != 1) {
			Redirect::home();
		}
        RegistrationModel::verifyNewUser($user_id, $activation_verification_code);
        Redirect::to('login');
    }

    public function request() {
	    $data = Session::get('data_register');
	    Session::remove('data_register');
		if (empty($data)) {
			$data = array(
				'request_type' => '',
				'institution_name' => '',
				'name' => '',
				'lastname' => '',
		        'document' => '',
		        'phone' => '',
		        'city' => '',
		        'email'=> '',
		        'university' => ''
			);
		}
		$this->View->render('register/request', $data);
    }

    public function request_action() {

		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = RegistrationModel::registerNewRequest(Request::post('request_type'), Request::post('institution_name'), Request::post('name'), Request::post('lastname'), Request::post('email'), Request::post('document'), Request::post('city'), Request::post('phone'), Request::post('university'));

		if ($result) {
			Redirect::to('login');
		} else {
			Redirect::to('register/request');
		}
	}

	public function verifyInstitution($user_id, $activation_verification_code) {
		if (Session::get('user_logged_in')) {
			LoginModel::logout();
			Session::init();
		}
        $result = RegistrationModel::verifyInstitution($user_id, $activation_verification_code);
        if ($result) {
	        $data = array('user_id' => $user_id, 'activation_hash' => $activation_verification_code);
	        $this->View->render('register/setPassword', $data);
        } else {
	        Redirect::home();
        }
    }

    public function verifyInstitution_action() {
	    if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}
	    $result = RegistrationModel::setPassword(Request::post('user_id'), Request::post('activation_hash'), Request::post('password'), Request::post('confirm_password'));

	    if ($result) {
		    Redirect::to('login');
	    }

	    Redirect::to('register/verifyInstitution/' . Request::post('user_id') . '/' . Request::post('activation_hash'));
    }

}