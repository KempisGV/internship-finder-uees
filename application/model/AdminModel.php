<?php

class AdminModel {

	public static function countUsers($user_type) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT user_id FROM TB_USERS WHERE account_type = :user_type";
		$query = $database->prepare($sql);
		$query->execute(array(':user_type' => $user_type));

		return count($query->fetchAll());
	}

	public static function countOffers($offer_type) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id FROM TB_OFFERS WHERE offer_type = :offer_type AND publication_date IS NOT NULL";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_type' => $offer_type));

		return count($query->fetchAll());
	}

	public static function countRequest() {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT request_id FROM TB_REQUESTS";
		$query = $database->prepare($sql);
		$query->execute();

		return count($query->fetchAll());
	}

	public static function doesEmailAlreadyExist($email) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("SELECT request_id FROM TB_REQUESTS WHERE email = :email LIMIT 1");
        $query->execute(array(':email' => $email));
        if ($query->rowCount() == 0) {
            return false;
        }
        return true;
    }

    public static function doesDocumentAlreadyExist($document) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("SELECT request_id FROM TB_REQUESTS WHERE document = :document LIMIT 1");
        $query->execute(array(':document' => $document));
        if ($query->rowCount() == 0) {
            return false;
        }
        return true;
    }

	public static function getUserList($user_id) {

		$keyword = Request::get('keyword');
		$city = Request::get('city');
		$user_type = Request::get('user_type');
		$page = empty(Request::get('page')) ? 1 : Request::get('page');

		$sql = "SELECT user_id, name, lastname, email, document, city, phone, birth, avatar, bio, account_type, active, deleted FROM TB_USERS WHERE user_id <> :user_id";

		$values = array(':user_id' => $user_id);

		if (!empty($keyword)) {
			$sql = $sql . " AND (name LIKE :keyword OR lastname = :keyword OR bio LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($city)) {
			$sql = $sql . " AND city = :city";
			$values[':city'] = $city;
		}

		if (!empty($user_type)) {
			$sql = $sql . " AND account_type = :user_type";
			$values[':user_type'] = $user_type;
		}

		$sql = $sql . " ORDER BY creation_timestamp DESC LIMIT " . (($page *10) - 10) . ", 10";
		//echo $sql;
		//print_r($values);exit;
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);
		return $query->fetchAll();
	}

	public static function getUserListTotal($user_id) {

		$keyword = Request::get('keyword');
		$city = Request::get('city');
		$user_type = Request::get('user_type');

		$sql = "SELECT user_id, name, lastname, email, document, city, phone, birth, avatar, bio, account_type FROM TB_USERS WHERE user_id <> :user_id";

		$values = array(':user_id' => $user_id);

		if (!empty($keyword)) {
			$sql = $sql . " AND (name LIKE :keyword OR lastname = :keyword OR bio LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($city)) {
			$sql = $sql . " AND city = :city";
			$values[':city'] = $city;
		}

		if (!empty($user_type)) {
			$sql = $sql . " AND account_type = :user_type";
			$values[':user_type'] = $user_type;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);
		return count($query->fetchAll());
	}

	public static function getRequestList() {

		$keyword = Request::get('keyword');
		$city = Request::get('city');
		$request_type = Request::get('request_type');
		$page = empty(Request::get('page')) ? 1 : Request::get('page');

		$sql = "SELECT request_id, request_type, institution_name, name, lastname, email, document, city, phone, university FROM TB_REQUESTS";

		$values = array();

		if (!empty($keyword)) {
			$sql = $sql . " AND (institution_name LIKE :keyword OR name LIKE :keyword OR lastname = :keyword OR bio LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($city)) {
			$sql = $sql . " AND city = :city";
			$values[':city'] = $city;
		}

		if (!empty($user_type)) {
			$sql = $sql . " AND account_type = :user_type";
			$values[':user_type'] = $user_type;
		}

		$sql = $sql . " LIMIT " . (($page *10) - 10) . ", 10";

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public static function getRequestListTotal() {

		$keyword = Request::get('keyword');
		$city = Request::get('city');
		$request_type = Request::get('request_type');

		$sql = "SELECT request_id, request_type, institution_name, name, lastname, email, document, city, phone FROM TB_REQUESTS";

		$values = array();

		if (!empty($keyword)) {
			$sql = $sql . " AND (institution_name LIKE :keyword OR name LIKE :keyword OR lastname = :keyword OR bio LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($city)) {
			$sql = $sql . " AND city = :city";
			$values[':city'] = $city;
		}

		if (!empty($user_type)) {
			$sql = $sql . " AND account_type = :user_type";
			$values[':user_type'] = $user_type;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute();
		return count($query->fetchAll());
	}

	public static function getRequestDatabyId($request_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT request_id, request_type, institution_name, name, lastname, email, document, city, phone, university FROM TB_REQUESTS WHERE request_id = :request_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':request_id' => $request_id));
		return $query->fetch();
	}

	public static function approveUser($request_id) {

		$request_info = self::getRequestDatabyId($request_id);
		$activation_hash = sha1(uniqid(mt_rand(), true));
		$avatar = uniqid() . '.png';
	    copy('images/avatar/anonymous_big.png', 'images/avatar/' . $avatar);

	    $university = $request_info->request_type == 3 ? $request_info->university : null;

		if($request_info->request_type == 3 OR $request_info->request_type == 2){
			$account_type = $request_info->request_type;
		}else{
			$account_type = 1;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO TB_USERS (name, document, phone, city, email, creation_timestamp, activation_hash, avatar, university, account_type) VALUES (:name, :document, :phone, :city, :email, :creation_timestamp, :activation_hash, :avatar, :university, :account_type)";
        $query = $database->prepare($sql);
        $query->execute(array(
        	':name' => $request_info->institution_name,
        	':document' => $request_info->document,
        	':phone' => $request_info->phone,
        	':city' => $request_info->city,
        	':email' => $request_info->email,
            ':creation_timestamp' => time(),
            ':activation_hash' => $activation_hash,
            ':avatar' => $avatar,
			':university' => $university,
			':account_type' => $account_type
        ));
        $count =  $query->rowCount();

        if ($count != 1) {
	        Session::add('feedback_negative', Text::get('notification/positive/generic_error'));
            return false;
        }

        $user_id = UserModel::getUserDataByEmail($request_info->email)->user_id;

        $body = Config::get('EMAIL_VERIFICATION_CONTENT') . '<a href="' . Config::get('URL') . 'register/verifyinstitution/' . urlencode($user_id) . '/' . urlencode($activation_hash) . '">aquí</a>.';
        $mail = new Mail;
        $mail_sent = $mail->sendMail($request_info->email, Config::get('EMAIL_VERIFICATION_FROM_EMAIL'), Config::get('EMAIL_VERIFICATION_FROM_NAME'), Config::get('EMAIL_VERIFICATION_SUBJECT'), $body);

        self::deleteRequest($request_id);

        Session::add('feedback_positive', Text::get('notification/positive/request_added'));
        return true;
	}


	public static function deleteUser($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET deleted = 1 WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => $user_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/user_deleted'));
		return true;
	}

	public static function undeleteUser($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET deleted = 0 WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => $user_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/user_undeleted'));
		return true;
	}

	private static function deleteRequest($request_id) {
		//tabla de requerimiento
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_REQUESTS WHERE request_id = :request_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':request_id' => $request_id
		));
	}

	public static function inactivateUser($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET active = 0 WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => $user_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/user_inactivated'));
		return true;
	}

	public static function activateUser($user_id) {
		$activation_hash = sha1(uniqid(mt_rand(), true));

		//Se modifico el valor de active = 0 a active = 1
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_USERS SET active = 1, activation_hash = :activation_hash WHERE user_id = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => $user_id,
			':activation_hash' => $activation_hash
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		$user_info = UserModel::getUserDataById($user_id);

        $body = Config::get('EMAIL_VERIFICATION_CONTENT') . '<a href="' . Config::get('URL') . 'register/verify/'
                . '/' . urlencode($user_id) . '/' . urlencode($activation_hash) . '">aquí</a>.';
        $mail = new Mail;
        $mail_sent = $mail->sendMail($user_info->email, Config::get('EMAIL_VERIFICATION_FROM_EMAIL'), Config::get('EMAIL_VERIFICATION_FROM_NAME'), Config::get('EMAIL_VERIFICATION_SUBJECT'), $body);

		Session::add('feedback_positive', Text::get('notification/positive/user_activated'));
		return true;
	}

	public static function updateRequest() {

		$request_id = Request::post('request_id');
		$request_type = Request::post('request_type');
		$institution_name = Request::post('institution_name');
		$name = Request::post('name');
		$lastname = Request::post('lastname');
		$email = Request::post('email');
		$document = Request::post('document');
		$city = Request::post('city');
		$phone = Request::post('phone');
		$university = $request_type == 3 ? Request::post('university') : null;

		$email_exists = UserModel::doesEmailAlreadyExist($email);
	    $document_exists = UserModel::doesDocumentAlreadyExist($document);

		if (empty($request_type) OR empty($name) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($document) OR !ValidationModel::validateDocument($document) OR empty($city) OR empty($phone) OR $email_exists OR $document_exists) {
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
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				Session::add('feedback_negative', Text::get('notification/negative/email_field_invalid'));
			}
			if (empty($document)) {
				Session::add('feedback_negative', Text::get('notification/negative/document_field_empty'));
			}
			if (!ValidationModel::validateDocument($document)) {
				Session::add('feedback_negative', Text::get('notification/negative/document_invalid'));
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

		$request_info = self::getRequestDatabyId($request_id);

		if ($request_info->request_type == $request_type AND $request_info->institution_name == $institution_name AND $request_info->name == $name AND $request_info->lastname == $lastname AND $request_info->email == $email AND $request_info->document == $document AND $request_info->city == $city AND $request_info->phone == $phone AND $request_info->university == $university) {
			Session::add('feedback_positive', Text::get('notification/positive/request_updated'));
			return true;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE TB_REQUESTS SET request_type = :request_type, institution_name = :institution_name, name = :name, lastname = :lastname, email = :email, document = :document, city = :city, phone = :phone, university = :university WHERE request_id = :request_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
	        ':request_id' => $request_id,
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

        if ($query->rowCount() != 1) {
	        Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
        }

        Session::add('feedback_positive', Text::get('notification/positive/request_updated'));
		return true;
	}
}