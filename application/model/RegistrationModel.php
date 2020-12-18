<?php

class RegistrationModel {

    public static function registerNewUser() {

        $name = strtoupper(strip_tags(Request::post('name')));
        $lastname = strtoupper(strip_tags(Request::post('lastname')));
        $document = strip_tags(Request::post('document'));
        $phone = strip_tags(Request::post('phone'));
        $birthday = Request::post('birth');
        $city = strip_tags(Request::post('city'));
        $email = strip_tags(Request::post('email'));
        $password = Request::post('password');
        $confirm_password = Request::post('confirm_password');
        $terms = Request::post('terms');

        Session::set('data_register', array(
	        'name' => $name,
	        'lastname' => $lastname,
	        'document' => $document,
	        'phone' => $phone,
	        'birthday' => $birthday,
	        'city' => $city,
	        'email'=> $email,
	        'terms' => $terms
        ));

        if (!self::registrationInputValidation($name, $lastname, $document, $phone, $birthday, $city, $email, $password, $confirm_password, $terms)) {
            return false;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $activation_hash = sha1(uniqid(mt_rand(), true));

        if (!self::writeNewUserToDatabase($name, $lastname, $document, $phone, $birthday, $city, $email, $password_hash, time(), $activation_hash)) {
            Session::add('feedback_negative', Text::get('notification/negative/user_creation_failed'));
            return false;
        }

        $user_id = UserModel::getUserDataByEmail($email)->user_id;

        if (empty($user_id)) {
            Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
            return false;
        }

        if (self::sendVerificationEmail($user_id, $email, $activation_hash)) {
	        Session::remove('register_data');
            Session::add('feedback_positive', Text::get('notification/positive/user_created'));
            return true;
        }

        self::rollbackRegistrationByUserId($user_id);
        return false;
    }

    public static function registrationInputValidation($name, $lastname, $document, $phone, $birthday, $city, $email,  $password, $confirm_password, $terms) {

	    $email_exists = UserModel::doesEmailAlreadyExist($email);
	    $document_exists = UserModel::doesDocumentAlreadyExist($document);
	    $document_flag = false;
	    $email_flag = false;
	    $password_flag = false;

		if(empty($name) OR ValidationModel::validateSpecialChars($name) OR empty($lastname) OR  ValidationModel::validateSpecialChars($lastname) OR empty($document) OR !ValidationModel::validateDocument($document) OR $document_exists OR empty($phone) OR ValidationModel::validateSpecialChars($phone) OR empty($birthday) OR empty($city) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR $email_exists OR empty($password) OR empty($confirm_password) OR $password !== $confirm_password OR strlen($password) < 6){
			if (empty($name)) {
	            Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
	        }
	        if (ValidationModel::validateSpecialChars($name)) {
	            Session::add('feedback_negative', Text::get('notification/negative/name_field_special_chars'));
	        }
	        if (empty($lastname)) {
	            Session::add('feedback_negative', Text::get('notification/negative/lastname_field_empty'));
	        }
	        if (ValidationModel::validateSpecialChars($lastname)) {
	            Session::add('feedback_negative', Text::get('notification/negative/lastname_field_special_chars'));
	        }
	        if (empty($document)) {
	            Session::add('feedback_negative', Text::get('notification/negative/document_field_empty'));
	            $document_flag = true;
	        }
	        if (!ValidationModel::validateDocument($document)) {
	            Session::add('feedback_negative', Text::get('notification/negative/document_invalid'));
	            $document_flag = true;
	        }
	        if ($document_exists AND !$document) {
		        Session::add('feedback_negative', Text::get('notification/negative/document_taken'));
	        }
	        if (empty($phone)) {
	            Session::add('feedback_negative', Text::get('notification/negative/phone_field_empty'));
	        }
	        if (ValidationModel::validateSpecialChars($phone)) {
	            Session::add('feedback_negative', Text::get('notification/negative/phone_field_special_chars'));
	        }
	        if (empty($birthday)) {
	            Session::add('feedback_negative', Text::get('notification/negative/birthday_field_empty'));
	        }
	        if (empty($city)) {
	            Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
	        }
	        if (empty($email)) {
	            Session::add('feedback_negative', Text::get('notification/negative/email_field_empty'));
	            $email_flag = true;
	        }
	        if (!filter_var($email, FILTER_VALIDATE_EMAIL) AND !$email_flag) {
	            Session::add('feedback_negative', Text::get('notification/negative/email_field_invalid'));
	            $email_flag = true;
	        }
	        if ($email_exists AND !$email_flag) {
		        Session::add('feedback_negative', Text::get('notification/negative/email_taken'));
	        }
			if (empty($password) OR empty($confirm_password)) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_field_empty'));
	            $password_flag = true;
	        }
	        if ($password !== $confirm_password) {
	            Session::add('feedback_negative', Text::get('notification/negative/confirm_password_field_empty'));
	            $password_flag = true;
	        }
	        if (strlen($password) < 6 AND !$password_flag) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_too_short'));
	        }
	        if (empty($terms)) {
		        Session::add('feedback_negative', Text::get('notification/negative/terms_not_accepted'));
	        }
	        return false;
		}

        return true;
    }

    public static function writeNewUserToDatabase($name, $lastname, $document, $phone, $birthday, $city, $email, $password_hash, $creation_timestamp, $activation_hash) {
	    $avatar = uniqid() . '.png';
	    copy('images/avatar/anonymous_big.png', 'images/avatar/' . $avatar);
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO TB_USERS (name, lastname, document, phone, birth, city, email, password_hash, creation_timestamp, activation_hash, avatar) VALUES (:name, :lastname, :document, :phone, :birth, :city, :email, :password_hash, :creation_timestamp, :activation_hash, :avatar)";
        $query = $database->prepare($sql);
        $query->execute(array(
        	':name' => $name,
        	':lastname' => $lastname,
        	':document' => $document,
        	':phone' => $phone,
        	':birth' => strtotime($birthday),
        	':city' => $city,
        	':email' => $email,
            ':password_hash' => $password_hash,
            ':creation_timestamp' => $creation_timestamp,
            ':activation_hash' => $activation_hash,
            ':avatar' => $avatar
        ));
        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    public static function rollbackRegistrationByUserId($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("DELETE FROM TB_USERS WHERE user_id = :user_id");
        $query->execute(array(':user_id' => $user_id));
    }

    public static function sendVerificationEmail($user_id, $email, $activation_hash) {
        $body = Config::get('EMAIL_VERIFICATION_CONTENT') . '<a href="' . Config::get('URL') . Config::get('EMAIL_VERIFICATION_URL')
                . '/' . urlencode($user_id) . '/' . urlencode($activation_hash) . '">aquí</a>.';
        $mail = new Mail;
        $mail_sent = $mail->sendMail($email, Config::get('EMAIL_VERIFICATION_FROM_EMAIL'), Config::get('EMAIL_VERIFICATION_FROM_NAME'), Config::get('EMAIL_VERIFICATION_SUBJECT'), $body);
        if ($mail_sent) {
            Session::add('feedback_positive', Text::get('notification/positive/email_sent'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('notification/negative/email_sent_error') . $mail->getError() );
            return false;
        }
    }

    public static function verifyNewUser($user_id, $activation_verification_code) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET active = 1, activation_hash = NULL WHERE user_id = :user_id AND activation_hash = :activation_hash LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
        	':user_id' => $user_id,
        	':activation_hash' => $activation_verification_code
        ));
        if ($query->rowCount() == 1) {
            Session::add('feedback_positive', Text::get('notification/positive/account_activation_successful'));
            return true;
        }
        Session::add('feedback_negative', Text::get('notification/negative/account_activation_failed'));
        return false;
    }

    public static function registerNewRequest($request_type, $institution_name, $name, $lastname, $email, $document, $city, $phone, $university) {

	    Session::set('data_register', array(
			'request_type' => $request_type,
			'institution_name' => $institution_name,
			'name' => $name,
			'lastname' => $lastname,
	        'document' => $document,
	        'phone' => $phone,
	        'city' => $city,
	        'email'=> $email,
	        'university' => $university
		));

		$email_exists_req = AdminModel::doesEmailAlreadyExist($email);
	    $email_exists = UserModel::doesEmailAlreadyExist($email);
	    $document_exists_req = AdminModel::doesDocumentAlreadyExist($document);
	    $document_exists = UserModel::doesDocumentAlreadyExist($document);

		if (empty($request_type) OR empty($name) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($document) OR !ValidationModel::validateDocument($document) OR empty($city) OR empty($phone) OR $email_exists OR $document_exists OR $email_exists_req OR $document_exists_req) {
			$email_flag = true;
			$document_flag = true;
			if (empty($request_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/request_type_field_empty'));
			}
			if (empty($institution_name)) {
				Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
			}
			if (empty($name)) {
				Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
			}
			if (empty($lastname)) {
				Session::add('feedback_negative', Text::get('notification/negative/lastname_field_empty'));
			}
			if (empty($email)) {
				Session::add('feedback_negative', Text::get('notification/negative/email_field_empty'));
				$email_flag = false;
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) AND $email_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/email_field_invalid'));
				$email_flag = false;
			}
			if (($email_exists OR $email_exists_req) AND $email_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/email_taken'));
			}
			if (empty($document)) {
				Session::add('feedback_negative', Text::get('notification/negative/document_field_empty'));
				$document_flag = false;
			}
			if (!ValidationModel::validateDocument($document) AND $document_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/document_invalid'));
				$document_flag = false;
			}
			if (($document_exists OR $document_exists_req) AND $document_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/document_taken'));
			}
			if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
			}
			if (empty($phone)) {
				Session::add('feedback_negative', Text::get('notification/negative/phone_field_empty'));
			}
			if ($email_exists) {
		        Session::add('feedback_negative', Text::get('notification/negative/email_taken'));
	        }
			if ($document_exists) {
		        Session::add('feedback_negative', Text::get('notification/negative/document_taken'));
	        }
			return false;
		}

		$university = $request_type == 3 ? $university : null;

		$database = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO TB_REQUESTS (request_type, institution_name, name, lastname, email, document, city, phone, university) VALUES (:request_type, :institution_name, :name, :lastname, :email, :document, :city, :phone, :university)";
        $query = $database->prepare($sql);
        $query->execute(array(
	        ':request_type' => $request_type,
	        ':institution_name' => $institution_name,
        	':name' => $name,
        	':lastname' => $lastname,
        	':document' => $document,
        	':phone' => $phone,
        	':city' => $city,
        	':email' => $email,
        	':university' => $university
        ));
        $count =  $query->rowCount();
        if ($count == 1) {
	        Session::remove('data_register');
	        Session::add('feedback_positive', Text::get('notification/positive/request_added'));
            return true;
        }
        return false;
    }

    public static function verifyInstitution($user_id, $activation_hash) {
	    $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_id FROM TB_USERS WHERE user_id = :user_id AND activation_hash = :activation_hash";
        $query = $database->prepare($sql);
        $query->execute(array(
	        ':user_id' => $user_id,
	        ':activation_hash' => $activation_hash
        ));

        if ($query->rowCount() == 1) {
	        return true;
        }

        return false;
    }

    public static function setPassword($user_id, $activation_hash, $password, $confirm_password) {
	    $password_flag = false;

	    if (empty($password) OR empty($confirm_password) OR $password !== $confirm_password OR strlen($password) < 6) {
	    	if (empty($password) OR empty($confirm_password)) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_field_empty'));
	            $password_flag = true;
	        }
	        if ($password !== $confirm_password) {
	            Session::add('feedback_negative', Text::get('notification/negative/confirm_password_field_empty'));
	            $password_flag = true;
	        }
	        if (strlen($password) < 6 AND !$password_flag) {
	            Session::add('feedback_negative', Text::get('notification/negative/password_too_short'));
	        }
	        return false;
	    }

	    $password_hash = password_hash($password, PASSWORD_DEFAULT);

	    $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_USERS SET password_hash = :password_hash, activation_hash = NULL, active = 1 WHERE user_id = :user_id AND activation_hash = :activation_hash";
        $query = $database->prepare($sql);
        $query->execute(array(
	        ':user_id' => $user_id,
	        ':activation_hash' => $activation_hash,
	        ':password_hash' => $password_hash
        ));

        if ($query->rowCount() != 1) {
	        Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
	        return false;
        }

        Session::add('feedback_positive', Text::get('notification/positive/account_activation_successful'));
        return true;
    }

}
