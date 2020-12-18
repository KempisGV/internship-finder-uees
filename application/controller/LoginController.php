<?php

class LoginController extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if (LoginModel::isUserLoggedIn()) {
			Redirect::home();
		} else {
			$data = array('redirect' => Request::get('redirect') ? Request::get('redirect') : NULL);
			$this->View->render('login/index', $data);
		}
	}

	public function login_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$login_successful = LoginModel::login(Request::post('email'), Request::post('password'), Request::post('set_remember_me_cookie'));

		if ($login_successful) {
			if (Request::post('redirect')) {
				Redirect::to(Request::post('redirect'));
			} else {
				Redirect::to('offer');
			}
		} else {
			if (Request::post('redirect')) {
				Redirect::to('login?redirect=' . Request::post('redirect'));
			} else {
				Redirect::to('login');
			}
		}
	}

	public function logout() {
		LoginModel::logout();
		Redirect::home();
	}

	public function loginWithCookie() {
		$login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));

		if ($login_successful) {
			Redirect::to('dashboard');
		} else {
			LoginModel::deleteCookie();
			Redirect::to('login');
		}
	}


	public function requestPasswordReset() {
		$this->View->render('login/requestPasswordReset');
	}

	public function requestPasswordReset_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		PasswordResetModel::requestPasswordReset(Request::post('email'));
		Redirect::to('login/requestpasswordreset');
	}

	public function resetPassword($user_id, $code) {
		if (PasswordResetModel::verifyPasswordReset($user_id, $code)) {
			$data = array(
				'user_id' => $user_id,
				'code' => $code
			);
			$this->View->render('login/resetPassword', $data);
		} else {
			Redirect::to('login');
		}
	}

	public function resetPassword_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		if (PasswordResetModel::setNewPassword(Request::post('user_id'), Request::post('password_reset_hash'), Request::post('password'), Request::post('confirm_password'))) {
			Redirect::to('login');
		} else {
			$data = array(
				'user_id' => Request::post('user_id'),
				'code' => Request::post('password_reset_hash')
			);
			$this->View->render('login/resetPassword', $data);
		}
	}
}