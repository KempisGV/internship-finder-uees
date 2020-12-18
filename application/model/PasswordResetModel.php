<?php

class PasswordResetModel {

	public static function requestPasswordReset($email) {
		if (empty($email)) {
            Session::add('feedback_negative', Text::get('notification/negative/email_or_password_empty'));
            return false;
        }

        $result = UserModel::getUserDataByEmail($email);
        if (!$result) {
            Session::add('feedback_negative', Text::get('notification/negative/user_not_found'));
            return false;
        }

		$temporary_timestamp = time();
        $password_reset_hash = sha1(uniqid(mt_rand(), true));

        $token_set = self::setPasswordResetDatabaseToken($result->user_id, $password_reset_hash, $temporary_timestamp);
        if (!$token_set) {
            return false;
        }

        $mail_sent = self::sendPasswordResetMail($result->user_id, $password_reset_hash, $email);
        if ($mail_sent) {
            return true;
        }

		return false;
	}

	public static function setPasswordResetDatabaseToken($user_id, $password_reset_hash, $temporary_timestamp) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET password_reset_hash = :password_reset_hash, password_reset_timestamp = :password_reset_timestamp WHERE user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':password_reset_hash' => $password_reset_hash,
            ':user_id' => $user_id,
            ':password_reset_timestamp' => $temporary_timestamp
        ));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('notification/negative/reset_token_not_valid'));
        return false;
    }

    public static function sendPasswordResetMail($user_id, $password_reset_hash, $email)
    {
        $body = Config::get('EMAIL_PASSWORD_RESET_CONTENT') . '<a href="' . Config::get('URL') . Config::get('EMAIL_PASSWORD_RESET_URL') . '/' . urlencode($user_id) . '/' . urlencode($password_reset_hash) . '">aquí</a>.';

        $mail = new Mail;
        $mail_sent = $mail->sendMail($email, Config::get('EMAIL_PASSWORD_RESET_FROM_EMAIL'), Config::get('EMAIL_PASSWORD_RESET_FROM_NAME'), Config::get('EMAIL_PASSWORD_RESET_SUBJECT'), $body);

        if ($mail_sent) {
            Session::add('feedback_positive', Text::get('notification/positive/reset_password_mail_sent'));
            return true;
        }

        Session::add('feedback_negative', Text::get('notification/negative/reset_password_mail_not_sent') . $mail->getError());
        return false;
    }

	public static function verifyPasswordReset($user_id, $code) {
		$database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_id, password_reset_timestamp FROM TB_USERS WHERE user_id = :user_id AND password_reset_hash = :password_reset_hash LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':password_reset_hash' => $code,
            ':user_id' => $user_id
        ));

        if ($query->rowCount() != 1) {
            Session::add('feedback_negative', Text::get('notification/negative/reset_token_not_valid'));
            return false;
        }

        $result_user_row = $query->fetch();

        $timestamp_one_hour_ago = time() - 3600;

        if ($result_user_row->password_reset_timestamp > $timestamp_one_hour_ago) {
            //Session::add('feedback_positive', Text::get('notification/positive/FEEDBACK_PASSWORD_RESET_LINK_VALID'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('notification/negative/reset_token_expired'));
            return false;
        }
	}

	public static function setNewPassword($user_id, $password_reset_hash, $password, $confirm_password) {
		if (!self::validateResetPassword($user_id, $password_reset_hash, $password, $confirm_password)) {
            return false;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if (self::saveNewUserPassword($user_id, $password_hash, $password_reset_hash)) {
            //Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_CHANGE_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('notification/negative/password_change_failed'));
            return false;
        }
	}

	public static function validateResetPassword($user_id, $password_reset_hash, $password, $confirm_password) {
        /*if (empty($user_name)) {
            Session::add('feedback_negative', Text::get('notification/negative/FEEDBACK_USERNAME_FIELD_EMPTY'));
            return false;
        } else if (empty($user_password_reset_hash)) {
            Session::add('feedback_negative', Text::get('notification/negative/reset_token_expiredFEEDBACK_PASSWORD_RESET_TOKEN_MISSING'));
            return false;
        } else */
        if (empty($password) OR empty($confirm_password) OR $password !== $confirm_password OR strlen($password) < 6) {
	        if (empty($password) OR empty($confirm_password)) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_empty'));
	        } else if ($password !== $confirm_password) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_no_match'));
	        } else if (strlen($password) < 6) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_too_short'));
	        }
	        return false;
        }
        return true;
    }

    public static function saveNewUserPassword($user_id, $password_hash, $password_reset_hash)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET password_hash = :password_hash, password_reset_hash = NULL, password_reset_timestamp = NULL WHERE user_id = :user_id AND password_reset_hash = :password_reset_hash LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':password_hash' => $password_hash,
            ':user_id' => $user_id,
            ':password_reset_hash' => $password_reset_hash
        ));

        return ($query->rowCount() == 1 ? true : false);
    }

    public static function changePassword($old_password, $password, $confirm_password) {
		if (empty($old_password) OR empty($password) OR empty($confirm_password) OR $password !== $confirm_password OR strlen($password) < 6) {
			$password_flag = false;
			if (empty($old_password)) {
				Session::add('feedback_negative', Text::get('notification/negative/old_password_empty'));
			}
			if (empty($password)) {
				Session::add('feedback_negative', Text::get('notification/negative/password_field_empty'));
				$password_flag = true;
			}
			if (empty($confirm_password)) {
				Session::add('feedback_negative', Text::get('notification/negative/confirm_password_field_empty'));
				$password_flag = true;
			}
			if ($password !== $confirm_password AND !$password_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/password_no_match'));
				$password_flag = true;
			}
			if (strlen($password) < 6 AND !$password_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/password_too_short'));
			}
			return false;
		}

		$verify_password = UserModel::getUserDataById(Session::get('user_id'))->password_hash;

		if (!password_verify($old_password, $verify_password)) {
			Session::add('feedback_negative', Text::get('notification/negative/old_password_wrong'));
			return false;
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET password_hash = :password_hash WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			":password_hash" => $password_hash,
			":user_id" => Session::get('user_id')
		));

		Session::add('feedback_positive', Text::get('notification/positive/password_changed'));
		return true;
    }
}