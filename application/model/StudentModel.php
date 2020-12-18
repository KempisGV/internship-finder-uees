<?php

class StudentModel {

	public static function getStudies($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT study_id, student_id, school_name, career, start_date, end_date, credits, description FROM TB_STUDIES WHERE student_id = :student_id ORDER BY start_date DESC";
		$query = $database->prepare($sql);
		$query->execute(array(':student_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getStudyData($study_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT study_id, student_id, school_name, career, start_date, end_date, credits, description FROM TB_STUDIES WHERE study_id = :study_id";
		$query = $database->prepare($sql);
		$query->execute(array(':study_id' => $study_id));
		return $query->fetch();
	}

	public static function addStudy($start_date, $end_date, $school_name, $career, $credits, $description) {
		Session::set('study_data', array(
			'start_date' => $start_date,
			'end_date' => $end_date,
			'school_name' => $school_name,
			'career' => $career,
			'credits' => $credits,
			'description' => $description
		));

		if (empty($start_date) OR empty($school_name) OR empty($career) OR empty($credits) OR empty($description)) {
			$credits_flag = true;
			if (empty($start_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/start_date_field_empty'));
			}
			if (empty($school_name)) {
				Session::add('feedback_negative', Text::get('notification/negative/school_name_field_empty'));
			}
			if (empty($career)) {
				Session::add('feedback_negative', Text::get('notification/negative/career_field_empty'));
			}
			if (empty($credits)) {
				Session::add('feedback_negative', Text::get('notification/negative/credits_field_empty'));
				$credits_flag = false;
			}
			if (!is_numeric($credits) AND $credits_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/credits_not_numeric'));
			}
			if (empty($description)) {
				Session::add('feedback_negative', Text::get('notification/negative/description_field_empty'));
			}
			return false;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_STUDIES (student_id, school_name, career, start_date, end_date, credits, description) VALUES (:student_id, :school_name, :career, :start_date, :end_date, :credits, :description)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':student_id' => Session::get('user_id'),
			':school_name' => $school_name,
			':career' => $career,
			':start_date' => $start_date,
			':end_date' => $end_date,
			':credits' => $credits,
			':description' => $description
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/study_added'));
		Session::remove('study_data');
		return true;
	}

	public static function editStudy($study_id, $start_date, $end_date, $school_name, $career, $credits, $description) {
		if (empty($start_date) OR empty($school_name) OR empty($career) OR empty($description) OR !is_numeric($credits)) {
			$credits_flag = true;
			if (empty($start_date)) {
				Session::add('feedback_negative', Text::get('notification/negative/start_date_field_empty'));
			}
			if (empty($school_name)) {
				Session::add('feedback_negative', Text::get('notification/negative/school_name_field_empty'));
			}
			if (empty($career)) {
				Session::add('feedback_negative', Text::get('notification/negative/career_field_empty'));
			}
			if (empty($credits)) {
				Session::add('feedback_negative', Text::get('notification/negative/credits_field_empty'));
				$credits_flag = false;
			}
			if (!is_numeric($credits) AND $credits_flag) {
				Session::add('feedback_negative', Text::get('notification/negative/credits_not_numeric'));
			}
			if (empty($description)) {
				Session::add('feedback_negative', Text::get('notification/negative/description_field_empty'));
			}
			return false;
		}

		$study_info = self::getStudyData($study_id);

		if ($study_info->start_date == $start_date AND $study_info->end_date == $end_date AND $study_info->school_name == $school_name AND $study_info->career == $career AND $study_info->credits == $credits AND $study_info->description == $description) {
			Session::add('feedback_positive', Text::get('notification/positive/study_edited'));
			return true;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_STUDIES SET school_name = :school_name, career = :career, start_date = :start_date, end_date = :end_date, credits = :credits, description = :description WHERE study_id = :study_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':study_id' => $study_id,
			':school_name' => $school_name,
			':career' => $career,
			':start_date' => $start_date,
			':end_date' => $end_date,
			':credits' => $credits,
			':description' => $description
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/study_edited'));
		return true;
	}

	public static function deleteStudy($study_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_STUDIES WHERE study_id = :study_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':study_id' => $study_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/study_deleted'));
		return true;
	}

	public static function getSkills($user_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT skill_id, student_id, name, rating FROM TB_SKILLS WHERE student_id = :student_id";
		$query = $database->prepare($sql);
		$query->execute(array(':student_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getSkillData($skill_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT skill_id, student_id, name, rating FROM TB_SKILLS WHERE skill_id = :skill_id";
		$query = $database->prepare($sql);
		$query->execute(array(':skill_id' => $skill_id));
		return $query->fetch();
	}

	public static function addSkill($name, $rating) {
		Session::set('skill_data', array(
			'name' => $name,
			'rating' => $rating
		));

		if (empty($name) OR empty($rating) OR $rating > 100 OR $rating < 0) {
			if (empty($name)) {
				Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
			}
			if (empty($rating)) {
				Session::add('feedback_negative', Text::get('notification/negative/rating_field_empty'));
			}
			if ($rating > 100 OR $rating < 0) {
				Session::add('feedback_negative', Text::get('notification/negative/rating_not_valid'));
			}
			return false;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_SKILLS (student_id, name, rating) VALUES (:student_id, :name, :rating)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':student_id' => Session::get('user_id'),
			':name' => $name,
			':rating' => $rating
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/skill_added'));
		Session::remove('skill_data');
		return true;
	}

	public static function editSkill($skill_id, $name, $rating) {
		if (empty($name) OR empty($rating) OR $rating > 100 OR $rating < 0) {
			if (empty($name)) {
				Session::add('feedback_negative', Text::get('notification/negative/name_field_empty'));
			}
			if (empty($rating)) {
				Session::add('feedback_negative', Text::get('notification/negative/rating_field_empty'));
			}
			if ($rating > 100 OR $rating < 0) {
				Session::add('feedback_negative', Text::get('notification/negative/rating_not_valid'));
			}
			return false;
		}

		$skill_info = self::getSkillData($skill_id);

		if ($skill_info->name == $name AND $skill_info->rating == $rating) {
			Session::add('feedback_positive', Text::get('notification/positive/skill_edited'));
			return true;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_SKILLS SET name = :name, rating = :rating WHERE skill_id = :skill_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':skill_id' => $skill_id,
			':name' => $name,
			':rating' => $rating
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/skill_edited'));
		return true;
	}

	public static function deleteSkill($skill_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_SKILLS WHERE skill_id = :skill_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':skill_id' => $skill_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/skill_deleted'));
		return true;
	}

	public static function checkFilledProfile() {
	    $user_info = UserModel::getUserDataById(Session::get('user_id'));
	    $user_studies = self::getStudies(Session::get('user_id'));
	    $user_skills = self::getSkills(Session::get('user_id'));

	    if (empty($user_info->bio) OR empty($user_studies) OR empty($user_skills)) {
			return false;
	    }

	    return true;
    }
	
	public static function isStudyCertified($student_id, $university_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.university_id, a.student FROM TB_STUDENTS a INNER JOIN TB_USERS c ON a.university_id = c.user_id WHERE a.student = :student_id AND c.university = :university";
		$query = $database->prepare($sql);
		$query->execute(array(
			':student_id' => $student_id,
			':university' => $university_id
		));
		
		if ($query->rowCount() == 1) {
			return true;
		}
		
		return false;
	}
}
