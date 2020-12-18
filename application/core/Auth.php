<?php

class Auth {
	
	public static function checkAuthentication() {
		Session::init();
		if (!Session::userIsLoggedIn()) {
			Session::destroy();
			Redirect::home();
		}
	}
	
	public static function checkAdmin() {
		if (Session::get('user_account') != 1) {
			Redirect::to('home');
		}
	}
}