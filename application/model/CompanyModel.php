<?php

class CompanyModel
{
	public static function countCompany()
	{

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT * FROM TB_USERS a  WHERE a.account_type = 2";
		$values = null;
		

		$query = $database->prepare($sql);
		$query->execute($values);
		return $query->fetchAll();
	}

	public static function getCompanies($letter = null)
	{

		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($letter)) {
			$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN (SELECT c.title, c.user_id FROM TB_OFFERS c WHERE c.publication_date IS NOT NULL) b ON b.user_id = a.user_id WHERE a.account_type = 2";
			$values = null;
		} else {
			$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN (SELECT c.title, c.user_id FROM TB_OFFERS c WHERE c.publication_date IS NOT NULL) b ON b.user_id = a.user_id WHERE a.account_type = 2 AND a.name LIKE :letter";
			$values = array(':letter' => $letter . '%');
		}
		$query = $database->prepare($sql);
		$query->execute($values);
		return $query->fetchAll();
	}

	public static function getCompanyData($company_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN TB_OFFERS b ON b.user_id = a.user_id WHERE a.account_type = 2 AND a.user_id = :company_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':company_id' => $company_id));
		return $query->fetch();
	}

	public static function getOffers($user_id = null)
	{

		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($user_id)) {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.publication_date IS NOT NULL AND offer_type = 1";
		} else {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.document, b.city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.user_id = :user_id AND a.publication_date IS NOT NULL AND offer_type = 1";
		}
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getDeals()
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.deal_id, a.university_id, a.company_id, a.deal_type, a.file_name, b.name as university_name, a.contact_person, a.contact_mail, a.university_person, a.university_mail, a.deal_extent, a.deal_autorenewable, a.start_date, a.duration, b.avatar FROM TB_DEALS a INNER JOIN TB_USERS b ON b.user_id = a.university_id WHERE a.company_id = :company_id";
		$query = $database->prepare($sql);
		$query->execute(array(':company_id' => Session::get('user_id')));
		return $query->fetchAll();
	}

	public static function getDealDataById($deal_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.deal_id, a.university_id, a.company_id, a.deal_type, a.file_name, b.name as university_name, a.contact_person, a.contact_mail, a.university_person, a.university_mail, a.deal_extent, a.deal_autorenewable, a.start_date, a.duration, b.avatar FROM TB_DEALS a INNER JOIN TB_USERS b ON b.user_id = a.university_id WHERE a.deal_id = :deal_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':deal_id' => $deal_id));
		return $query->fetch();
	}

	public static function getSelectedStudents()
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio, b.birth, c.user_id FROM TB_APPLICATIONS a INNER JOIN TB_USERS b ON a.student_id = b.user_id INNER JOIN TB_OFFERS c ON c.offer_id = a.offer_id WHERE c.user_id = :company_id AND a.selected = 2 AND c.close_date IS NOT NULL";
		$query = $database->prepare($sql);
		$query->execute(array(':company_id' => Session::get('user_id')));
		return $query->fetchAll();
	}
}
