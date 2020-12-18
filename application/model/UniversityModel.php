<?php

class UniversityModel
{
	public static function countUniversity()
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT * FROM TB_USERS a  WHERE a.account_type = 3 ";
		$values = null;
		
		$query = $database->prepare($sql);
		$query->execute($values);
		return $query->fetchAll();
	}

	public static function getUniversities($letter = null)
	{

		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($letter)) {
			$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN TB_OFFERS b ON b.user_id = a.user_id WHERE a.account_type = 3 AND b.publication_date IS NOT NULL";
			$values = null;
		} else {
			$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN TB_OFFERS b ON b.user_id = a.user_id WHERE a.account_type = 3 AND b.publication_date IS NOT NULL AND a.name LIKE :letter";
			$values = array(':letter' => $letter . '%');
		}
		$query = $database->prepare($sql);
		$query->execute($values);
		return $query->fetchAll();
	}

	public static function getUniversityData($university_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.user_id, a.name, a.lastname, a.email, a.bio, a.avatar, count(b.title) as offers FROM TB_USERS a LEFT JOIN TB_OFFERS b ON b.user_id = a.user_id WHERE a.account_type = 3 AND a.user_id = :university_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':university_id' => $university_id));
		return $query->fetch();
	}

	public static function getOffers($user_id = null)
	{

		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($user_id)) {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.lastname, b.email, b.document, b.city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.publication_date IS NOT NULL AND offer_type = 2";
		} else {
			$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.city, a.end_date, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.lastname, b.email, b.document, b.city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.user_id = :user_id AND a.publication_date IS NOT NULL AND offer_type = 2";
		}
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getDeals($university_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.deal_id, a.university_id, a.company_id, a.deal_type, a.start_date, a.duration, a.contact_person, a.contact_mail, a.university_person, a.university_mail, a.deal_extent, a.deal_autorenewable, a.file_name, b.name as company_name, b.lastname as company_lastname FROM TB_DEALS a INNER JOIN TB_USERS b ON a.company_id = b.user_id WHERE university_id = :university_id";
		$query = $database->prepare($sql);
		$query->execute(array(':university_id' => $university_id));
		return $query->fetchAll();
	}

	public static function getDealData($deal_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.deal_id, a.university_id, a.company_id, a.deal_type, a.start_date, a.duration, a.contact_person, a.contact_mail, a.university_person, a.university_mail, a.deal_extent, a.deal_autorenewable, a.file_name, b.name as company_name, b.lastname as company_lastname FROM TB_DEALS a INNER JOIN TB_USERS b ON a.company_id = b.user_id WHERE deal_id = :deal_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':deal_id' => $deal_id));
		return $query->fetch();
	}

	public static function addDeal($company_id, $deal_type, $start_date, $duration, $contact_person, $contact_mail, $university_person, $university_mail, $deal_extent, $deal_autorenewable, $document)
	{

		Session::set('deal_data', array(
			'company_id' => $company_id,
			'deal_type' => $deal_type,
			'start_date' => $start_date,
			'duration' => $duration,
			'contact_person' => $contact_person,
			'contact_mail' => $contact_mail,
			'university_person' => $university_person,
			'university_mail' => $university_mail,
			'deal_extent' => $deal_extent,
			'deal_autorenewable' => $deal_autorenewable
		));

		if (empty($company_id) or empty($deal_type) or empty($start_date) or empty($duration) or empty($contact_person) or empty($contact_mail) or empty($university_person) or empty($university_mail)) {
			if (empty($company_id)) {
				Session::add('feedback_negative', Text::get('notification/negative/company_field_empty'));
			}
			if (empty($deal_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_type_empty'));
			}
			if (empty($start_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/start_date_field_empty'));
			}
			if (empty($duration)) {
				Session::add('feedback_negative', Text::get('notification/negative/duration_field_empty'));
			}
			if (empty($contact_person)) {
				Session::add('feedback_negative', Text::get('notification/negative/contact_person_field_empty'));
			}
			if (empty($contact_mail)) {
				Session::add('feedback_negative', Text::get('notification/negative/contact_mail_field_empty'));
			}
			if (empty($university_person)) {
				Session::add('feedback_negative', Text::get('notification/negative/university_person_field_empty'));
			}
			if (empty($university_mail)) {
				Session::add('feedback_negative', Text::get('notification/negative/university_mail_field_empty'));
			}
			if (empty($deal_extent)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_extent_field_empty'));
			}
			if (empty($deal_autorenewable)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_autorenewable_field_empty'));
			}
			return false;
		}

		$file_name = null;

		if (!empty($document['name'])) {
			$file_name = uniqid() . '.pdf';
			if (!self::uploadDocument($document, $file_name)) {
				return false;
			}
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_DEALS (university_id, company_id, deal_type, start_date, duration, contact_person, contact_mail, university_person, university_mail, deal_extent, deal_autorenewable, file_name) VALUES (:university_id, :company_id, :deal_type, :start_date, :duration, :contact_person, :contact_mail, :university_person, :university_mail, :deal_extent, :deal_autorenewable, :file_name)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':university_id' => Session::get('user_id'),
			':company_id' => $company_id,
			':deal_type' => $deal_type,
			':start_date' => strtotime($start_date),
			':duration' => $duration,
			':contact_person' => $contact_person,
			':contact_mail' => $contact_mail,
			':university_person' => $university_person,
			':university_mail' => $university_mail,
			':deal_extent' => $deal_extent,
			':deal_autorenewable' => $deal_autorenewable,
			':file_name' => $file_name
		));

		Session::remove('deal_data');
		Session::add('feedback_positive', Text::get('notification/positive/deal_added'));
		return true;
	}

	public static function editDeal($deal_id, $company_id, $deal_type, $start_date, $duration, $contact_person, $contact_mail, $university_person, $university_mail, $deal_extent, $deal_autorenewable, $document)
	{
		//Validacion
		if (empty($company_id) or empty($deal_type) or empty($start_date) or empty($duration) or empty($contact_person) or empty($contact_mail) or empty($university_person) or empty($university_mail)) {
			if (empty($company_id)) {
				Session::add('feedback_negative', Text::get('notification/negative/company_field_empty'));
			}
			if (empty($deal_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_type_empty'));
			}
			if (empty($start_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/start_date_field_empty'));
			}
			if (empty($duration)) {
				Session::add('feedback_negative', Text::get('notification/negative/duration_field_empty'));
			}
			if (empty($contact_person)) {
				Session::add('feedback_negative', Text::get('notification/negative/contact_person_field_empty'));
			}
			if (empty($contact_mail)) {
				Session::add('feedback_negative', Text::get('notification/negative/contact_mail_field_empty'));
			}
			if (empty($university_person)) {
				Session::add('feedback_negative', Text::get('notification/negative/university_person_field_empty'));
			}
			if (empty($university_mail)) {
				Session::add('feedback_negative', Text::get('notification/negative/university_mail_field_empty'));
			}
			if (empty($deal_extent)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_extent_field_empty'));
			}
			if (empty($deal_autorenewable)) {
				Session::add('feedback_negative', Text::get('notification/negative/deal_autorenewable_field_empty'));
			}
			return false;
		}
		//Validar archivo
		$deal_info = self::getDealData($deal_id);
		$file_name = $deal_info->file_name;

		if (!empty($document['name'])) {
			if (empty($file_name)) {
				$file_name = uniqid() . '.pdf';
			}
			if (!self::uploadDocument($document, $file_name)) {
				return false;
			}
		}
		//validar si es igual
		if ($company_id == $deal_info->company_id and $deal_type == $deal_info->deal_type and $start_date == date('d-m-Y', $deal_info->start_date) and $duration == $deal_info->duration and $contact_person == $deal_info->contact_person and $contact_mail == $deal_info->contact_mail and $university_person == $deal_info->university_person and $university_mail == $deal_info->universiy_mail and $deal_extent == $deal_info->deal_extent and $deal_autorenewable == $deal_info->deal_autorenewable and $file_name == $deal_info->file_name) {
			Session::add('feedback_positive', Text::get('notification/positive/deal_edited'));
			return true;
		}
		//UPDATE DEAL
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_DEALS SET company_id = :company_id, deal_type = :deal_type, start_date = :start_date, duration = :duration, contact_person = :contact_person, contact_mail = :contact_mail, university_person = :university_person, university_mail = :university_mail, deal_extent = :deal_extent, deal_autorenewable = :deal_autorenewable, file_name = :file_name WHERE deal_id = :deal_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':deal_id' => $deal_id,
			':company_id' => $company_id,
			':deal_type' => $deal_type,
			':start_date' => strtotime($start_date),
			':duration' => $duration,
			':contact_person' => $contact_person,
			':contact_mail' => $contact_mail,
			':university_person' => $university_person,
			':university_mail' => $university_mail,
			':deal_extent' => $deal_extent,
			':deal_autorenewable' => $deal_autorenewable,
			':file_name' => $file_name

		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic-error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/deal_edited'));
		return true;
	}

	public static function deleteDeal($deal_id)
	{
		//DELETE
		$file_name = self::getDealData($deal_id)->file_name;

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_DEALS WHERE deal_id = :deal_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':deal_id' => $deal_id));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic-error'));
			return false;
		}

		if (!empty($file_name)) {
			unlink('files/' . $file_name);
		}

		Session::add('feedback_positive', Text::get('notification/positive/deal_deleted'));
		return true;
	}

	private static function uploadDocument($file, $file_name)
	{

		if ($file['error'] !== UPLOAD_ERR_OK) {
			if ($file['error'] == 1) {
				Session::add('feedback_negative', Text::get('notification/negative/doc_larger'));
			} else {
				Session::add('feedback_negative', Text::get('notification/negative/document_error'));
			}
			return false;
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $file['tmp_name']);

		if ($mime != 'application/pdf' or $file['size'] > 10485760) {
			if ($mime != 'application/pdf') {
				Session::add('feedback_negative', Text::get('notification/negative/document_pdf'));
			}
			if ($file['size'] > 10485760) {
				Session::add('feedback_negative', Text::get('notification/negative/doc_larger'));
			}
			return false;
		}

		if (move_uploaded_file($file['tmp_name'], 'files/' . $file_name)) {
			return true;
		} else {
			Session::add('feedback_negative', Text::get('notification/negative/document_error'));
			return false;
		}
	}

	public static function getStudents()
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.university_id, a.student, c.user_id, c.name, c.lastname, c.document, c.email, c.avatar, c.city FROM TB_STUDENTS a LEFT JOIN (SELECT b.user_id, b.name, b.lastname, b.document, b.email, b.avatar, b.city FROM TB_USERS b WHERE b.account_type = 1) c ON c.document = a.student WHERE university_id = :university_id";
		$query = $database->prepare($sql);
		$query->execute(array(':university_id' => Session::get('user_id')));
		return $query->fetchAll();
	}

	public static function updateStudents($file)
	{
		//Pasar archivo csv
		if (empty($file['name'])) {
			Session::add('feedback_negative', Text::get('notification/negative/student_file_empty'));
			return false;
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $file['tmp_name']);

		if ($mime != 'text/plain') {
			Session::add('feedback_negative', Text::get('notification/negative/student_file_ext_wrong'));
			return false;
		}

		$students = file($file['tmp_name']);

		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "INSERT IGNORE INTO TB_STUDENTS (university_id, student) VALUES ";
		for ($i = 0; $i < count($students); $i++) {
			if ($i == count($students) - 1) {
				$sql = $sql . '(:university_id, :student' . $i . ')';
			} else {
				$sql = $sql . '(:university_id, :student' . $i . '),';
			}
		}

		$query = $database->prepare($sql);

		$values = array();
		for ($i = 0; $i < count($students); $i++) {
			$values[':student' . $i] = trim($students[$i]);
		}
		$values[':university_id'] = Session::get('user_id');

		$query->execute($values);

		Session::add('feedback_positive', Text::get('notification/positive/students_updated') . ' Se han agregado ' . $query->rowCount() . ' estudiantes.');
		return true;
	}

	public static function getSelectedStudents()
	{
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio, b.birth, c.user_id FROM TB_APPLICATIONS a INNER JOIN TB_USERS b ON a.student_id = b.user_id INNER JOIN TB_OFFERS c ON c.offer_id = a.offer_id WHERE c.user_id = :university_id AND a.selected = 2 AND c.close_date IS NOT NULL";
		$query = $database->prepare($sql);
		$query->execute(array(':university_id' => Session::get('user_id')));
		return $query->fetchAll();
	}
}
