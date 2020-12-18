<?php

class OfferModel {

	public static function getOffers($offer_type = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($offer_type)) {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id";
		} elseif ($offer_type == 1) {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE offer_type = 1";
		} elseif ($offer_type == 2) {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE offer_type = 2";
		}
		$query = $database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public static function getMyOffers($user_id, $page = null) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.user_id = :user_id";
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getOfferData($offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetch();
	}

	public static function addOffer($offer_type, $title, $end_date, $city, $careers, $workareas, $benefits, $description, $publish) {

		Session::set('offer_data', array(
			'offer_type' => $offer_type,
			'title' => $title,
			'end_date' => $end_date,
			'city' => $city,
			'careers' => empty($careers) ? array() : $careers,
			'workareas' => empty($workareas) ? array() : $workareas,
			'benefits' => empty($benefits) ? array() : $benefits,
			'description' => $description
		));

		if (empty($offer_type) OR empty($title) OR empty($description) OR empty($end_date) OR empty($workareas) OR empty($benefits) OR empty($careers) OR empty($city)) {
			if (empty($offer_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/offer_type_empty'));
			}
			if (empty($title)) {
				Session::add('feedback_negative', Text::get('notification/negative/title_field_empty'));
			}
			if (empty($end_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/end_date_field_empty'));
			}
			if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
			}
			if (empty($careers)) {
				Session::add('feedback_negative', Text::get('notification/negative/careers_empty'));
			}
			if (empty($workareas)) {
				Session::add('feedback_negative', Text::get('notification/negative/workareas_empty'));
			}
			if (empty($benefits)) {
				Session::add('feedback_negative', Text::get('notification/negative/benefits_empty'));
			}
			if (empty($description)) {
				Session::add('feedback_negative', Text::get('notification/negative/description_field_empty'));
			}
			return false;
		}

		$offer_id = uniqid();
		$publication_date = $publish == "2" ? time() : null;

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_OFFERS (offer_id, offer_type, user_id, title, end_date, city, description, publication_date) VALUES (:offer_id, :offer_type, :user_id, :title, :end_date, :city, :description, :publication_date)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':offer_type' => $offer_type,
			':user_id' => Session::get('user_id'),
			':title' => $title,
			':end_date' => strtotime($end_date),
			':city' => $city,
			':description' => $description,
			':publication_date' => $publication_date
		));

		self::setCareers($careers, $offer_type, $offer_id);

		self::setWorkareas($workareas, $offer_type, $offer_id);

		self::setBenefits($benefits, $offer_type, $offer_id);

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::remove('offer_data');
		Session::add('feedback_positive', Text::get('notification/positive/offer_added'));
		return true;
	}

	public static function editOffer($offer_id, $offer_type, $title, $end_date, $city, $careers, $workareas, $benefits, $description) {

		if (empty($offer_type) OR empty($title) OR empty($description) OR empty($end_date) OR empty($workareas) OR empty($benefits) OR empty($careers) OR empty($city)) {
			if (empty($offer_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/offer_type_empty'));
			}
			if (empty($title)) {
				Session::add('feedback_negative', Text::get('notification/negative/title_field_empty'));
			}
			if (empty($end_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/end_date_field_empty'));
			}
			if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
			}
			if (empty($careers)) {
				Session::add('feedback_negative', Text::get('notification/negative/careers_empty'));
			}
			if (empty($workareas)) {
				Session::add('feedback_negative', Text::get('notification/negative/workareas_empty'));
			}
			if (empty($benefits)) {
				Session::add('feedback_negative', Text::get('notification/negative/benefits_empty'));
			}
			if (empty($description)) {
				Session::add('feedback_negative', Text::get('notification/negative/description_field_empty'));
			}
			return false;
		}

		$offer_info = self::getOfferData($offer_id);

		$careers_info = self::getCareers($offer_id, PDO::FETCH_ASSOC);

		$workareas_info = self::getWorkareas($offer_id, PDO::FETCH_ASSOC);

		$benefits_info = self::getBenefits($offer_id, PDO::FETCH_ASSOC);

		if ($offer_info->offer_type == $offer_type AND $offer_info->title == $title AND date('d-m-Y', $offer_info->end_date) == $end_date AND $offer_info->city == $city AND $offer_info->description == $description AND $careers == array_column($careers_info, 'career') AND $workareas == array_column($workareas_info, 'workarea') AND $benefits == array_column($benefits_info, 'benefit')) {
			Session::add('feedback_positive', Text::get('notification/positive/offer_edited'));
			return true;
		}

		if ($offer_info->offer_type != $offer_type OR $offer_info->title != $title OR date('d-m-Y', $offer_info->end_date) != $end_date OR $offer_info->city != $city OR $offer_info->description != $description) {
			$database = DatabaseFactory::getFactory()->getConnection();
			$sql = "UPDATE TB_OFFERS SET offer_type = :offer_type, title = :title, end_date = :end_date, city = :city, description = :description WHERE offer_id = :offer_id LIMIT 1";
			$query = $database->prepare($sql);
			$query->execute(array(
				':offer_id' => $offer_id,
				':offer_type' => $offer_type,
				':title' => $title,
				':end_date' => strtotime($end_date),
				':city' => $city,
				':description' => $description
			));

			if ($query->rowCount() != 1) {
				Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
				return false;
			}
		}

		self::setCareers($careers, $offer_type, $offer_id);

		self::setWorkareas($workareas, $offer_type, $offer_id);

		self::setBenefits($benefits, $offer_type, $offer_id);

		Session::add('feedback_positive', Text::get('notification/positive/offer_edited'));
		return true;
	}

	public static function publishOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_OFFERS SET publication_date = :publication_date WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':publication_date' => time()
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_published'));
		return true;
	}

	public static function closeOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_OFFERS SET close_date = :close_date WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':close_date' => time()
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		$applicants = ApplicationModel::getApplicants($offer_id);

		foreach ($applicants as $student) {
			$body = 'Has sido seleccionado. Puedes revisar la oferta <a href="' . Config::get('URL') . 'offer/offerdetail/' . urlencode($offer_id) . '">aquí</a>.';
			$mail = new Mail;
			$mail->sendMail($student->email, Config::get('EMAIL_ADMIN'), Config::get('EMAIL_ADMIN_NAME'), 'Has sido seleccionado', $body);
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_closed'));
		return true;
	}

	public static function isOfferClosed($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id FROM TB_OFFERS WHERE offer_id = :offer_id AND close_date IS NOT NULL LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		if ($query->rowCount() == 1) {
			return true;
		}

		return false;
	}

	public static function deleteOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_OFFERS WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_deleted'));
		return true;
	}

	public static function getCareers($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, career FROM TB_CAREERS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	public static function getWorkareas($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, workarea FROM TB_WORKAREAS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	public static function getBenefits($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, benefit FROM TB_BENEFITS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	private static function setCareers($careers, $offer_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_CAREERS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_CAREERS (offer_id, career) VALUES ";
		for ($i = 0; $i < count($careers); $i++) {
			if ($i == count($careers) - 1) {
				$sql = $sql . '(:offer_id, :career' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :career' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($careers); $i++) {
			$values[':career' . $i] = $careers[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}

	private static function setWorkareas($workareas, $offer_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_WORKAREAS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_WORKAREAS (offer_id, workarea) VALUES ";

		for ($i = 0; $i < count($workareas); $i++) {
			if ($i == count($workareas) - 1) {
				$sql = $sql . '(:offer_id, :workarea' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :workarea' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($workareas); $i++) {
			$values[':workarea' . $i] = $workareas[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}

	private static function setBenefits($benefits, $offer_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_BENEFITS WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_BENEFITS (offer_id, benefit) VALUES ";

		for ($i = 0; $i < count($benefits); $i++) {
			if ($i == count($benefits) - 1) {
				$sql = $sql . '(:offer_id, :benefit' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :benefit' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($benefits); $i++) {
			$values[':benefit' . $i] = $benefits[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}
}