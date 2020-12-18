<?php

class UserModel {

	public static function getUserDataByEmail($email) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT user_id, name, lastname, email, document, city, phone, birth, avatar, bio, password_hash, account_type, active, deleted, remember_me_token, creation_timestamp, suspension_timestamp, last_login_timestamp, failed_logins, last_failed_login, activation_hash, password_reset_hash, password_reset_timestamp FROM TB_USERS WHERE email = :email";
		$query = $database->prepare($sql);
		$query->execute(array(':email' => $email));
		return $query->fetch();
	}

	public static function getUserDataById($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT user_id, name, lastname, email, document, city, phone, birth, avatar, bio, password_hash, account_type, active, deleted, remember_me_token, creation_timestamp, suspension_timestamp, last_login_timestamp, failed_logins, last_failed_login, activation_hash, password_reset_hash, password_reset_timestamp FROM TB_USERS WHERE user_id = :user_id";
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id));
		return $query->fetch();
	}

	public static function getUserDataByUserIdAndToken($user_id, $token) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT user_id, name, lastname, email, document, city, phone, birth, avatar, bio, password_hash, account_type, active, deleted, remember_me_token, creation_timestamp, suspension_timestamp, last_login_timestamp, failed_logins, last_failed_login, activation_hash, password_reset_hash, password_reset_timestamp FROM TB_USERS WHERE user_id = :user_id AND remember_me_token = :remember_me_token AND remember_me_token IS NOT NULL LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id, ':remember_me_token' => $token));
		return $query->fetch();
	}

	public static function doesEmailAlreadyExist($email) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("SELECT user_id FROM TB_USERS WHERE email = :email LIMIT 1");
        $query->execute(array(':email' => $email));
        if ($query->rowCount() == 0) {
            return false;
        }
        return true;
    }

    public static function doesDocumentAlreadyExist($document) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("SELECT user_id FROM TB_USERS WHERE document = :document LIMIT 1");
        $query->execute(array(':document' => $document));
        if ($query->rowCount() == 0) {
            return false;
        }
        return true;
    }

    public static function updateUserData() {
	    $name = strtoupper(Request::post('name'));
	    $lastname = strtoupper(Request::post('lastname'));
	    $email = Request::post('email');
	    $document = Request::post('document');
	    $phone = Request::post('phone');
	    $birthday = Request::post('birth');
	    $city = Request::post('city');
	    $avatar = Request::files('avatar');

	    $user_info = self::getUserDataById(Session::get('user_id'));

	    if (empty($name) OR ValidationModel::validateSpecialChars($name) OR (Session::get('user_account_type') == 1 AND empty($lastname)) OR (Session::get('user_account_type') == 1 AND ValidationModel::validateSpecialChars($lastname)) OR empty($email) OR empty($document) OR !ValidationModel::validateDocument($document) OR empty($phone) OR ValidationModel::validateSpecialChars($phone) OR (empty($birthday) AND Session::get('user_account_type') == 1) OR empty($city)) {
		    if (empty($name)) {
			    Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
		    }
		    if (ValidationModel::validateSpecialChars($name)) {
			    Session::add('feedback_negative', Text::get('notification/negative/name_field_special_chars'));
		    }
		    if (Session::get('user_account_type') == 1 AND empty($lastname)) {
			    Session::add('feedback_negative', Text::get('notification/negative/lastname_field_empty'));
		    }
		    if (Session::get('user_account_type') == 1 AND ValidationModel::validateSpecialChars($lastname)) {
			    Session::add('feedback_negative', Text::get('notification/negative/lastname_field_special_chars'));
		    }
		    if (empty($email)) {
			    Session::add('feedback_negative', Text::get('notification/negative/email_field_empty'));
		    }
		    if (empty($document)) {
			    Session::add('feedback_negative', Text::get('notification/negative/document_field_empty'));
		    }
		    if (!ValidationModel::validateDocument($document)) {
	            Session::add('feedback_negative', Text::get('notification/negative/document_invalid'));
	            $document_flag = true;
	        }
		    if (empty($phone)) {
			    Session::add('feedback_negative', Text::get('notification/negative/phone_field_empty'));
		    }
		    if (ValidationModel::validateSpecialChars($phone)) {
			    Session::add('feedback_negative', Text::get('notification/negative/phone_field_special_char'));
		    }
		    if (empty($birthday) AND Session::get('user_account_type') == 1) {
			    Session::add('feedback_negative', Text::get('notification/negative/birthday_field_empty'));
		    }
		    if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
		    }
		    return false;
	    }

		$avatar_upload = false;

		if (!empty($avatar['name'])) {
			$avatar_upload = self::uploadAvatar($avatar);
			if (!$avatar_upload) {
				return false;
			}
		}

		$activation_hash = null;

		if ($email != $user_info->email) {
			if (self::doesEmailAlreadyExist($email)) {
				Session::add('feedback_negative', Text::get('notification/negative/email_taken'));
				return false;
			} else {
				$activation_hash = sha1(uniqid(mt_rand(), true));
				RegistrationModel::sendVerificationEmail(Session::get('user_id'), $email, $activation_hash);
			}
		}

	    if ($name == $user_info->name AND $lastname == $user_info->lastname AND $email == $user_info->email AND $document == $user_info->document AND $phone == $user_info->phone AND strtotime($birthday) == $user_info->birth AND $city == $user_info->city AND Session::get('user_avatar') == $user_info->avatar) {
		    Session::add('feedback_positive', Text::get('notification/positive/profile_updated'));
			return true;
	    }

	    $database = DatabaseFactory::getFactory()->getConnection();
	    $sql = "UPDATE TB_USERS SET name = :name, lastname = :lastname, email = :email, document = :document, phone = :phone, birth = :birthday, city = :city, avatar = :avatar, activation_hash = :activation_hash WHERE user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
	        ':name' => $name,
	        ':lastname' => $lastname,
	        ':email' => $email,
        	':document' => $document,
        	':phone' => $phone,
        	':birthday' => strtotime($birthday),
        	':city' => $city,
        	':user_id' => Session::get('user_id'),
        	':avatar' => Session::get('user_avatar'),
        	':activation_hash' => $activation_hash
        ));

        if ($query->rowCount() != 1) {
	        Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
	        return false;
        }

		Session::add('feedback_positive', Text::get('notification/positive/profile_updated'));
		return true;
    }

    private static function uploadAvatar($file) {

		if ($file['error'] !== UPLOAD_ERR_OK) {
			if ($file['error'] == 1) {
				Session::add('feedback_negative', Text::get('notification/negative/doc_larger'));
			} else {
				Session::add('feedback_negative', Text::get('notification/negative/avatar_error'));
			}
			return false;
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $file['tmp_name']);

		if (!($mime == 'image/jpeg' OR $mime == 'image/png') OR $file['size'] > 10485760) {
			if ($mime != 'image/jpeg') {
				Session::add('feedback_negative', Text::get('notification/negative/avatar_jpg_png'));
			}
			if ($file['size'] > 10485760) {
				Session::add('feedback_negative', Text::get('notification/negative/doc_larger'));
			}
			return false;
		}

		$name = explode('.', Session::get('user_avatar'));
		$ext = explode('.', $file['name']);

		$file_name = $name[0] . '.' . end($ext);

		unlink('images/avatar/'. Session::get('user_avatar'));
		Session::set('user_avatar', $file_name);

		if (move_uploaded_file($file['tmp_name'], 'images/avatar/' . $file_name)) {
			$imgResize = new resize(__DIR__ . '/../../public_html/images/avatar/' . $file_name);
			$imgResize->resizeImage('240','240', 'crop');
			$imgResize->saveImage(__DIR__ . '/../../public_html/images/avatar/' . $file_name, 100);
			return true;
		} else {
			Session::add('feedback_negative', Text::get('notification/negative/avatar_error'));
			return false;
		}
	}

    public static function editBio($bio) {
	    if (empty($bio)) {
		    Session::add('feedback_negative', Text::get('notification/negative/bio_field_empty'));
		    return false;
	    }

	    $database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET bio = :bio WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => Session::get('user_id'),
			':bio' => $bio
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
		    return false;
		}

		Session::add('feedback_positve', Text::get('notification/positive/bio_edited'));
		return true;
    }

    public static function checkActivation() {
		if (Session::get('user_logged_in')) {
		    $database = DatabaseFactory::getFactory()->getConnection();
		    $sql = "SELECT user_id FROM TB_USERS WHERE user_id = :user_id AND activation_hash IS NOT NULL LIMIT 1";
		    $query = $database->prepare($sql);
		    $query->execute(array(
			    ':user_id' => Session::get('user_id')
		    ));

		    if ($query->rowCount() == 1) {
			    Session::add('feedback_negative', Text::get('notification/negative/email_not_verified'));
		    }
		}
    }
}