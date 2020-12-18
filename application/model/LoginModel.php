<?php

class LoginModel {

	public static function login($email, $password, $set_remember_me_cookie = null) {

		if (empty($email) OR empty($password)) {
			Session::add('feedback_negative', Text::get('notification/negative/email_or_password_empty'));
			return false;
		}

		$result = self::validateAndGetUser($email, $password);

		if (!$result) {
			return false;
		}

		if ($result->deleted == 1) {
			Session::add('feedback_negative', Text::get('notification/negative/user_deleted'));
			return false;
		}

		if ($result->suspension_timestamp != null && $result->suspension_timestamp - time() > 0) {
			$suspensionTimer = Text::get('notification/negative/account_suspended') . round(abs($result->suspension_timestamp - time())/60/60, 2) . " horas.";
			Session::add('feedback_negative', Text::get('notification/negative/account_suspended'));
			return false;
		}

		if ($result->last_failed_login > 0) {
			self::resetFailedLoginCounterOfUser($result->email);
		}

		self::saveTimestampOfLoginOfUser($result->email);

		if ($set_remember_me_cookie) {
			self::setRememberMeInDatabaseAndCookie($result->user_id);
		}

		self::setSuccessfulLoginIntoSession($result->user_id, $result->email, $result->name, $result->lastname, $result->account_type, $result->avatar);

		return true;
	}

	private static function validateAndGetUser($email, $password) {

		if (Session::get('failed-login-count') >= 3 AND (Session::get('last-failed-login') > (time() - 30))) {
            Session::add('feedback_negative', Text::get('notification/negative/login_failed_3_times'));
            return false;
        }

        $result = UserModel::getUserDataByEmail($email);

        if (!$result) {
	        self::incrementUserNotFoundCounter();
	        Session::add('feedback_negative', Text::get('notification/negative/email_or_password_wrong'));
	        return false;
        }

        if (!password_verify($password, $result->password_hash)) {
            self::incrementFailedLoginCounterOfUser($result->email);
            Session::add('feedback_negative', Text::get('notification/negative/email_or_password_wrong'));
            return false;
        }

        if ($result->active != 1) {
            Session::add('feedback_negative', Text::get('notification/negative/account_not_activated'));
            return false;
        }

        self::resetUserNotFoundCounter();
        return $result;
	}

	private static function resetUserNotFoundCounter() {
        Session::set('failed-login-count', 0);
        Session::set('last-failed-login', '');
    }

    private static function incrementUserNotFoundCounter() {
        Session::set('failed-login-count', Session::get('failed-login-count') + 1);
        Session::set('last-failed-login', time());
    }

    public static function loginWithCookie($cookie) {

	    if (!$cookie) {
            Session::add('feedback_negative', Text::get('notification/negative/cookie_invalid'));
            return false;
        }

        if (count (explode(':', $cookie)) !== 3) {
            Session::add('feedback_negative', Text::get('notification/negative/cookie_invalid'));
            return false;
        }

        list ($user_id, $token, $hash) = explode(':', $cookie);

        $user_id = Encryption::decrypt($user_id);

        if ($hash !== hash('sha256', $user_id . ':' . $token) OR empty($token) OR empty($user_id)) {
            Session::add('feedback_negative', Text::get('notification/negative/cookie_invalid'));
            return false;
        }

        $result = UserModel::getUserDataByUserIdAndToken($user_id, $token);

        if ($result) {
	        self::setSuccessfulLoginIntoSession($result->user_id, $result->email, $result->name, $result->lastname, $result->account_type, $result->avatar);
			self::saveTimestampOfLoginOfUser($result->email);
			return true;
        } else {
	        Session::add('feedback_negative', Text::get('notification/negative/cookie_invalid'));
            return false;
        }
    }

    public static function logout() {
	    $user_id = Session::get('user_id');
	    self::deleteCookie($user_id);

	    Session::destroy();
    }

    public static function setSuccessfulLoginIntoSession($user_id, $email, $name, $lastname, $account_type, $avatar) {
	    Session::init();
	    session_regenerate_id(true);
	    $_SESSION = array();

	    Session::set('user_id', $user_id);
	    Session::set('user_email', $email);
	    Session::set('user_name', $name);
	    Session::set('user_lastname', $lastname);
	    Session::set('user_account_type', $account_type);
	    Session::set('user_avatar', $avatar);
	    Session::set('user_logged_in', true);

	    setcookie(session_name(), session_id(), time() + Config::get('SESSION_RUNTIME'), Config::get('COOKIE_PATH'), Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    public static function incrementFailedLoginCounterOfUser($email) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET failed_logins = failed_logins+1, last_failed_login = :last_failed_login WHERE email = :email LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':email' => $email, ':last_failed_login' => time() ));
    }

    public static function resetFailedLoginCounterOfUser($email)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET failed_logins = 0, last_failed_login = NULL WHERE email = :email AND failed_logins != 0 LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':email' => $email));
    }

    public static function saveTimestampOfLoginOfUser($email)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET last_login_timestamp = :last_login_timestamp WHERE email = :email LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':email' => $email, ':last_login_timestamp' => time()));
    }

    public static function setRememberMeInDatabaseAndCookie($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $random_token_string = hash('sha256', mt_rand());
        $sql = "UPDATE TB_USERS SET remember_me_token = :remember_me_token WHERE user_id = :user_id LIMIT 1";
        $sth = $database->prepare($sql);
        $sth->execute(array(':remember_me_token' => $random_token_string, ':user_id' => $user_id));
        $cookie_string_first_part = Encryption::encrypt($user_id) . ':' . $random_token_string;
        $cookie_string_hash       = hash('sha256', $user_id . ':' . $random_token_string);
        $cookie_string            = $cookie_string_first_part . ':' . $cookie_string_hash;
        setcookie('remember_me', $cookie_string, time() + Config::get('COOKIE_RUNTIME'), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    public static function deleteCookie($user_id = null) {
        if (isset($user_id)) {
            $database = DatabaseFactory::getFactory()->getConnection();
            $sql = "UPDATE TB_USERS SET remember_me_token = :remember_me_token WHERE user_id = :user_id LIMIT 1";
            $sth = $database->prepare($sql);
            $sth->execute(array(':remember_me_token' => NULL, ':user_id' => $user_id));
        }
        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'), Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

	public static function isUserLoggedIn() {
		return Session::userIsLoggedIn();
	}
}