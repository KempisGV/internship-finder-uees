<?php

class SearchModel {

	private static function countSearchOffer($user_id = null, $keyword = null, $offer_type = null, $start_date = null, $end_date = null, $city = null, $careers = null, $workareas = null, $benefits = null) {

		$time = time();
		$sql = "SELECT DISTINCT a.offer_id, a.offer_type, a.title as offer_title, a.user_id, a.end_date, from_unixtime(a.end_date, '%d-%m-%Y') as end, a.city, a.description, from_unixtime(a.publication_date, '%d-%m-%Y') as publication, a.publication_date, from_unixtime(a.close_date, '%d-%m-%Y') as close, a.close_date, b.name as user_name, b.lastname as user_lastname, b.email, b.avatar FROM TB_OFFERS a INNER JOIN TB_USERS b ON b.user_id = a.user_id WHERE a.end_date >= :time";
		$values = array();
        $values[':time'] = $time;

/*
		if (!empty($careers)) {
			foreach ($careers as $key => $career) {
				$sql = $sql . " INNER JOIN TB_CAREERS career" . $key . " ON a.offer_id = career" . $key . ".offer_id";
			}
		}

		if (!empty($workareas)) {
			foreach ($workareas as $key => $workarea) {
				$sql = $sql . " INNER JOIN TB_WORKAREAS workarea" . $key . " ON a.offer_id = workarea" . $key . ".offer_id";
			}
		}

		if (!empty($benefits)) {
			foreach ($benefits as $key => $benefit) {
				$sql = $sql . " INNER JOIN TB_BENEFITS benefit" . $key . " ON a.offer_id = benefit" . $key . ".offer_id";
			}
		}
*/

		if (empty($user_id)) {
			$sql = $sql . " AND a.publication_date IS NOT NULL ";
		} else {
			$sql = $sql . " AND a.user_id = :user_id ";
			$values[':user_id'] = $user_id;
		}

		if (!empty($keyword)) {
			$sql = $sql . "AND (a.title LIKE :keyword OR a.description LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($offer_type)) {
			$sql = $sql . "AND a.offer_type = :offer_type";
			$values[':offer_type'] = $offer_type;
		}

		if (!empty($start_date)) {
			$sql = $sql . "AND a.publication_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . "AND a.publication_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . "AND a.city = :city";
			$values[':city'] = $city;
		}

/*
		if (!empty($careers)) {
			foreach ($careers as $key => $career) {
				$sql = $sql . "AND career" . $key . ".career = :career" . $key;
				$values[':career' . $key] = $career;
			}
		}

		if (!empty($workareas)) {
			foreach ($workareas as $key => $workarea) {
				$sql = $sql . "AND workarea" . $key . ".workarea = :workarea" . $key;
				$values[':workarea' . $key] = $workarea;
			}
		}

		if (!empty($benefits)) {
			foreach ($benefits as $key => $benefit) {
				$sql = $sql . "AND benefit" . $key . ".benefit = :benefit" . $key;
				$values[':benefit' . $key] = $benefit;
			}
		}
*/

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);
		return count($query->fetchAll());
	}

	public static function searchOffer() {

		$user_id = Request::post('user_id');
		$keyword = Request::post('keyword');
		$offer_type = Request::post('offer_type');
		$start_date = Request::post('start_date');
		$end_date = Request::post('end_date');
		$city = Request::post('city');
		$careers = Request::post('careers');
		$workareas = Request::post('workareas');
		$benefits = Request::post('benefits');
		$page = empty(Request::post('page')) ? 1 : Request::post('page');
		$total = self::countSearchOffer($user_id, $keyword, $offer_type, $start_date, $end_date, $city, $careers, $workareas, $benefits);
		$time = time();

		$sql = "SELECT DISTINCT a.offer_id, a.offer_type, a.title as offer_title, a.user_id, a.end_date, from_unixtime(a.end_date, '%d-%m-%Y') as end, a.city, a.description, from_unixtime(a.publication_date, '%d-%m-%Y') as publication, a.publication_date, from_unixtime(a.close_date, '%d-%m-%Y') as close, a.close_date, b.name as user_name, b.lastname as user_lastname, b.email, b.avatar FROM TB_OFFERS a INNER JOIN TB_USERS b ON b.user_id = a.user_id WHERE a.end_date >= :time";
		$values = array();
		$values[':time'] = $time;

/*
		if (!empty($careers)) {
			foreach ($careers as $key => $career) {
				$sql = $sql . " INNER JOIN TB_CAREERS career" . $key . " ON a.offer_id = career" . $key . ".offer_id";
			}
		}

		if (!empty($workareas)) {
			foreach ($workareas as $key => $workarea) {
				$sql = $sql . " INNER JOIN TB_WORKAREAS workarea" . $key . " ON a.offer_id = workarea" . $key . ".offer_id";
			}
		}

		if (!empty($benefits)) {
			foreach ($benefits as $key => $benefit) {
				$sql = $sql . " INNER JOIN TB_BENEFITS benefit" . $key . " ON a.offer_id = benefit" . $key . ".offer_id";
			}
		}
*/

		if (empty($user_id)) {
			$sql = $sql . " AND a.publication_date IS NOT NULL ";
		} else {
			$sql = $sql . " AND a.user_id = :user_id ";
			$values[':user_id'] = $user_id;
		}

		if (!empty($keyword)) {
			$sql = $sql . "AND (a.title LIKE :keyword OR a.description LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($offer_type)) {
			$sql = $sql . "AND a.offer_type = :offer_type";
			$values[':offer_type'] = $offer_type;
		}

		if (!empty($start_date)) {
			$sql = $sql . "AND a.publication_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . "AND a.publication_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . "AND a.city = :city";
			$values[':city'] = $city;
		}

/*
		if (!empty($careers)) {
			foreach ($careers as $key => $career) {
				$sql = $sql . "AND career" . $key . ".career = :career" . $key;
				$values[':career' . $key] = $career;
			}
		}

		if (!empty($workareas)) {
			foreach ($workareas as $key => $workarea) {
				$sql = $sql . "AND workarea" . $key . ".workarea = :workarea" . $key;
				$values[':workarea' . $key] = $workarea;
			}
		}

		if (!empty($benefits)) {
			foreach ($benefits as $key => $benefit) {
				$sql = $sql . "AND benefit" . $key . ".benefit = :benefit" . $key;
				$values[':benefit' . $key] = $benefit;
			}
		}
*/

		$sql = $sql . " ORDER BY a.publication_date DESC LIMIT " . (($page *10) - 10) . ", 10";

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);

		echo json_encode(array(
			'result' => 'success',
			'total' => $total,
			'current_page' => $page,
			'total_pages' => ceil($total / 10),
			'cities' => Config::get('CITIES'),
			'careers' => Config::get('CAREERS'),
			'workareas' => Config::get('WORKAREAS'),
			'benefits' => Config::get('BENEFITS'),
			'info' => $query->fetchAll()
		));
	}

	public static function recentOffers() {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.offer_type, a.user_id, a.title, a.end_date, a.city, a.description, a.publication_date, a.close_date, b.name, b.lastname, b.email, b.avatar FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.publication_date IS NOT NULL AND a.close_date IS NULL ORDER BY a.publication_date DESC LIMIT 10";
		$query = $database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public static function countSearchStudent($offer_id, $keyword = null, $start_date = null, $end_date = null, $city = null, $status = null) {

		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date, b.name as user_name, b.lastname as user_lastname, b.email, b.city, b.avatar FROM TB_APPLICATIONS a INNER JOIN TB_USERS b ON a.student_id = b.user_id WHERE a.offer_id = :offer_id";
		$values = array();
		$values[':offer_id'] = $offer_id;

		if (!empty($keyword)) {
			$sql = $sql . " AND (b.name LIKE :keyword OR b.email LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($start_date)) {
			$sql = $sql . " AND b.application_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . " AND b.application_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . " AND b.city = :city";
			$values[':city'] = $city;
		}

		if (!empty($status)) {
			$sql = $sql . " AND a.selected = :status";
			$values[':status'] = $status;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);
		return count($query->fetchAll());
	}

	public static function searchStudent() {

		$offer_id = Request::post('offer_id');
		$keyword = Request::post('keyword');
		$start_date = Request::post('start_date');
		$end_date = Request::post('end_date');
		$city = Request::post('city');
		$status = Request::post('status');
		$page = empty(Request::post('page')) ? 1 : Request::post('page');
		$total = self::countSearchStudent($offer_id, $keyword, $start_date, $end_date, $city, $status);

		$sql = "SELECT a.offer_id, a.student_id, a.selected, from_unixtime(a.application_date, '%d-%m-%Y') as application, a.application_date, b.name as user_name, b.lastname as user_lastname, b.email, b.city, b.avatar FROM TB_APPLICATIONS a INNER JOIN TB_USERS b ON a.student_id = b.user_id WHERE a.offer_id = :offer_id";
		$values = array();
		$values[':offer_id'] = $offer_id;

		if (!empty($keyword)) {
			$sql = $sql . " AND (b.name LIKE :keyword OR b.email LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($start_date)) {
			$sql = $sql . " AND b.application_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . " AND b.application_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . " AND b.city = :city";
			$values[':city'] = $city;
		}

		if (!empty($status)) {
			$sql = $sql . " AND a.selected = :status";
			$values[':status'] = $status;
		}

		$sql = $sql . " ORDER BY a.selected, a.application_date DESC LIMIT " . (($page *10) - 10) . ", 10";

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);

		echo json_encode(array(
			'result' => 'success',
			'close' => OfferModel::isOfferClosed($offer_id),
			'total' => $total,
			'current_page' => $page,
			'total_pages' => ceil($total / 10),
			'cities' => Config::get('CITIES'),
			'info' => $query->fetchAll()
		));
	}

	private static function countSearchApplications($student_id, $keyword = null, $offer_type = null, $start_date = null, $end_date = null, $city = null) {

		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date,b.end_date, from_unixtime(b.end_date, '%d-%m-%Y'), from_unixtime(b.publication_date, '%d-%m-%Y') as publication, b.publication_date, from_unixtime(b.close_date, '%d-%m-%Y') as close, b.close_date, b.offer_type, b.title as offer_title, b.city, from_unixtime(b.end_date, '%d-%m-%Y') as end, b.description, from_unixtime(b.publication_date, '%d-%m-%Y') as publication, b.close_date, b.offer_type, b.title as offer_title, b.city, from_unixtime(b.end_date, '%d-%m-%Y') as end, b.description, from_unixtime(b.publication_date, '%d-%m-%Y') as publication, b.close_date, b.user_id, c.name as institute_name, c.email, c.avatar FROM TB_APPLICATIONS a INNER JOIN TB_OFFERS b ON a.offer_id = b.offer_id INNER JOIN TB_USERS c ON b.user_id = c.user_id WHERE a.student_id = :student_id";

		$values = array(
			':student_id' => $student_id
		);

		if (!empty($keyword)) {
			$sql = $sql . " AND (b.title LIKE :keyword OR b.description LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($offer_type)) {
			$sql = $sql . " AND b.offer_type = :offer_type";
			$values[':offer_type'] = $offer_type;
		}

		if (!empty($start_date)) {
			$sql = $sql . " AND b.publication_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . " AND b.publication_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . " AND b.city = :city";
			$values[':city'] = $city;
		}

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);

		return count($query->fetchAll());
	}

	public static function searchApplications() {

		$student_id = Request::post('student_id');
		$keyword = Request::post('keyword');
		$offer_type = Request::post('offer_type');
		$start_date = Request::post('start_date');
		$end_date = Request::post('end_date');
		$city = Request::post('city');
		$page = empty(Request::post('page')) ? 1 : Request::post('page');
		$total = self::countSearchApplications($student_id, $keyword, $offer_type, $start_date, $end_date, $city);

		$sql = "SELECT a.offer_id, a.student_id, a.selected, a.application_date, b.end_date, from_unixtime(b.end_date, '%d-%m-%Y'), from_unixtime(b.publication_date, '%d-%m-%Y') as publication, b.publication_date, from_unixtime(b.close_date, '%d-%m-%Y') as close, b.close_date, b.offer_type, b.title as offer_title, b.city, from_unixtime(b.end_date, '%d-%m-%Y') as end, b.description, from_unixtime(b.publication_date, '%d-%m-%Y') as publication, b.close_date, b.user_id, c.name as institute_name, c.email, c.avatar FROM TB_APPLICATIONS a INNER JOIN TB_OFFERS b ON a.offer_id = b.offer_id INNER JOIN TB_USERS c ON b.user_id = c.user_id WHERE a.student_id = :student_id";

		$values = array(
			':student_id' => $student_id
		);

		if (!empty($keyword)) {
			$sql = $sql . " AND (b.title LIKE :keyword OR b.description LIKE :keyword)";
			$values[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($offer_type)) {
			$sql = $sql . " AND b.offer_type = :offer_type";
			$values[':offer_type'] = $offer_type;
		}

		if (!empty($start_date)) {
			$sql = $sql . " AND b.publication_date >= :start_date";
			$values[':start_date'] = strtotime($start_date);
		}

		if (!empty($end_date)) {
			$sql = $sql . " AND b.publication_date <= :end_date";
			$values[':end_date'] = strtotime($end_date);
		}

		if (!empty($city)) {
			$sql = $sql . " AND b.city = :city";
			$values[':city'] = $city;
		}

		$sql = $sql . " ORDER BY b.publication_date DESC LIMIT " . (($page *10) - 10) . ", 10";

		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare($sql);
		$query->execute($values);

		echo json_encode(array(
			'sql' => $sql,
			'result' => 'success',
			'total' => $total,
			'current_page' => $page,
			'total_pages' => ceil($total / 10),
			'cities' => Config::get('CITIES'),
			'careers' => Config::get('CAREERS'),
			'workareas' => Config::get('WORKAREAS'),
			'benefits' => Config::get('BENEFITS'),
			'info' => $query->fetchAll()
		));
	}
}