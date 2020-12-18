<?php

class ApplicationModel {

	public static function getMyApplications() {
		//corregir
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.start_date, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.student_id = :user_id";
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => Session::get('user_id')));
		return $query->fetchAll();
	}

	public static function getApplicants($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_APPLICATIONS a INNER JOIN TB_USERS b ON a.student_id = b.user_id WHERE a.offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll();
	}

	public static function applyOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_APPLICATIONS (offer_id, student_id, selected, application_date) VALUES (:offer_id, :student_id, 1, :application_date)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':student_id' => Session::get('user_id'),
			':application_date' => time()
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::remove('offer_data');
		Session::add('feedback_positive', Text::get('notification/positive/aplication_done'));
		return true;
	}

	public static function removeApplication($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_APPLICATIONS WHERE offer_id = :offer_id AND student_id = :student_id";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':student_id' => Session::get('user_id')
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::remove('offer_data');
		Session::add('feedback_positive', Text::get('notification/positive/aplication_removed'));
		return true;
	}

	public static function hasUserApplied($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id FROM TB_APPLICATIONS WHERE offer_id = :offer_id AND student_id = :student_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':student_id' => Session::get('user_id')
		));

		if ($query->rowCount() == 1) {
			return true;
		}
		return false;
	}

	public static function selectStudent($student_id, $offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_APPLICATIONS SET selected = 2 WHERE offer_id = :offer_id AND student_id = :student_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':student_id' => $student_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/student_selected'));
		return true;
	}

	public static function removeStudent($student_id, $offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_APPLICATIONS SET selected = 1 WHERE offer_id = :offer_id AND student_id = :student_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':student_id' => $student_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/student_deleted'));
		return true;
	}

	public static function hasSelected($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id FROM TB_APPLICATIONS WHERE offer_id = :offer_id AND selected = 2";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		if ($query->rowCount() == 0) {
			return false;
		}

		return true;
	}
}